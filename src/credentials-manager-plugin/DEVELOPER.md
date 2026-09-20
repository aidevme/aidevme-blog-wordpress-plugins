# Developer Guide

Practical setup notes for working on this plugin locally. `SPECIFICATION.md` is the authoritative description of the plugin itself; `REACT-DEVELOPER-GUIDE.md` covers the React/Fluent UI list-screen pattern; this file covers local tooling that isn't part of the plugin's own `package.json`/`npm run build` pipeline.

## Installing PHP CLI on Windows

This plugin has no PHP build step — `npm run build` only compiles the TypeScript/React admin screens (§6.2.1 of `SPECIFICATION.md`). But having a PHP CLI available locally is still valuable for one thing in particular: **catching a fatal PHP syntax error before it ever reaches a live site**, the way `npm run check-types` catches TypeScript errors before a build. CHANGE_LOG.md's v62 entry is a concrete example of a bug a 30-second `php -l` run would have caught instantly, and that instead reached production as a site-wide fatal error, because no PHP CLI was available in the environment the change was made in.

Pick whichever of these fits how you already work:

### Option 1 — Official Windows builds (recommended if you only need the CLI)

1. Go to <https://windows.php.net/download/> and download the **Non Thread Safe (NTS)** VC16 x64 **zip** build matching this plugin's minimum supported version (`Requires PHP: 7.4` in `credentials-manager-plugin.php` — but installing a current PHP 8.x build is fine too; linting only needs PHP's own parser, and this plugin's code avoids PHP 8-only syntax deliberately, see CHANGE_LOG.md v62). The installer `.exe` is not offered for CLI-only use — the zip is what you want.
2. Extract it somewhere stable, e.g. `C:\php`.
3. Add that folder to your `PATH`:
   ```powershell
   # PowerShell (run as the current user is enough — no admin needed for a user-level PATH change)
   [Environment]::SetEnvironmentVariable('PATH', "$env:PATH;C:\php", 'User')
   ```
   Open a **new** terminal window afterward — `PATH` changes don't apply to already-open shells.
4. PHP's CLI needs a `php.ini` to run without warnings (not strictly required for `php -l`, but avoids noise). Copy `php.ini-development` to `php.ini` in the same folder; the defaults are fine for linting.

### Option 2 — A package manager

Any of these install PHP and put it on `PATH` for you automatically:

```powershell
# winget (built into Windows 11)
winget install PHP.PHP

# Chocolatey
choco install php

# Scoop
scoop install php
```

### Option 3 — A bundled local-server stack

If you also want a full local WordPress environment (not just the CLI) — [XAMPP](https://www.apachefriends.org/), [Laragon](https://laragon.org/), or [WampServer](https://www.wampserver.com/) all bundle PHP. Its CLI binary is usually at `<install-dir>\php\php.exe` and needs to be added to `PATH` manually the same way as Option 1, since these stacks are built around Apache/PHP-FPM integration, not standalone CLI use.

### Verifying the install

```powershell
php -v
```

should print a version banner. If you're running commands through this repo's Bash tool (Git Bash) rather than PowerShell, confirm it resolves there too:

```bash
which php && php -v
```

Git Bash inherits the Windows `PATH`, so a working PowerShell `php -v` should also work in Bash — but if it doesn't, add the same folder to `PATH` from Git Bash's own profile (`~/.bashrc`) as a fallback: `export PATH="$PATH:/c/php"`.

## Linting PHP files with `php -l`

`php -l` ("lint") parses a file and reports a syntax error without executing any of its code — safe to run against any file, including ones with side-effecting top-level code (this plugin's files are all class definitions with no top-level side effects anyway, but the flag matters in general).

### The easy way: `npm run lint-php`

```bash
npm run lint-php
```

This runs `bin/lint-php.js` — a small, cross-platform Node.js script (plain `child_process.spawnSync`, no `find`/`xargs`, so it runs the same under Windows `cmd.exe`/PowerShell and under a Unix shell) that walks every `.php` file in this plugin (skipping `node_modules/`, `build/`, `dist/`, `.git/`) and runs `php -l` against each one, printing `OK`/`FAIL` per file and exiting non-zero if anything failed to parse. It still needs a PHP CLI on `PATH` (see above) — if none is found, it prints a pointer back to this file and exits non-zero rather than silently doing nothing. Run it after editing any `.php` file in this plugin, before packaging `dist/credentials-manager-plugin.zip`.

The rest of this section explains what that script is doing under the hood, and how to run the same check by hand if you ever need to.

### Before packaging a release: `npm run build:release`

```bash
npm run build:release
```

Runs `npm run lint-php`, and only if that passes, `npm run build` (`lint-php && build` — a failed lint stops the webpack build from running at all). This is now the single command that takes you all the way to a freshly repackaged `dist/credentials-manager-plugin.zip`: lint, then bump the version, then build, then rezip (see the next two sections) — no separate manual step needed afterward.

### `npm run build` (and therefore `build:release`) auto-bumps the plugin version

`build` has a `prebuild` script (`node bin/bump-version.js`) that npm runs automatically first — no separate command needed. It increments the patch version (e.g. `0.0.71` → `0.0.72`) in **both** `package.json`'s `"version"` and `credentials-manager-plugin.php`'s docblock `* Version:` line and `define( 'CREDPL_VERSION', … )`, so the two can never drift out of sync the way a manual edit to only one of them could. Since `build:release` itself runs `npm run build` internally, the version is bumped exactly once per `build:release` run too — not twice — because npm's `prebuild` hook fires on that nested `npm run build` invocation, not on `build:release` directly.

It does **not** touch `CREDPL_DB_VERSION` (only bumped by hand, on an actual schema change) or write a `CHANGE_LOG.md` entry (still a deliberate, hand-authored step for every real change, per the root `CLAUDE.md`) — it only keeps the two version *numbers* in sync with each other. One trade-off worth knowing: this means the version number now increases on every `npm run build`, including routine builds during iterative development (per the root `CLAUDE.md`: rebuild after every `src/` edit) — not just once per finished, documented change, the way every version bump up through v65 was. If you're mid-iteration and don't want the version to move yet, skip `npm run build` and use `npx wp-scripts build` directly (bypasses `package.json`'s scripts, and therefore `prebuild`, entirely) until you're ready for the bump.

### `npm run build` (and therefore `build:release`) also auto-repackages `dist/credentials-manager-plugin.zip`

`build` also has a `postbuild` script (`node bin/package-zip.js`) that npm runs automatically right after the webpack build finishes — the mirror image of `prebuild`, same "fires exactly once, even through `build:release`'s nested `npm run build`" behavior. It rebuilds `dist/credentials-manager-plugin.zip` directly from whatever's currently on disk: the fixed set of shippable root docs (`SPECIFICATION.md`, `CHANGE_LOG.md`, `DEVELOPER.md`, etc. — never `package.json`/`node_modules`/`src`/`tsconfig.json`/`webpack.config.js`/`bin/`, matching `SPECIFICATION.md` §9), every `.php` file under `includes/` (globbed, not hardcoded — a new admin class ships automatically), every `.js`/`.asset.php` under `build/` (also globbed — a new webpack entry ships automatically), and everything under `assets/`. Uses the `adm-zip` npm package (a real devDependency now, not just something pulled in transitively) rather than shelling out to a zip binary or PowerShell's `Compress-Archive`, so it works the same on any OS.

If you only changed a doc (no `src/`/PHP change worth a rebuild) and just want the zip refreshed with the current files, skip the full build and run the packaging step on its own:

```bash
npm run package-zip
```

This is the exact same script `postbuild` runs — just callable without triggering a version bump or a webpack rebuild first. There's no longer any reason to hand-build a staging folder and run `Compress-Archive` yourself; `npm run build:release` (or, for a docs-only refresh, `npm run package-zip`) replaces that entirely.

### Building on GitHub: the "Build Credentials Manager Plugin" workflow

`.github/workflows/build-credentials-manager-plugin.yml` builds the plugin on a GitHub-hosted runner, **manual trigger only** (`workflow_dispatch`): Actions tab → **Build Credentials Manager Plugin** → **Run workflow**, choosing a branch. It runs, in order: `npm ci`, `npm run check-types`, `npm run lint-php` (with PHP 7.4, the plugin's declared minimum), `npx wp-scripts build`, `npm run package-zip`, then uploads `dist/credentials-manager-plugin.zip` as a workflow artifact named `credentials-manager-plugin-<version>` (downloadable from the run's summary page).

It deliberately uses `npx wp-scripts build` rather than `npm run build`, so the `prebuild` version bump (above) does **not** run: the artifact carries exactly the version committed on the chosen branch, and nothing is committed or pushed back. It builds from the committed sources, so it doesn't include uncommitted local changes, and its `build/` output is discarded with the runner — the `build/` folder and `dist/` zip committed in the repo are still the ones you produce locally.

### Static analysis on GitHub: the "CodeQL - Credentials Manager Plugin" workflow

`.github/workflows/codeql-credentials-manager-plugin.yml` runs GitHub's CodeQL analysis. It starts in two ways: **manually** (Actions tab → **CodeQL - Credentials Manager Plugin** → **Run workflow**) and **automatically on every push to the `dev` branch**. It deliberately has **no `pull_request` trigger**, so opening or updating a pull request into `main` does not start it — and since merging that PR is a push to `main`, which isn't a trigger either, `main` itself is not analyzed (see below). It runs two analyses in parallel — `javascript-typescript` (the `.ts`/`.tsx` sources and the `bin/`/`webpack.config.js` scripts) and `actions` (the workflow files themselves) — with the `security-and-quality` query suite, i.e. the security queries *plus* maintainability/reliability ones. Neither language needs a build step (`build-mode: none`). Results appear under the repo's **Security → Code scanning** tab, one category per language.

**Where the results show up.** Code scanning results are stored per branch, and the Security tab shows the default branch (`main`) by default. Because only `dev` is analyzed, findings appear under the branch filter `branch:dev`, and pull requests get no CodeQL check or inline annotations. If you later want `main` covered too, add a `push` trigger for it (a merge is a push, so this needs no `pull_request` trigger).

**It does not analyze the PHP.** CodeQL has no PHP support at all, so everything under `includes/` is outside what this workflow checks — `npm run lint-php` (syntax only) is still the only automated PHP check. `.github/codeql/codeql-config.yml` excludes `build/`, `dist/`, and `node_modules` from analysis: the compiled, minified bundles committed there would only add noise, and the TypeScript under `src/` is what's worth scanning.

Uploading results needs repository **code scanning** to be usable, which is free for a public repository. If you later turn on GitHub's own CodeQL "default setup" for this repo, it will conflict with this workflow (GitHub rejects advanced-workflow uploads while default setup is enabled) — use one or the other, not both.

### Publishing a release: the "Release Credentials Manager Plugin" workflow

`.github/workflows/release-credentials-manager-plugin.yml` builds the plugin and publishes a **GitHub Release** with the installable zip attached. **Manual trigger only, and only from `main`** (Actions tab → **Release Credentials Manager Plugin** → **Run workflow**, with **Use workflow from** set to `main`). Started from any other branch, its first step fails immediately with an explanatory error — before anything is checked out, built, or published. It has two checkboxes: **prerelease** (default on — keep it on while the plugin is `0.x`) and **draft** (default off; turn it on to review the release before it goes public).

**The version comes from the repo, not the workflow.** Like the build workflow it uses `npx wp-scripts build`, so the `prebuild` version bump does *not* run; the release is built from exactly what's committed. Bump the version first (a local `npm run build` does it), merge that to `main`, then run the workflow. Before building anything it checks that `package.json`, the plugin header `Version:`, and `CREDPL_VERSION` all agree and are in `X.Y.Z` form, and that the tag doesn't already exist — otherwise it stops with an error rather than publishing something inconsistent. After building it type-checks, lints PHP with 7.4, and verifies the zip contains the required plugin files and compiled scripts and none of the dev-only files (`src/`, `bin/`, `package.json`, …).

**What it creates:**

- A tag named `credentials-manager-plugin-v<version>` (for example `credentials-manager-plugin-v0.0.83`), on the exact commit that was built. The name is plugin-scoped because this repository will hold more than one plugin, so a bare `v0.0.83` would be ambiguous.
- A release titled **Credentials Manager \<version\>** with `credentials-manager-plugin-<version>.zip` attached, and notes made of a short install blurb (with the WordPress/PHP requirements read from the plugin header and a link to `CHANGE_LOG.md` at that tag) followed by GitHub's auto-generated "What's Changed" list.

Things to know:

- **`main` only.** The first step compares the run's ref with `refs/heads/main` exactly, so `dev`, a feature branch, a tag, or a look-alike such as `main-2` all fail it. It's a step that fails rather than a job-level `if:`, because a skipped job looks like a passing run and is easy to mistake for a release that happened. The job summary records the branch and commit that were released. Note this guards against *mistakes*, not against someone with write access: a workflow can be edited on another branch and run from there. For a hard guarantee, put the release job in a GitHub **Environment** restricted to the `main` branch (repo Settings → Environments → Deployment branches).
- **The auto-generated notes cover the whole repository**, not only this plugin, so once other plugins exist they can include those plugins' pull requests. The install blurb and the `CHANGE_LOG.md` link are plugin-specific.
- **It uses the built-in `GITHUB_TOKEN`** with `contents: write` on this job only, and the `gh` CLI that GitHub-hosted runners already have — no third-party release action and no extra secret.
- **To redo a release**, delete the release *and* its tag (Releases page, then Tags) — the workflow refuses to run while the tag exists — then bump the version and run it again.

**How sites find out about a release.** From version 0.0.84 the plugin checks these GitHub Releases itself (`includes/class-credpl-updater.php`, `SPECIFICATION.md` §6.9): the header's `Update URI:` makes WordPress ask `Credpl_Updater`, which reads the repo's releases and offers the newest that is published (not a draft), tagged `credentials-manager-plugin-v<X.Y.Z>`, and has the `credentials-manager-plugin-<X.Y.Z>.zip` asset. Consequences for how you release:

- **Don't rename the tag or the asset.** The tag prefix and the asset name are what the updater matches on; a release that doesn't follow them is invisible to sites. The workflow produces them correctly — don't hand-create releases.
- **The package must come from the workflow.** GitHub's automatic "Source code" zips have a different top-level folder and would install as a second plugin.
- **Pre-releases are offered while the plugin is below 1.0.0** and stop being offered from 1.0.0 (filter `credpl_updater_include_prereleases` overrides this). So when you reach 1.0.0, untick **prerelease** in the workflow's dialog or nobody will be offered it.
- **Sites see it after WordPress's next update check** (about every 12 hours, or when an admin opens the Plugins or Updates page) **and** once the plugin's own 6-hour cache of GitHub's answer has expired. **Dashboard → Updates → Check Again does not clear that cache** (a known limitation, `SPECIFICATION.md` §6.9). To see a release immediately, clear both caches: `wp eval 'delete_site_transient("credpl_latest_release"); delete_site_transient("update_plugins");'` — or install or update any plugin from the admin, which makes core clear its own cache (and the plugin's with it).
- **The first version with the updater is 0.0.84.** Sites on 0.0.83 or earlier can't self-update and need the zip installed by hand once.

**Verifying the updater on a real site** (this has been tested against stubbed WordPress functions and the live GitHub API, not inside a running WordPress — do this once): install the 0.0.84 zip on a test site, then publish a later release (or, quicker, temporarily edit the *installed* copy's `Version:` header down to `0.0.83` while release 0.0.84 exists). Clear the caches first (the `wp eval` command above), then open **Dashboard → Updates**: the plugin should be listed as updatable, and **View version 0.0.84 details** should open a popup with the release notes. Run the update and confirm it replaces `wp-content/plugins/credentials-manager-plugin/` in place (no second copy). With WP-CLI: `wp transient delete update_plugins --network` (or `wp transient delete --all`) then `wp plugin list --update=available`.

### Lint one file

```bash
php -l includes/class-credpl-admin-ms-certifications.php
```

Output on success:

```text
No syntax errors detected in includes/class-credpl-admin-ms-certifications.php
```

Output on failure — using the actual v62 bug as an example (a doc comment closed early by an accidental `*/`, see CHANGE_LOG.md):

```text
PHP Parse error:  syntax error, unexpected token "**" in includes/class-credpl-admin-ms-certifications.php on line 199
Errors parsing includes/class-credpl-admin-ms-certifications.php
```

### Lint every PHP file in this plugin at once

From `src/credentials-manager-plugin/`:

```bash
# Bash / Git Bash
find . -name "*.php" -not -path "./node_modules/*" -print0 | xargs -0 -n1 php -l
```

```powershell
# PowerShell
Get-ChildItem -Recurse -Filter *.php -Exclude node_modules | ForEach-Object { php -l $_.FullName }
```

This is exactly what `npm run lint-php` (above) does for every file automatically — the manual commands here are for linting a single file in isolation, or for an environment where running an npm script isn't convenient. Either way, run it after editing **any** `.php` file in this plugin, before packaging `dist/credentials-manager-plugin.zip` — it takes under a second for a plugin this size and would have caught v62 immediately, well before it ever reached a live site.

### What `php -l` does and doesn't catch

- **Catches**: syntax errors — unbalanced braces/parens, the accidental `*/`-inside-a-doc-comment class of bug from v62, using PHP 8-only syntax on a codebase declaring `Requires PHP: 7.4` (`match`, `str_contains()`, etc. — actually, syntax like `match` is fine to *parse* on PHP 8's own CLI even though it wouldn't run on 7.4; if you need to confirm 7.4 compatibility specifically, lint with a PHP 7.4 CLI, not whatever version you happened to install).
- **Doesn't catch**: undefined functions/classes/constants, wrong argument counts, logic bugs, WordPress-specific issues (missing capability checks, un-escaped output, etc.) — `php -l` only parses; it never resolves symbols or executes anything. It's a fast first check, not a substitute for actually testing the change on a real WordPress install (or a static analyzer like PHPStan/Psalm/PHPCS with the WordPress ruleset, none of which are currently set up for this plugin — see "Repository overview" in the root `CLAUDE.md`: there's no repo-wide lint/test tooling).

## Fallback: linting without installing PHP at all

If you can't install a PHP CLI in your environment (this was the case for the session that introduced and then had to diagnose the v62 bug), the same class of syntax error can still be caught with a pure-JavaScript PHP parser, since Node.js is already required for this plugin's own `npm run build`:

```bash
mkdir /tmp/phplint && cd /tmp/phplint
npm install php-parser --no-audit --no-fund
```

```js
// lint.js
const fs = require('fs');
const path = require('path');
const parser = require('php-parser');

const root = process.argv[2]; // e.g. the plugin's own directory
const files = [];

function walk(dir) {
  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    if (entry.name === 'node_modules' || entry.name === 'build' || entry.name === 'dist') continue;
    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) walk(full);
    else if (entry.name.endsWith('.php')) files.push(full);
  }
}
walk(root);

const p = new parser.Engine({ parser: { extractDoc: true, suppressErrors: false }, ast: { withPositions: true } });
let anyError = false;
for (const f of files) {
  try {
    p.parseCode(fs.readFileSync(f, 'utf8'), f);
    console.log('OK   ' + f);
  } catch (e) {
    anyError = true;
    console.log('FAIL ' + f);
    console.log('     ' + e.message);
  }
}
if (!anyError) console.log('\nAll files parsed without error.');
```

```bash
node lint.js /path/to/credentials-manager-plugin
```

This is what actually found the v62 bug (`unexpected '**' (T_POW)`, pointing straight at the broken doc comment). It's a real parser (used by several PHP static-analysis tools in the JS ecosystem), not a heuristic, so its errors are trustworthy — but treat `php -l` (Option 1–3 above) as the primary tool once it's available, since it's the actual PHP engine rather than a reimplementation, and needs no setup beyond having PHP installed. This `node_modules` install is standalone tooling, not a dependency of the plugin — never add `php-parser` to this plugin's own `package.json`.
