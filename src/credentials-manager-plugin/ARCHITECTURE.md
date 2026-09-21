# Credentials Manager Plugin — Architecture

## Tables

The plugin creates and manages five dedicated custom database tables — no custom post type, no `wp_posts` usage. All five are created via `dbDelta()` in `Credpl_Installer::install()` and versioned via the `credpl_db_version` option (see `credentials-manager-plugin.php` for the full `CREDPL_DB_VERSION` history). All reads/writes for all five tables go through the single shared data-layer class, `Credpl_Data`. This is a summary reference — `SPECIFICATION.md` §4 is the authoritative, most detailed source; keep both in sync when the schema changes.

### `{$wpdb->prefix}credentials`

One row per credential record (a certification, badge, applied skill, or award). Managed on the "Credentials" admin screen (`Credpl_Admin_Credentials`); rendered on the front end via the `[credential-block]` shortcode.

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | PRIMARY KEY | Internal identifier. |
| `title` | `VARCHAR(255)` | NOT NULL | `''` | KEY (index) | Human-readable name of the credential. |
| `credentials_type` | `VARCHAR(50)` | NOT NULL | `''` | — | One of a fixed set of categories: `Applied Skills`, `Certifications`, `Awards` (`Credpl_Admin_Credentials::CREDENTIALS_TYPES`). Chosen via a Fluent UI `Dropdown` on the Add/Edit form; anything outside the allow-list is rejected server-side back to `''`. |
| `status` | `VARCHAR(20)` | NOT NULL | `''` | — | One of a fixed set of values: `Active`, `Expired` (`Credpl_Admin_Credentials::STATUSES`). Same Dropdown + server-side allow-list pattern as `credentials_type`. Set manually — not derived from `expires_on`. |
| `credential_link` | `VARCHAR(255)` | NOT NULL | `''` | — | URL to the credential's external verification/issuing page. |
| `badge_media` | `BIGINT(20) UNSIGNED` | NOT NULL | `0` | KEY (index) | WordPress media library attachment ID for the badge image. |
| `issuer` | `VARCHAR(255)` | NOT NULL | `''` | KEY (index) | Organization or authority that issued the credential. |
| `credential_id` | `VARCHAR(255)` | NOT NULL | `''` | KEY (index) | The issuing platform's own identifier for this specific issued credential (e.g. a Credly credential ID) — distinct from `id` (this table's own primary key) and from `certification_number`. |
| `certification_number` | `VARCHAR(255)` | NOT NULL | `''` | — | The certification/license number tied to the certification program itself, as opposed to this one issued instance of it. |
| `earned_on` | `DATE` | NULL | `NULL` | — | Date the credential was earned/issued. No time component. |
| `expires_on` | `DATE` | NULL | `NULL` | KEY (index) | Date the credential expires, if it does. `NULL` for credentials that don't expire. |
| `description` | `TEXT` | NULL | `NULL` | — | Free-text notes about the credential. Admin-only — not rendered by the `[credential-block]` shortcode. |
| `created_at` | `DATETIME` | NULL | `NULL` | — | Set once, at insert. |
| `updated_at` | `DATETIME` | NULL | `NULL` | — | Refreshed on every update. |

### `{$wpdb->prefix}credential_blocks`

One row per saved Credential Block — a named, ordered selection of `credentials` rows. Managed on the "Credential Blocks" admin screen (`Credpl_Admin_Blocks`); rendered on the front end via the `[credential-block id="…"]` shortcode. Named `credential_blocks` since the v3→v4 Form→Block rename — was `credential_forms` (with a `form_key` column) before that; see `SPECIFICATION.md` §10 for the in-place migration on sites that predate the rename.

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | PRIMARY KEY | Internal identifier. |
| `block_key` | `VARCHAR(20)` | NOT NULL | — | UNIQUE KEY | Short, unique, non-guessable public identifier — the `id` attribute used in the `[credential-block id="…"]` shortcode. Generated once at creation; never the raw auto-increment `id`. |
| `title` | `VARCHAR(255)` | NOT NULL | `''` | — | Admin-facing name for this block. Also the heading rendered above the block's credential list on the front end — not overridable per-shortcode-instance. |
| `description` | `TEXT` | NULL | `NULL` | — | Free-text, admin-facing notes about this block. Admin-only — not rendered on the front end. |
| `credential_ids` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of `credentials.id` values, in display order (e.g. `[5,2,9]`). |
| `created_at` | `DATETIME` | NULL | `NULL` | — | Set once, at insert. |
| `updated_at` | `DATETIME` | NULL | `NULL` | — | Refreshed on every update. |

### `{$wpdb->prefix}microsoft_certifications`

One row per Microsoft Learn certification catalog entry. Standalone reference data — no relationship to `credentials` or `credential_blocks`, and not connected to the `[credential-block]` shortcode or any other front-end output. Managed on the "Microsoft Certifications" admin screen (`Credpl_Admin_Ms_Certifications`).

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | PRIMARY KEY | Internal identifier. |
| `uid` | `VARCHAR(255)` | NOT NULL | — | UNIQUE KEY | Stable external identifier from the source data (e.g. `certification.mcsa-windows-server-certification`). Admin-typed, not server-generated — checked for uniqueness (`Credpl_Data::ms_certification_uid_exists()`) before every insert/update. |
| `title` | `VARCHAR(255)` | NOT NULL | `''` | KEY (index) | Certification name. |
| `subtitle` | `LONGTEXT` | NULL | `NULL` | — | Rich description; may contain HTML (sanitized with `wp_kses_post()` on save, not stripped). |
| `url` | `VARCHAR(500)` | NOT NULL | `''` | — | Link to the certification's page on Microsoft Learn. |
| `icon_url` | `VARCHAR(500)` | NOT NULL | `''` | — | External URL to the certification's badge/icon image — not a WordPress media library attachment ID. |
| `last_modified` | `DATETIME` | NULL | `NULL` | — | When the source data was last updated. Stored as a naive `Y-m-d H:i:s`; the source data's own timezone offset isn't preserved. |
| `type` | `VARCHAR(50)` | NOT NULL | `''` | — | The source data's own top-level category, e.g. `cert`. Free text, not a fixed allow-list. |
| `certification_type` | `VARCHAR(100)` | NOT NULL | `''` | KEY (index) | The source data's own certification-family code, e.g. `mcsa`. Free text. |
| `exams` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of exam UIDs. Edited on the form as one value per line in a plain Textarea. |
| `levels` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["intermediate"]`. |
| `roles` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["administrator"]`. |
| `study_guide` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded value of unspecified shape (`[]` in every example seen so far). Edited as raw JSON text. |
| `created_at` | `DATETIME` | NULL | `NULL` | — | Set once, at insert. |
| `updated_at` | `DATETIME` | NULL | `NULL` | — | Refreshed on every update. |

Also has a **Sync Certifications** admin action (`Credpl_Admin_Ms_Certifications::sync()`) that fetches Microsoft Learn's live catalog API and upserts rows automatically, matched by `uid`.

### `{$wpdb->prefix}microsoft_exams`

One row per Microsoft Learn exam catalog entry. Sibling table to `microsoft_certifications` — same standalone-reference-data status; no relationship to `credentials`/`credential_blocks`, and no *enforced* relationship to `microsoft_certifications` either, even though a certification's own `exams` array lists the `uid`s of rows here. Managed on the "Microsoft Exams" admin screen (`Credpl_Admin_Ms_Exams`).

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | PRIMARY KEY | Internal identifier. |
| `uid` | `VARCHAR(255)` | NOT NULL | — | UNIQUE KEY | Stable external identifier from the source data (e.g. `exam.mb-300`). Admin-typed, not server-generated — checked for uniqueness (`Credpl_Data::ms_exam_uid_exists()`) before every insert/update. |
| `title` | `VARCHAR(255)` | NOT NULL | `''` | KEY (index) | Exam name. |
| `subtitle` | `LONGTEXT` | NULL | `NULL` | — | Description of what the exam measures; sanitized with `wp_kses_post()` on save. |
| `display_name` | `VARCHAR(255)` | NOT NULL | `''` | KEY (index) | Short exam code, e.g. `MB-300` — distinct from `title` and `uid`. |
| `url` | `VARCHAR(500)` | NOT NULL | `''` | — | Link to the exam's page on Microsoft Learn. |
| `icon_url` | `VARCHAR(500)` | NOT NULL | `''` | — | External URL to the exam's badge/icon image — not a WordPress media library attachment ID. |
| `locales` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of locale codes, e.g. `["en-us"]`. |
| `last_modified` | `DATETIME` | NULL | `NULL` | — | When the source data was last updated. Naive `Y-m-d H:i:s`, same as `microsoft_certifications.last_modified`. |
| `type` | `VARCHAR(50)` | NOT NULL | `''` | — | The source data's own top-level category, e.g. `exam`. Free text. |
| `courses` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of course UIDs. |
| `levels` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["intermediate"]`. |
| `roles` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["functional-consultant"]`. |
| `products` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings, e.g. `["dynamics-365","dynamics-finance"]`. |
| `providers` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded array of strings (e.g. third-party testing providers). |
| `study_guide` | `LONGTEXT` | NOT NULL | — | — | JSON-encoded value of unspecified shape. Edited as raw JSON text. |
| `created_at` | `DATETIME` | NULL | `NULL` | — | Set once, at insert. |
| `updated_at` | `DATETIME` | NULL | `NULL` | — | Refreshed on every update. |

Also has a **Sync Exams** admin action (`Credpl_Admin_Ms_Exams::sync()`) — same architecture as Microsoft Certifications' Sync, reading the `exams` array from the same catalog API response.

### `{$wpdb->prefix}skills`

One row per skill. Standalone: no relationship to any other table, and not exposed via the shortcode. Managed on the "Skills" admin screen (`Credpl_Admin_Skills`) through `Credpl_Data` (`get_skills()`, `get_skill()`, `get_skill_by_guid()`, `insert_skill()`, `update_skill()`, `delete_skill()`).

| Column | Type | Null | Default | Key | Description |
| --- | --- | --- | --- | --- | --- |
| `id` | `BIGINT(20) UNSIGNED` | NOT NULL | `AUTO_INCREMENT` | PRIMARY KEY | Internal identifier. |
| `guid` | `VARCHAR(36)` | NOT NULL | — | UNIQUE KEY | Stable external identifier (UUID v4). Generated by `insert_skill()` via `wp_generate_uuid4()` unless supplied; never changed by `update_skill()`. |
| `skill_name` | `VARCHAR(255)` | NOT NULL | `''` | KEY (index) | The skill's display name. |
| `description` | `TEXT` | NULL | `NULL` | — | Free-text description. |

No `created_at`/`updated_at` columns.
