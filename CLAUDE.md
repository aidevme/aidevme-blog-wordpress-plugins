# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Repository overview

WordPress plugins developed for the Aidevme Blog project. Most plugins are plain PHP with no compile step; `credentials-manager-plugin` is the exception — it has its own `package.json` (`@wordpress/scripts`) for one React-based admin screen, see below. There's no repo-wide build/lint/test tooling (no root `package.json`, `composer.json`, or PHPUnit config).

## Repository structure

- `src/` — individual WordPress plugins, one directory per plugin (e.g. `src/credentials-manager-plugin/`).
- `docs/wordpress/wordpress-plugins/` — a mirror of the official WordPress Plugin Handbook, kept in sync with `developer.wordpress.org` (see below).
- `docs/styles/` — documentation style guides; `WORDPRESS-PLUGIN-DOCS-STYLE.md` governs everything under `docs/wordpress/wordpress-plugins/`.
- `.github/instructions/commit-messages.instructions.md` — commit message convention (Conventional Commits: `<type>(<scope>): <subject>`, types `feat`/`fix`/`docs`/`style`/`refactor`/`test`/`chore`/`perf`/`ci`). Follow this for any commit made in this repo.

## Syncing the WordPress Plugin Handbook mirror

`docs/wordpress/wordpress-plugins/index.md` is the source of truth: it has an `## Index` table (`Index | Name | Document | Reference Url | Last Synced On | Notes`) mapping each handbook section to a local `.md` file and the live page it was sourced from.

- Run `/sync-wordpress-plugin-docs` (invokes the `wordpress-docs-research-agent` subagent) to refresh some or all rows against their live source, using Playwright MCP browser tools to fetch actual rendered content — never paraphrase from memory.
- Full conventions (folder/file layout, Index table format, document skeleton, content-fidelity rules, formatting mechanics) live in `docs/styles/WORDPRESS-PLUGIN-DOCS-STYLE.md`. If you change a convention there, update `.claude/agents/wordpress-docs-research-agent.md` to match — the two are meant to stay identical.
- This repo's `.mcp.json` defines its own headless `playwright` MCP server (`mcp__playwright__*`, run with `--headless`). The `wordpress-docs-research-agent` is scoped to that server specifically — do not substitute a different Playwright MCP server (e.g. one provided by another plugin), since its headlessness isn't guaranteed.

## The `credentials-manager-plugin`

`src/credentials-manager-plugin/SPECIFICATION.md` is the authoritative spec — read it before changing this plugin's architecture. Key points:

- Modeled on Contact Form 7's admin UX: **not** a custom post type. Two custom database tables (`{$wpdb->prefix}credentials`, `{$wpdb->prefix}credential_blocks`), each with its own dedicated `WP_List_Table`-based admin screen (list + add/edit form), plus a `[credential-block id="..."]` shortcode to render a saved selection of credentials on the front end. (The second entity was called "Credential Form" until a rename to "Credential Block" — see SPECIFICATION.md §10 for the live-data table migration that involved.)
- All `$wpdb` access for both tables is meant to go through a single shared data-layer class (`Credpl_Data`), used by both admin screens and the shortcode renderer, so query shape/escaping/sanitization live in one place.
- Table creation and versioning follow the pattern in `includes/class-credpl-installer.php`: `Credpl_Installer::install()` runs `dbDelta()` on activation (`register_activation_hook`) and is re-run from a `plugins_loaded` hook (`maybe_upgrade()`) whenever the stored `credpl_db_version` option doesn't match `CREDPL_DB_VERSION`, since activation hooks don't fire on plugin updates.
- `uninstall.php` is intentionally a no-op — both tables and their rows are left in place on uninstall, not dropped.
- The Add/Edit Credential admin screen is a **React app** (`src/index.js`, JSX, built via `@wordpress/scripts`) — see SPECIFICATION.md §6.2.1/§6.2.2. Run `npm install && npm run build` from `src/credentials-manager-plugin/` after editing `src/index.js`; the compiled `build/index.js` + `build/index.asset.php` are what's actually enqueued (and what ships in `dist/credentials-manager-plugin.zip`), not the JSX source. This bumped the plugin's `Requires at least` to WP 6.6 (the automatic JSX runtime needs a script handle only registered from that version on).
- Security conventions used throughout: `manage_options` capability check on every admin screen/action, `wp_nonce_field()`/`check_admin_referer()` (or, for the React form, an equivalent nonce passed through localized data) on every save/delete, `$wpdb->insert()`/`update()`/`delete()` (never raw `query()`), and output escaped with `esc_html()`/`esc_url()`/`esc_attr()` at render time.
