/**
 * React-based "All Microsoft Certifications" list screen, built with
 * Fluent UI 9's plain `Table` building blocks — the same pattern
 * `src/credentials-list.tsx` (§10 v34–v56) and
 * `src/credentials-blocks-list.tsx` (§10 v59) established (see
 * REACT-DEVELOPER-GUIDE.md for the full write-up of why/how). Renders
 * into #credpl-ms-certifications-list-root (see
 * Credpl_Admin_Ms_Certifications::render_list_page()). Row data, the
 * current sort, and every Edit URL come pre-built from PHP via
 * `window.credplMsCertificationsList` — the same
 * `Credpl_Data::get_ms_certifications()` query the old `WP_List_Table`
 * used, just localized instead of rendered as HTML. Clicking a sortable
 * column header still does a full page reload to `?orderby=…&order=…`
 * rather than re-sorting client-side — this screen has no client-side
 * data source beyond what PHP already queried once.
 *
 * The one addition beyond the Credential Blocks pattern: a **Sync
 * Certifications** toolbar button, replacing the old PHP-rendered
 * `page-title-action` "Sync Certifications" link (with its inline
 * `onclick="confirm(...)"`) with a `ConfirmationDialog`-gated
 * `ToolbarButton`. It's always enabled (no selection required) and
 * navigates to `config.syncUrl` — the exact same nonce URL/handler
 * (`Credpl_Admin_Ms_Certifications::sync()`) the old link posted to; only
 * the trigger moved, the backend sync logic is unchanged (§6.4).
 */

import { createRoot, useState } from '@wordpress/element';
import { __, _n, sprintf } from '@wordpress/i18n';
import {
	FluentProvider,
	webLightTheme,
	Toolbar,
	ToolbarButton,
	ToolbarDivider,
	Card,
	Link,
	Tooltip,
} from '@fluentui/react-components';
import { ArrowLeftRegular, AddRegular, EditRegular, DeleteRegular, ArrowSyncRegular } from '@fluentui/react-icons';
import { useMsCertificationsListStyles, useToolbarCardStyles } from './styles';
import { ConfirmationDialog, DataTable, useRowSelection, type ColumnDef } from './components';
import { EM_DASH, getCurrentSortDirection, buildNextSortUrl, buildBulkDeleteUrl } from './tools';

interface MsCertificationRow {
	id: number;
	title: string;
	editUrl: string;
	iconUrl: string;
	certificationType: string;
	type: string;
	lastModifiedDisplay: string;
	lastModifiedRaw: string;
}

/**
 * The shape PHP's `wp_localize_script( 'credpl-ms-certifications-list',
 * 'credplMsCertificationsList', […] )` call sends (see
 * Credpl_Admin_Ms_Certifications::enqueue_list_assets()).
 */
interface MsCertificationsListConfig {
	rows: MsCertificationRow[];
	listUrl: string;
	orderby: string;
	order: string;
	backUrl: string;
	addNewUrl: string;
	bulkDeleteUrl: string;
	syncUrl: string;
	noItemsText: string;
}

declare global {
	interface Window {
		credplMsCertificationsList?: MsCertificationsListConfig;
	}
}

const config: MsCertificationsListConfig = window.credplMsCertificationsList || ( {
	rows: [],
	listUrl: '',
	orderby: 'title',
	order: 'asc',
	backUrl: '',
	addNewUrl: '',
	bulkDeleteUrl: '',
	syncUrl: '',
	noItemsText: '',
} as MsCertificationsListConfig );

/**
 * The direction the currently-sorted column (`config.orderby`) is sorted
 * in — only meaningful for whichever column ID matches `config.orderby`;
 * every other column's header renders with no arrow at all.
 * `EM_DASH`/`buildNextSortUrl()`/`buildBulkDeleteUrl()` are shared across
 * all four list screens — see `src/tools/listUrls.ts`.
 */
const currentSortDirection: 'ascending' | 'descending' = getCurrentSortDirection( config.order );

/**
 * The Title cell is a Fluent UI `Link` to the certification's Edit screen
 * (`row.editUrl`), so clicking the title itself opens the record for
 * editing — a plain navigation, not a form POST, so no nonce is needed
 * here any more than for the toolbar's Edit button.
 */
function MsCertificationTitleCell( { row }: { row: MsCertificationRow } ) {
	return (
		<Link href={ row.editUrl }>
			{ row.title || __( '(no title)', 'credentials-manager-plugin' ) }
		</Link>
	);
}

function MsCertificationIconCell( { iconUrl }: { iconUrl: string } ) {
	const styles = useMsCertificationsListStyles();

	if ( ! iconUrl ) {
		return <>{ EM_DASH }</>;
	}

	return <img src={ iconUrl } alt="" className={ styles.iconImg } />;
}

function MsCertificationTextCell( { value }: { value: string } ) {
	return <>{ value || EM_DASH }</>;
}

function MsCertificationLastModifiedCell( { display, raw }: { display: string; raw: string } ) {
	if ( ! display ) {
		return <>{ EM_DASH }</>;
	}

	return <time dateTime={ raw }>{ display }</time>;
}

/**
 * Column IDs that are sortable (`title`, `certification_type`, `type`,
 * `last_modified`) are the exact strings
 * `Credpl_Data::get_ms_certifications()`'s allowlist already accepts —
 * `buildSortUrl()` passes them straight through as `orderby`, no mapping
 * layer needed. `icon` isn't sortable, same as the old `WP_List_Table`
 * (an image, not descriptive data) — column order otherwise matches that
 * table exactly: title, icon, certification_type, type, last_modified.
 */
const columns: ColumnDef<MsCertificationRow>[] = [
	{
		id: 'title',
		label: __( 'Title', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( "The certification's name, linking to its edit screen. Click this header to sort the list by title; click again to reverse the order.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsCertificationTitleCell row={ row } />,
	},
	{
		id: 'icon',
		label: __( 'Icon', 'credentials-manager-plugin' ),
		sortable: false,
		headerTooltip: __( "The certification's badge icon. This column is not sortable.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsCertificationIconCell iconUrl={ row.iconUrl } />,
	},
	{
		id: 'certification_type',
		label: __( 'Certification Type', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'The kind of certification (e.g. certification, applied skill). Click this header to sort the list by certification type; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsCertificationTextCell value={ row.certificationType } />,
	},
	{
		id: 'type',
		label: __( 'Type', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'The catalog entry type from Microsoft Learn. Click this header to sort the list by type; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsCertificationTextCell value={ row.type } />,
	},
	{
		id: 'last_modified',
		label: __( 'Last Modified', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'When this certification was last modified. Click this header to sort the list by last modified date; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsCertificationLastModifiedCell display={ row.lastModifiedDisplay } raw={ row.lastModifiedRaw } />,
	},
];

function MsCertificationsList() {
	const toolbarCardStyles = useToolbarCardStyles();
	const { selectedIds, setSelectedIds, singleSelectedRow } = useRowSelection( config.rows );
	const [ pendingDeleteIds, setPendingDeleteIds ] = useState<number[] | null>( null );
	const [ pendingSync, setPendingSync ] = useState( false );

	function handleConfirmDelete() {
		if ( ! pendingDeleteIds || 0 === pendingDeleteIds.length ) {
			return;
		}

		window.location.href = buildBulkDeleteUrl( config, pendingDeleteIds );
	}

	function handleCancelDelete() {
		setPendingDeleteIds( null );
	}

	function handleConfirmSync() {
		window.location.href = config.syncUrl;
	}

	function handleCancelSync() {
		setPendingSync( false );
	}

	const pendingDeleteRow = pendingDeleteIds && 1 === pendingDeleteIds.length
		? config.rows.find( ( row ) => row.id === pendingDeleteIds[ 0 ] )
		: undefined;

	const deleteDialogTitle = pendingDeleteIds && pendingDeleteIds.length > 1
		? __( 'Delete Microsoft Certifications', 'credentials-manager-plugin' )
		: __( 'Delete Microsoft Certification', 'credentials-manager-plugin' );

	const deleteDialogMessage = ( () => {
		if ( ! pendingDeleteIds ) {
			return '';
		}

		if ( pendingDeleteRow ) {
			return sprintf(
				/* translators: %s: certification title. */
				__( 'Are you sure you want to delete "%s"? This action cannot be undone.', 'credentials-manager-plugin' ),
				pendingDeleteRow.title || __( '(no title)', 'credentials-manager-plugin' )
			);
		}

		return sprintf(
			/* translators: %d: number of selected certifications. */
			_n(
				'Are you sure you want to delete %d selected Microsoft Certification? This action cannot be undone.',
				'Are you sure you want to delete %d selected Microsoft Certifications? This action cannot be undone.',
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

	const syncDialog = (
		<ConfirmationDialog
			open={ pendingSync }
			title={ __( 'Sync Certifications', 'credentials-manager-plugin' ) }
			message={ __( 'Sync certifications from Microsoft Learn now? This fetches the full catalog and may take a minute.', 'credentials-manager-plugin' ) }
			confirmLabel={ __( 'Sync', 'credentials-manager-plugin' ) }
			cancelLabel={ __( 'Cancel', 'credentials-manager-plugin' ) }
			onConfirm={ handleConfirmSync }
			onCancel={ handleCancelSync }
		/>
	);

	const toolbar = (
		<Card className={ toolbarCardStyles.toolbarCard }>
			<Toolbar aria-label={ __( 'Microsoft Certifications actions', 'credentials-manager-plugin' ) }>
				<Tooltip
					content={ __( 'Go back to the Credentials Manager page.', 'credentials-manager-plugin' ) }
					relationship="label"
					withArrow
				>
					<ToolbarButton
						icon={ <ArrowLeftRegular /> }
						onClick={ () => {
							window.location.href = config.backUrl;
						} }
					/>
				</Tooltip>
				<ToolbarDivider />
				<Tooltip
					content={ __( 'Create a new Microsoft Certification. Deselect all certifications to enable this button.', 'credentials-manager-plugin' ) }
					relationship="label"
					withArrow
				>
					<ToolbarButton
						icon={ <AddRegular /> }
						disabledFocusable={ selectedIds.size > 0 }
						onClick={ () => {
							window.location.href = config.addNewUrl;
						} }
					/>
				</Tooltip>
				<Tooltip
					content={ __( "Edit the selected Microsoft Certification's details. Select exactly one certification to enable this button.", 'credentials-manager-plugin' ) }
					relationship="label"
					withArrow
				>
					<ToolbarButton
						icon={ <EditRegular /> }
						disabledFocusable={ ! singleSelectedRow }
						onClick={ () => {
							if ( singleSelectedRow ) {
								window.location.href = singleSelectedRow.editUrl;
							}
						} }
					/>
				</Tooltip>
				<ToolbarDivider />
				<Tooltip
					content={ __( 'Permanently delete the selected Microsoft Certification(s). Select one or more certifications to enable this button.', 'credentials-manager-plugin' ) }
					relationship="label"
					withArrow
				>
					<ToolbarButton
						icon={ <DeleteRegular /> }
						disabledFocusable={ 0 === selectedIds.size }
						onClick={ () => setPendingDeleteIds( Array.from( selectedIds ) ) }
					/>
				</Tooltip>
				<ToolbarDivider />
				<Tooltip
					content={ __( 'Sync Certifications from the Microsoft Learn catalog now.', 'credentials-manager-plugin' ) }
					relationship="label"
					withArrow
				>
					<ToolbarButton
						icon={ <ArrowSyncRegular /> }
						onClick={ () => setPendingSync( true ) }
					>
						{ __( 'Sync Certifications', 'credentials-manager-plugin' ) }
					</ToolbarButton>
				</Tooltip>
			</Toolbar>
		</Card>
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
				ariaLabel={ __( 'Microsoft Certifications', 'credentials-manager-plugin' ) }
				selectAllTooltip={ __( 'Select or deselect every Microsoft Certification currently shown in the list.', 'credentials-manager-plugin' ) }
				selectAllLabel={ __( 'Select all Microsoft Certifications', 'credentials-manager-plugin' ) }
				selectRowLabel={ __( 'Select Microsoft Certification', 'credentials-manager-plugin' ) }
				noItemsText={ config.noItemsText }
			/>
			{ deleteDialog }
			{ syncDialog }
		</>
	);
}

const root = document.getElementById( 'credpl-ms-certifications-list-root' );

if ( root ) {
	createRoot( root ).render(
		<FluentProvider theme={ webLightTheme }>
			<MsCertificationsList />
		</FluentProvider>
	);
}
