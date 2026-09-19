# Credentials Manager Plugin — Specification

## 1. Overview

A WordPress plugin modeled on **Contact Form 7's** admin UX: four dedicated, fully custom admin screens (not the standard post editor, not a custom post type) for managing structured data, plus a shortcode to embed the result in any page or post.

- **Credentials** — individual records (a certification, badge, or issued credential): title, external link, badge link, badge image, issuer. Managed on their own "Credentials" admin screen — created, listed, edited, deleted — like rows in a spreadsheet, not blog posts.
- **Credential Blocks** — a named, saved selection of existing Credential records (e.g. "Homepage Badges," "AWS Certifications"). Managed on a separate "Credential Blocks" admin screen. Saving a block generates a unique shortcode, shown right there in the editor (exactly like Contact Form 7 shows `[contact-form-7 id="..." title="..."]` after you save a form):

  ```text
  [credential-block id="a2949a2"]
  ```

  Pasting that shortcode into any page or post renders the selected credentials.

- **Microsoft Certifications** — a separate, unrelated reference table of Microsoft Learn certification catalog entries (uid, title, subtitle, URL, icon, exams, levels, roles, etc. — §4.3), sourced from data shaped like [Microsoft Learn's certification catalog](https://learn.microsoft.com/en-us/credentials/certifications/). Managed on its own "Microsoft Certifications" admin screen, same List + React Add/Edit architecture as Credentials, but not connected to Credentials, Credential Blocks, or the `[credential-block]` shortcode in any way (§3) — added purely as a browsable/editable reference table. Has a **Sync Certifications** button (§6.4) that fetches Microsoft Learn's live catalog API and creates/updates rows automatically.
- **Microsoft Exams** — a sibling reference table (uid, title, subtitle, display name, URL, icon, locales, courses, levels, roles, products, providers, etc. — §4.4) for individual exam catalog entries, e.g. `MB-300`. Same standalone, admin-only architecture as Microsoft Certifications; the two aren't linked by an enforced relationship even though a certification's `exams` array names exam `uid`s that correspond to rows here (§3). Has its own **Sync Exams** button (§6.5), reading the `exams` array from the very same catalog API response Microsoft Certifications' sync already fetches.
- **Plugin slug:** `credentials-manager-plugin`
- **Text domain:** `credentials-manager-plugin`
- **Function/class prefix:** `credpl_` (procedural) / `Credpl_` (classes)
- **Minimum requirements:** WordPress 6.6+, PHP 7.4+ (bumped from 6.0 — see §6.2 for why the Credential add/edit form needs 6.6)
- **Author (Plugins screen):** `AIDevMe`, set via the `Author:` plugin header. A **"View details"** link is added next to it on the Plugins list (`credpl_plugin_row_meta()`, hooked to `plugin_row_meta`) — this link doesn't appear automatically since the plugin isn't hosted on WordPress.org, so it's added manually as a placeholder (`href="#"`) until a real details destination exists.

> **This replaces earlier versions of this spec** — first a custom database table with a hand-rolled REST/CRUD layer, then a Custom Post Type exposed at `/wp-json/wp/v2/credentials`, then a Contact-Form-7-style design that called this second entity a "Credential Form." All superseded. See §10 (Migration Notes) — the v3→v4 rename (Form → Block) in particular involves a live-data table migration, not just a find-and-replace.

## 2. Goals

- Store Credentials, Credential Blocks, Microsoft Certifications, and Microsoft Exams in **four dedicated custom database tables** — not `wp_posts`, not a custom post type.
- Give Credentials their own admin screen: a list (via `WP_List_Table`, the same framework Contact Form 7 and WordPress core itself use for admin lists) plus a React-based add/edit form — title, credential link, badge link, badge image (media picker), issuer.
- Give Credential Blocks their own admin screen: a list plus a plain add/edit form — a title, and a checklist to pick which existing Credential records belong to this block.
- On saving a Credential Block, generate a short, unique, non-guessable `id` (e.g. `a2949a2`) and display the ready-to-copy `[credential-block id="..."]` shortcode, exactly as Contact Form 7 does for its own shortcode.
- Register the `[credential-block]` shortcode so pasting it into any page/post content renders that block's selected credentials on the front end.
- Give Microsoft Certifications their own admin screen — same List + React Add/Edit architecture as Credentials — for browsing/maintaining a reference table of Microsoft Learn certification catalog entries (§4.3, §6.4).
- Give Microsoft Exams their own admin screen, same architecture again (including its own **Sync Exams** button), for the sibling reference table of individual exam catalog entries (§4.4, §6.5).

## 3. Non-Goals

- REST API exposure (this spec previously targeted `/wp-json/wp/v2/credentials` via a Custom Post Type; that approach is dropped along with the CPT — see §10). A REST API over these tables could be added later under the plugin's own namespace (e.g. `credentials-manager-plugin/v1`), but isn't part of this spec.
- A drag-and-drop or visually customizable per-block template (unlike Contact Form 7's editable form-tag markup) — a Credential Block is simply an ordered set of existing Credential records rendered with one default template (§7). Custom per-block layouts aren't specified.
- Front-end submission of new Credentials by site visitors — Credentials are authored by admins/editors only, on the back end.
- Import/export tooling.
- Any relationship between Microsoft Certifications/Microsoft Exams and Credentials/Credential Blocks — no shared IDs, no picker, no shortcode integration. Both are standalone reference tables (§4.3, §4.4, §6.4, §6.5); connecting either to Credentials (e.g. letting a Credential reference a Microsoft Certification row) isn't specified here.
- A real, enforced relationship *between* Microsoft Certifications and Microsoft Exams — a certification's `exams` array (§4.3) stores exam `uid`s that correspond to `microsoft_exams.uid` (§4.4) rows, but nothing in this plugin validates, looks up, or links them (no foreign key, no "view this exam" link from a certification's edit screen). They're two independently synced/maintained tables that happen to share an identifier convention.
- A *combined* sync that populates both Microsoft Certifications and Microsoft Exams from a single button/request — each table's Sync action (§6.4, §6.5) independently calls `wp_remote_get()` against the same `CATALOG_API_URL` and reads its own half of the response (`certifications` or `exams`); clicking both buttons therefore fetches that URL twice rather than sharing one fetched response between them. Combining them into one request is a possible follow-up, not specified here.

## 4. Data Model

### 4.1 Table: `{$wpdb->prefix}credentials`

One row per credential record.

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | `PRIMARY KEY` | Internal identifier. |
| `title` | `VARCHAR(255)` | NOT NULL | `''` | `KEY` (index) | Human-readable name of the credential. |
| `credentials_type` | `VARCHAR(50)` | NOT NULL | `''` | — | One of a fixed set of categories: `Applied Skills`, `Certifications`, `Awards` (`Credpl_Admin_Credentials::CREDENTIALS_TYPES`). Chosen via a Fluent UI `Dropdown` on the Add/Edit form (§6.2); any other value submitted is rejected server-side back to `''` (§8). |
| `status` | `VARCHAR(20)` | NOT NULL | `''` | — | One of a fixed set of values: `Active`, `Expired` (`Credpl_Admin_Credentials::STATUSES`). Chosen via a Fluent UI `Dropdown` on the Add/Edit form (§6.2), same pattern as `credentials_type`; any other value submitted is rejected server-side back to `''` (§8). Set manually, not derived from `expires_on`. |
| `award_category` | `VARCHAR(255)` | NOT NULL | `''` | — | Free-text award category (e.g. "MVP", "Employee of the Year") — unlike `credentials_type`/`status`, not validated against a fixed list; the source data's actual range of values isn't specified. Rendered on the front end (§7) as an "Award Category: …" line, but only for credentials whose `credentials_type` is `Awards`, and only when this field is non-empty. |
| `technology_area` | `VARCHAR(255)` | NOT NULL | `''` | — | Free-text technology/product area the credential relates to (e.g. "Power Platform", "Dynamics 365"). Same free-text reasoning as `award_category`, and rendered the same conditional way — a "Technology Area: …" line, `Awards`-type credentials only, only when non-empty. |
| `credential_link` | `VARCHAR(255)` | NOT NULL | `''` | — | URL to the credential's external verification/issuing page. |
| `badge_media` | `BIGINT(20) UNSIGNED` | NOT NULL | `0` | `KEY` (index) | WordPress media library attachment ID for the badge image. |
| `issuer` | `VARCHAR(255)` | NOT NULL | `''` | `KEY` (index) | Organization or authority that issued the credential. |
| `credential_id` | `VARCHAR(255)` | NOT NULL | `''` | `KEY` (index) | The issuing platform's own identifier for this specific issued credential (e.g. a Credly credential ID) — **distinct from `id`** (this table's own primary key) and from `certification_number` below. |
| `certification_number` | `VARCHAR(255)` | NOT NULL | `''` | — | The certification/license number tied to the certification program itself (e.g. an exam or licensing board's reference number), as opposed to this one issued instance of it. |
| `earned_on` | `DATE` | NULL | `NULL` | — | Date the credential was earned/issued. No time component — just a calendar date. |
| `expires_on` | `DATE` | NULL | `NULL` | `KEY` (index) | Date the credential expires, if it does. `NULL` for credentials that don't expire. |
| `description` | `TEXT` | NULL | `NULL` | — | Free-text notes about the credential. Can't carry a MySQL column default (see the `credential_ids` note in §4.2) — always written explicitly (as `''` when empty) by `Credpl_Data::insert_credential()`. |
| `created_at` | `DATETIME` | NULL | `NULL` | — | Set once, at insert. |
| `updated_at` | `DATETIME` | NULL | `NULL` | — | Refreshed on every update. |

### 4.2 Table: `{$wpdb->prefix}credential_blocks`

One row per saved Credential Block (a named selection of Credentials). Named `credential_blocks` — was `credential_forms` (with a `form_key` column) prior to the Form→Block rename; see §10 for the migration that renames the table in place on sites that already have data in the old name.

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | `PRIMARY KEY` | Internal identifier. |
| `block_key` | `VARCHAR(20)` | NOT NULL | — | `UNIQUE KEY` | Short, unique, non-guessable public identifier — the `id` attribute used in the `[credential-block id="…"]` shortcode. Generated once at creation (§6.3); never the raw auto-increment `id`. |
| `title` | `VARCHAR(255)` | NOT NULL | `''` | — | Admin-facing name for this block (e.g. "Homepage Badges"). Also the heading rendered above the block's credential list on the front end (§7) — not overridable per-shortcode-instance. |
| `description` | `TEXT` | NULL | `NULL` | — | Free-text, admin-facing notes about this block (e.g. what it's used for). Can't carry a MySQL column default (see the `credential_ids` note below), always written explicitly (as `''` when empty) by `Credpl_Data::insert_credential_block()`. Not currently rendered on the front end (§7) — admin-only, same as `credentials.description` (§4.1). |
| `credential_ids` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of `credentials.id` values, in display order (e.g. `[5,2,9]`). |
| `created_at` | `DATETIME` | NULL | `NULL` | — | Set once, at insert. |
| `updated_at` | `DATETIME` | NULL | `NULL` | — | Refreshed on every update. |

### 4.3 Table: `{$wpdb->prefix}microsoft_certifications`

One row per Microsoft Learn certification catalog entry. Standalone reference data — no relationship to `credentials` or `credential_blocks` (§3). Managed on the "Microsoft Certifications" admin screen (`Credpl_Admin_Ms_Certifications`, §6.4); not exposed via the `[credential-block]` shortcode or any other front-end output.

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | `PRIMARY KEY` | Internal identifier. |
| `uid` | `VARCHAR(255)` | NOT NULL | — | `UNIQUE KEY` | Stable external identifier from the source data (e.g. `certification.mcsa-windows-server-certification`). Unlike `credential_blocks.block_key`, this is admin-typed, not server-generated — `Credpl_Data::ms_certification_uid_exists()` is checked before every insert/update so a duplicate surfaces as a friendly validation error rather than a raw database constraint failure. |
| `title` | `VARCHAR(255)` | NOT NULL | `''` | `KEY` (index) | Certification name, e.g. "MCSA: Windows Server 2012". |
| `subtitle` | `LONGTEXT` | NULL | `NULL` | — | Rich description, may contain HTML (as in the source data — e.g. a `<div class="WARNING">…</div>` retirement notice). Sanitized with `wp_kses_post()` on save, not `sanitize_text_field()`/`sanitize_textarea_field()` — both of those would strip the HTML entirely. |
| `url` | `VARCHAR(500)` | NOT NULL | `''` | — | Link to the certification's page on Microsoft Learn. `VARCHAR(500)`, not `255` like `credentials.credential_link` — Microsoft Learn URLs routinely carry long tracking query strings (e.g. `?WT.mc_id=…`). |
| `icon_url` | `VARCHAR(500)` | NOT NULL | `''` | — | URL to the certification's badge/icon image (an external URL, e.g. an SVG on Microsoft's own CDN — unlike `credentials.badge_media`, this is not a WordPress media library attachment ID, so no `wp_enqueue_media()`/picker is needed on the form). |
| `last_modified` | `DATETIME` | NULL | `NULL` | — | When the source data was last updated. Stored as a naive `Y-m-d H:i:s` (the source data's own ISO 8601 timezone offset, e.g. `+00:00`, is not preserved — see §6.4). |
| `type` | `VARCHAR(50)` | NOT NULL | `''` | — | The source data's own top-level category, e.g. `cert`. Free text — not validated against a fixed list, unlike `credentials.credentials_type`/`credentials.status` (§4.1), since the source data's actual range of values isn't specified here. |
| `certification_type` | `VARCHAR(100)` | NOT NULL | `''` | `KEY` (index) | The source data's own certification-family code, e.g. `mcsa`. Free text, same reasoning as `type`. |
| `exams` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of exam UIDs, e.g. `["exam.70-410","exam.70-411","exam.70-412"]`. Edited on the form as one value per line in a plain Textarea, not a picker — unlike `credential_blocks.credential_ids`, these aren't references to another table in this plugin. |
| `levels` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["intermediate"]`. Same one-per-line Textarea editing as `exams`. |
| `roles` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["administrator"]`. Same one-per-line Textarea editing as `exams`. |
| `study_guide` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded value of unspecified shape (the source data shows it as `[]` in every example seen so far, but its real structure — e.g. an array of `{title, url}` resource objects — isn't known). Edited as raw JSON text (§6.4) rather than a purpose-built control, since no specific shape is specified to build one for. |
| `created_at` | `DATETIME` | NULL | `NULL` | — | Set once, at insert. |
| `updated_at` | `DATETIME` | NULL | `NULL` | — | Refreshed on every update. |

### 4.4 Table: `{$wpdb->prefix}microsoft_exams`

One row per Microsoft Learn exam catalog entry. Sibling table to `microsoft_certifications` (§4.3) — same "standalone reference data" status: no relationship to `credentials`/`credential_blocks` (§3), and (for now — see §3) no relationship to `microsoft_certifications` either, even though a certification's own `exams` array (§4.3) lists the `uid`s of rows here. Managed on the "Microsoft Exams" admin screen (`Credpl_Admin_Ms_Exams`, §6.5); not exposed via the `[credential-block]` shortcode or any other front-end output.

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | `PRIMARY KEY` | Internal identifier. |
| `uid` | `VARCHAR(255)` | NOT NULL | — | `UNIQUE KEY` | Stable external identifier from the source data (e.g. `exam.mb-300`) — this is what a `microsoft_certifications.exams` entry references, though nothing in this plugin enforces that relationship (§3). Admin-typed, not server-generated, same as `microsoft_certifications.uid` — `Credpl_Data::ms_exam_uid_exists()` is checked before every insert/update. |
| `title` | `VARCHAR(255)` | NOT NULL | `''` | `KEY` (index) | Exam name, e.g. "Microsoft Dynamics 365: Core Finance and Operations". |
| `subtitle` | `LONGTEXT` | NULL | `NULL` | — | Description of what the exam measures. May contain HTML in principle (the sample seen so far is plain text, but this is sanitized with `wp_kses_post()` on save, same as `microsoft_certifications.subtitle`, rather than assuming it never will). |
| `display_name` | `VARCHAR(255)` | NOT NULL | `''` | `KEY` (index) | Short exam code, e.g. `MB-300` — distinct from `title` (the long name) and `uid` (the internal identifier). |
| `url` | `VARCHAR(500)` | NOT NULL | `''` | — | Link to the exam's page on Microsoft Learn. `VARCHAR(500)`, same reasoning as `microsoft_certifications.url` (§4.3). |
| `icon_url` | `VARCHAR(500)` | NOT NULL | `''` | — | URL to the exam's badge/icon image — an external URL, not a media library attachment, same as `microsoft_certifications.icon_url`. |
| `locales` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of locale codes the exam is offered in (e.g. `["en-us"]`). Edited as one value per line in a plain Textarea, same pattern as `microsoft_certifications.exams` (§4.3) — not a picker, since these aren't references to another table. |
| `last_modified` | `DATETIME` | NULL | `NULL` | — | When the source data was last updated. Same naive `Y-m-d H:i:s` storage (source timezone offset not preserved) as `microsoft_certifications.last_modified`. |
| `type` | `VARCHAR(50)` | NOT NULL | `''` | — | The source data's own top-level category, e.g. `exam`. Free text, not validated against a fixed list, same reasoning as `microsoft_certifications.type`. |
| `courses` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of course UIDs associated with the exam. Same one-per-line Textarea editing as `locales`. |
| `levels` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["intermediate"]`. Same one-per-line Textarea editing as `locales`. |
| `roles` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["functional-consultant"]`. Same one-per-line Textarea editing as `locales`. |
| `products` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["dynamics-365","dynamics-finance"]` — the Microsoft product(s) the exam covers. This table has no single `certification_type`-equivalent column (§4.3); `products` is itself already an array in the source data. Same one-per-line Textarea editing as `locales`. |
| `providers` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings (e.g. third-party testing providers). Same one-per-line Textarea editing as `locales`. |
| `study_guide` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded value of unspecified shape, same as `microsoft_certifications.study_guide` (§4.3) — edited as raw JSON text (§6.5) rather than a purpose-built control. |
| `created_at` | `DATETIME` | NULL | `NULL` | — | Set once, at insert. |
| `updated_at` | `DATETIME` | NULL | `NULL` | — | Refreshed on every update. |

### 4.5 Suggested `CREATE TABLE` SQL (via `dbDelta()`)

```php
$charset_collate = $wpdb->get_charset_collate();

$credentials_table = $wpdb->prefix . 'credentials';
$sql_credentials = "CREATE TABLE $credentials_table (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL DEFAULT '',
  credentials_type varchar(50) NOT NULL DEFAULT '',
  status varchar(20) NOT NULL DEFAULT '',
  award_category varchar(255) NOT NULL DEFAULT '',
  technology_area varchar(255) NOT NULL DEFAULT '',
  credential_link varchar(255) NOT NULL DEFAULT '',
  badge_media bigint(20) unsigned NOT NULL DEFAULT 0,
  issuer varchar(255) NOT NULL DEFAULT '',
  credential_id varchar(255) NOT NULL DEFAULT '',
  certification_number varchar(255) NOT NULL DEFAULT '',
  earned_on date DEFAULT NULL,
  expires_on date DEFAULT NULL,
  description text,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY  (id),
  KEY title (title),
  KEY issuer (issuer),
  KEY badge_media (badge_media),
  KEY credential_id (credential_id),
  KEY expires_on (expires_on)
) $charset_collate;";

$blocks_table = $wpdb->prefix . 'credential_blocks';
$sql_blocks = "CREATE TABLE $blocks_table (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  block_key varchar(20) NOT NULL,
  title varchar(255) NOT NULL DEFAULT '',
  description text,
  credential_ids longtext NOT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY block_key (block_key)
) $charset_collate;";

$ms_certifications_table = $wpdb->prefix . 'microsoft_certifications';
$sql_ms_certifications = "CREATE TABLE $ms_certifications_table (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  uid varchar(255) NOT NULL,
  title varchar(255) NOT NULL DEFAULT '',
  subtitle longtext,
  url varchar(500) NOT NULL DEFAULT '',
  icon_url varchar(500) NOT NULL DEFAULT '',
  last_modified datetime DEFAULT NULL,
  type varchar(50) NOT NULL DEFAULT '',
  certification_type varchar(100) NOT NULL DEFAULT '',
  exams longtext NOT NULL,
  levels longtext NOT NULL,
  roles longtext NOT NULL,
  study_guide longtext NOT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY uid (uid),
  KEY title (title),
  KEY certification_type (certification_type)
) $charset_collate;";

$ms_exams_table = $wpdb->prefix . 'microsoft_exams';
$sql_ms_exams = "CREATE TABLE $ms_exams_table (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  uid varchar(255) NOT NULL,
  title varchar(255) NOT NULL DEFAULT '',
  subtitle longtext,
  display_name varchar(255) NOT NULL DEFAULT '',
  url varchar(500) NOT NULL DEFAULT '',
  icon_url varchar(500) NOT NULL DEFAULT '',
  locales longtext NOT NULL,
  last_modified datetime DEFAULT NULL,
  type varchar(50) NOT NULL DEFAULT '',
  courses longtext NOT NULL,
  levels longtext NOT NULL,
  roles longtext NOT NULL,
  products longtext NOT NULL,
  providers longtext NOT NULL,
  study_guide longtext NOT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY uid (uid),
  KEY title (title),
  KEY display_name (display_name)
) $charset_collate;";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta( $sql_credentials );
dbDelta( $sql_blocks );
dbDelta( $sql_ms_certifications );
dbDelta( $sql_ms_exams );
```

`longtext` (like `text`) can't carry a MySQL column `DEFAULT`, so `credential_ids` is always explicitly written on insert (defaulting to `'[]'` if a block is saved with nothing selected). Same reasoning applies to `credentials.description` (§4.1); in `microsoft_certifications` (§4.3), `subtitle`, `exams`, `levels`, `roles`, and `study_guide`; and in `microsoft_exams` (§4.4), `subtitle`, `locales`, `courses`, `levels`, `roles`, `products`, `providers`, and `study_guide` — all always written explicitly (as `''`/`'[]'` when empty) by `Credpl_Data::insert_credential()`/`insert_credential_block()`/`insert_ms_certification()`/`insert_ms_exam()` rather than relying on a column default.

Unlike the table *rename* in §10 (which `dbDelta()` cannot do on its own — it only creates tables or adds/alters columns on a table it already recognizes by name), adding new columns to an *existing* table is exactly what `dbDelta()` is designed for: it diffs the `CREATE TABLE` statement above against the table's actual current structure and runs the necessary `ALTER TABLE ... ADD COLUMN` statements itself. So `credential_id`, `certification_number`, `earned_on`, `expires_on`, and `description` (added after `credentials` already existed on real installs) needed no custom migration step — just updating this SQL and bumping `CREDPL_DB_VERSION` so `maybe_upgrade()` re-runs `install()`. The reverse — **dropping** a column, as `badge_link` was (§10) — is a case `dbDelta()` explicitly does *not* handle: it only ever adds or alters columns to match the `CREATE TABLE` statement, never drops one just because it's no longer listed. Removing a column for real needs the same kind of explicit migration step as the table rename.

## 5. Table Creation & Versioning

Following [Creating Tables with Plugins](../../docs/wordpress/wordpress-plugins/21-creating-tables-with-plugins/creating-tables-with-plugins.md) and [Activation / Deactivation Hooks](../../docs/wordpress/wordpress-plugins/03-plugin-basics/activation-deactivation-hooks.md):

1. `Credpl_Installer::install()` first runs a one-time migration (`maybe_rename_forms_table_to_blocks()`, §10) for sites upgrading from the pre-rename schema, then creates all four tables (§4.5) via `dbDelta()`.
2. **`install()` then verifies the result before trusting it, instead of assuming `dbDelta()` succeeded.** `dbDelta()` reports no failure of its own — on some hosts the WordPress database user lacks `ALTER` privileges, and the `ADD COLUMN` statements it runs internally fail completely silently. Without a check, `credpl_db_version` would still get marked "up to date," and every subsequent save would fail on a confusing "Unknown column" database error forever, since `maybe_upgrade()` (step 4) would never retry. So `install()` re-queries `DESCRIBE {$wpdb->prefix}credentials` afterward (`missing_credential_columns()`) and compares against the full expected column list: if anything is still missing, it stores that list in the `credpl_migration_missing_columns` option and returns **without** marking the schema version as up to date — leaving `maybe_upgrade()` free to keep retrying on every admin page load. A persistent `admin_notices` banner (`maybe_render_migration_notice()`, shown site-wide, not just on this plugin's own screens) then tells the site owner which columns are missing and that they likely need to ask their host for `ALTER` privileges — since that's not something any amount of retrying from inside the plugin can fix on its own.
3. Only once every expected column is confirmed present does `install()` call `update_option( 'credpl_db_version', CREDPL_DB_VERSION )` (and clear the missing-columns option, in case a previous run had failed and this one succeeded).
4. `register_activation_hook( __FILE__, array( 'Credpl_Installer', 'install' ) )` runs it on activation.
5. Since `register_activation_hook()` doesn't fire on plugin update, `Credpl_Installer::maybe_upgrade()` is hooked to `plugins_loaded`, comparing `get_option( 'credpl_db_version' )` against `CREDPL_DB_VERSION` and re-running `install()` (safe/idempotent via `dbDelta()`, and the migration step is itself idempotent — it no-ops once the new table exists) when they differ.
6. `uninstall.php` is a no-op by default — all four tables and their rows are left in place when the plugin is deleted, consistent with the earlier versions of this spec. Dropping user data automatically on uninstall is avoided.

## 6. Admin UI

Four admin screens, each with a list view and an add/edit view, all plain wp-admin pages (`add_menu_page()`/`add_submenu_page()` callbacks rendering HTML directly) — no post editor, no CPT, no meta boxes.

### 6.1 Menu structure

A top-level **"Credentials Manager"** menu (`dashicons-awards` icon), mirroring Contact Form 7's own "Contact" menu structure — the primary list (Credential Blocks) comes first, so clicking the top-level item itself lands on the Credential Blocks list, not the Credentials list. Five *visible* submenu items:

| Label | Screen |
| --- | --- |
| All Credential Blocks | Credential Blocks list (`WP_List_Table`) — also the top-level menu's own click target |
| All Credentials | Credentials list (`WP_List_Table`) |
| All Microsoft Certifications | Microsoft Certifications list (`WP_List_Table`) |
| All Microsoft Exams | Microsoft Exams list (`WP_List_Table`) |
| Integration | Placeholder screen (§6.7) — no integrations exist yet |

**The four "Add …" screens (Add Credential Block, Add Credential, Add Microsoft Certification, Add Microsoft Exam) are deliberately *not* in this visible list** (§10 v26) — each is still registered normally via `add_submenu_page()`, exactly like every other row in the table above (nothing about their registration differs), so their page slugs stay fully reachable. What hides them from the sidebar is a separate step, `Credpl_Admin_Menu::hide_add_screens_from_menu()` (hooked to `admin_head`, since the WP admin sidebar is global, not scoped to this plugin's own screens): a small inline `<style>` block that targets each hidden page's exact link (`#adminmenu a[href$="page=credpl-credential-new"]{display:none;}`, one rule per page) and hides it visually. **Deliberately not `remove_submenu_page()`** — an earlier version (v26) tried that instead, and it broke direct access to all four pages entirely (v28 fixes this; see that note for the root cause) because removing an entry from the `$submenu` global also breaks WordPress core's own resolution of that page's parent menu, which core's access-control check depends on for *every* request to that page, not just sidebar rendering. Each screen is still reachable three other ways: its list's own **Add New** `page-title-action` button, each list row's **Edit** link, and — since a create/update redirects back to the edit screen with `updated=1` (§10 v24/v25) — a **"Back to All …"** button shown right there. With those three entry points already covering every real navigation path to these screens, a fifth path (a permanent, always-visible top-level menu item) was redundant.

Registered via `Credpl_Admin_Menu::register()`, hooked to `admin_menu`. Capability: `manage_options` for all screens (a single, simple permission model; see §8 for why this is looser than the earlier CPT version's per-post capabilities).

### 6.2 Credentials screen

**List: a React app built on Fluent UI 9's plain `Table` building blocks, not a `WP_List_Table`** (§10 v34/v37 — this screen was the first of the plugin's four list tables converted; see §6.2.3 for the build setup and why the other three, §6.3/§6.4/§6.5, still use `WP_List_Table` for now). A `Toolbar` above the table (New / Edit / Delete, §10 v41) and a leading checkbox column (Fluent UI's `TableSelectionCell`, §10 v38/v40) let one or more rows be selected at once, with a header checkbox to select/deselect all — see §6.2.3 for how selection state is tracked and how it drives the toolbar's enablement and actions; there is no per-row Actions column any more (§10 v45 — Edit/Delete are toolbar-only, matching the New button they sit beside). Columns Title (a Fluent UI `Link` to the credential's Edit screen, §10 v36 — not plain text the way every other column's cells are), Type (`credentials_type`, or `—` when not set), Issuer, Earned On, Expires On (the latter two formatted server-side via `date_i18n()` against the site's `date_format` option, `—` when not set — same formatting as the shortcode's front-end output, §7), Status (a colored Fluent UI `Badge` — green (`color="success"`) for `Active`, red (`color="danger"`) for `Expired`, an uncolored default-appearance `Badge` for any other non-empty value, plain `—` text (no `Badge`) when not set at all, §10 v35), Badge (thumbnail), Description (truncated with an ellipsis and wrapped in a Fluent UI `Tooltip` showing the full text on hover/focus, `—` when not set at all — §10 v36). Title, Type, Issuer, Earned On, and Expires On are sortable (clicking a header does a full page reload to `?orderby=…&order=…`, exactly like the old list table's sort links did — see §6.2.3 for why); Status, Badge, and Description aren't. The underlying query is unchanged: `Credpl_Data::get_credentials()`, which validates `orderby`/`order` against a fixed column allowlist before they reach SQL (§8) — PHP still runs this query once per page load and hands the resulting rows to React as already-fetched, already-sorted data; there is no client-side re-fetch or re-sort.

**Add/Edit form: a React app, not PHP-rendered markup, built entirely with Fluent UI 9 controls.** `Credpl_Admin_Credentials::render_edit_page()` outputs only an empty mount point (`<div id="credpl-credential-form-root"></div>` — note this element ID refers to the HTML `<form>` this React component renders, unrelated to the "Credential Form/Block" naming discussed elsewhere in this document); the actual form is a React component, built from JSX source via `@wordpress/scripts` and enqueued as a compiled script. See §6.2.1 for the build setup and §6.2.2 for how it still saves through the plain-PHP `admin-post.php` handler unchanged.

| Field | Fluent UI control |
| --- | --- |
| Title | `Field` + `Input` (required) |
| Credentials Type | `Field` + `Dropdown` — fixed options `Applied Skills` / `Certifications` / `Awards` (`Credpl_Admin_Credentials::CREDENTIALS_TYPES`, passed through `credentialsTypeOptions` so the client's options can't drift from the server's allow-list); optional, no default selection |
| Status | `Field` + `Dropdown` — fixed options `Active` / `Expired` (`Credpl_Admin_Credentials::STATUSES`, passed through `statusOptions`, same pattern as Credentials Type); optional, no default selection |
| Award Category | `Field` + `Input` — free text; not a fixed-option `Dropdown` like Credentials Type/Status, since the source data's actual range of values isn't specified. Only rendered when Credentials Type is `Awards` (§10 v30) |
| Technology Area | `Field` + `Input` — free text, same reasoning as Award Category. Also only rendered when Credentials Type is `Awards` |
| Issuer | `Field` + `Input` |
| Credential ID | `Field` + `Input` — the issuing platform's own identifier, distinct from `id`/Certification Number (§4.1) |
| Certification Number | `Field` + `Input` |

Award Category and Technology Area are conditionally rendered — a plain `'Awards' === credentialsType` check in `CredentialForm()` (§10 v30), not a separate control prop or CSS visibility toggle — so their `Field`/`Input` pair (and therefore their `name="award_category"`/`name="technology_area"` inputs) simply aren't in the DOM at all while Credentials Type is anything other than `Awards`, the same way React conditionally omits any other JSX. This has a real save-time consequence worth calling out: since neither input exists in that case, the form POST carries no `award_category`/`technology_area` key at all, and `Credpl_Admin_Credentials::save()`'s existing `isset( $_POST['award_category'] )` fallback (§6.2.2) stores `''` for both — so switching an existing Award-type credential to a different Credentials Type and saving **clears** any previously-entered Award Category/Technology Area, rather than merely hiding them while leaving the stored values intact. Client-side React *state* for both fields isn't reset on toggle, though — switching Credentials Type back to `Awards` within the same form session (before submitting) restores whatever was typed, since the underlying `useState` values are untouched by the field's visibility.
| Credential Link | `Field` + `Input type="url"` |
| Earned On | `Field` + `@fluentui/react-datepicker-compat`'s `DatePicker` |
| Expires On | `Field` + `DatePicker` — blank means "doesn't expire" |
| Description | `Field` + `Textarea` |
| Badge Image | media-library picker (Fluent `Button`s for Select/Remove + a plain `<img>` thumbnail preview) — calls `wp.media()` directly from the component (the same picker pattern the earlier plain-JS version used, now inline in the React component instead of a separate enqueued script) |

The whole form is wrapped in a `FluentProvider` (`webLightTheme`) — required for any Fluent UI 9 component to render correctly; without it, Fluent components render unstyled/broken. `Field`'s `hint` prop supplies the small helper text under Issuer/Credential ID/Credential Link/Expires On that used to be a plain `<p class="description">`.

**Date handling:** `DatePicker` works in terms of JS `Date` objects, not the `YYYY-MM-DD` strings PHP sends and expects. `parseDateValue()`/`formatDateValue()` (top of `src/credential.tsx`) convert between the two by hand — using local date parts (`getFullYear()`/`getMonth()`/`getDate()`), not `new Date( 'YYYY-MM-DD' )` or `toISOString()`, both of which parse/serialize through UTC and can shift the displayed day by one in timezones behind UTC. Since `DatePicker` has no `name` attribute of its own to submit through a plain form POST, each one is paired with a hidden `<input type="hidden" name="earned_on" value={ formatDateValue( earnedOn ) } />` (same for `expires_on`) that actually carries the value to the backend — the same "component manages rich state, a hidden input carries the plain string" pattern already used for `badge_media`/`badgeMediaId`. `Dropdown` has the same limitation (Fluent UI 9's `Dropdown`/`Option` render a custom listbox, not a native `<select>`), so Credentials Type follows the identical pattern: a controlled `Dropdown` paired with `<input type="hidden" name="credentials_type" value={ credentialsType } />`.

`Earned On`/`Expires On` are still validated server-side by `Credpl_Admin_Credentials::sanitize_date()` regardless of what the client sends — WordPress has no built-in "sanitize a date" helper, and client-side validation (whether a plain `<input type="date">` or `DatePicker`) is not a substitute, since a raw POST request bypasses it entirely. A value that doesn't parse as a real `Y-m-d` date (or is empty) is stored as `NULL`, never as a malformed string. Likewise, Credentials Type is validated server-side by `Credpl_Admin_Credentials::sanitize_credentials_type()` against the same `CREDENTIALS_TYPES` allow-list the Dropdown's options come from — a raw POST could submit any string regardless of what the Dropdown offered client-side, so anything outside the allow-list is stored as `''`. `Description` uses `sanitize_textarea_field()` rather than `sanitize_text_field()`, since the latter strips line breaks.

#### 6.2.1 Build setup

- `package.json` (plugin-local, `private: true`) with devDependencies `@wordpress/scripts`, `typescript`, `@types/react`, and `@types/react-dom`, and three scripts: `build` (`wp-scripts build`), `start` (`wp-scripts start`, for local watch-mode development), and `check-types` (`tsc --noEmit`, for standalone type-checking — see the TypeScript note below). Regular `dependencies` (bundled into the compiled JS, not just build tooling): `@fluentui/react-components` (Fluent UI 9), `@fluentui/react-datepicker-compat` (the `DatePicker`), and `@fluentui/react-icons` (the icon set — first used by the Credentials list toolbar's icon-only buttons, §6.2.3, §10 v43) — the same category of dependency as `@dnd-kit/*` for the Credential Block picker (§6.3.1), for the same reason: none of the three is a `@wordpress/*` package the dependency-extraction plugin knows how to externalize to a WordPress core global, so all three get bundled into whichever entry imports them (`build/credential.js` ~312 KB minified, up from ~6 KB before this — an accepted trade-off for a richer admin-only form, same reasoning as §6.3.1's bundle-size note).
- Source: `src/credential.tsx` (TypeScript + JSX). `@wordpress/scripts`'s default webpack config only auto-discovers a single entry named exactly `src/index.{js,tsx,…}`, so this plugin's `webpack.config.js` (§6.3.1) replaces that default with an explicit two-entry map — `credential: './src/credential.tsx'` — whose key also names the compiled output (`build/credential.js` / `build/credential.asset.php`).
- **TypeScript**: both React apps (`src/credential.tsx` and `src/credentials-block.tsx`, §6.3.1) are TypeScript, not plain JS — `@wordpress/scripts` supports `.ts`/`.tsx` sources out of the box via its bundled Babel config, but **only strips types during the build**; it does not type-check. A plugin-local `tsconfig.json` (`strict: true`, `jsx: "react-jsx"`, `noEmit: true` — `@wordpress/scripts` v35 ships no base config to extend, so this was written from scratch) exists purely so `npm run check-types` can catch type errors separately; it has no effect on `npm run build`'s output. `window.credplCredentialForm` / `window.credplCredentialBlockForm` (the PHP-localized globals) are typed via `declare global { interface Window { … } }` blocks in each entry file, matching exactly what `enqueue_assets()` passes to `wp_localize_script()` — keep those interfaces in sync if the localized data shape ever changes.
- Build output: `build/credential.js` (compiled/minified) and `build/credential.asset.php` (an array of `{ dependencies, version }` auto-generated by `@wordpress/dependency-extraction-webpack-plugin`, bundled inside `@wordpress/scripts` — it detects `import … from '@wordpress/element'` / `'@wordpress/i18n'` and turns them into references to WordPress core's own `wp.element` / `wp.i18n` globals rather than bundling React itself; `react`/`react-dom` are externalized the same way, which is why the bundle size above is driven by Fluent UI + the date picker, not React).
- `Credpl_Admin_Credentials::enqueue_assets()` reads `build/credential.asset.php` and passes its `dependencies` array straight to `wp_enqueue_script()`, so the script handle's dependencies always match what the current build actually needs — nothing hand-maintained.
- **Why "Requires at least: 6.6"** (§1): the current `@wordpress/scripts` major version compiles JSX using React's automatic runtime, which externalizes to a script handle called `react-jsx-runtime`. That handle is only registered by WordPress core starting with 6.6; on an older core the compiled script would reference an undefined global and fail. Forcing the older "classic" JSX runtime to support pre-6.6 sites was considered and rejected — fighting the build tool's modern defaults with custom Babel config seemed more fragile than just requiring a realistically current WordPress version.
- `build/` **is** committed/shipped (it's what actually runs); `node_modules/` is not (gitignored) — same relationship as `src/` vs. compiled output in any front-end project. Running `npm install && npm run build` from `src/credentials-manager-plugin/` regenerates `build/` from `src/credential.tsx` (and `src/credentials-block.tsx`, §6.3.1); `npm run check-types` type-checks both without emitting anything.
- **A real bug this build already caught:** `wp_localize_script()` casts every value to a string (`(string) $value` on each scalar, inside `WP_Scripts::localize()`), so a numeric field like `id: 0` arrives in JS as `"0"` — truthy, unlike the number `0`. The component normalizes `config.id`/`config.badgeMediaId` to real numbers (`Number( config.id ) || 0`) once, at the top of `src/credential.tsx`, rather than trusting raw truthiness of localized values anywhere else in the component. The `CredentialFormConfig` TypeScript interface deliberately types every field (including `id`/`badgeMediaId`) as `string` for exactly this reason — typing them `number` would silently rely on a cast `wp_localize_script()` doesn't actually perform. Follow the same pattern for any future numeric field passed through `wp_localize_script()`.

#### 6.2.2 How saving still works

The React form renders a real `<form method="post" action={actionUrl}>` — `actionUrl`, the credential's current field values (when editing), the nonce, and the badge attachment ID/URL are all passed in from PHP via `wp_localize_script( 'credpl-credential-form', 'credplCredentialForm', […] )`, and the component hydrates its initial state from `window.credplCredentialForm`. Clicking Submit is a **plain browser form submission** — no `fetch`, no REST call — posting the same field names (`title`, `credentials_type`, `status`, `award_category`, `technology_area`, `issuer`, `credential_id`, `certification_number`, `credential_link`, `earned_on`, `expires_on`, `description`, `badge_media`, `id`, `_wpnonce`) to `admin-post.php?action=credpl_save_credential` that the earlier PHP-rendered form posted, Fluent UI controls included — Fluent's `Input`/`Textarea` forward a plain `name` prop straight through to the native `<input>`/`<textarea>` they render, same as any HTML form field. `Credpl_Admin_Credentials::save()` (§9) needed **no changes** for this — the "React-ness" is entirely about how the form is rendered and controlled on the client; persistence is still the same nonce-checked, capability-checked, sanitize-on-save PHP handler.

Nonce-protected: PHP generates the nonce with `wp_create_nonce( 'credpl_save_credential' )` (the same string `wp_nonce_field()` would have used) and passes it into the localized data; the React form renders it as a plain hidden `_wpnonce` input. Save handler: `Credpl_Admin_Credentials::save()`, hooked to `admin_post_credpl_save_credential`; checks `manage_options`, calls `check_admin_referer()`, sanitizes each field (`sanitize_text_field()`/`esc_url_raw()`/`absint()` — see §8), and calls `Credpl_Data::insert_credential()` / `update_credential()`.

Delete: `admin-post.php?action=credpl_delete_credential&id=…`, nonce-protected, calls `Credpl_Data::delete_credential()`. A credential still referenced by one or more Credential Blocks can still be deleted; blocks simply skip missing IDs when rendering (§7).

`save()` redirects with `updated=1` (as it already did); whenever that's present, `render_edit_page()` shows a **"Back to All Credentials"** button above the form mount point, same pattern (and same `$_GET['updated']` trigger) as the Credential Block edit screen's own back-button (§6.3, §10 v24/v25).

#### 6.2.3 The Credentials list: Fluent UI 9's plain `Table` building blocks

**Mount point**: `Credpl_Admin_Credentials::render_list_page()` renders `<div id="credpl-credentials-list-root"></div>` in place of `Credpl_Credentials_List_Table::display()`'s HTML table; the surrounding chrome (`<h1>`, the **Add New** `page-title-action` link, the save/delete success notices) stays PHP-rendered, exactly the pattern the Add/Edit forms already use for their own mount points (§6.2, §6.3).

**Source**: `src/credentials-list.tsx` (TypeScript + JSX, §6.2.1) — a fifth entry point in `webpack.config.js`'s multi-entry map, alongside `credential`/`credentials-block`/`ms-certification`/`ms-exam`. No new npm dependency: Fluent UI 9's plain `Table`/`TableHeader`/`TableHeaderCell`/`TableRow`/`TableBody`/`TableCell` building blocks ship as part of `@fluentui/react-components`, already a dependency since §6.2's form — same package `DataGrid` (used here from §10 v34 through v36) came from, just its lower-level primitives instead of the higher-level component built on top of them (§10 v37). Compiled to `build/credentials-list.js` (~168 KB minified, down from `DataGrid`'s ~280 KB — the plain `Table` primitives pull in none of `@fluentui/react-table`'s sort/column-sizing/selection machinery, since this screen never used any of it beyond a `compare`-free "is this column sortable" flag, §10 v37) / `build/credentials-list.asset.php`, same dependency-extraction-plugin-generated shape as every other entry (§6.2.1).

**Data flow — the query stays server-side, only the rendering moved to React**: `Credpl_Admin_Credentials::enqueue_list_assets()` (gated to the Credentials list screen the same `$_GET['page']` way every other screen's `enqueue_assets()` is) reads and validates `$_GET['orderby']`/`$_GET['order']` exactly as `Credpl_Credentials_List_Table::prepare_items()` used to (`sanitize_key()`'d, then re-validated by `Credpl_Data::get_credentials()`'s own allowlist, §8), runs the same `SELECT * FROM {$wpdb->prefix}credentials … ORDER BY …` query once, and localizes the *already-fetched, already-sorted* rows — plus each row's pre-built, nonce-protected Edit/Delete URLs (identical to what the old list table's `column_title()` generated) and pre-formatted Earned On/Expires On display strings (`date_i18n()`, same as before) — as `window.credplCredentialsList = { rows, listUrl, orderby, order, addNewUrl, bulkDeleteUrl, noItemsText }`. There is no REST endpoint and no client-side re-fetch: this is the "server-rendered-once" data-flow option (as opposed to a fully client-side, REST-backed list), chosen because it's the smallest change that gets a Fluent UI table presentation without introducing a new API surface — a candidate for revisiting if this screen later needs pagination or in-place (no-reload) sorting.

**Columns as plain data, not `DataGrid`'s `createTableColumn()`**: a `ColumnDef[]` array (`{ id, label, sortable, renderCell }`) drives both the header row and every body row — `<TableHeader><TableRow>{ columns.map( … ) }</TableRow></TableHeader>` renders one `TableHeaderCell` per entry, and each body `<TableRow>` renders one `TableCell` per entry via that same column's `renderCell( row )`. This is hand-rolled rather than a `DataGrid`/`createTableColumn()`-style column-definition API, since the plain `Table` primitives don't ship one of their own — the array is just this component's own bookkeeping.

**Sorting**: `TableHeaderCell` takes `sortable`/`sortDirection` props directly (purely presentational — they control the `aria-sort` attribute and which way the built-in sort-arrow icon points) and a `button` slot for the click handler that actually does something (`button={ { onClick: () => { … } } }`, targeting the accessible interactive element `TableHeaderCell` renders for a sortable column, rather than attaching `onClick` to the cell's root). Only `title`/`credentials_type`/`issuer`/`earned_on`/`expires_on` set `sortable: true` in the `columns` array — the same "opt in per column" shape `get_sortable_columns()` gave `WP_List_Table` (§10 v16) and `createTableColumn()`'s `compare` gave `DataGrid` (v34–v36). Clicking a sortable header's `onClick` builds `?orderby=<columnId>&order=<asc|desc>` from `config.listUrl` (`buildNextSortUrl()` — toggling direction if the clicked column is already the current sort, defaulting to ascending otherwise, the same two-click behavior `DataGrid`'s built-in sorting gave for free) and navigates there (`window.location.href = …`) — a full page reload, functionally identical to clicking one of the old list table's sort links or the `DataGrid` version's header cells. `sortDirection` is only ever set on whichever `TableHeaderCell` matches PHP's current `orderby` (`column.id === config.orderby ? currentSortDirection : undefined`) so only that one header shows an arrow — there is no controlled/uncontrolled sort *state* to manage the way `DataGrid`'s `sortState` prop implied, since nothing here ever sorts client-side.

**Header tooltips** (§10 v44): every header cell — the leading select-all checkbox and all nine columns — is wrapped in a Fluent UI `Tooltip` (`relationship="label"`, the same mechanism already used for the Description column's cell content, §10 v36, and the toolbar's icon-only buttons, §10 v43), carrying a full sentence describing what the column shows and, for the five sortable ones, that clicking the header sorts by it (and clicking again reverses the order); the four non-sortable columns' tooltips say so explicitly ("This column is not sortable."), so hovering any header cell explains both what it is and whether/how it interacts. Each `ColumnDef` entry gained a `headerTooltip: string` field alongside `id`/`label`/`sortable`/`renderCell` to carry this text. The `Tooltip` wraps the whole `TableHeaderCell`/`TableSelectionCell` (not just its inner text), so hovering anywhere over a header cell — not only its sort button — shows the tooltip.

**Header cell font weight** (§10 v46): each column's `TableHeaderCell` carries an inline `style={ { fontWeight: tokens.fontWeightSemibold } }` so its label reads semibold rather than `TableHeaderCell`'s own default regular weight. This is an inline style, not a `className`/`makeStyles` rule — `TableHeaderCell`'s root slot already sets `font-weight: var(--fontWeightRegular)` via its own Griffel-generated class (targeting the same `<th>` a custom `className` would), so a class-based override would have had to out-specificity or out-order that existing rule, which Griffel's atomic-CSS insertion order doesn't reliably guarantee; an inline style always wins over any class-based rule on the same element regardless of specificity or insertion order, so it's the dependable choice here. The `button` slot `TableHeaderCell` renders internally for a sortable column has no `font-weight` of its own, so it inherits the semibold weight from the root the normal CSS way.

**No per-row Actions column** (§10 v45): this screen briefly had a dedicated "Actions" column (`Button`s for Edit/Delete, v34–v44) but it's removed — the Title `Link` (v36) already opens a row's edit screen, and the toolbar's Edit/Delete buttons (below) cover the rest, so a third, always-visible per-row Edit/Delete pair was redundant. `CredentialsListRowActions()` (the component that rendered it) is deleted along with it, and `columns` — no longer needing to hand any cell a callback that closes over component state — moved back to module scope (it had only been pulled inside `CredentialsList()` in the first place for that column's sake, §10 v42).

**Multi-row selection** (§10 v38/v40): a leading `TableSelectionCell` column (Fluent UI's checkbox-cell component, also from `@fluentui/react-table`) lets more than one row be checked at once — a header-row checkbox (checked/unchecked/`"mixed"` depending on whether all, none, or some rows are currently selected) toggles every row at once, and each body row's own checkbox toggles just that row. Selection state is a plain `useState<Set<number>>` of credential IDs local to `CredentialsList()` — not `@fluentui/react-table`'s `useTableFeatures`/`useTableSelection` hook pair, since those expect a `DataGrid`-style `columns: TableColumnDefinition<TItem>[]` array (with `compare`/`renderCell` per entry) to drive their internal row/column bookkeeping, which this screen deliberately stopped maintaining when it moved off `DataGrid` (§10 v37) — plain component state is a smaller, more direct fit for "just track which IDs are checked." A selected row is visually highlighted (`TableRow appearance="brand"`, the same prop Fluent's own selection examples use) and marked `aria-selected` for assistive tech. Each checkbox's toggle handler is attached directly to `TableSelectionCell` itself (its top-level `onClick`, which Fluent forwards to the cell's own root element, a plain `<td>`/`<th>`) rather than to the `Checkbox` Fluent renders inside it (v40 — v38's original `checkboxIndicator`-level `onClick`, and v39's follow-up attempt at `checkboxIndicator`-level `onChange`, both turned out not to reliably reach the intended toggle; attaching to the cell's own root sidesteps `Checkbox`'s internal event wiring entirely, relying only on a click bubbling up from anywhere inside the cell to its native table-cell ancestor). Clicking is scoped to each row's checkbox specifically — deliberately not "click anywhere in the row selects it," the more common Fluent UI selection pattern — because several cells in this table are themselves clickable (the Title `Link`, the Actions column's Edit/Delete `Button`s, §10 v36); wiring selection to the whole row would mean every click on those elements also toggled that row's selection as an unrelated side effect.

**Toolbar** (§10 v41/v43): a Fluent UI `Toolbar` rendered above the table — `ToolbarButton`s **New**, **Edit**, a `ToolbarDivider`, then **Delete** — reads the very same `selectedIds` state. Each button is icon-only (`AddRegular`/`EditRegular`/`DeleteRegular` from `@fluentui/react-icons`, via the `icon` prop) with no visible text label, wrapped in a Fluent UI `Tooltip` (`relationship="label"` — the accessible-name mechanism Fluent's own guidance calls for on an icon-only control with no visible text, same pattern already used for the Description column's truncated-text tooltip, §10 v36) carrying a full sentence explaining what the button does and, since the enablement rules aren't obvious from the icon alone, what makes it available. Disabled buttons use `disabledFocusable` rather than `disabled` specifically so their tooltip still shows on hover/focus while disabled (a plain `disabled` native `<button>` typically can't receive hover events at all) — functionally identical to `disabled` otherwise, since `useARIAButtonProps()` (`@fluentui/react-aria`) strips the `onClick` handler from the rendered button either way, so no separate click-guard is needed in this component's own handlers:

- **New** — tooltip *"Create a new credential. Deselect all credentials to enable this button."* Disabled whenever anything is selected (`selectedIds.size > 0`) and otherwise navigates to `config.addNewUrl` (the Add New Credential screen — the same URL the page's own `page-title-action` **Add New** link, §6.2's chrome, already points to).
- **Edit** — tooltip *"Edit the selected credential's details. Select exactly one credential to enable this button."* Enabled only when exactly one row is selected (`1 === selectedIds.size`) and navigates to that one row's own `editUrl` — the same URL its Title `Link` (§10 v36) and its Actions column's Edit button both already use.
- **Delete** — tooltip *"Permanently delete the selected credential(s). Select one or more credentials to enable this button."* Enabled whenever one or more rows are selected and, when clicked, sets `pendingDelete` to `{ kind: 'bulk', ids: […] }` — opening the same shared confirmation dialog the row-level Delete button uses (§10 v42), rather than navigating straight away.

New and Edit are plain navigations (`window.location.href = …`), not `fetch`/REST calls, matching this plugin's established "full page reload, no client-side data layer" convention (§6.2.3) — they were already reachable via existing links elsewhere on the page; the toolbar is a second way to reach them once a selection already exists, driven by the same state that colors the selected rows. Delete navigates the same way, just gated behind the confirmation dialog below.

**Delete confirmation dialog** (§10 v42/v45): the toolbar's Delete button — the only delete entry point since the Actions column was removed (v45) — goes through one `<ConfirmationDialog>` instance (`src/components/dialogs/confirmation-dialog.tsx`, a small, **not** Credentials-specific component: it takes `open`/`title`/`message`/`confirmLabel`/`cancelLabel`/`onConfirm`/`onCancel` and renders Fluent UI's `Dialog`/`DialogSurface`/`DialogBody`/`DialogTitle`/`DialogContent`/`DialogActions`, with `modalType="alert"` so it can't be dismissed by clicking the dimmed backdrop — only an explicit Cancel or Confirm click, appropriate for a destructive action). `CredentialsList()` tracks the pending delete in one `useState<number[] | null>` (`pendingDeleteIds`) — a snapshot of `selectedIds` taken when Delete was clicked, so the dialog's copy/confirm action can't drift if the selection somehow changed while it's open; clicking Delete just sets this state (no navigation yet). The dialog's `open` prop is `!! pendingDeleteIds`; its title/message adapt to the count — when exactly one ID is pending, `pendingDeleteRow` looks that credential up in `config.rows` and the message names its title directly (**"Delete Credential"** / *Are you sure you want to delete "\<title>"? This action cannot be undone.*); for two or more, a singular-or-plural (`_n()`) count is used instead (**"Delete Credentials"** / *Are you sure you want to delete N selected credentials? This action cannot be undone.*). Confirming (`onConfirm`) navigates to `buildBulkDeleteUrl( pendingDeleteIds )` (below — this now handles every delete, one ID or many, uniformly) and cancelling (`onCancel`, also fired when the dialog closes via Escape) just clears `pendingDeleteIds` and does nothing else.

**Bulk delete** (§10 v41): `Credpl_Admin_Credentials::BULK_DELETE_ACTION` (`credpl_bulk_delete_credentials`) is a new nonce-protected `admin-post.php` action, alongside the existing single-row `DELETE_ACTION`. Unlike that one — whose nonce is generated per row (`credpl_delete_credential_{id}`, §6.2.2) since each row's Delete link is built server-side for one known ID — the bulk action's nonce is a single fixed action string, because the set of selected IDs is only known client-side at click time: `Credpl_Admin_Credentials::enqueue_list_assets()` localizes one nonce URL with no `ids[]` of its own (`bulkDeleteUrl`), and `buildBulkDeleteUrl()` in `src/credentials-list.tsx` appends `&ids[]=<id>&ids[]=<id>…` for the IDs being deleted, called from the confirmation dialog's `onConfirm` (§10 v42) rather than immediately on click (v41). `Credpl_Admin_Credentials::bulk_delete()` (`admin_post_credpl_bulk_delete_credentials`) checks `manage_options`, `check_admin_referer( self::BULK_DELETE_ACTION )`, reads `$_GET['ids']` as an array of `absint()`-sanitized IDs, calls `Credpl_Data::delete_credential()` once per ID (silently skipping any that no longer exist — same as the single-delete action's behavior), and redirects back to the Credentials list with `bulk_deleted=<count>` (a distinct query arg from the existing single-row `deleted=1` flag, following the same collision-avoidance convention the Sync actions' `sync_*`-prefixed args established, §10 v20) — `maybe_render_notice()` renders it as **"N credential(s) deleted."** (`_n()`, singular/plural). `DELETE_ACTION`'s single-row endpoint (and the per-row `deleteUrl` `enqueue_list_assets()` still builds into each row, §6.2.2) is left in place and untouched, even though no UI on this screen links to it any more after v45 removed the Actions column — deleting exactly one credential now goes through selecting its row and using the toolbar's Delete button, which calls `bulk_delete()` the same as deleting several does.

**Removed**: `Credpl_Credentials_List_Table` (`includes/class-credpl-credentials-list-table.php`) is deleted outright, not left in place unused — nothing else in the plugin referenced it once this screen stopped calling it (§10 v34). The other three list tables (`Credpl_Blocks_List_Table`, `Credpl_Ms_Certifications_List_Table`, `Credpl_Ms_Exams_List_Table`, §6.3/§6.4/§6.5) are untouched and still `WP_List_Table`-based — this conversion is scoped to Credentials only, as a pilot for the pattern.

### 6.3 Credential Blocks screen

**List** (`Credpl_Blocks_List_Table extends WP_List_Table`): columns Title, Shortcode (the `[credential-block id="…"]` string, click-to-select, same as Contact Form 7's list), Description (`—` when not set), row actions Edit / Delete. Title and Description are sortable (`get_sortable_columns()`, same mechanism as the other three list tables, §6.2); Shortcode isn't, since it's a generated identifier rather than descriptive data.

**Add/Edit form**: a **React app** (§6.3.1, mirroring §6.2's Credential form), POSTing to `admin-post.php?action=credpl_save_credential_block`. Only the read-only shortcode display above it (an existing block's `[credential-block id="…"]` tag, click-to-select) stays PHP-rendered, since it isn't part of the form.

On save, `Credpl_Admin_Blocks::save()`:

1. If creating a new block, generates `block_key` — `wp_generate_password( 7, false, false )` lowercased, regenerated on the rare event of a collision (checked against the `UNIQUE KEY` via `Credpl_Data::block_key_exists()`) — matching the shape of the requested example (`a2949a2`).
2. Sanitizes the submitted `credential_ids[]` array to integers and keeps only IDs that exist in `credentials` (`array_map( 'absint', … )` intersected against `Credpl_Data::get_credential_ids()`) — this validation applies equally regardless of which UI produced the array (the current React form, or the plain checklist it originally replaced).
3. `json_encode()`s the resulting array into `credential_ids`.
4. Calls `Credpl_Data::insert_credential_block()` / `update_credential_block()`.
5. Redirects back to `?action=edit&id=…&updated=1`, where the edit screen displays the shortcode in a read-only, click-to-select input at the top of the page — the same UX Contact Form 7 uses:

   ```html
   <input type="text" readonly onclick="this.select();" value='[credential-block id="a2949a2"]' />
   ```

   Whenever `updated=1` is present (i.e. a create or update just redirected back here), a **"Back to All Credentials"** button (`Credpl_Admin_Menu::PAGE_CREDENTIALS`) is also shown, above the shortcode box — a shortcut to the Credentials screen for going on to add/adjust the credentials just selected into this block (§10 v24).

Delete: `admin-post.php?action=credpl_delete_credential_block&id=…`, nonce-protected.

#### 6.3.1 The Credential Block form: Fluent UI 9 Title/Description fields + an embedded two-column, drag-and-drop picker

A single React app covering the whole Add/Edit Credential Block screen — a Fluent UI 9 `Field`/`Input` for Title, a `Field`/`Textarea` for Description, plus a **"Selected Credentials"** (left) / **"Available Credentials"** (right) drag-and-drop picker built from Fluent UI 9 `Card`s and `@dnd-kit`, all in one component tree. (Earlier this screen was a plain PHP `<form>` with only the picker as React, itself replacing an even earlier plain checkbox list — the picker was absorbed into this file so the whole screen follows the same architecture as the Credential form, §6.2.)

- **Mount point**: `Credpl_Admin_Blocks::render_edit_page()` renders `<div id="credpl-credential-block-form-root"></div>` — no PHP-rendered `<form>`/`<table class="form-table">` markup at all anymore, matching §6.2's Credential form pattern. The read-only shortcode display for an existing block stays PHP-rendered above the mount point, since it isn't part of the form being edited.
- **Source**: `src/credentials-block.tsx` (TypeScript + JSX, §6.2.1) — a second, independent entry point alongside the Credential form's `src/credential.tsx` (and, since §10 v19, a third, `src/ms-certification.tsx`, §6.4). `@wordpress/scripts`'s default webpack config only auto-discovers a single `src/index.{js,tsx,…}` entry (confirmed empirically while building the first React screen — naming a second source file anything else produced "No entry file discovered"), so a `webpack.config.js` at the plugin root replaces that default entirely with an explicit multi-entry map. Everything else (Babel/TSX handling, the dependency-extraction plugin) is inherited unchanged. `window.credplCredentialBlockForm`, dnd-kit's drag events (`DragOverEvent`/`DragEndEvent`), and the two-column `containers` state are all typed (`Record<'selected' | 'available', number[]>`).
- **New npm dependencies** (regular `dependencies`, not `devDependencies` — they're bundled into the compiled JS, not just build tooling): `@fluentui/react-components` (Fluent UI 9) for `Field`/`Input`/`Textarea`/`Card`/`Link`/`FluentProvider`, and `@dnd-kit/core` + `@dnd-kit/sortable` + `@dnd-kit/utilities` for drag-and-drop — the same DnD library WordPress core's own block editor uses internally. `react`/`react-dom` are still externalized to WordPress core's own registered `react`/`wp-element` script handles via the same dependency-extraction plugin as the Credential form, so only Fluent UI and dnd-kit actually get bundled (~247 KB minified) — this is an admin-only screen, so that's an accepted trade-off for the nicer UX, not something optimized further.
- **Data flow**: `Credpl_Admin_Blocks::enqueue_assets()` (gated to the Add/Edit Block screen the same `$_GET['page']` way `Credpl_Admin_Credentials::enqueue_assets()` is) localizes `window.credplCredentialBlockForm = { id, nonce, actionUrl, title, description, addCredentialUrl, allCredentials, selectedIds }` — `allCredentials` shaped down to just `id`/`title`/`issuer`/`badgeMediaUrl` per credential (`prepare_credential_for_js()`), not full table rows; `addCredentialUrl` (the Add New Credential screen's URL) backs the empty-state link described below.
- **Drag-and-drop mechanics**: one `DndContext` wraps both columns; each column is a `@dnd-kit/sortable` `SortableContext` *and* a `useDroppable` target (needed so dropping into an *empty* column works — a `SortableContext` alone only makes existing items droppable, not the empty space around them). `onDragOver` moves a card live between columns as you drag over the other one; `onDragEnd` finalizes reordering within whichever column the drag ended in (via `arrayMove`).
- **Still just a form submission**: the component renders a real `<form method="post" action={actionUrl}>` (same pattern as §6.2.2) with hidden `action`/`id`/`_wpnonce` inputs, a Title `Input` with `name="title"`, a Description `Textarea` with `name="description"` (Fluent's `Textarea` forwards a plain `name` prop straight through to the native `<textarea>` it renders, same as `Input`, so it needs no paired hidden input the way `Dropdown`/`DatePicker` do elsewhere in this plugin), and — on every render — one `<input type="hidden" name="credential_ids[]" value={id} />` per selected credential, in current order. Clicking Submit is a plain browser form POST — no `fetch`, no REST call — so `Credpl_Admin_Blocks::save()` only needed to start reading/sanitizing the one new `description` field (`sanitize_textarea_field()`, matching `credentials.description`'s own sanitization, §8) — everything else about how the form saves is unchanged.
- **Empty-state fallback stays in the component**: when there are no credentials at all yet, the "Credentials" field renders a `createInterpolateElement()`-built "No credentials exist yet. Add one first." message (linking to `addCredentialUrl`) instead of the picker — an empty two-column drag target with nothing to drag isn't a useful screen. The Title field and Save button still render either way, so a block can be created/renamed even with zero credentials available.

### 6.4 Microsoft Certifications screen

**List** (`Credpl_Ms_Certifications_List_Table extends WP_List_Table`): columns Title, Icon (a small `<img>` from `icon_url` — an external URL, not a media library attachment, so no `wp_enqueue_media()`/picker is needed anywhere on this screen), Certification Type, Type, Last Modified (`date_i18n()` against the site's `date_format` **and** `time_format` options, since `last_modified` is a full datetime, unlike Credentials' date-only `earned_on`/`expires_on`, §6.2), row actions Edit / Delete. Title, Certification Type, Type, and Last Modified are sortable (`get_sortable_columns()`, same mechanism as §6.2); Icon isn't. Two `page-title-action` buttons sit next to the `<h1>`: **Add New** (the standard pattern, §6.2/§6.3) and **Sync Certifications** (below).

**Add/Edit form**: a **React app** (below), POSTing to `admin-post.php?action=credpl_save_ms_certification`. `Credpl_Admin_Ms_Certifications::render_edit_page()` renders only an empty mount point (`<div id="credpl-ms-certification-form-root"></div>`), same pattern as §6.2/§6.3.

| Field | Fluent UI control |
| --- | --- |
| UID | `Field` + `Input` (required) — a stable external identifier, e.g. `certification.mcsa-windows-server-certification` |
| Title | `Field` + `Input` (required) |
| Subtitle | `Field` + `Textarea` — HTML allowed, sanitized with `wp_kses_post()` on save (not `sanitize_textarea_field()`, which would strip it) |
| URL | `Field` + `Input type="url"` |
| Icon URL | `Field` + `Input type="url"`, with a live `<img>` preview underneath as the field is typed |
| Last Modified | `Field` + `Input type="datetime-local"` — a native HTML5 control, not `@fluentui/react-datepicker-compat`'s `DatePicker` (§6.2), since `DatePicker` only handles a date, not a date+time |
| Type | `Field` + `Input` — free text, e.g. `cert`; not a fixed-option `Dropdown` like `credentials.credentials_type`/`status` (§6.2), since the source data's actual range of values for this field isn't specified |
| Certification Type | `Field` + `Input` — free text, e.g. `mcsa`, same reasoning as Type |
| Exams | `Field` + `Textarea`, one exam UID per line (e.g. `exam.70-410`) |
| Levels | `Field` + `Textarea`, one value per line |
| Roles | `Field` + `Textarea`, one value per line |
| Study Guide (JSON) | `Field` + `Textarea` — raw JSON text; `study_guide`'s real shape isn't specified (every example seen so far is just `[]`), so it's edited as JSON rather than a purpose-built control |

Every control here is a plain `Input`/`Textarea` with a `name` prop that forwards straight through to the native form field it renders (confirmed for both in §6.2.2) — unlike the Credential and Credential Block forms, this one needs **no** `Dropdown`, `DatePicker`, or hidden-input pairing at all: `last_modified` uses a native `datetime-local` input instead of `DatePicker` specifically so it can stay a plain `Input`; `exams`/`levels`/`roles`/`study_guide` are plain multi-line text, parsed server-side.

**Source**: `src/ms-certification.tsx` (TypeScript + JSX), the third webpack entry (§6.3.1). Styles live in `src/styles/msCertification.styles.ts` (`useMsCertificationStyles`), following the same one-hook-per-screen-per-file convention already established for `src/styles/credential.styles.ts` and `src/styles/credentialsBlock.styles.ts` (each screen's `makeStyles()` hook extracted out of its form component into its own module under `src/styles/`).

**Data flow**: `Credpl_Admin_Ms_Certifications::enqueue_assets()` (gated to the Add/Edit screen, same `$_GET['page']` pattern as the other two forms) localizes `window.credplMsCertificationForm = { id, nonce, actionUrl, uid, title, subtitle, url, iconUrl, lastModified, type, certificationType, exams, levels, roles, studyGuide }`. `exams`/`levels`/`roles` arrive **pre-joined with `\n`** (`Credpl_Admin_Ms_Certifications::decode_string_list()`, the JSON column decoded and imploded) so the Textareas can bind directly to them with no client-side JSON handling; `studyGuide` arrives **pre-pretty-printed** (`pretty_json()`, `JSON_PRETTY_PRINT`) for readability; `lastModified` arrives reformatted from the stored `Y-m-d H:i:s` to the `Y-m-d\TH:i` a native `datetime-local` input expects (`format_datetime_local()`) — a plain string operation, not a timestamp round-trip, so no timezone conversion can shift the displayed value (same reasoning as `parseDateValue()`/`formatDateValue()` in `credential.tsx`, §6.2).

On save, `Credpl_Admin_Ms_Certifications::save()`:

1. Sanitizes `uid` (`sanitize_text_field()` — not `sanitize_key()`, which would strip the `.` characters this field's format relies on, e.g. `certification.mcsa-…`) and, if non-empty, checks it against every *other* row via `Credpl_Data::ms_certification_uid_exists( $uid, $id )` — `uid` carries a `UNIQUE KEY` (§4.3) but, unlike `credential_blocks.block_key`, it's admin-typed rather than server-generated, so a collision is a realistic mistake worth a friendly validation error (redirecting back with `error=1`) rather than a raw database constraint failure.
2. Sanitizes `title` with `sanitize_text_field()`; `subtitle` with `wp_kses_post()`; `url`/`icon_url` with `esc_url_raw()`; `type`/`certification_type` with `sanitize_text_field()` (§8).
3. Sanitizes `last_modified` with `sanitize_datetime()` — validates the submitted `datetime-local` string actually parses as a real date/time (with or without seconds) and reformats it to `Y-m-d H:i:s`, or stores `NULL` if it doesn't parse/is empty. Same "never trust client-side control validation" rationale as `sanitize_date()` (§6.2).
4. Sanitizes `exams`/`levels`/`roles` with `sanitize_string_list()` — splits the submitted Textarea text on newlines, trims and `sanitize_text_field()`s each line, drops blank lines, and `wp_json_encode()`s the resulting array.
5. Sanitizes `study_guide` with `sanitize_json_field()` — validates the submitted text actually parses as JSON (`json_decode()` + `json_last_error()`) and re-encodes it (normalizing whitespace); anything that doesn't parse is stored as `'[]'` rather than malformed JSON. Not escaped as HTML on save, since nothing renders it as HTML — this screen has no front-end output at all (§7).
6. Calls `Credpl_Data::insert_ms_certification()` / `update_ms_certification()`.

Delete: `admin-post.php?action=credpl_delete_ms_certification&id=…`, nonce-protected, calls `Credpl_Data::delete_ms_certification()`.

`save()` redirects with `updated=1`; whenever that's present, `render_edit_page()` shows a **"Back to All Microsoft Certifications"** button above the form mount point, same `$_GET['updated']`-triggered pattern as the other three screens (§6.2, §6.3, §6.5, §10 v25).

**Sync Certifications**: a `page-title-action` link on the list screen (next to Add New), nonce-protected (`wp_nonce_url()`/`check_admin_referer()`) and gated behind a JS `confirm()` — same "nonce-protected `<a>` link, no separate POST form" pattern this plugin already uses for row-level Delete links, chosen for consistency rather than introducing a new form-button pattern for one action. `admin-post.php?action=credpl_sync_ms_certifications` → `Credpl_Admin_Ms_Certifications::sync()`:

1. Best-effort raises the PHP execution time limit (`set_time_limit( 120 )`, suppressed and gated behind `function_exists()` — some hosts disallow changing it, and this must never fatal the request if so) — fetching and upserting the whole catalog in one synchronous request/response cycle (no AJAX, no background job/cron; this is a manually-triggered, infrequent, admin-only action, so the simplest approach was chosen over building queuing infrastructure for it) can run past the default limit.
2. `fetch_catalog_certifications()` calls `wp_remote_get( CATALOG_API_URL, array( 'timeout' => 45 ) )` — `CATALOG_API_URL` is `https://learn.microsoft.com/api/catalog/?type=certifications,exams&locale=en-us`, a fixed constant, never user input, so there's no SSRF surface here. Returns a `WP_Error` (surfaced as an admin notice, §8) if the request fails, the HTTP status isn't `200`, or the decoded JSON body has no `certifications` array — otherwise returns just that array (the same response's `exams` array is present because the API requires `type=` to name every type it should include, but is unused here: this table stores each certification's own `exams` list of exam *uids*, not separate exam records).
3. For each entry in that array, `map_catalog_certification()` builds the same `$data` shape `save()` builds from `$_POST`, applying the same sanitization rules per field (§8) — this is still untrusted external input, regardless of the source's reputation, so nothing here is exempt from sanitization just because it didn't come through a form.
4. Looks up an existing row by the entry's `uid` (`Credpl_Data::get_ms_certification_by_uid()`); calls `update_ms_certification()` if found, `insert_ms_certification()` otherwise. An entry with an empty/missing `uid`, or whose insert/update fails, is skipped (counted, not fatal to the rest of the run) rather than aborting the whole sync over one bad row — the reason for the *first* skip encountered (not a valid object / missing `uid` / the actual database error) is stashed via `store_error_notice()` (§10 v21) so a systemic failure (e.g. the table itself missing) is diagnosable from the notice alone, not just a bare count.
5. Redirects back to the list with `synced=1` plus `sync_created`/`sync_updated`/`sync_skipped` counts (prefixed `sync_` specifically so they can't collide with the plain `updated`/`deleted` flags `save()`/`delete()` already use on redirects to this same screen — e.g. a sync that happens to update exactly one row would otherwise also satisfy `isset( $_GET['updated'] )` and incorrectly show the single-row "saved" notice alongside the sync summary), rendered as **"Sync complete: N created, M updated, K skipped."** (plus **"First reason: …"** when `K > 0`) by `maybe_render_notice()`.

`last_modified` gets different treatment here than from the manual form: the catalog API's value is a real ISO 8601 datetime with an explicit offset (e.g. `2025-02-05T01:17:00+00:00`), representing an actual instant, so `sanitize_iso8601_to_mysql()` converts it to a Unix timestamp and reformats in UTC (`gmdate()`) rather than keeping it naive — unlike `sanitize_datetime()` (used by the form), which has no offset to work with in the first place (a `datetime-local` input's value is wall-clock only) and so just reformats the string as-is. Both end up as the same naive `Y-m-d H:i:s` shape in the database; only the reasoning for getting there differs.

### 6.5 Microsoft Exams screen

**List** (`Credpl_Ms_Exams_List_Table extends WP_List_Table`): columns Title, Icon (external `icon_url`, same as Microsoft Certifications' Icon column, §6.4), Display Name, Type, Last Modified (`date_i18n()` against `date_format`/`time_format`, same as Microsoft Certifications' Last Modified), row actions Edit / Delete. Title, Display Name, Type, and Last Modified are sortable (`get_sortable_columns()`); Icon isn't. Two `page-title-action` buttons sit next to the `<h1>`: **Add New** and **Sync Exams** (below, §10 v23).

**Add/Edit form**: a **React app** (below), POSTing to `admin-post.php?action=credpl_save_ms_exam`. `Credpl_Admin_Ms_Exams::render_edit_page()` renders only an empty mount point (`<div id="credpl-ms-exam-form-root"></div>`), same pattern as the other three forms.

| Field | Fluent UI control |
| --- | --- |
| UID | `Field` + `Input` (required) — a stable external identifier, e.g. `exam.mb-300` |
| Title | `Field` + `Input` (required) |
| Display Name | `Field` + `Input` — short exam code, e.g. `MB-300`; distinct from Title (the long name) and UID |
| Subtitle | `Field` + `Textarea` — HTML allowed, sanitized with `wp_kses_post()` on save, same as `microsoft_certifications.subtitle` (§6.4) |
| URL | `Field` + `Input type="url"` |
| Icon URL | `Field` + `Input type="url"`, with a live `<img>` preview underneath, same pattern as Microsoft Certifications |
| Last Modified | `Field` + `Input type="datetime-local"` — same native-control reasoning as Microsoft Certifications (§6.4): `DatePicker` only handles a date, not a date+time |
| Type | `Field` + `Input` — free text, e.g. `exam` |
| Locales | `Field` + `Textarea`, one locale per line (e.g. `en-us`) |
| Courses | `Field` + `Textarea`, one course UID per line |
| Levels | `Field` + `Textarea`, one value per line |
| Roles | `Field` + `Textarea`, one value per line |
| Products | `Field` + `Textarea`, one value per line (e.g. `dynamics-365`) — this table has no single `certification_type`-equivalent column; Products is itself already a list in the source data |
| Providers | `Field` + `Textarea`, one value per line |
| Study Guide (JSON) | `Field` + `Textarea` — raw JSON text, same reasoning as Microsoft Certifications' Study Guide (unspecified shape) |

Every control here is a plain `Input`/`Textarea` with a `name` prop forwarding straight through to the native form field it renders — same as Microsoft Certifications (§6.4): no `Dropdown`, no `DatePicker`, no hidden-input pairing anywhere on this form either.

**Source**: `src/ms-exam.tsx` (TypeScript + JSX), the fourth webpack entry (§6.3.1). Styles live in `src/styles/msExam.styles.ts` (`useMsExamStyles`), same one-hook-per-screen-per-file convention as the other three forms.

**Data flow**: `Credpl_Admin_Ms_Exams::enqueue_assets()` (gated to the Add/Edit screen, same `$_GET['page']` pattern as the other forms) localizes `window.credplMsExamForm = { id, nonce, actionUrl, uid, title, subtitle, displayName, url, iconUrl, locales, lastModified, type, courses, levels, roles, products, providers, studyGuide }`. `locales`/`courses`/`levels`/`roles`/`products`/`providers` arrive **pre-joined with `\n`** (`decode_string_list()`) so the Textareas can bind directly to them; `studyGuide` arrives **pre-pretty-printed** (`pretty_json()`); `lastModified` arrives reformatted from `Y-m-d H:i:s` to `Y-m-d\TH:i` (`format_datetime_local()`) — all identical to Microsoft Certifications (§6.4).

On save, `Credpl_Admin_Ms_Exams::save()`:

1. Sanitizes `uid` (`sanitize_text_field()`) and, if non-empty, checks it against every *other* row via `Credpl_Data::ms_exam_uid_exists( $uid, $id )` — same uid-uniqueness rationale as Microsoft Certifications (§6.4, §4.4).
2. Sanitizes `title`/`display_name`/`type` with `sanitize_text_field()`; `subtitle` with `wp_kses_post()`; `url`/`icon_url` with `esc_url_raw()` (§8).
3. Sanitizes `last_modified` with `sanitize_datetime()` — identical to Microsoft Certifications.
4. Sanitizes `locales`/`courses`/`levels`/`roles`/`products`/`providers` with `sanitize_string_list()` — identical to Microsoft Certifications' `exams`/`levels`/`roles`.
5. Sanitizes `study_guide` with `sanitize_json_field()` — identical to Microsoft Certifications.
6. Calls `Credpl_Data::insert_ms_exam()` / `update_ms_exam()`.

Delete: `admin-post.php?action=credpl_delete_ms_exam&id=…`, nonce-protected, calls `Credpl_Data::delete_ms_exam()`.

`save()` redirects with `updated=1`; whenever that's present, `render_edit_page()` shows a **"Back to All Microsoft Exams"** button above the form mount point, same `$_GET['updated']`-triggered pattern as the other three screens (§6.2, §6.3, §6.4, §10 v25).

**Sync Exams**: identical pattern to Microsoft Certifications' **Sync Certifications** (§6.4, §10 v20/v21) — a nonce-protected `page-title-action` link gated behind a JS `confirm()`. `admin-post.php?action=credpl_sync_ms_exams` → `Credpl_Admin_Ms_Exams::sync()` fetches the *same* `CATALOG_API_URL` Microsoft Certifications' sync already fetches (`https://learn.microsoft.com/api/catalog/?type=certifications,exams&locale=en-us` — one HTTP request already returns both arrays; each screen's sync just reads its own half), but reads the response's `exams` array instead of `certifications`, maps each entry through the same field-by-field sanitization rules `save()` applies (`map_catalog_exam()`, §8), and upserts by `uid` (`Credpl_Data::get_ms_exam_by_uid()`). Redirects with `synced=1` plus `sync_created`/`sync_updated`/`sync_skipped`, rendered as **"Sync complete: N created, M updated, K skipped."** plus **"First reason: …"** when `K > 0` — this screen shipped with the skip-diagnostics behavior from the start (§10 v23), rather than needing a v21-style follow-up fix the way Microsoft Certifications did.

### 6.6 Shared data layer

`Credpl_Data` is the single place that talks to `$wpdb` for all four tables — every admin screen and the shortcode renderer (§7) go through it, so there's one place query shape, escaping, and sanitization live:

- `get_credentials( array $args = array() ): array`
- `get_credential( int $id ): array|null`
- `insert_credential( array $data ): int|WP_Error`
- `update_credential( int $id, array $data ): bool`
- `delete_credential( int $id ): bool`
- `get_credential_blocks(): array`
- `get_credential_block( int $id ): array|null`
- `get_credential_block_by_key( string $block_key ): array|null`
- `insert_credential_block( array $data ): int|WP_Error`
- `update_credential_block( int $id, array $data ): bool`
- `delete_credential_block( int $id ): bool`
- `block_key_exists( string $block_key ): bool`
- `get_ms_certifications( array $args = array() ): array`
- `get_ms_certification( int $id ): array|null`
- `get_ms_certification_by_uid( string $uid ): array|null`
- `ms_certification_uid_exists( string $uid, int $exclude_id = 0 ): bool`
- `insert_ms_certification( array $data ): int|WP_Error`
- `update_ms_certification( int $id, array $data ): bool|WP_Error`
- `delete_ms_certification( int $id ): bool`
- `get_ms_exams( array $args = array() ): array`
- `get_ms_exam( int $id ): array|null`
- `get_ms_exam_by_uid( string $uid ): array|null`
- `ms_exam_uid_exists( string $uid, int $exclude_id = 0 ): bool`
- `insert_ms_exam( array $data ): int|WP_Error`
- `update_ms_exam( int $id, array $data ): bool|WP_Error`
- `delete_ms_exam( int $id ): bool`

### 6.7 Integration screen (placeholder)

Mirrors Contact Form 7's "Integration" tab, which lists third-party services (Akismet, reCAPTCHA, etc.) a contact form can hook into. Nothing to integrate with is specified for this plugin yet, so `Credpl_Admin_Menu::render_integration_page()` is a stub — just a heading and a "No integrations are available yet" message. It exists now so the menu shape matches the requested structure (§6.1); real integrations (if any are wanted later — e.g. verification services, badge-issuing platforms) would replace this stub.

## 7. Shortcode: `[credential-block]`

Registered via `add_shortcode( 'credential-block', array( 'Credpl_Shortcode', 'render' ) )`.

**Attributes:**

| Attribute | Required | Notes |
| --- | --- | --- |
| `id` | Yes | The block's `block_key` (§4.2), not the raw database `id`. |

There is no `title` attribute. The heading shown above the list (`<h3 class="credpl-credential-block-heading">`, rendered whenever the block's own `title` is non-empty) always comes straight from the Credential Block's stored Title field (§4.2) — it can only be changed by editing the block in the admin screen, not per shortcode instance, so a page's heading can never drift from the block's own name. (An earlier version of this plugin exposed a `title` shortcode attribute that could override this; see §10 v10.)

**Rendering (`Credpl_Shortcode::render( $atts )`):**

1. Look up the block by `block_key` via `Credpl_Data::get_credential_block_by_key()`. If not found, render nothing (front end) — never expose a PHP error to visitors.
2. Decode `credential_ids`, fetch each existing credential (skipping any that were deleted since the block was last saved — see §6.2).
3. Output the default template: an optional heading (the block's own `title`, per the table above), then one entry per credential — badge image (linking to `credential_link`, if set), title, and — for any credential whose `credentials_type` is **not** `Awards` — an "Expires on … · Earned on …" line (`Credpl_Shortcode::format_earned_expires()`, using each set date formatted via `date_i18n()` against the site's `date_format` option; either clause is dropped if that date isn't set on the credential, and the whole line is omitted if neither is) — wrapped in a container the site can restyle. `issuer` is collected on the Credentials admin screen (§6.2, shown in its own list table column) but deliberately not rendered here (§10 v12). For a credential whose `credentials_type` is `Awards` (§10 v31), the Expires/Earned line is suppressed instead (§10 v32 — those dates aren't meaningful for an award) and two further lines are appended — **"Award Category: …"** and **"Technology Area: …"** — each only when that field is actually set on the credential (empty ones are simply skipped, same "omit if not set" behavior the Expires/Earned line used); credentials of any other type never render these two lines, even if `award_category`/`technology_area` happen to hold a leftover value (§10 v30 already covers how that can happen on the form side):

   ```html
   <div class="credpl-credential-block" data-credpl-block="a2949a2">
     <h3 class="credpl-credential-block-heading">Award(s)</h3>
     <ul class="credpl-credential-list">
       <li class="credpl-credential-item">
         <span class="credpl-credential-badge">
           <img src="https://…" alt="" />
         </span>
         <div class="credpl-credential-info">
           <h3 class="credpl-credential-title">Microsoft MVP</h3>
           <p class="credpl-credential-meta">Award Category: Business Applications</p>
           <p class="credpl-credential-meta">Technology Area: Copilot Studio, Power Apps</p>
         </div>
       </li>
       <!-- … -->
     </ul>
   </div>
   ```

4. `assets/css/credpl-credential-block.css` provides minimal default styling — a vertical stacked list with a small (40px) badge icon, a bold title slightly smaller than body text (`font-size: 0.9em`, kept low-specificity so a theme can still override it), and a muted meta line below (reused as-is for the Award Category/Technology Area lines — `Credpl_Shortcode::render_item()` gives them the same `credpl-credential-meta` class, no new CSS rule needed) — enqueued only on pages whose content actually contains the shortcode (`has_shortcode( $post->post_content, 'credential-block' )`), not site-wide. `.credpl-credential-list`/`.credpl-credential-item` are the one exception to "kept low-specificity": both carry `list-style: none !important` (plus a belt-and-suspenders `.credpl-credential-item::marker { content: none; }`), since without it a theme's own content-area list styling can reintroduce a bullet in front of each entry — and, because `.credpl-credential-item` is `display: flex`, that reintroduced marker renders on its own line above the badge/title row rather than beside it (§10 v33). This is the only `!important` in the stylesheet, deliberately scoped to just the marker suppression.

## 8. Permissions

- All admin screens and their save/delete actions require `manage_options` — a single, simple permission model appropriate for this admin-tool-style plugin (unlike the earlier CPT version, there's no per-post `edit_post`/author-ownership concept to map onto raw table rows). Flag if a narrower/custom capability is wanted instead (e.g. to let Editors manage credentials without full `manage_options`).
- Every admin-post save/delete action is nonce-protected (`wp_nonce_field()` / `check_admin_referer()`), per [Nonces](../../docs/wordpress/wordpress-plugins/04-plugin-security/nonces.md) — including the **Sync Certifications** (§6.4) and **Sync Exams** (§6.5) actions, both of which write to the database the same as save()/delete() do and are protected identically (`wp_nonce_url()`/`check_admin_referer()`), even though they're triggered by a link rather than a form. The Credentials list's **bulk delete** action (§6.2.3, §10 v41) follows the same `wp_nonce_url()`/`check_admin_referer()` pattern as the single-row Delete action, just with one fixed nonce action string covering however many `ids[]` the client attaches, rather than a nonce baked around one specific ID — `check_admin_referer()` validates the nonce independently of which IDs ride along with it, so this doesn't weaken the protection, it just matches the action having a client-determined ID list instead of a server-known one.
- Microsoft Certifications' and Microsoft Exams' sync actions (§6.4, §6.5) are the only places this plugin makes an outbound HTTP request: `wp_remote_get()` against a **fixed constant URL** (`Credpl_Admin_Ms_Certifications::CATALOG_API_URL` / `Credpl_Admin_Ms_Exams::CATALOG_API_URL` — the same literal URL, defined once per class rather than shared, matching this plugin's established per-screen-independence convention), never a user-supplied one, so there's no SSRF surface. Each response is still treated as untrusted external input — every field goes through the exact same sanitization as the corresponding manual Add/Edit form (below), nothing is exempted just because it came from Microsoft's own API.
- All writes go through `$wpdb->insert()` / `$wpdb->update()` / `$wpdb->delete()` (auto-escaping), never raw `$wpdb->query()` — except the one-time table/column rename in `Credpl_Installer::maybe_rename_forms_table_to_blocks()` (§10), which necessarily uses `RENAME TABLE`/`ALTER TABLE` DDL with interpolated (not parameterizable) identifiers; those identifiers come only from `$wpdb->prefix` plus fixed string literals, never user input. All output (titles, issuer names, URLs) is escaped at render time — `esc_html()` / `esc_url()` / `esc_attr()` as appropriate — per [Securing (escaping) Output](../../docs/wordpress/wordpress-plugins/04-plugin-security/securing-escaping-output.md).
- `credential_link` is sanitized with `esc_url_raw()` on save; `title`/`issuer` with `sanitize_text_field()`; `badge_media` and the `credential_ids` selection with `absint()` per value; `credentials_type` with `sanitize_text_field()` plus a fixed allow-list check (`Credpl_Admin_Credentials::sanitize_credentials_type()`, values outside `CREDENTIALS_TYPES` stored as `''`); `status` the same way (`Credpl_Admin_Credentials::sanitize_status()`, values outside `STATUSES` stored as `''`); `award_category`/`technology_area` with plain `sanitize_text_field()` — no allow-list, since they're free text, not fixed-option dropdowns; `credentials.description` and `credential_blocks.description` both with `sanitize_textarea_field()` (not `sanitize_text_field()`, which strips line breaks); the Credentials list table's `$_GET['orderby']`/`$_GET['order']` (§6.2) are `sanitize_key()`'d in `Credpl_Credentials_List_Table::prepare_items()` and then validated again against a fixed column allowlist in `Credpl_Data::get_credentials()` (falling back to `title`/`ASC` for anything unrecognized) before being interpolated into the `ORDER BY` clause — identifiers can't go through `$wpdb->prepare()`, so the allowlist is what makes this safe, per [Data Validation](../../docs/wordpress/wordpress-plugins/04-plugin-security/data-validation.md). The Credential Blocks, Microsoft Certifications, and Microsoft Exams list tables' `$_GET['orderby']`/`$_GET['order']` (§6.3, §6.4, §6.5) follow the identical pattern, each against its own `Credpl_Data::get_*()` method's own allowlist.
- Microsoft Certifications (§6.4) follows the same principles with a few field-specific choices: `uid` with `sanitize_text_field()` — not `sanitize_key()`, which would strip the `.` characters the source data's uid format relies on — plus an explicit uniqueness check (`Credpl_Data::ms_certification_uid_exists()`) before insert/update, since `uid`'s `UNIQUE KEY` is admin-typed rather than server-generated; `title`/`type`/`certification_type` with `sanitize_text_field()`; `subtitle` with `wp_kses_post()` (not `sanitize_text_field()`/`sanitize_textarea_field()`, both of which would strip the HTML this field is expected to carry); `url`/`icon_url` with `esc_url_raw()`; `last_modified` with a custom `sanitize_datetime()` (validates a real, parseable `datetime-local` value or stores `NULL`, same "never trust client-side validation" rationale as `sanitize_date()`); `exams`/`levels`/`roles` with a custom `sanitize_string_list()` (splits on newlines, `sanitize_text_field()`s and trims each line, drops blanks, `wp_json_encode()`s the result); `study_guide` with a custom `sanitize_json_field()` (validates the submitted text parses as JSON via `json_decode()`/`json_last_error()`, falling back to `'[]'` if it doesn't — not escaped as HTML, since this table has no front-end output for it to leak into, §7). The Sync Certifications action (§6.4) reuses every one of these same per-field rules on the catalog API's response (`Credpl_Admin_Ms_Certifications::map_catalog_certification()`), with one substitution: `last_modified` goes through `sanitize_iso8601_to_mysql()` instead of `sanitize_datetime()`, since the API supplies a real timezone-aware instant (converted to UTC) rather than a `datetime-local` form value with no timezone at all.
- Microsoft Exams (§6.5) reuses the identical set of rules and helper methods as Microsoft Certifications, field-for-field: `uid` with `sanitize_text_field()` plus `Credpl_Data::ms_exam_uid_exists()`; `title`/`display_name`/`type` with `sanitize_text_field()`; `subtitle` with `wp_kses_post()`; `url`/`icon_url` with `esc_url_raw()`; `last_modified` with `sanitize_datetime()`; `locales`/`courses`/`levels`/`roles`/`products`/`providers` each with `sanitize_string_list()`; `study_guide` with `sanitize_json_field()`. Its **Sync Exams** action (§6.5) is a second outbound-HTTP-request surface in this plugin, alongside Microsoft Certifications' Sync — same fixed-constant-URL/no-SSRF reasoning, same `map_catalog_exam()` reuse of every save() sanitization rule (with `sanitize_iso8601_to_mysql()` standing in for `sanitize_datetime()`, same substitution as Microsoft Certifications' sync).

## 9. Suggested File Structure

```
credentials-manager-plugin/
  credentials-manager-plugin.php      (plugin header + bootstrap)
  includes/
    class-credpl-installer.php          (dbDelta table creation + versioning + Form→Block migration, §5/§10)
    class-credpl-data.php               (Credpl_Data — shared $wpdb layer, §6.6)
    class-credpl-admin-menu.php         (top-level + 9 submenu registration, 4 CSS-hidden via admin_head, §6.1)
    class-credpl-admin-credentials.php  (Credentials list/add/edit page callbacks + save/delete, §6.2 — the list page callback renders a React DataGrid mount point, not a WP_List_Table, §6.2.3/§10 v34)
    class-credpl-blocks-list-table.php  (Credpl_Blocks_List_Table, §6.3)
    class-credpl-admin-blocks.php       (Credential Blocks list/add/edit page callbacks + save/delete, §6.3)
    class-credpl-ms-certifications-list-table.php  (Credpl_Ms_Certifications_List_Table, §6.4)
    class-credpl-admin-ms-certifications.php  (Microsoft Certifications list/add/edit page callbacks + save/delete/sync, §6.4)
    class-credpl-ms-exams-list-table.php  (Credpl_Ms_Exams_List_Table, §6.5)
    class-credpl-admin-ms-exams.php     (Microsoft Exams list/add/edit page callbacks + save/delete, §6.5)
    class-credpl-shortcode.php          ([credential-block] registration + rendering, §7)
  package.json                        (devDependencies: @wordpress/scripts, typescript, @types/react, @types/react-dom; dependencies: @fluentui/react-components, @fluentui/react-datepicker-compat, @dnd-kit/*, §6.2.1/§6.3.1)
  package-lock.json
  node_modules/                       (gitignored — not shipped)
  tsconfig.json                       (strict TypeScript config for `npm run check-types`, §6.2.1)
  webpack.config.js                   (replaces @wordpress/scripts's default config with a multi-entry map, §6.3.1)
  src/
    credential.tsx                      (TypeScript + JSX source for the React Add/Edit Credential form, §6.2)
    credentials-list.tsx                (TypeScript + JSX source for the React Credentials list — Fluent UI 9 Table building blocks, §6.2.3)
    credentials-block.tsx               (TypeScript + JSX source for the React Add/Edit Credential Block form + embedded drag-and-drop picker, §6.3.1)
    ms-certification.tsx                (TypeScript + JSX source for the React Add/Edit Microsoft Certification form, §6.4)
    ms-exam.tsx                         (TypeScript + JSX source for the React Add/Edit Microsoft Exam form, §6.5)
    components/
      dialogs/
        confirmation-dialog.tsx             (ConfirmationDialog — generic Fluent UI 9 Dialog wrapper, not Credentials-specific; first used by credentials-list.tsx's Delete flow, §6.2.3/§10 v42)
    styles/
      credential.styles.ts                (useCredentialStyles — extracted from credential.tsx)
      credentialsList.styles.ts           (useCredentialsListStyles, §6.2.3)
      credentialsBlock.styles.ts          (useCredentialsBlockStyles — extracted from credentials-block.tsx)
      msCertification.styles.ts           (useMsCertificationStyles, §6.4)
      msExam.styles.ts                    (useMsExamStyles, §6.5)
  build/                               (compiled by `npm run build` — shipped, not gitignored)
    credential.js
    credential.asset.php
    credentials-list.js
    credentials-list.asset.php
    credentials-block.js
    credentials-block.asset.php
    ms-certification.js
    ms-certification.asset.php
    ms-exam.js
    ms-exam.asset.php
  assets/
    css/
      credpl-credential-block.css         (front-end shortcode styling, §7)
  uninstall.php                       (no-op by default — tables and rows are left in place)
  dist/
    credentials-manager-plugin.zip      (redistributable build — runtime files + build/ output + SPECIFICATION.md, no package.json/src/node_modules/)
```

## 10. Migration Notes

The full version-by-version history of every change made to this plugin — what changed, why, and what it means for an already-running site — has moved to [CHANGE_LOG.md](CHANGE_LOG.md) (§10 v48), so this document can stay focused on describing the plugin as it currently is rather than the path that got it there. Every `(§10 vNN)` cross-reference elsewhere in this document (§4 through §11) points at the numbered entry with that same `vNN` in that file — the numbering carried over unchanged when the content moved, so none of those references needed to change.

## 11. Acceptance Criteria

- Activating the plugin creates `{$wpdb->prefix}credentials`, `{$wpdb->prefix}credential_blocks`, `{$wpdb->prefix}microsoft_certifications`, and `{$wpdb->prefix}microsoft_exams`, and sets `credpl_db_version`.
- On a site that already had data in `{$wpdb->prefix}credential_forms` (i.e. was running the plugin before the Form→Block rename), activating/updating renames that table to `{$wpdb->prefix}credential_blocks` (and its `form_key` column to `block_key`) **without losing any rows**, rather than creating an empty new table alongside an orphaned old one.
- A top-level **"Credentials Manager"** admin menu item appears, with **All Credential Blocks**, **All Credentials**, **All Microsoft Certifications**, **All Microsoft Exams**, and **Integration** submenus visible (the four "Add …" screens are intentionally not in this list, §6.1, §10 v26), and clicking the top-level item lands on the same screen as **All Credential Blocks**.
- Even though "Add Credential Block", "Add Credential", "Add Microsoft Certification", and "Add Microsoft Exam" aren't in the visible menu, each is still reachable and fully functional via its list's **Add New** button, an **Edit** row link, and (after a save) the edit screen's own **"Back to All …"** button — visiting any of their URLs directly still works.
- Creating a Credential (Title, Credential Link, Badge Image, Issuer) via "Add Credential" saves a new row and appears in the Credentials list. Immediately after, a **"Back to All Credentials"** button appears on the edit screen and navigates to the Credentials list; reloading the edit screen without a fresh save doesn't show it.
- The Credentials list renders as a Fluent UI `Table` (§6.2.3, §10 v34/v37), showing every existing credential with working Edit/Delete actions; clicking the Title, Type, Issuer, Earned On, or Expires On column header reloads the page sorted by that column (ascending, then descending on a second click), matching what those same columns did before this screen was converted from a `WP_List_Table`. Hovering (or focusing) any header cell, including the leading select-all checkbox, shows a tooltip describing that column and whether/how clicking it sorts the list (§10 v44).
- On the Credentials list, checking a row's checkbox selects it (visually highlighted, checkbox shows checked); checking the header checkbox selects every row, and shows a `"mixed"` indeterminate state when only some rows are checked. The toolbar's three buttons show only an icon, no text — hovering (or focusing) any of them, including while disabled, shows a tooltip explaining what it does and when it's enabled. With nothing selected, **New** is enabled and **Edit**/**Delete** are disabled; with exactly one row selected, **Edit** is also enabled and navigates to that credential's edit screen when clicked; with one or more rows selected, **New** is disabled and **Delete** is enabled.
- Clicking the toolbar's Delete button (with one or more rows selected) opens a Fluent UI confirmation dialog naming what's about to be deleted (the credential's title when exactly one is selected, a count for multiple) before anything happens; clicking Cancel (or pressing Escape, or the dialog's own close action) closes it with no change; clicking the dialog's Delete button actually deletes the credential(s) and returns to the list with an updated count in the notice. There is no per-row Delete button in the table itself (§10 v45) — deleting always goes through selecting a row and using the toolbar.
- On the Add/Edit Credential Block screen, dragging a credential card from "Available Credentials" into "Selected Credentials" (and vice versa) moves it between the two columns; dragging within "Selected Credentials" reorders it. Saving persists exactly the resulting set and order as `credential_ids`.
- Creating a Credential Block, selecting one or more existing Credentials via the drag-and-drop picker, and saving generates a unique `block_key` and displays a copyable `[credential-block id="…"]` shortcode on the edit screen and in the Credential Blocks list.
- Immediately after creating or updating a Credential Block, a **"Back to All Credentials"** button appears on the edit screen (above the shortcode box) and clicking it navigates to the Credentials list; reloading/revisiting the edit screen without a fresh save (no `updated=1` in the URL) does not show the button.
- On the Credential Blocks list, clicking the Title or Description column header sorts the list ascending, clicking it again sorts descending, and the arrow indicator reflects the current sort — the same behavior as the already-sortable columns on the other three list tables.
- Pasting that shortcode into a page or post's content renders a heading (the block's own Title field, when set — not overridable per shortcode instance) followed by the selected credentials (badge image, title linking to `credential_link`, and — for any credential whose Credentials Type is not `Awards` — an Expires on/Earned on line for whichever of those dates are set — issuer is not shown here, see §10 v12) on the front end, styled by `credpl-credential-block.css`. Renaming the block in the admin screen updates the heading everywhere the shortcode is pasted.
- A Credential Block containing an `Awards`-type credential with both Award Category and Technology Area set renders "Award Category: …" and "Technology Area: …" lines for that credential on the front end instead of an Expires on/Earned on line, even if `earned_on`/`expires_on` are set on it (§10 v32); a credential of any other Credentials Type never shows either Award/Technology line, and an `Awards`-type credential with just one of the two fields set shows only that one line.
- Deleting a Credential that's referenced by an existing Credential Block does not break that block's shortcode — the deleted credential is simply omitted from the rendered output.
- Creating a Microsoft Certification (UID, Title, Subtitle, URL, Icon URL, Last Modified, Type, Certification Type, Exams, Levels, Roles, Study Guide) via "Add Microsoft Certification" saves a new row and appears in the Microsoft Certifications list; saving a second row with a UID that already exists shows a validation error instead of a database error, and doesn't create a duplicate row. Immediately after a successful save, a **"Back to All Microsoft Certifications"** button appears on the edit screen and navigates to the Microsoft Certifications list.
- Editing an existing Microsoft Certification pre-fills every field with its current stored value, including `exams`/`levels`/`roles` as one value per line and `last_modified` in the datetime picker.
- Clicking **Sync Certifications** on the Microsoft Certifications list fetches Microsoft Learn's catalog, creates a row for every certification `uid` not already present, updates every row whose `uid` already exists, and shows a "Sync complete: N created, M updated, K skipped." notice with accurate counts — run it twice in a row and the second run reports 0 created (everything already exists) rather than duplicating rows. If anything was skipped, the notice also names a reason (not just a count).
- Creating a Microsoft Exam (UID, Title, Display Name, Subtitle, URL, Icon URL, Locales, Last Modified, Type, Courses, Levels, Roles, Products, Providers, Study Guide) via "Add Microsoft Exam" saves a new row and appears in the Microsoft Exams list; saving a second row with a UID that already exists shows a validation error instead of a database error, and doesn't create a duplicate row. Immediately after a successful save, a **"Back to All Microsoft Exams"** button appears on the edit screen and navigates to the Microsoft Exams list.
- Editing an existing Microsoft Exam pre-fills every field with its current stored value, including the six array fields (`locales`/`courses`/`levels`/`roles`/`products`/`providers`) as one value per line and `last_modified` in the datetime picker.
- Clicking **Sync Exams** on the Microsoft Exams list fetches Microsoft Learn's catalog, creates a row for every exam `uid` not already present, updates every row whose `uid` already exists, and shows a "Sync complete: N created, M updated, K skipped." notice (with a "First reason: …" detail whenever anything was skipped) — run it twice in a row and the second run reports 0 created.
- Deactivating or uninstalling the plugin leaves all four tables and all rows untouched.
