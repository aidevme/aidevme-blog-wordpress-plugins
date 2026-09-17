# Credentials Plugin — Specification

## 1. Overview

A WordPress plugin that creates and manages a custom database table, `{$wpdb->prefix}credentials`, for storing credential records (e.g. certifications, badges, or issued documents) outside of the standard Posts/Post Meta system.

- **Plugin slug:** `credentials-plugin`
- **Text domain:** `credentials-plugin`
- **Function/class prefix:** `credpl_` (procedural) / `Credpl_` (classes) — see [Naming Conventions](#7-naming-conventions--prefixing)
- **Minimum requirements:** WordPress 6.0+, PHP 7.4+

## 2. Goals

- Create a dedicated `credentials` table automatically when the plugin is activated.
- Keep the table structure upgradeable across future plugin versions without requiring manual intervention.
- Provide a minimal, safe data-access layer (insert / get / update / delete) so the table is usable from day one.
- Follow WordPress core conventions for custom tables (`dbDelta()`, `$wpdb->prefix`, activation hooks, sanitized/escaped I/O).

## 3. Non-Goals (out of scope for this specification)

- Admin UI (list table, add/edit screens) — not specified yet; can be a follow-up spec.
- REST API endpoints or Gutenberg blocks — not specified yet.
- Front-end display templates or shortcodes — not specified yet.
- Import/export tooling.

## 4. Data Model

### 4.1 Table

| Property | Value |
| --- | --- |
| Table name | `{$wpdb->prefix}credentials` (e.g. `wp_credentials` on a default install) |
| Engine / charset | Whatever `$wpdb->get_charset_collate()` returns for the site (do not hard-code) |
| Created by | `credpl_install()`, run on `register_activation_hook()` |
| Structure managed by | `dbDelta()` (see [Table Creation](#5-table-creation)) |

### 4.2 Columns

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | `PRIMARY KEY` | Internal numeric identifier. |
| `guid` | `CHAR(36)` | NOT NULL | — | `UNIQUE KEY` | Globally unique identifier (UUID v4) for the credential, stable across exports/environments. |
| `link` | `VARCHAR(255)` | NOT NULL | `''` | — | URL to the credential (verification page or issuing platform link). |
| `badge_link` | `VARCHAR(255)` | NOT NULL | `''` | — | URL to the credential's badge (e.g. a Credly/Open Badges verification URL), distinct from the general `link`. |
| `badge_media` | `BIGINT(20) UNSIGNED` | NOT NULL | `0` | `KEY` (index) | WordPress media library attachment ID (`{$wpdb->prefix}posts.ID` where `post_type = 'attachment'`) for the badge image. |
| `slug` | `VARCHAR(200)` | NOT NULL | `''` | `UNIQUE KEY` | URL-friendly identifier for the credential, used for front-end permalinks/lookups. |
| `title` | `VARCHAR(255)` | NOT NULL | `''` | `KEY` (index) | Human-readable name of the credential. |
| `issuer` | `VARCHAR(255)` | NOT NULL | `''` | `KEY` (index) | Organization or authority that issued the credential. |
| `author` | `BIGINT(20) UNSIGNED` | NOT NULL | `0` | `KEY` (index) | WordPress user ID (`{$wpdb->prefix}users.ID`) that owns/created this record — mirrors `post_author` semantics. |

**Assumptions:**

- `author` stores a numeric WordPress user ID (not a free-text name), consistent with `wp_posts.post_author`. Flag if a free-text "issuing author" field is actually intended instead — that would need its own column.
- `badge_media` stores a WordPress media library attachment ID rather than a raw image URL, so the badge image is managed through the standard Media Library (`wp_get_attachment_image_url()`, etc.). Flag if an external badge image URL (not uploaded to this site) is intended instead — that would make it a `VARCHAR(255)` like `badge_link`.

### 4.3 Suggested `CREATE TABLE` SQL (via `dbDelta()`)

`dbDelta()` requires each field on its own line, two spaces before `PRIMARY KEY`, uppercase SQL keywords, lowercase field types, and no backticks/apostrophes around field names — see [Creating Tables with Plugins](../../docs/wordpress/wordpress-plugins/21-creating-tables-with-plugins/creating-tables-with-plugins.md).

```php
$table_name      = $wpdb->prefix . 'credentials';
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  guid char(36) NOT NULL,
  link varchar(255) NOT NULL DEFAULT '',
  badge_link varchar(255) NOT NULL DEFAULT '',
  badge_media bigint(20) unsigned NOT NULL DEFAULT 0,
  slug varchar(200) NOT NULL DEFAULT '',
  title varchar(255) NOT NULL DEFAULT '',
  issuer varchar(255) NOT NULL DEFAULT '',
  author bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (id),
  UNIQUE KEY guid (guid),
  UNIQUE KEY slug (slug),
  KEY title (title),
  KEY issuer (issuer),
  KEY author (author),
  KEY badge_media (badge_media)
) $charset_collate;";
```

### 4.4 Open questions (recommended, not assumed)

These are not part of the requested column list, so they're **not** included in §4.2/4.3 — call these out to confirm before implementation:

- Should `created_at` / `updated_at` (`DATETIME`) columns be added for auditing? Almost every custom table benefits from these.
- Should there be a `status` column (e.g. `draft` / `published` / `revoked`) to control visibility without deleting rows?
- Should `guid` be generated by PHP (e.g. `wp_generate_uuid4()`) at insert time, or supplied by the caller (e.g. imported from an external credentialing system)?

## 5. Table Creation

Following the pattern in [Creating Tables with Plugins](../../docs/wordpress/wordpress-plugins/21-creating-tables-with-plugins/creating-tables-with-plugins.md) and [Activation / Deactivation Hooks](../../docs/wordpress/wordpress-plugins/03-plugin-basics/activation-deactivation-hooks.md):

1. `credpl_install()` builds `$table_name` from `$wpdb->prefix`, loads `wp-admin/includes/upgrade.php`, and calls `dbDelta( $sql )` with the SQL in §4.3.
2. `credpl_install()` also stores a schema version option: `add_option( 'credpl_db_version', CREDPL_DB_VERSION )`.
3. `register_activation_hook( __FILE__, 'credpl_install' )` runs the installer when the plugin is activated.
4. Because `register_activation_hook()` does **not** fire on plugin update (since WP 3.1), also hook `plugins_loaded` to compare `get_option( 'credpl_db_version' )` against the current `CREDPL_DB_VERSION` constant and re-run `credpl_install()` (which is `dbDelta()`-safe/idempotent) when they differ.
5. Uninstallation (via `uninstall.php`, checking `WP_UNINSTALL_PLUGIN`) is **not** enabled by default — dropping a credentials table on uninstall is destructive and should be an explicit, confirmed setting rather than automatic. Default behavior: leave the table in place on uninstall; expose a settings toggle later if "remove all data on uninstall" is wanted.

## 6. Data Access Layer (minimal)

A small set of wrapper functions/class methods so other code never writes raw SQL against this table directly:

- `credpl_insert_credential( array $data ): int|WP_Error` — validates required fields (`link`, `slug`, `title`, `issuer`), generates a `guid` if not supplied, sets `author` to the current user if not supplied, and calls `$wpdb->insert()` (which auto-escapes values).
- `credpl_get_credential( int $id ): array|null` — fetches a single row by `id`.
- `credpl_get_credential_by_slug( string $slug ): array|null` — fetches a single row by `slug`.
- `credpl_get_credential_by_guid( string $guid ): array|null` — fetches a single row by `guid`.
- `credpl_update_credential( int $id, array $data ): bool` — updates specified fields via `$wpdb->update()`.
- `credpl_delete_credential( int $id ): bool` — deletes a row via `$wpdb->delete()`.

All read paths that accept caller input (e.g. `$slug`, `$guid`) must validate/sanitize before querying, and any output rendered to HTML must be escaped at output time — see [Data Validation](../../docs/wordpress/wordpress-plugins/04-plugin-security/data-validation.md) and [Securing (escaping) Output](../../docs/wordpress/wordpress-plugins/04-plugin-security/securing-escaping-output.md).

## 7. Naming Conventions / Prefixing

Per [Best Practices](../../docs/wordpress/wordpress-plugins/03-plugin-basics/best-practices.md):

- All global functions, classes, options, and the DB table itself are prefixed `credpl_` / `Credpl_` — never `wp_`, `__`, or an unprefixed name.
- The schema-version option is `credpl_db_version`.
- The main plugin file is `credentials-plugin.php`, containing the plugin header (see [Header Requirements](../../docs/wordpress/wordpress-plugins/03-plugin-basics/header-requirements.md)) with at minimum `Plugin Name`, `Version`, `Requires at least`, `Requires PHP`, `License`, `Text Domain`.

## 8. Suggested File Structure

```
credentials-plugin/
  credentials-plugin.php      (plugin header + bootstrap, hooks in install/upgrade)
  includes/
    class-credpl-installer.php   (credpl_install(), version-check/upgrade logic)
    class-credpl-data.php        (CRUD wrapper functions in §6)
  uninstall.php                  (present but a no-op by default, per §5)
```

## 9. Security Considerations

- Use `$wpdb->insert()` / `$wpdb->update()` / `$wpdb->delete()` (not raw `$wpdb->query()`) wherever possible — these auto-escape values.
- If a raw query is ever unavoidable, use `$wpdb->prepare()`.
- Validate all external input (e.g. `slug`, `guid` format) before querying; see [Checking User Capabilities](../../docs/wordpress/wordpress-plugins/04-plugin-security/checking-user-capabilities.md) for any future admin-facing write actions (`current_user_can()` gate + nonce).

## 10. Acceptance Criteria

- Activating the plugin creates `{$wpdb->prefix}credentials` with exactly the columns in §4.2, and `credpl_db_version` is set.
- Reactivating, or upgrading to a new plugin version with a changed `CREDPL_DB_VERSION`, updates the table structure via `dbDelta()` without data loss.
- Deactivating the plugin leaves the table and its data untouched.
- Uninstalling (delete) the plugin leaves the table and its data untouched, by default.
- The data-access functions in §6 correctly insert, read, update, and delete rows, with `guid` and `slug` enforced unique at the database level.
