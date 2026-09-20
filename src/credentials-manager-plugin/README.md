![Aidevme Blog WordPress Plugins — Credentials Manager: a puzzle piece and an award badge beside credential cards](../../assets/credentials-manager-social-preview-image.png)

# Credentials Manager

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php&logoColor=white)
![TypeScript](https://img.shields.io/badge/TypeScript-3178C6?logo=typescript&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=black)
![CSS](https://img.shields.io/badge/CSS-1572B6?logo=css&logoColor=white)

[![Version](https://img.shields.io/badge/dynamic/json?url=https%3A%2F%2Fraw.githubusercontent.com%2Faidevme%2Faidevme-blog-wordpress-plugins%2Fmain%2Fsrc%2Fcredentials-manager-plugin%2Fpackage.json&query=%24.version&label=version&prefix=v&color=0F6CBD)](CHANGE_LOG.md)
![React](https://img.shields.io/badge/React-20232A?logo=react&logoColor=61DAFB)
![Fluent UI 9](https://img.shields.io/badge/Fluent%20UI-9-0F6CBD)
![WordPress 6.6+](https://img.shields.io/badge/WordPress-6.6%2B-21759B?logo=wordpress&logoColor=white)

A WordPress plugin for keeping a structured record of your credentials —
certifications, applied skills, awards — and showing a chosen selection of them,
as badges, anywhere on your site with a shortcode.

Its admin UX is modeled on Contact Form 7: dedicated admin screens (not the post
editor, and not a custom post type) with a list and an add/edit form for each
kind of record, and a shortcode you copy after saving.

> **Status:** early development (`0.0.x`), not published on WordPress.org.
> Install it from the zip described below.

## Features

- **Credentials** — individual records: title, type (Applied Skills,
  Certifications, or Awards), status (Active or Expired), credential link, badge
  image (from the media library), issuer, credential ID, certification number,
  earned/expiry dates, description, and — for Awards — an award category and
  technology area.
- **Credential Blocks** — a named, saved selection of credentials, picked with a
  two-column drag-and-drop editor. Saving a block generates a unique shortcode
  such as `[credential-block id="a2949a2"]`.
- **Front-end shortcode** — paste it into any page or post to render that block's
  credentials as a clean, restylable list of badges.
- **Microsoft Certifications** and **Microsoft Exams** — two admin-only reference
  tables of Microsoft Learn catalog entries, filled with a **Sync** button.
  They are separate from Credentials and are never shown on the front end.
- **Modern admin** — every list and form is a React app built with
  [Fluent UI 9](https://react.fluentui.dev/), with a landing page of navigation
  cards, sortable lists, multi-select, and confirmation dialogs.

## Requirements

| | |
| --- | --- |
| WordPress | 6.6 or later |
| PHP | 7.4 or later |
| Who can use it | Users with the `manage_options` capability (Administrators) |

## Installation

1. Get the plugin zip: [`dist/credentials-manager-plugin.zip`](dist/credentials-manager-plugin.zip)
   in this repository, or the artifact from a run of the **Build Credentials
   Manager Plugin** GitHub workflow.
2. In WordPress: **Plugins → Add New → Upload Plugin**, choose the zip, then
   **Install Now** and **Activate**.

Activation creates the plugin's four database tables. Later updates upgrade the
schema automatically when the plugin loads.

### Updates

From version 0.0.84, WordPress tells you when a new version is available, like
any other plugin: a notice on **Plugins** and **Dashboard → Updates**, with a
one-click update (and the per-plugin auto-update toggle). It works by checking
this repository's GitHub Releases — see [Data, privacy, and security](#data-privacy-and-security)
for what that request involves. A version is offered only once a release has been
published for it; merging code alone offers nothing. WordPress checks on its own
schedule, and the plugin remembers GitHub's answer for up to 6 hours, so a release
published in the last few hours may take a while to appear. (**Dashboard →
Updates → Check Again** does not clear that memory yet — a known limitation.)

Sites still running 0.0.83 or earlier don't have this and need the newer zip
installed by hand once.

## Using it

After activating, a **Credentials Manager** item appears in the admin sidebar. Its
landing page has cards that lead to each screen:

| Screen | What it is for |
| --- | --- |
| **All Credentials** | List, add, edit, and delete credentials. |
| **All Credential Blocks** | Build a selection of credentials and get its shortcode. |
| **All Microsoft Certifications** | Browse or edit the certification catalog table; **Sync** to refresh it. |
| **All Microsoft Exams** | Browse or edit the exam catalog table; **Sync** to refresh it. |
| **Integration** | A placeholder for future integrations. |

### Showing credentials on your site

1. Add your credentials under **All Credentials**.
2. Under **All Credential Blocks**, create a block, pick its credentials, and save.
3. Copy the shortcode shown for the block, for example:

   ```text
   [credential-block id="a2949a2"]
   ```

4. Paste it into any page or post.

The block's own title is shown as the heading, followed by one entry per
credential: badge, title, and an "Expires on … · Earned on …" line. For **Awards**
the dates line is replaced by the award category and technology area. If a block
is missing or empty, nothing is rendered — visitors never see an error.

### Styling

The plugin loads a small stylesheet, only on pages that actually contain the
shortcode. The markup uses `credpl-` prefixed classes, so your theme can restyle
it:

```html
<div class="credpl-credential-block" data-credpl-block="a2949a2">
  <h3 class="credpl-credential-block-heading">…</h3>
  <ul class="credpl-credential-list">
    <li class="credpl-credential-item">
      <span class="credpl-credential-badge"><img src="…" alt="" /></span>
      <div class="credpl-credential-info">
        <h3 class="credpl-credential-title">…</h3>
        <p class="credpl-credential-meta">…</p>
      </div>
    </li>
  </ul>
</div>
```

## Data, privacy, and security

- **Your data stays put on uninstall.** Deleting the plugin does **not** remove
  its tables; drop `{prefix}credentials`, `{prefix}credential_blocks`,
  `{prefix}microsoft_certifications`, and `{prefix}microsoft_exams` yourself if
  you want them gone.
- **Two kinds of outbound request.**
  - The **Sync** buttons on the Microsoft Certifications and Microsoft Exams
    screens fetch `https://learn.microsoft.com/api/catalog/`. This only happens
    when an administrator clicks Sync and confirms. It is a plain `GET` request;
    none of your stored records are sent.
  - **Update checks** ask `https://api.github.com/repos/aidevme/aidevme-blog-wordpress-plugins/releases`
    whether a newer release exists. WordPress does this on its normal update
    schedule, and the plugin remembers the answer for 6 hours (1 hour after a
    failure). The request carries only a `User-Agent` naming this plugin and its
    version — no site URL, no content, no stored records — but, like any web
    request, GitHub sees your server's IP address. If GitHub can't be reached, the
    check fails silently.
- **Security model.** Every admin screen and action requires `manage_options`,
  every save/delete/sync is nonce-protected, database writes use `$wpdb`'s
  insert/update/delete helpers, and output is escaped when rendered. The details
  are in [SPECIFICATION.md](SPECIFICATION.md) §8.

## Development

The admin screens are TypeScript/React source in `src/`, compiled by
[`@wordpress/scripts`](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)
into `build/`. WordPress loads the **compiled** files, so rebuild after editing
anything under `src/`.

```bash
cd src/credentials-manager-plugin
npm install

npm start                # webpack watch mode
npm run check-types      # TypeScript type-check (the build itself only strips types)
npm run lint-php         # php -l on every PHP file (needs a PHP CLI on PATH)
npm run build            # build, and repackage dist/credentials-manager-plugin.zip
npm run build:release    # lint-php, then build
```

`npm run build` also **bumps the patch version** in `package.json` and the plugin
header first. To build without bumping it, run `npx wp-scripts build` and then
`npm run package-zip`. See [DEVELOPER.md](DEVELOPER.md) for why, and for
installing PHP on Windows.

Three GitHub Actions workflows are provided:

- **Build Credentials Manager Plugin** — type-check, PHP lint, build, and upload
  the zip. Run manually from the Actions tab.
- **CodeQL - Credentials Manager Plugin** — static analysis of the TypeScript and
  the workflows. Run manually from the Actions tab, and automatically on every push
  to `dev` (not on pull requests). CodeQL does not support PHP, so the PHP is not
  covered by it.
- **Release Credentials Manager Plugin** — builds the committed version and
  publishes a GitHub Release (tag `credentials-manager-plugin-v<version>`) with the
  installable zip attached. Run manually from the Actions tab, and only from `main`.

## Documentation

| Document | Contents |
| --- | --- |
| [SPECIFICATION.md](SPECIFICATION.md) | The authoritative spec: data model, screens, shortcode, acceptance criteria. |
| [ARCHITECTURE.md](ARCHITECTURE.md) | How the pieces fit together. |
| [DEVELOPER.md](DEVELOPER.md) | Build, lint, packaging, and CI workflows. |
| [REACT-DEVELOPER-GUIDE.md](REACT-DEVELOPER-GUIDE.md) | The React/Fluent UI screen pattern used across the admin. |
| [UNIT-TESTING.md](UNIT-TESTING.md) | The proposed unit-testing approach. |
| [END-TO-END-TESTING.md](END-TO-END-TESTING.md) | Placeholder for end-to-end testing — empty for now. |
| [CHANGE_LOG.md](CHANGE_LOG.md) | Version-by-version history of every change. |

## License

GPL v2 or later, as declared in the plugin header
([license text](https://www.gnu.org/licenses/gpl-2.0.html)).
