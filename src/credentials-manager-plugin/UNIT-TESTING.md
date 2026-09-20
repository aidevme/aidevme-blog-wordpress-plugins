# Unit Testing

## Unit Testing - PHP

**Status: not yet set up.** This section documents the recommended approach for when it is — there's no `composer.json`, `tests/` directory, or PHPUnit config in this plugin yet (see the root `CLAUDE.md`: no repo-wide test tooling exists either). Nothing here runs today; treat it as a plan, not a description of what exists.

### Why a two-tier approach

Almost everything worth testing in this plugin falls into one of two categories, and they call for different tools:

1. **Logic that doesn't touch WordPress at all** — the sanitize/map/format helper methods scattered through the `Credpl_Admin_*` classes: `sanitize_string_list()`, `sanitize_json_field()`, `sanitize_iso8601_to_mysql()`, `format_datetime_local()`, `sanitize_datetime()`, `map_catalog_certification()`/`map_catalog_exam()`, `decode_string_list()`, `pretty_json()`, and `Credpl_Admin_Menu`'s none, but similar helpers elsewhere. These are pure(ish) string/array transforms — given an input, they return an output, with no `$wpdb` query, no hook, no global state. Plain PHPUnit, no WordPress bootstrap at all, tests these fastest and simplest.
2. **Logic that talks to `$wpdb`, hooks, or other WordPress APIs** — essentially all of `Credpl_Data` (every `get_*`/`insert_*`/`update_*`/`delete_*`/`*_exists`/`*_by_uid` method), and the admin classes' `save()`/`delete()`/`bulk_delete()`/`sync()` handlers (capability checks, nonces, redirects, `wp_remote_get()`). These need a real WordPress environment — mocking `$wpdb` well enough to trust the result is harder than just running against one — so this tier uses the **official WordPress PHPUnit test suite** (`wp-phpunit/wp-phpunit` via Composer), which boots an actual WordPress install against a disposable test database for each test run and rolls back every test in a transaction, so tests don't leave rows behind.

Main tradeoff: tier 2 needs a local MySQL/MariaDB test database and more setup (Composer, `wp-phpunit`, a `wp-tests-config.php`) — a bigger lift than the PHP-CLI-only linting `DEVELOPER.md` covers — but it's the only way to actually verify `Credpl_Data`'s SQL and the admin handlers' WordPress-specific behavior rather than guessing at it. Tier 1 needs none of that and should be the starting point.

### Setting up tier 2 (WordPress integration tests)

1. Add a plugin-local `composer.json` (this plugin has none yet, same as it had no `package.json` before the React screens needed one) with `require-dev`: `phpunit/phpunit` (a version matching the target PHP — PHPUnit 9.x for PHP 7.4, since `Requires PHP: 7.4` in `credentials-manager-plugin.php`) and `wp-phpunit/wp-phpunit`.
2. `wp-phpunit/wp-phpunit` ships WordPress core's own test scaffolding (`WP_UnitTestCase`, `WP_UnitTest_Factory`, etc.) as a Composer package — no separate SVN checkout of `develop.svn.wordpress.org` needed, which is the older, non-Composer way the WordPress Plugin Handbook's own scaffolding (`wp scaffold plugin-tests`, via WP-CLI) still defaults to. Either works; the Composer route fits this plugin's existing "everything installable via a package manager" pattern (`npm` for the React side) better than a separate SVN step would.
3. A local MySQL/MariaDB server with a dedicated test database (e.g. `credpl_test`) and a `tests/wp-tests-config.php` pointing at it (`DB_NAME`/`DB_USER`/`DB_PASSWORD`/`DB_HOST`, plus `ABSPATH` pointing at a WordPress core checkout — `wp-phpunit` needs an actual WordPress install present, it only supplies the *test* scaffolding, not WordPress itself). A local WordPress environment for manual testing (mentioned as a possibility for PHP CLI in `DEVELOPER.md`'s "Option 3" — XAMPP/Laragon/WampServer) can double as this.
4. `tests/bootstrap.php` loads `wp-phpunit`'s own `functions.php`, registers `plugins_loaded` to `require_once` `credentials-manager-plugin.php` (so the plugin under test is actually active for every test), then loads WP's test bootstrap.
5. `phpunit.xml.dist` at the plugin root points at `tests/bootstrap.php` and a `<testsuite>` covering `tests/`.

### Setting up tier 1 (plain PHPUnit, no WordPress)

Same `phpunit/phpunit` dependency, no `wp-phpunit`, no database, no bootstrap beyond `require`-ing the file under test directly. A second `phpunit.xml.dist` (or a second `<testsuite>` in one config, run separately) pointed at a `tests/unit/` directory keeps these fast tests from accidentally requiring the database tier 2 needs.

### Suggested directory structure

```text
tests/
  unit/                                (tier 1 — no WordPress, no database)
    Admin/
      MsCertificationsSanitizeTest.php   (sanitize_string_list(), sanitize_json_field(), sanitize_iso8601_to_mysql(), map_catalog_certification(), …)
      MsExamsSanitizeTest.php            (same, for Credpl_Admin_Ms_Exams)
  wp/                                  (tier 2 — boots WordPress + a test database)
    bootstrap.php
    wp-tests-config.php                  (gitignored — machine-specific DB credentials)
    DataTest.php                         (Credpl_Data::insert_*/get_*/update_*/delete_* round-trips, for all four tables)
    AdminCredentialsTest.php             (save()/delete()/bulk_delete() — capability checks, nonce checks, sanitization landing correctly in the database)
```

Tier-1 methods being `private static` on their admin classes (not part of any public API) means tests need `ReflectionMethod::setAccessible( true )` to call them directly — an accepted, common PHPUnit pattern for testing private helpers without making them public just for testability.

### What to prioritize first

`Credpl_Data` is the highest-value target: it's the single place every table's query shape, escaping, and `orderby`/`order` allowlisting live (§6.6/§8 of `SPECIFICATION.md`), used by every admin screen and the shortcode renderer — a regression there is the most likely thing to silently corrupt or mis-query real data. After that, the sanitize/map helpers (tier 1, fast to add) — particularly `Credpl_Admin_Ms_Certifications`/`Credpl_Admin_Ms_Exams`'s `sync()`-related mapping functions, since they process untrusted external API data (§8) and are exactly the kind of "many small edge cases" logic unit tests suit best.

### Running tests (once set up)

```bash
# tier 1 — fast, no database
vendor/bin/phpunit --testsuite unit

# tier 2 — needs the test database configured in tests/wp/wp-tests-config.php
vendor/bin/phpunit --testsuite wp
```

## Unit Testing - React

**Status: not yet set up.** Same caveat as the PHP section above — no test runner, config, or `tests/` directory exists for the React side yet; this documents the recommended approach for when it is.

### Recommended stack: `wp-scripts test-unit-js` + `@testing-library/react`

`@wordpress/scripts` (already a devDependency, §6.2.1 of `SPECIFICATION.md`) ships a `test-unit-js` command — Jest, pre-configured with a WordPress-tuned preset (`@wordpress/jest-preset-default`: jsdom environment, Babel transform for `.tsx` reusing the same config `npm run build` already uses, so no separate TypeScript-in-Jest setup is needed). Pairing it with `@testing-library/react` (render components and query them the way a user would — by role/text/label — rather than reaching into component internals) is the same combination WordPress core itself uses for its own block-editor components. This is the recommended route specifically *because* it needs almost no new tooling: `@wordpress/scripts` and its Jest preset are already installed, so getting started only means adding `@testing-library/react`/`@testing-library/jest-dom` as devDependencies, a `jest.config.js` extending the default preset, and a `test-unit-js` script.

One import-resolution detail worth flagging up front: `webpack.config.js`'s dependency-extraction plugin (§6.3.1) externalizes `@wordpress/element`/`@wordpress/i18n` imports to WordPress core's `wp.element`/`wp.i18n` globals — but that's a **build-time** (webpack) concern only. Under Jest, those same `import { createRoot } from '@wordpress/element'` statements resolve to the real, installed npm packages directly (no `wp.*` global exists under Node/jsdom, and none is needed) — so components under test run exactly as written, no mocking of `window.wp` required.

### Why a two-tier approach here too

Mirroring the PHP section's split, this plugin's list screens (`src/credentials-list.tsx`, `src/ms-certifications-list.tsx`, etc. — see `REACT-DEVELOPER-GUIDE.md`) separate cleanly into:

1. **Pure logic, no rendering** — `buildSortUrl()`/`buildNextSortUrl()`/`buildBulkDeleteUrl()` in each list screen. These are ordinary functions closing over `config` (the `window.credpl*List` PHP-localized global); given a `config` and a column id, they return a URL string. No React, no DOM — plain Jest `expect(...).toBe(...)` assertions, fastest tier.
2. **Component rendering + interaction** — everything that needs a DOM: does checking a row's checkbox highlight it and enable the toolbar's Edit button; does the toolbar's Delete button open `ConfirmationDialog` with the right title/message (singular vs. plural, named row vs. count); does clicking a sortable `TableHeaderCell` navigate `window.location.href` to the URL tier 1 already covers; does the Sync button's own dialog show the exact confirmation text `SPECIFICATION.md` documents. This tier needs `@testing-library/react` + jsdom.

Tier 1 needs no setup beyond Jest itself; tier 2 needs `window.credpl*List` seeded with a fixture **before** the module is imported (each entry file reads `window.credpl*List` once, at module load time, into its module-scope `config` constant — not inside a component or a `useEffect` — so the global must exist before `import`/`require` runs, e.g. via `jest.resetModules()` + setting the global + `require()`-ing the entry inside each test, rather than a top-of-file `import`).

### Suggested directory structure

```text
src/
  __tests__/
    ms-certifications-list.test.tsx        (tier 2 — render + interaction, seeds window.credplMsCertificationsList)
    ms-exams-list.test.tsx                 (same, for Microsoft Exams)
    credentials-list.test.tsx              (same, for Credentials)
    lib/
      sort-urls.test.ts                     (tier 1 — buildSortUrl()/buildNextSortUrl()/buildBulkDeleteUrl(), if/when extracted into a shared module — see note below)
    components/
      confirmation-dialog.test.tsx          (the generic, reusable dialog, §10 v42 — one shared test covers every screen that uses it)
      table-footer.test.tsx                 (the generic table footer, §10 v49)
```

`buildSortUrl()`/`buildNextSortUrl()`/`buildBulkDeleteUrl()` are currently hand-duplicated per list-screen file rather than shared (each screen's own `config` shape differs slightly) — testing them today means one test file per screen, importing the whole entry module just to reach these functions (they aren't exported). Extracting the URL-building logic into a small shared, exported, screen-agnostic module under `src/lib/` (parameterized by `config.listUrl`/`orderby`/`order`, the one shape every screen's config already has in common) would let tier 1 test it once instead of once per screen — worth doing as a refactor alongside adding these tests, not a prerequisite for starting.

### Example test sketches

Tier 2 (component + interaction), seeding the PHP-localized global before importing the entry module:

```tsx
import { render, screen, fireEvent } from '@testing-library/react';

test( 'selecting exactly one row enables the toolbar Edit button', async () => {
	window.credplMsCertificationsList = {
		rows: [ { id: 1, title: 'AZ-900', editUrl: '/edit/1', iconUrl: '', certificationType: 'cert', type: 'cert', lastModifiedDisplay: '', lastModifiedRaw: '' } ],
		listUrl: '/list', orderby: 'title', order: 'asc',
		addNewUrl: '/new', bulkDeleteUrl: '/bulk-delete', syncUrl: '/sync', noItemsText: '',
	};

	document.body.innerHTML = '<div id="credpl-ms-certifications-list-root"></div>';
	await import( '../ms-certifications-list' ); // self-mounts on import, same as in the browser

	fireEvent.click( screen.getByRole( 'checkbox', { name: /select microsoft certification/i } ) );

	expect( screen.getByRole( 'button', { name: /edit/i } ) ).toBeEnabled();
} );
```

Tier 1 (pure logic, once extracted per the note above):

```ts
import { buildNextSortUrl } from '../lib/sort-urls';

test( 'clicking the already-sorted ascending column reverses it to descending', () => {
	const config = { listUrl: '/list', orderby: 'title', order: 'asc' };
	expect( buildNextSortUrl( config, 'title' ) ).toBe( '/list?orderby=title&order=desc' );
} );
```

### What to prioritize first

`ConfirmationDialog` and `TableFooter` (`src/components/`) are the highest-value targets to start with: they're generic, reusable, and every list screen depends on them (§10 v42/v49) — one well-written test file for each covers all four screens' delete/sync confirmation flows and record-count footers at once, rather than duplicating the same assertions per screen. After that, the `TableSelectionCell` selection-state logic (the `onClick`-on-the-cell-itself pattern, §10 v40 — a real bug this plugin already hit twice before landing on the working approach, exactly the kind of regression a test would catch) is the next-highest-value target, followed by the per-screen sort/bulk-delete URL builders once extracted into a shared module.

### Running tests (once set up)

```bash
npm run test-unit-js
```

(the conventional script name `wp-scripts test-unit-js` expects; add it to `package.json`'s `scripts` alongside `build`/`start`/`check-types`/`lint-php` when this is set up).
