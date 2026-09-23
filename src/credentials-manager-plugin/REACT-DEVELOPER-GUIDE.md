# React / Fluent UI 9 Developer Guide

This is the reference for building the next Fluent UI 9 **list screen** in this plugin. All four of this plugin's list screens (Credentials, Credential Blocks, Microsoft Certifications, Microsoft Exams — see `SPECIFICATION.md` §6.2.3/§6.3.2/§6.4.2/§6.5.2) have already gone through this conversion (`CHANGE_LOG.md` v34/v59/v60/v61); this guide stays as the reference for the *next* screen this plugin ever adds, or for any future plugin using the same pattern.

Everything here is distilled from `src/credentials-list.tsx` as it exists today, plus the two small reusable components it introduced (`src/components/dialogs/confirmation-dialog.tsx`, `src/components/tables/table-footer.tsx`). Read this guide, then read that file — the guide tells you *why* it's built the way it is; the file is the actual pattern to copy from.

This is a reference document, not a spec — `SPECIFICATION.md` §6.2.3 is the authoritative description of what `credentials-list.tsx` does and why, and `CHANGE_LOG.md` has the full version-by-version history of how it got there. When the two disagree, they win; update this guide to match.

## 1. When to reach for this pattern

Convert a `WP_List_Table` screen to this Fluent UI pattern when the screen would benefit from richer interaction (multi-select, an icon toolbar, inline badges/tooltips) — not automatically for every list. (This plugin no longer has any `WP_List_Table`-based screens left to convert — all four went through this exact conversion, §1 above — but the same judgment call applies to any future list screen this plugin or another one adds.)

Don't reach for `DataGrid` (`@fluentui/react-table`'s higher-level wrapper). This plugin's lists are all **server-rendered-once**: PHP queries and sorts exactly once per page load, and every interaction that needs different data (sorting, in the current implementation) does a full page reload rather than re-querying or re-sorting client-side. `DataGrid` bundles client-side sort-state management, column sizing, and selection machinery for exactly the scenario this plugin doesn't have — a client-side data source. Use the plain `Table`/`TableHeader`/`TableHeaderCell`/`TableRow`/`TableBody`/`TableCell`/`TableSelectionCell` building blocks instead (all from `@fluentui/react-components`). This was a deliberate migration *away* from `DataGrid` (`CHANGE_LOG.md` v37) once it became clear none of what `DataGrid` adds on top was ever being used — smaller bundle, more direct fit.

## 2. The end-to-end shape of one of these screens

Every piece, in the order data flows through it:

1. **PHP query**: the admin class's `enqueue_list_assets()` method (e.g. `Credpl_Admin_Credentials::enqueue_list_assets()`) reads `$_GET['orderby']`/`$_GET['order']`, `sanitize_key()`s them, and passes them to the entity's `Credpl_Data::get_*()` method — which re-validates against its own fixed column allowlist before the values reach SQL (see `SPECIFICATION.md` §8). This is the *only* place sorting is decided; nothing client-side re-sorts.
2. **Row shaping**: the same PHP method maps each DB row into a flat object with pre-built values the React side just renders — pre-formatted dates (`date_i18n()`), pre-built nonce-protected Edit/Delete URLs, anything else a cell needs. Don't make the client compute or format anything PHP can hand it directly; keep the TypeScript side "dumb" about anything WordPress-specific (nonces, capability checks, date formatting against site options).
3. **Localization**: `wp_localize_script()` ships the shaped rows plus a handful of URLs/strings as `window.credpl<Entity>List` (camelCase, matching the entity — e.g. `credplCredentialsList`). This is the *entire* interface between PHP and React — there is no REST endpoint, no AJAX, no client-side data fetching of any kind in this pattern.
4. **PHP mount point**: `render_list_page()` renders the page's surrounding chrome (`<h1>`, notices) in plain PHP, then a single empty `<div id="credpl-<entity>-list-root"></div>` for React to take over. Don't render the table itself in PHP any more — that's the whole point of the conversion.
5. **TypeScript entry**: a new `src/<entity>-list.tsx` file, added to `webpack.config.js`'s `entry` map (the key becomes the `build/<key>.js`/`.asset.php` filenames `wp_enqueue_script()` needs to reference).
6. **Render**: `createRoot(root).render(<FluentProvider theme={webLightTheme}><EntityList /></FluentProvider>)` at the bottom of the file, gated behind `if (root)` in case the mount point isn't on the current page (it always should be, but this guards against enqueue/localize mismatches silently rendering into `null`).

## 3. `window.credpl<Entity>List` — the localized config contract

Define a `<Entity>Row` interface and a `<Entity>ListConfig` interface at the top of the file, matching exactly what PHP's `wp_localize_script()` call sends — keep the two in sync by hand; nothing enforces this automatically. Declare the global:

```ts
interface CredentialRow {
	id: number;
	title: string;
	editUrl: string;
	deleteUrl: string;
	// … one field per column, already display-formatted where relevant
}

interface CredentialsListConfig {
	rows: CredentialRow[];
	listUrl: string;      // base admin.php?page=… URL, no orderby/order of its own
	orderby: string;
	order: string;        // 'asc' | 'desc', lowercase, matching what PHP's allowlist accepts
	backUrl: string;      // the Credentials Manager landing page — the toolbar's Back button (§7)
	addNewUrl: string;
	bulkDeleteUrl: string; // a nonce URL with no ids[] of its own — appended client-side
	noItemsText: string;
}

declare global {
	interface Window {
		credplCredentialsList?: CredentialsListConfig;
	}
}

const config: CredentialsListConfig = window.credplCredentialsList || ( {
	rows: [],
	listUrl: '',
	orderby: 'title',
	order: 'asc',
	backUrl: '',
	addNewUrl: '',
	bulkDeleteUrl: '',
	noItemsText: '',
} as CredentialsListConfig );
```

**Numeric fields are stringified.** `wp_localize_script()` casts every scalar to a string (`(string) $value` inside `WP_Scripts::localize()`), so a PHP `int` arrives in JS as a non-empty, truthy string, not a number — `"0"` is truthy. This plugin's Add/Edit forms already document this gotcha (`src/credential.tsx`'s `toNumber()` helper); it applies here too for any numeric field you localize (there happen to be none in the Credentials list's own config, but if a future list needs one, normalize it with `Number(value) || 0` once, at module scope, rather than trusting raw truthiness anywhere else).

**`config` is a module-level constant, not component state.** It's read once when the script loads and never changes — there is no `setConfig`, no re-fetch. Anything that needs to react to user interaction (selection, which delete is pending) is separate `useState` inside the component; `config` itself is inert data.

## 4. Sorting: `TableHeaderCell`, not `DataGrid`'s sort machinery

**`buildSortUrl()`/`buildNextSortUrl()`/`buildBulkDeleteUrl()`/`EM_DASH` live in `src/tools/listUrls.ts`, shared by all four list screens — don't hand-write a fifth copy.** These four screens each started with an independent, hand-written copy of this exact logic; once a fourth copy landed byte-for-byte identical to the first three, they were extracted into one shared module, parameterized by a minimal `ListUrlConfig` (`{ listUrl, orderby, order, bulkDeleteUrl }` — the four fields every screen's own config interface already has, alongside whatever else that screen needs). Import from the `src/tools/index.ts` barrel, not `listUrls.ts` directly (`import { EM_DASH, getCurrentSortDirection, buildNextSortUrl, buildBulkDeleteUrl } from './tools';`), and pass your screen's own `config` object as the first argument — don't recreate any of these locally, even if it feels like "just a few lines":

```ts
const currentSortDirection: 'ascending' | 'descending' = getCurrentSortDirection( config.order );
```

Each sortable `TableHeaderCell` gets `sortable`, `sortDirection` (only set on the one column matching `config.orderby` — every other header gets `undefined`, i.e. no arrow), and a `button` slot override whose `onClick` navigates via `window.location.href = buildNextSortUrl(config, columnId)`:

```tsx
<TableHeaderCell
	sortable={ column.sortable }
	sortDirection={ column.id === config.orderby ? currentSortDirection : undefined }
	button={ column.sortable ? { onClick: () => {
		window.location.href = buildNextSortUrl( config, column.id );
	} } : undefined }
>
	{ column.label }
</TableHeaderCell>
```

`sortable`/`sortDirection` here are **purely presentational** — they control the `aria-sort` attribute and which way the arrow icon points. The actual sorting happens because clicking navigates to a URL PHP re-queries against. Columns you don't want sortable (media, free-text notes, anything not in the PHP allowlist) simply get `sortable: false` and no `button` override.

## 5. Column definitions: a hand-rolled array, not `createTableColumn()`

There's no `DataGrid`, so there's no `createTableColumn()` either. Define your own array, typed with the shared generic `ColumnDef<TRow>` (exported from `./components`, defined in `src/components/tables/table.tsx` — don't redeclare it per screen):

```ts
import { DataTable, type ColumnDef } from './components';

const columns: ColumnDef<CredentialRow>[] = [
	{
		id: 'title',
		label: __( 'Title', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'Click this header to sort…', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <CredentialTitleCell row={ row } />,
	},
	// …
];
```

`id` doubles as the `orderby` value sent to PHP for sortable columns — use the exact same string PHP's allowlist accepts (snake_case, matching the DB column name), so there's no translation layer between the two.

**Keep this array at module scope**, not inside the component function, *unless* a cell needs to close over component state (a callback into a `useState` setter, for instance). Credentials list's own `columns` array moved *into* the component temporarily (`CHANGE_LOG.md` v42) when its Actions column needed to hand a delete-confirmation callback down to a row-action button, then moved back *out* to module scope (v45) once that column was deleted and nothing remaining needed the closure. Default to module scope; only pull it into the component if you have a concrete reason.

You don't render the header row or the body rows yourself — hand the array to `DataTable` (§10), which renders both off it, so the header and every row can't drift apart:

```tsx
<DataTable
	rows={ config.rows }
	columns={ columns }
	sortColumnId={ config.orderby }
	sortDirection={ currentSortDirection }
	onSortColumn={ ( columnId ) => {
		window.location.href = buildNextSortUrl( config, columnId );
	} }
	selectedIds={ selectedIds }
	onSelectionChange={ setSelectedIds }
	ariaLabel={ __( 'Credentials', 'credentials-manager-plugin' ) }
	selectAllTooltip={ __( 'Select or deselect every credential currently shown in the list.', 'credentials-manager-plugin' ) }
	selectAllLabel={ __( 'Select all credentials', 'credentials-manager-plugin' ) }
	selectRowLabel={ __( 'Select credential', 'credentials-manager-plugin' ) }
	noItemsText={ config.noItemsText }
/>
```

## 6. Multi-row selection: the `TableSelectionCell` gotcha

**Where this lives now** (`CHANGE_LOG.md` v83): everything below is implemented **once**, inside `DataTable` (`src/components/tables/table.tsx`, §10) — a screen no longer writes any `TableSelectionCell` markup or toggle handlers itself. It only owns the selection *state*, through the `useRowSelection()` hook (below), so its toolbar can read it. This section is kept because it explains *why* `DataTable` is written the way it is — read it before changing `DataTable`'s selection cells.

**Attach the toggle handler's `onClick` directly to `TableSelectionCell` itself — never to its `checkboxIndicator` slot.** This took three attempts to get right in `credentials-list.tsx` (`CHANGE_LOG.md` v38–v40) and is the single most important gotcha in this whole guide:

- v38's first attempt put `onClick` on the `checkboxIndicator` slot override — the `Checkbox` Fluent renders inside the cell. Didn't reliably fire.
- v39's attempt switched to `onChange` on the same slot, since `useCheckboxBase_unstable` (`@fluentui/react-checkbox`) only wires `state.input.onChange` to the native `<input>`'s `change` event internally. Still not reliable enough in practice.
- v40, the fix that actually works: attach `onClick` as a **top-level prop on `TableSelectionCell` itself**. Like any Fluent slot component, an unmatched top-level prop forwards to the component's own root element — here, the actual `<td>`/`<th>` the cell renders. A click anywhere inside that cell (including on the checkbox visual) reaches this handler through plain, guaranteed DOM event bubbling to a native table cell, with zero dependency on how `Checkbox` wires its own internal events.

```tsx
{ /* header row */ }
<TableSelectionCell
	checked={ allSelected ? true : ( someSelected ? 'mixed' : false ) }
	onClick={ toggleAllRows }
	checkboxIndicator={ { 'aria-label': __( 'Select all credentials', 'credentials-manager-plugin' ) } }
/>

{ /* each body row */ }
<TableSelectionCell
	checked={ selected }
	onClick={ () => toggleRow( row.id ) }
	checkboxIndicator={ { 'aria-label': __( 'Select credential', 'credentials-manager-plugin' ) } }
/>
```

Selection state is a plain `useState<Set<number>>` — **not** `@fluentui/react-table`'s `useTableFeatures`/`useTableSelection` hook pair. That pair expects a `DataGrid`-shaped `columns: TableColumnDefinition<TItem>[]` array to drive its bookkeeping, which this pattern doesn't maintain (§1 above). A `Set` is the direct, sufficient fit. Screens get it from `useRowSelection()` (`src/components/tables/use-row-selection.ts`), which also derives the one row the toolbar's Edit button needs:

```ts
const { selectedIds, setSelectedIds, singleSelectedRow } = useRowSelection( config.rows );
```

`DataTable` reports every change through `onSelectionChange( nextSet )` — pass it `setSelectedIds` directly. The parent keeps ownership of the state (rather than `DataTable` holding it) because the toolbar reads it too: New is enabled only when `selectedIds.size === 0`, Edit only when `singleSelectedRow` is set, Delete when `selectedIds.size > 0`.

A selected row gets `<TableRow appearance="brand" aria-selected={ selected }>` — this is a visual cue only; nothing about row rendering otherwise changes.

**Scope selection to the checkbox, not the whole row.** If any cell in the row is itself clickable (a `Link`, a `Button`), a whole-row `onClick` would make every click on those *also* toggle selection as an unwanted side effect. Keep the `onClick` on `TableSelectionCell` alone.

## 7. The toolbar: `ListPagesToolbar`, a shared component

The `Card`-wrapped `Toolbar` — icon-only Back/New/Edit/Delete buttons, plus an optional Sync button on the two Microsoft screens — used to be hand-copied into each list screen. As of `CHANGE_LOG.md` v88 it's one shared component, `ListPagesToolbar` (`src/components/toolbars/list-pages-toolbar.tsx`, re-exported from the `src/components/index.ts` barrel), used by all five list screens instead:

```tsx
<ListPagesToolbar
	ariaLabel={ __( 'Credentials actions', 'credentials-manager-plugin' ) }
	backUrl={ config.backUrl }
	addNewUrl={ config.addNewUrl }
	addNewTooltip={ __( 'Create a new credential. Deselect all credentials to enable this button.', 'credentials-manager-plugin' ) }
	addNewDisabled={ selectedIds.size > 0 }
	editTooltip={ __( "Edit the selected credential's details. Select exactly one credential to enable this button.", 'credentials-manager-plugin' ) }
	editUrl={ singleSelectedRow?.editUrl }
	deleteTooltip={ __( 'Permanently delete the selected credential(s). Select one or more credentials to enable this button.', 'credentials-manager-plugin' ) }
	deleteDisabled={ 0 === selectedIds.size }
	onDelete={ () => setPendingDeleteIds( Array.from( selectedIds ) ) }
	// sync={ { tooltip, label, onClick } } — Microsoft Certifications/Exams only; omit elsewhere
/>
```

What the component owns vs. what a screen still supplies:

- **Back is fully hardcoded** — icon, tooltip copy ("Go back to the Credentials Manager page."), always enabled — since it's identical on every screen; a screen only supplies `backUrl`.
- **New/Edit/Delete tooltip wording still varies per entity** ("Create a new credential…" vs "…skill…"), so `addNewTooltip`/`editTooltip`/`deleteTooltip` stay screen-supplied strings.
- **New's and Delete's disabled state are booleans the screen computes from its own selection** (`addNewDisabled={ selectedIds.size > 0 }`, `deleteDisabled={ 0 === selectedIds.size }`) — the component has no selection state of its own.
- **Edit's disabled state is *not* a separate boolean.** Pass `editUrl={ singleSelectedRow?.editUrl }`; the button is disabled whenever that's `undefined` and navigates to it otherwise. This avoids a second value (`editDisabled`) that could drift out of sync with whether there's actually a URL to go to.
- **Delete never navigates directly** — `onDelete` is a callback, because every screen opens its own `ConfirmationDialog` first (§10). Same for the optional `sync` prop's `onClick`.
- **`sync?: { tooltip, label, onClick }`** adds the trailing Sync button (visible label, not icon-only — `ArrowSyncRegular`) only when passed; omit it and no Sync button, divider, or icon renders at all. Only Microsoft Certifications and Microsoft Exams pass it.

A few rules baked into the component itself, worth knowing if you're changing it:

- **Icon-only, no visible text label** on Back/New/Edit/Delete (`icon` prop from `@fluentui/react-icons` — the `*Regular` variant, e.g. `AddRegular`/`EditRegular`/`DeleteRegular`). Because there's no visible text, every `ToolbarButton` is wrapped in a `Tooltip` with `relationship="label"` — this is the mechanism Fluent's own accessibility guidance calls for to give an icon-only control its accessible name. Tooltip copy is a **full sentence**, not just a restatement of the icon: what the button does *and*, since the enablement rule isn't obvious from the icon alone, what makes it available (e.g. "Select exactly one credential to enable this button.").
- **`withArrow` on every `Tooltip`** in this plugin — including the header-cell tooltips (§8) and the Description cell's truncation tooltip. Keep it consistent across every `Tooltip` usage, not just the toolbar's.
- **`disabledFocusable`, never plain `disabled`, on a button with a tooltip.** A plain `disabled` native `<button>` doesn't reliably receive hover/focus events in most browsers, so its tooltip would never show — including when the user most needs the explanation (to understand *why* it's disabled). `disabledFocusable` keeps it hoverable/focusable while still fully non-interactive: `useARIAButtonProps()` (`@fluentui/react-aria`) strips the `onClick` handler from the rendered button either way, so no separate click-guard is needed.
- **Wrapped in a `Card`** (`appearance="filled"`, the default — no need to pass it explicitly) for the "rounded corners + shadow" panel look, via `useToolbarCardStyles()` — now called only inside `ListPagesToolbar` itself, not in each screen. `Card`'s default appearance already provides `border-radius`, `box-shadow: var(--shadow4)`, and a `colorNeutralBackground1` background with zero custom CSS. The `Card` gets a `marginBottom` via its own style rule (see §11) and no constrained `width`; a block-level `Card` stretches to its container's width on its own, matching the table below it edge-to-edge, which is what actually reads as "a toolbar for this table" rather than a floating unrelated panel.

## 8. Header tooltips

Every header cell — including the leading select-all checkbox — gets a `Tooltip` wrapping the *whole cell* (not just its text), so hovering anywhere over the header shows it, not only over a small sort-icon target:

```tsx
<Tooltip key={ column.id } content={ column.headerTooltip } relationship="label" withArrow>
	<TableHeaderCell /* … */>{ column.label }</TableHeaderCell>
</Tooltip>
```

Write a comprehensive sentence per column: what the column shows, and for sortable ones, that clicking sorts (and clicking again reverses). For non-sortable columns, say so explicitly ("This column is not sortable.") rather than leaving the reader to guess why nothing happens on click.

**Making a `TableHeaderCell`'s label bold: use an inline `style`, not `className`.** `TableHeaderCell`'s own root slot already sets `font-weight: var(--fontWeightRegular)` via its own Griffel-generated class. A competing `className`-based override is a coin flip — both are equal-specificity atomic classes, and which one wins the cascade depends on stylesheet insertion order, which you don't control. An inline style always wins over any class-based rule on the same element, so:

```tsx
<TableHeaderCell style={ { fontWeight: tokens.fontWeightSemibold } } /* … */>
```

## 9. Cell renderer patterns

A handful of small, reusable shapes cover most columns:

- **Navigable title** — the primary identifying column as a `Link`, not plain text, so clicking it opens the record for editing:

  ```tsx
  function CredentialTitleCell( { row }: { row: CredentialRow } ) {
  	return <Link href={ row.editUrl }>{ row.title || __( '(no title)', '…' ) }</Link>;
  }
  ```

- **Fixed-option field as a colored `Badge`** — for a column backed by a small, known set of values (a status, a type), render a `Badge` rather than plain text, and hardcode the color mapping against the *exact literal strings* the field's allow-list uses server-side (not a guess/derivation):

  ```tsx
  function CredentialStatusCell( { status }: { status: string } ) {
  	if ( ! status ) return <>{ EM_DASH }</>;
  	if ( 'Active' === status ) return <Badge color="success">{ status }</Badge>;
  	if ( 'Expired' === status ) return <Badge color="danger">{ status }</Badge>;
  	return <Badge>{ status }</Badge>; // unknown value — don't guess a color
  }
  ```

- **Long free text, truncated + tooltip** — fixed max-width, CSS ellipsis, `Tooltip` carrying the untruncated value, nothing rendered at all when the field is empty:

  ```tsx
  function CredentialDescriptionCell( { description }: { description: string } ) {
  	const styles = useCredentialsListStyles();
  	if ( ! description ) return <>{ EM_DASH }</>;
  	return (
  		<Tooltip content={ description } relationship="label" withArrow>
  			<span className={ styles.descriptionCell }>{ description }</span>
  		</Tooltip>
  	);
  }
  ```

  (`descriptionCell` style: `display: block; max-width: 280px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;`.)

- **Empty-value convention**: `EM_DASH` (imported from `./tools`, §4 — not a local `const`), `value || EM_DASH` in every `renderCell`. Consistent across every column in this pattern — don't invent a second "not set" convention.

## 10. Reusable components: `DataTable`, `useRowSelection`, `ListPagesToolbar`, `ConfirmationDialog` and `TableFooter`

These **not entity-specific** pieces already exist under `src/components/` — reuse them rather than rebuilding any of them:

- **`DataTable`** (`src/components/tables/table.tsx`, `CHANGE_LOG.md` v83) — the whole list table: multi-select checkbox column, sortable header cells with tooltips, selected-row highlight, the empty state, and a `TableFooter` below. Generic over the row type (`DataTable<TRow extends { id: number }>`). It deliberately owns **no** selection state, **no** URLs and **no** strings: selection comes in through `selectedIds`/`onSelectionChange` (§6), a sortable header click just calls `onSortColumn( columnId )` (the screen turns that into a reload, §4), and every label — `ariaLabel`, `selectAllTooltip`, `selectAllLabel`, `selectRowLabel`, `noItemsText`, each column's `label`/`headerTooltip` — is passed in already translated, so a screen's `__()` calls stay in its own file. With no rows it renders just the `noItemsText` paragraph (no table, no footer). The confirmation dialogs stay in the screen, since their title/message vary between screens. Its own two style rules (`tableWrap`, `noItems`) are in `src/styles/table.styles.ts` (`useTableStyles`), so a screen's `*List.styles.ts` only holds its cell-specific rules.
- **`useRowSelection( rows )`** (`src/components/tables/use-row-selection.ts`) — returns `{ selectedIds, setSelectedIds, singleSelectedRow }` (§6).
- **`ListPagesToolbar`** (`src/components/toolbars/list-pages-toolbar.tsx`, `CHANGE_LOG.md` v88) — the `Card`-wrapped `Toolbar` above the table: Back (hardcoded), New/Edit/Delete, and an optional trailing Sync button. See §7 for its full prop shape and the reasoning behind which parts it owns vs. which stay screen-supplied.

- **`ConfirmationDialog`** (`src/components/dialogs/confirmation-dialog.tsx`) — wraps Fluent's `Dialog`/`DialogSurface`/`DialogBody`/`DialogTitle`/`DialogContent`/`DialogActions` behind `open`/`title`/`message`/`confirmLabel`/`cancelLabel`/`onConfirm`/`onCancel` props, with `modalType="alert"` so it can only be dismissed by an explicit Cancel/Confirm click (not by clicking the dimmed backdrop) — appropriate for any destructive confirmation, not just delete. The owning component tracks *what's* pending in its own state (Credentials list uses `useState<number[] | null>`) and builds the dialog's title/message from that state; the dialog itself has no idea what a "credential" is.
- **`TableFooter`** (`src/components/tables/table-footer.tsx`) — renders "Number of Records: N" / "Number of Selected Records: N" on one line. Its only props are `recordCount`/`selectedCount`, both plain numbers the caller supplies (`config.rows.length`, `selectedIds.size`). `DataTable` already renders it below the table (and not in the empty state, where there's nothing meaningful to count), so a screen using `DataTable` never renders it itself.

All are re-exported from the `src/components/index.ts` barrel — import from `'./components'`, not each file's own path:

```ts
import { ConfirmationDialog, DataTable, ListPagesToolbar, useRowSelection, type ColumnDef } from './components';
```

**If you add a new reusable component**, add its `export`/`export type` pair to that barrel too, and import it from `'./components'` in whatever uses it. A barrel nothing imports from is dead code.

## 11. Styling: one `makeStyles` hook per concern, in `src/styles/`, via the barrel

**Rule: styles must live in their own file under `src/styles/`, never inline in the component/screen file.** Don't call `makeStyles()` directly inside `src/<entity>-list.tsx` (or any component under `src/components/`) — not even for a single one-off rule. Every screen and component in this codebase follows this without exception (`credential.styles.ts`, `credentialsList.styles.ts`, `credentialsBlock.styles.ts`, `msCertification.styles.ts`, `msExam.styles.ts`, `tableFooter.style.ts`, `toolbarCard.styles.ts`), and a new one should too. This keeps each component file focused on markup/logic, keeps every styles hook independently reusable, and keeps the `src/styles/index.ts` barrel (below) a complete, accurate inventory of every style rule in the plugin — an inline `makeStyles()` call bypasses that inventory entirely.

Follow the existing convention: each screen/component gets its own `use<Name>Styles` hook in its own file under `src/styles/`, all re-exported from `src/styles/index.ts`:

```ts
// src/styles/credentialsList.styles.ts
import { makeStyles, tokens } from '@fluentui/react-components';

export const useCredentialsListStyles = makeStyles( {
	tableWrap: { overflowX: 'auto' },
	badgeImg: { display: 'block', width: '40px', height: '40px', objectFit: 'contain' },
	// …
} );
```

```ts
// src/styles/index.ts
export { useCredentialsListStyles } from './credentialsList.styles';
// … one line per styles file
```

Import from the barrel, not the file directly: `import { useCredentialsListStyles } from './styles';`.

**One caveat**: importing a single hook through the barrel pulls in the barrel module itself, which re-exports *every* styles hook — this cost every entry point a small (~1–2 KB) bundle-size increase when the barrel was introduced (`CHANGE_LOG.md` v52), since webpack's tree-shaking of pure re-exports doesn't fully eliminate the barrel's own per-module wrapper overhead. Negligible for these admin-only screens; not worth avoiding the barrel over, just worth knowing it's not perfectly free.

If a style rule is specific to one small piece (like the toolbar's `Card` wrapper), give it its own file/hook rather than folding it into the screen's main styles hook — e.g. `toolbarCard.styles.ts` / `useToolbarCardStyles()`, kept separate from `credentialsList.styles.ts` / `useCredentialsListStyles()`.

## 12. i18n

Every user-facing string goes through `@wordpress/i18n`, same text domain as the rest of the plugin (`'credentials-manager-plugin'`):

- `__( 'Text', 'credentials-manager-plugin' )` for a fixed string.
- `sprintf( __( 'Are you sure you want to delete "%s"?', '…' ), title )` for one with an interpolated value.
- `_n( 'Delete %d selected credential?', 'Delete %d selected credentials?', count, '…' )` for anything that needs singular/plural — combine with `sprintf` for the actual number:
  ```ts
  sprintf( _n( '…%d…', '…%d…', count, 'credentials-manager-plugin' ), count )
  ```

Never build user-facing copy by string concatenation or template literals with no `__()`/`_n()` wrapper — this plugin's translators rely on every string being extractable.

## 13. Checklist for a new list screen

1. PHP: add `enqueue_<entity>_list_assets()` (or extend the existing `enqueue_assets()` dispatcher) to query, shape rows, and `wp_localize_script()` the config — make sure it includes `listUrl`/`orderby`/`order`/`bulkDeleteUrl` (the shape `src/tools/listUrls.ts`'s `ListUrlConfig` needs, §4) alongside whatever else this screen's config carries.
2. PHP: replace the `WP_List_Table`-rendering `render_list_page()` body with the chrome + one empty mount `<div>`.
3. `webpack.config.js`: add the new entry.
4. New `src/<entity>-list.tsx`: config interfaces + global declaration (§3), `columns` array (§5), sortable-header wiring **imported from the `src/tools` barrel, not hand-written** (§4 — `EM_DASH`/`getCurrentSortDirection()`/`buildNextSortUrl()`/`buildBulkDeleteUrl()`, each called with this screen's own `config` as the first argument), `useRowSelection()` (§6), toolbar (§7), cell renderers (§9), and one `<DataTable>` for the table itself with its footer (§10) — no hand-written `Table`/`TableSelectionCell`/`TableFooter` markup.
5. New `src/styles/<entity>List.styles.ts`, added to the barrel (§11) — never `makeStyles()` inline in the `.tsx` file, even for a single rule.
6. Update `SPECIFICATION.md` for the converted screen and add a `CHANGE_LOG.md` entry, per this repo's usual discipline (`.claude/agents/developer.md`).
7. `npm run check-types` clean first (webpack's build only strips types, it doesn't check them — see `DEVELOPER.md`/§6.2.1). Then `npm run build:release` — lints every `.php` file, bumps `CREDPL_VERSION`/`package.json` together, runs the webpack build, and repackages `dist/credentials-manager-plugin.zip`, all in one command (see `DEVELOPER.md`).
