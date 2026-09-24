# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Repository overview

WordPress plugins developed for the Aidevme Blog project. Most plugins are plain PHP with no compile step; `credentials-manager-plugin` is the exception — it has its own `package.json` (`@wordpress/scripts`) for its React/TypeScript admin screens, see below. There's no repo-wide build/lint/test tooling (no root `package.json`, `composer.json`, or PHPUnit config).

## Repository structure

- `src/` — individual WordPress plugins, one directory per plugin (e.g. `src/credentials-manager-plugin/`).
- `docs/wordpress/wordpress-plugins/` — a mirror of the official WordPress Plugin Handbook, kept in sync with `developer.wordpress.org` (see below).
- `docs/wordpress/api-reference/` — two more mirrors of developer.wordpress.org content, kept in sync the same way: `wp-cli-commands/` (the WP-CLI command reference) and `wordpress-rest-apis/` (the REST API Handbook). Each has its own `index.md` Index table.
- `docs/claude/agents/` — documentation of the project's Claude Code agents in `.claude/agents/`, one file per agent plus an `AGENTS.md` overview. Update the matching file when an agent definition changes.
- `.claude/skills/` — project skills (shared checklists and reference material the plugin agents load: `wordpress-plugin-security-checklist`, `wordpress-handbook-lookup`, `microsoft-docs-lookup`, `changelog-entry`); documented in `docs/claude/skills/SKILLS.md`. Change a shared rule in its skill, not in each agent.
- `docs/claude/commands/` — documentation of the project's slash commands in `.claude/commands/`, one file per command plus a `COMMANDS.md` overview. Update the matching file when a command definition changes.
- `docs/styles/` — documentation style guides; `WORDPRESS-PLUGIN-DOCS-STYLE.md` governs everything under `docs/wordpress/wordpress-plugins/`, and `CLAUDE-AGENTS-STYLE.md` governs the agent definitions in `.claude/agents/`.
- `.github/workflows/` — CI workflows plus GitHub agentic workflows (`*.md` compiled to `*.lock.yml` with `gh aw compile`): `sync-wordpress-plugins-docs` and `sync-wp-cli-docs` open weekly draft PRs refreshing the mirrors, and `pr-title-and-description` writes a Conventional Commits title and description for new PRs. Edit the `.md`, recompile, and commit both files; never hand-edit a `.lock.yml`.
- `CONTRIBUTING.md` — contributor guide (branching from `dev`, commit and PR conventions, the docs mirrors).
- `.github/instructions/commit-messages.instructions.md` — commit message convention (Conventional Commits: `<type>(<scope>): <subject>`, types `feat`/`fix`/`docs`/`style`/`refactor`/`test`/`chore`/`perf`/`ci`). Follow this for any commit made in this repo.

## Syncing the WordPress documentation mirrors

Three mirrors of developer.wordpress.org content live under `docs/wordpress/`. Each has an `index.md` that is its source of truth: an `## Index` table (`Index | Name | Document | Reference Url | Last Synced On | Notes`) mapping each page to a local `.md` file and the live page it was sourced from.

| Mirror | Folder | Command | `researcher` mode |
| --- | --- | --- | --- |
| Plugin Handbook | `docs/wordpress/wordpress-plugins/` | `/sync-wordpress-plugin-docs` | `wordpress-plugin-docs` |
| REST API Handbook | `docs/wordpress/api-reference/wordpress-rest-apis/` | `/sync-wordpress-rest-api-docs` | `wordpress-rest-api-docs` |
| WP-CLI commands | `docs/wordpress/api-reference/wp-cli-commands/` | `/sync-wordpress-wp-cli-command-docs` | `wordpress-wp-cli-command-docs` |

- Run the matching command (optionally with an Index number or Name to limit it to some rows) to refresh rows against their live source. Each command invokes the `researcher` subagent in that mode, which uses Playwright MCP browser tools to fetch actual rendered content — never paraphrase from memory. The `researcher` agent also has a `general` mode for open-ended research that writes nothing by default. Its definition, `.claude/agents/researcher.md`, holds the full sync procedure and per-mode rules; the scheduled GitHub workflows read it too.
- These mirrors are generated: don't hand-edit files inside them, since the next sync overwrites the edits. The Index tables fix the folder layout and numbering; sync never adds, renames or renumbers anything.
- Full conventions (folder/file layout, Index table format, document skeleton, content-fidelity rules, formatting mechanics) live in `docs/styles/WORDPRESS-PLUGIN-DOCS-STYLE.md`. If you change a convention there, update the Plugin Handbook mode of `.claude/agents/researcher.md` to match — the two are meant to stay identical.
- This repo's `.mcp.json` defines its own headless `playwright` MCP server (`mcp__playwright__*`, run with `--headless`). The `researcher` agent is scoped to that server specifically — do not substitute a different Playwright MCP server (e.g. one provided by another plugin), since its headlessness isn't guaranteed.

## The `credentials-manager-plugin`

`src/credentials-manager-plugin/SPECIFICATION.md` is the authoritative spec — read it before changing this plugin's architecture. Key points:

- `SPECIFICATION.md` describes the plugin as it currently is; the version-by-version history of how it got there (superseded designs, renames, live-data migrations) lives in `src/credentials-manager-plugin/CHANGE_LOG.md`, and the spec's `(§10 vNN)` cross-references point at the numbered entries in that file. **Every code change to a plugin gets a new entry in that plugin's own `CHANGE_LOG.md`** (create it if the plugin has none) — including bug fixes, refactors, and internal-only changes, not just features; the `developer` agent is instructed to do this. Don't grow a second history inside `SPECIFICATION.md`.
- Modeled on Contact Form 7's admin UX: **not** a custom post type. Four custom database tables, each with its own dedicated admin screen (list + add/edit form): `{$wpdb->prefix}credentials` and `{$wpdb->prefix}credential_blocks` (the core entities), plus `{$wpdb->prefix}microsoft_certifications` and `{$wpdb->prefix}microsoft_exams` (standalone, admin-only reference tables of Microsoft Learn catalog entries, filled by a "Sync" action on their list screens; unrelated to the other two and not exposed by the shortcode). A `[credential-block id="..."]` shortcode renders a saved selection of credentials on the front end. The Credentials list is a React screen; the other three lists are still `WP_List_Table`-based. (The second entity was called "Credential Form" until a rename to "Credential Block" — see CHANGE_LOG.md v4 for the live-data table migration that involved.)
- All `$wpdb` access for all four tables is meant to go through a single shared data-layer class (`Credpl_Data`), used by the admin screens and the shortcode renderer, so query shape/escaping/sanitization live in one place.
- Table creation and versioning follow the pattern in `includes/class-credpl-installer.php`: `Credpl_Installer::install()` runs `dbDelta()` on activation (`register_activation_hook`) and is re-run from a `plugins_loaded` hook (`maybe_upgrade()`) whenever the stored `credpl_db_version` option doesn't match `CREDPL_DB_VERSION`, since activation hooks don't fire on plugin updates.
- `uninstall.php` is intentionally a no-op — all the plugin's tables and their rows are left in place on uninstall, not dropped.
- Five admin screens are **React apps** written in TypeScript/TSX on Fluent UI 9 and built via `@wordpress/scripts` — see SPECIFICATION.md §6.2.1/§6.2.2/§6.2.3. Entry points are in `src/` (`credential.tsx`, `credentials-list.tsx`, `credentials-block.tsx`, `ms-certification.tsx`, `ms-exam.tsx`), mapped by an explicit multi-entry `webpack.config.js` (the `@wordpress/scripts` default only finds `src/index.js`); shared components are in `src/components/`, per-screen `makeStyles()` hooks in `src/styles/`. Run `npm install && npm run build` from `src/credentials-manager-plugin/` after editing anything under `src/`; the compiled `build/<entry>.js` + `build/<entry>.asset.php` are what's actually enqueued (and what ships in `dist/credentials-manager-plugin.zip`), not the TSX source. `npm run check-types` (`tsc --noEmit`) does the type checking — the build itself only strips types. The plugin's `Requires at least` is WP 6.6 (the automatic JSX runtime needs a script handle only registered from that version on).
- Security conventions used throughout: `manage_options` capability check on every admin screen/action, `wp_nonce_field()`/`check_admin_referer()` (or, for the React form, an equivalent nonce passed through localized data) on every save/delete, `$wpdb->insert()`/`update()`/`delete()` (never raw `query()`), and output escaped with `esc_html()`/`esc_url()`/`esc_attr()` at render time.
