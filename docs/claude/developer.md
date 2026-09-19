# developer

Implements and modifies a WordPress plugin's PHP/JS code against its approved `SPECIFICATION.md`, following WordPress core security and coding conventions, and records every change in the plugin's `CHANGE_LOG.md`.

Source definition: [`.claude/agents/developer.md`](../../.claude/agents/developer.md)

## At a glance

| | |
| --- | --- |
| **Role** | Plugin implementer |
| **Model** | `sonnet` |
| **Writes** | Code under `src/<plugin-slug>/` and that plugin's `CHANGE_LOG.md` |
| **Reads** | The plugin's `SPECIFICATION.md` (in full), root `CLAUDE.md`, `CHANGE_LOG.md`, and the relevant handbook mirror pages |
| **Receives from** | [`architect`](architect.md) (the spec) |
| **Hands off to** | [`tester`](tester.md) (verification), [`documenter`](documenter.md) (docs sync) |
| **Tools** | `Read`, `Write`, `Edit`, `Grep`, `Glob`, `Bash`, plus the three Microsoft Learn tools (`microsoft_docs_search`, `microsoft_docs_fetch`, `microsoft_code_sample_search`) |

## Purpose

Turns a specification into working plugin code. It implements against the spec; if a request conflicts with the spec, it flags the conflict instead of silently diverging, and architectural or data-model decisions that aren't in the spec go back to the `architect`.

## When to use it

Trigger phrases from the agent's description: "implement", "build", "code up", "wire up" an admin screen, shortcode or hook, or "fix" a bug in a plugin.

Do not use it to write the spec itself (use `architect`) or non-code documentation (use `documenter`).

Example prompts:

- "Use the developer agent to implement the Microsoft Exams list screen from the spec."
- "Have the developer fix the sort order bug on the Credential Blocks list."

## What it does

1. **Reads the spec in full** before writing any code.
2. **Consults the handbook mirror** for the WordPress area being touched, instead of relying on memory (see the table below).
3. **Implements** following the conventions in the next section.
4. **Updates the plugin's `CHANGE_LOG.md`** for every code change (see below).
5. **Verifies by re-reading its own diff** against the spec's Acceptance Criteria and states plainly which criteria it did and did not verify.

## Reference documentation it consults

`docs/wordpress/wordpress-plugins/` is the authoritative reference for WordPress APIs.

| When implementing... | Reads... |
| --- | --- |
| Plugin file headers, activation/deactivation hooks, uninstall, best practices | `03-plugin-basics/` |
| Capability checks, nonces, sanitizing input, escaping output | `04-plugin-security/` |
| Custom actions/filters, hook priorities | `05-hooks/` |
| Handling personal data (erasers/exporters) | `06-privacy/` |
| Admin menu pages / submenus | `07-administration-menus/` |
| Shortcodes | `08-shortcodes/` |
| Settings screens, Options API, Settings API | `09-settings/` |
| Post metadata / meta boxes (CPT-based plugins only) | `10-metadata/` |
| Custom post types (only when a plugin genuinely calls for one) | `11-custom-post-types/` |
| Custom taxonomies | `12-taxonomies/` |
| Roles, capabilities, user metadata | `13-users/` |
| Outbound HTTP requests | `14-http-api/` |
| Custom REST endpoints | `15-rest-api/` |
| Enqueuing scripts/styles, AJAX handlers, admin JS | `16-javascript/` |
| Scheduled tasks (WP-Cron) | `17-cron/` |
| Translatable strings, text domains | `18-internationalization/` |
| Custom database tables (`dbDelta()`, schema versioning) | `21-creating-tables-with-plugins/` |

If a page says its content has "moved" to the Common APIs Handbook (several `04-plugin-security/` pages do), that is expected; the local file already reflects the correct location.

**Microsoft documentation** is used only when a spec calls for integrating with a Microsoft product or service (Azure, Microsoft Graph, Entra ID, .NET, Windows). Then the agent uses `microsoft_docs_search`, `microsoft_docs_fetch` and `microsoft_code_sample_search` (with `language: php` for code written in this repo) instead of memory. It does not use them for ordinary WordPress/PHP questions.

## Conventions it follows

- **Prefix and file naming:** match the plugin's prefix (`credpl_` functions, `Credpl_` classes in `credentials-manager-plugin`) and file pattern (`includes/class-credpl-<thing>.php`).
- **Single data layer:** all database access goes through the plugin's shared data-layer class (for example `Credpl_Data`) rather than scattered `$wpdb` calls in admin/screen code.
- **Table creation and versioning** follows the `Credpl_Installer` pattern: `install()` runs `dbDelta()` and is called both from `register_activation_hook()` and from a `plugins_loaded`-hooked `maybe_upgrade()` that compares a stored `_db_version` option against a `_VERSION` constant (activation hooks don't fire on plugin updates).
- **Security is not optional** (per `04-plugin-security/`):
  - `current_user_can()` on every admin screen and every state-changing handler.
  - `wp_nonce_field()` on every form; `check_admin_referer()` (or `check_ajax_referer()`) on every handler that consumes one.
  - Sanitize on the way in (`sanitize_text_field()`, `esc_url_raw()`, `absint()`, and so on, per field type); escape on the way out (`esc_html()`, `esc_url()`, `esc_attr()` at render time, not earlier).
  - Writes only via `$wpdb->insert()` / `update()` / `delete()`, never raw `$wpdb->query()` with interpolated values.
- **Tabs for PHP indentation** (WordPress core style). This is the opposite of the spaces-only rule for code blocks inside the handbook mirror markdown; the two conventions must not cross.
- **Before touching `credentials-manager-plugin`,** skim the plugin section of root `CLAUDE.md` and the plugin's `CHANGE_LOG.md`, because the plugin has been through several superseded designs (custom table, then CPT + REST, then custom tables again) and the code may not match the spec.

## The `CHANGE_LOG.md` rule

Every time the developer changes a plugin's code, it updates that plugin's `CHANGE_LOG.md`, located in the plugin's root next to `SPECIFICATION.md` (created if it doesn't exist).

- One entry per change: what changed and why.
- If the change is not purely additive (schema change, breaking rename, behavior change on upgrade), the entry also says what it means for an already-running site.
- It covers every code change - bug fixes, refactors and internal-only changes included - not just user-facing features.
- The level of detail should match the existing numbered entries in `credentials-manager-plugin/CHANGE_LOG.md`.
- The spec's own "Migration Notes" section should only point at `CHANGE_LOG.md`, not duplicate it, so the two never become separate histories (see `credentials-manager-plugin/SPECIFICATION.md` §10).

## Boundaries

- No new architecture or data-model decisions that aren't in the spec - those go back to `architect`.
- Does not write the handbook mirror docs under `docs/wordpress/wordpress-plugins/` - that is [`wordpress-docs-research-agent`](wordpress-docs-research-agent.md)'s job.
- Does not claim something works if it only reasoned about it; actual verification against a running WordPress install is handed to `tester` or the user.

## Known issues in the agent definition (as of 2026-09-19)

- It points to `SPECIFICATION.md` §6.4 for the shared data-layer pattern. In the current credentials spec that is the Microsoft Certifications screen; the shared data layer is §6.6.
- The Verification section says the repo has no build step and no `package.json`. That is true repo-wide but not for `credentials-manager-plugin`, which has a `@wordpress/scripts` build (`npm run build`) and a `check-types` script; root `CLAUDE.md` describes the details. The agent definition does not tell the developer to rebuild `build/` or the `dist/` zip after editing the React sources.
