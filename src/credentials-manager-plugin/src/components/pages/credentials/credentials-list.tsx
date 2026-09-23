/**
 * React-based "All Credentials" list screen, built with Fluent UI 9's
 * plain `Table` building blocks (`Table`/`TableHeader`/`TableRow`/
 * `TableHeaderCell`/`TableBody`/`TableCell`, `@fluentui/react-components`)
 * rather than the higher-level `DataGrid` component this screen used from
 * §10 v34 through v36 — see §10 v37 for why.
 *
 * Renders into #credpl-credentials-list-root (see
 * Credpl_Admin_Credentials::render_list_page()). Row data, the current
 * sort, and every Edit/Delete URL come pre-built from PHP via
 * `window.credplCredentialsList` — the same `Credpl_Data::get_credentials()`
 * query and nonce-protected admin-post.php URLs the old `WP_List_Table`
 * used, just localized instead of rendered as HTML. Clicking a sortable
 * column header still does a full page reload to `?orderby=…&order=…`
 * (the same navigation the old list table's column-header links
 * performed) rather than re-sorting client-side — this screen has no
 * client-side data source beyond what PHP already queried once, so
 * there's nothing to usefully re-sort in the browser.
 */

import { createRoot, useState } from '@wordpress/element';
import { __, _n, sprintf } from '@wordpress/i18n';
import {
	FluentProvider,
	webLightTheme,
	Badge,
	Link,
	Tooltip,
} from '@fluentui/react-components';
import { useCredentialsListStyles } from '../../../styles';
import { ConfirmationDialog, DataTable, ListPagesToolbar, useRowSelection, type ColumnDef } from '../../../components';
import { EM_DASH, getCurrentSortDirection, buildNextSortUrl, buildBulkDeleteUrl } from '../../../tools';

interface CredentialRow {
	id: number;
	title: string;
	editUrl: string;
	deleteUrl: string;
	credentialsType: string;
	issuer: string;
	earnedOnDisplay: string;
	earnedOnRaw: string;
	expiresOnDisplay: string;
	expiresOnRaw: string;
	status: string;
	badgeUrl: string;
	description: string;
}

/**
 * The shape PHP's `wp_localize_script( 'credpl-credentials-list',
 * 'credplCredentialsList', […] )` call sends (see
 * Credpl_Admin_Credentials::enqueue_list_assets()).
 */
interface CredentialsListConfig {
	rows: CredentialRow[];
	listUrl: string;
	orderby: string;
	order: string;
	backUrl: string;
	addNewUrl: string;
	bulkDeleteUrl: string;
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

/**
 * The direction the currently-sorted column (`config.orderby`) is sorted
 * in — only meaningful for whichever column ID matches `config.orderby`;
 * every other column's header renders with no arrow at all (§6.2.3).
 * `EM_DASH`/`buildNextSortUrl()`/`buildBulkDeleteUrl()` are shared across
 * all four list screens — see `src/tools/listUrls.ts`.
 */
const currentSortDirection: 'ascending' | 'descending' = getCurrentSortDirection( config.order );

/**
 * The Title cell is a Fluent UI `Link` to the credential's Edit screen
 * (`row.editUrl` — the same nonce-free `admin.php?page=…&id=…` URL the
 * toolbar's Edit button also uses, §10 v41) rather than a plain string,
 * so clicking the title itself opens the record for editing — a plain
 * navigation, not a form POST, so no nonce is needed here any more than
 * for the toolbar's Edit button.
 */
function CredentialTitleCell( { row }: { row: CredentialRow } ) {
	return (
		<Link href={ row.editUrl }>
			{ row.title || __( '(no title)', 'credentials-manager-plugin' ) }
		</Link>
	);
}

/**
 * 'Active'/'Expired' must match the literals in
 * `Credpl_Admin_Credentials::STATUSES` (§6.2) — the same fixed set the
 * Add/Edit form's Status `Dropdown` offers. Any other value (including
 * '', for a credential saved before Status existed) falls back to a
 * plain, uncolored `Badge` rather than guessing a color for it.
 */
function CredentialStatusCell( { status }: { status: string } ) {
	if ( ! status ) {
		return <>{ EM_DASH }</>;
	}

	if ( 'Active' === status ) {
		return <Badge color="success">{ status }</Badge>;
	}

	if ( 'Expired' === status ) {
		return <Badge color="danger">{ status }</Badge>;
	}

	return <Badge>{ status }</Badge>;
}

/**
 * Truncated with an ellipsis (`descriptionCell`, §6.2.3) so a long
 * description doesn't blow out the row height/column width; a `Tooltip`
 * around the truncated text surfaces the full value on hover/focus. No
 * tooltip at all when there's nothing to show (empty description), same
 * as every other "—" cell in this list.
 */
function CredentialDescriptionCell( { description }: { description: string } ) {
	const styles = useCredentialsListStyles();

	if ( ! description ) {
		return <>{ EM_DASH }</>;
	}

	return (
		<Tooltip content={ description } relationship="label" withArrow>
			<span className={ styles.descriptionCell }>{ description }</span>
		</Tooltip>
	);
}

function CredentialBadgeCell( { row }: { row: CredentialRow } ) {
	const styles = useCredentialsListStyles();

	if ( ! row.badgeUrl ) {
		return <>{ EM_DASH }</>;
	}

	return <img src={ row.badgeUrl } alt="" className={ styles.badgeImg } />;
}

/**
 * Column IDs that are sortable (`title`, `credentials_type`, `issuer`,
 * `earned_on`, `expires_on`) are the exact strings
 * `Credpl_Data::get_credentials()`'s allowlist already accepts (§8) —
 * `buildSortUrl()` passes them straight through as `orderby`, no mapping
 * layer needed. No `actions` column any more (§10 v45 — deleted along
 * with `CredentialsListRowActions`) — Edit/Delete are now toolbar-only
 * (§10 v41), so none of these `renderCell`s need to close over any
 * component state, and the array can live at module scope again.
 */
const columns: ColumnDef<CredentialRow>[] = [
	{
		id: 'title',
		label: __( 'Title', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( "The credential's name, linking to its edit screen. Click this header to sort the list by title; click again to reverse the order.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <CredentialTitleCell row={ row } />,
	},
	{
		id: 'credentials_type',
		label: __( 'Type', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'The kind of credential — Applied Skills, Certifications, or Awards. Click this header to sort the list by type; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => row.credentialsType || EM_DASH,
	},
	{
		id: 'issuer',
		label: __( 'Issuer', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'The organization or authority that issued the credential. Click this header to sort the list by issuer; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => row.issuer || EM_DASH,
	},
	{
		id: 'earned_on',
		label: __( 'Earned On', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'The date the credential was earned, if set. Click this header to sort the list by earned date; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => row.earnedOnDisplay || EM_DASH,
	},
	{
		id: 'expires_on',
		label: __( 'Expires On', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'The date the credential expires, if it does. Click this header to sort the list by expiry date; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => row.expiresOnDisplay || EM_DASH,
	},
	{
		id: 'status',
		label: __( 'Status', 'credentials-manager-plugin' ),
		sortable: false,
		headerTooltip: __( 'Whether the credential is currently Active or Expired. This column is not sortable.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <CredentialStatusCell status={ row.status } />,
	},
	{
		id: 'badge',
		label: __( 'Badge', 'credentials-manager-plugin' ),
		sortable: false,
		headerTooltip: __( "The credential's badge image, if one was uploaded. This column is not sortable.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <CredentialBadgeCell row={ row } />,
	},
	{
		id: 'description',
		label: __( 'Description', 'credentials-manager-plugin' ),
		sortable: false,
		headerTooltip: __( 'A free-text note about the credential. This column is not sortable.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <CredentialDescriptionCell description={ row.description } />,
	},
];

function CredentialsList() {
	const { selectedIds, setSelectedIds, singleSelectedRow } = useRowSelection( config.rows );
	const [ pendingDeleteIds, setPendingDeleteIds ] = useState<number[] | null>( null );

	/**
	 * The Delete confirmation dialog (§10 v42) — one shared instance for
	 * the toolbar's Delete button, the only remaining way to delete a
	 * credential since the per-row Actions column was removed (§10 v45).
	 * `pendingDeleteIds` always holds the current selection at the moment
	 * Delete was clicked (a snapshot, not a live reference to
	 * `selectedIds`, so the dialog's copy/confirm action can't drift if —
	 * implausibly, since the dialog is modal — the selection changed
	 * while it's open). When exactly one ID is pending, the message names
	 * that credential's own title rather than just a count.
	 */
	function handleConfirmDelete() {
		if ( ! pendingDeleteIds || 0 === pendingDeleteIds.length ) {
			return;
		}

		window.location.href = buildBulkDeleteUrl( config, pendingDeleteIds );
	}

	function handleCancelDelete() {
		setPendingDeleteIds( null );
	}

	const pendingDeleteRow = pendingDeleteIds && 1 === pendingDeleteIds.length
		? config.rows.find( ( row ) => row.id === pendingDeleteIds[ 0 ] )
		: undefined;

	const deleteDialogTitle = pendingDeleteIds && pendingDeleteIds.length > 1
		? __( 'Delete Credentials', 'credentials-manager-plugin' )
		: __( 'Delete Credential', 'credentials-manager-plugin' );

	const deleteDialogMessage = ( () => {
		if ( ! pendingDeleteIds ) {
			return '';
		}

		if ( pendingDeleteRow ) {
			return sprintf(
				/* translators: %s: credential title. */
				__( 'Are you sure you want to delete "%s"? This action cannot be undone.', 'credentials-manager-plugin' ),
				pendingDeleteRow.title || __( '(no title)', 'credentials-manager-plugin' )
			);
		}

		return sprintf(
			/* translators: %d: number of selected credentials. */
			_n(
				'Are you sure you want to delete %d selected credential? This action cannot be undone.',
				'Are you sure you want to delete %d selected credentials? This action cannot be undone.',
				pendingDeleteIds.length,
				'credentials-manager-plugin'
			),
			pendingDeleteIds.length
		);
	} )();

	const deleteDialog = (
		<ConfirmationDialog
			open={ !! pendingDeleteIds }
			title={ deleteDialogTitle }
			message={ deleteDialogMessage }
			confirmLabel={ __( 'Delete', 'credentials-manager-plugin' ) }
			cancelLabel={ __( 'Cancel', 'credentials-manager-plugin' ) }
			onConfirm={ handleConfirmDelete }
			onCancel={ handleCancelDelete }
		/>
	);

	const toolbar = (
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
		/>
	);

	return (
		<>
			{ toolbar }
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
			{ deleteDialog }
		</>
	);
}

const root = document.getElementById( 'credpl-credentials-list-root' );

if ( root ) {
	createRoot( root ).render(
		<FluentProvider theme={ webLightTheme }>
			<CredentialsList />
		</FluentProvider>
	);
}
