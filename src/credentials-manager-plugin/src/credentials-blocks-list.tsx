/**
 * React-based "All Credential Blocks" list screen, built with Fluent UI
 * 9's plain `Table` building blocks — the same pattern
 * `src/credentials-list.tsx` established (§10 v34–v56; see
 * REACT-DEVELOPER-GUIDE.md for the full write-up of why/how). Renders
 * into #credpl-credentials-blocks-list-root (see
 * Credpl_Admin_Blocks::render_list_page()). Row data, the current sort,
 * and every Edit URL come pre-built from PHP via
 * `window.credplCredentialBlocksList` — the same
 * `Credpl_Data::get_credential_blocks()` query and shortcode string the
 * old `WP_List_Table` used, just localized instead of rendered as HTML.
 * Clicking a sortable column header still does a full page reload to
 * `?orderby=…&order=…` rather than re-sorting client-side — this screen
 * has no client-side data source beyond what PHP already queried once.
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
import { ArrowLeftRegular, AddRegular, EditRegular, DeleteRegular } from '@fluentui/react-icons';
import { useCredentialsBlocksListStyles, useToolbarCardStyles } from './styles';
import { ConfirmationDialog, DataTable, useRowSelection, type ColumnDef } from './components';
import { EM_DASH, getCurrentSortDirection, buildNextSortUrl, buildBulkDeleteUrl } from './tools';

interface CredentialBlockRow {
	id: number;
	title: string;
	editUrl: string;
	shortcode: string;
	description: string;
}

/**
 * The shape PHP's `wp_localize_script( 'credpl-credentials-blocks-list',
 * 'credplCredentialBlocksList', […] )` call sends (see
 * Credpl_Admin_Blocks::enqueue_list_assets()).
 */
interface CredentialBlocksListConfig {
	rows: CredentialBlockRow[];
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
		credplCredentialBlocksList?: CredentialBlocksListConfig;
	}
}

const config: CredentialBlocksListConfig = window.credplCredentialBlocksList || ( {
	rows: [],
	listUrl: '',
	orderby: 'title',
	order: 'asc',
	backUrl: '',
	addNewUrl: '',
	bulkDeleteUrl: '',
	noItemsText: '',
} as CredentialBlocksListConfig );

/**
 * The direction the currently-sorted column (`config.orderby`) is sorted
 * in — only meaningful for whichever column ID matches `config.orderby`;
 * every other column's header renders with no arrow at all.
 * `EM_DASH`/`buildNextSortUrl()`/`buildBulkDeleteUrl()` are shared across
 * all four list screens — see `src/tools/listUrls.ts`.
 */
const currentSortDirection: 'ascending' | 'descending' = getCurrentSortDirection( config.order );

/**
 * The Title cell is a Fluent UI `Link` to the block's Edit screen
 * (`row.editUrl`), so clicking the title itself opens the record for
 * editing — a plain navigation, not a form POST, so no nonce is needed
 * here any more than for the toolbar's Edit button.
 */
function CredentialBlockTitleCell( { row }: { row: CredentialBlockRow } ) {
	return (
		<Link href={ row.editUrl }>
			{ row.title || __( '(no title)', 'credentials-manager-plugin' ) }
		</Link>
	);
}

/**
 * A read-only, click-to-select text field showing the block's copyable
 * `[credential-block id="…"]` shortcode — the same "select all on click"
 * UX the old `WP_List_Table`'s shortcode column used.
 */
function CredentialBlockShortcodeCell( { shortcode }: { shortcode: string } ) {
	const styles = useCredentialsBlocksListStyles();

	return (
		<input
			type="text"
			readOnly
			value={ shortcode }
			className={ styles.shortcodeInput }
			onClick={ ( event ) => event.currentTarget.select() }
		/>
	);
}

/**
 * Truncated with an ellipsis so a long description doesn't blow out the
 * row height/column width; a `Tooltip` around the truncated text
 * surfaces the full value on hover/focus. No tooltip at all when
 * there's nothing to show (empty description).
 */
function CredentialBlockDescriptionCell( { description }: { description: string } ) {
	const styles = useCredentialsBlocksListStyles();

	if ( ! description ) {
		return <>{ EM_DASH }</>;
	}

	return (
		<Tooltip content={ description } relationship="label" withArrow>
			<span className={ styles.descriptionCell }>{ description }</span>
		</Tooltip>
	);
}

/**
 * Column IDs that are sortable (`title`, `description`) are the exact
 * strings `Credpl_Data::get_credential_blocks()`'s allowlist already
 * accepts — `buildSortUrl()` passes them straight through as `orderby`,
 * no mapping layer needed. `shortcode` isn't sortable — a generated
 * identifier, not descriptive data.
 */
const columns: ColumnDef<CredentialBlockRow>[] = [
	{
		id: 'title',
		label: __( 'Title', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( "The block's name, linking to its edit screen. Click this header to sort the list by title; click again to reverse the order.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <CredentialBlockTitleCell row={ row } />,
	},
	{
		id: 'shortcode',
		label: __( 'Shortcode', 'credentials-manager-plugin' ),
		sortable: false,
		headerTooltip: __( 'The copyable [credential-block] shortcode for this block — click the field to select it. This column is not sortable.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <CredentialBlockShortcodeCell shortcode={ row.shortcode } />,
	},
	{
		id: 'description',
		label: __( 'Description', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'A free-text note about the block. Click this header to sort the list by description; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <CredentialBlockDescriptionCell description={ row.description } />,
	},
];

function CredentialBlocksList() {
	const toolbarCardStyles = useToolbarCardStyles();
	const { selectedIds, setSelectedIds, singleSelectedRow } = useRowSelection( config.rows );
	const [ pendingDeleteIds, setPendingDeleteIds ] = useState<number[] | null>( null );

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
		? __( 'Delete Credential Blocks', 'credentials-manager-plugin' )
		: __( 'Delete Credential Block', 'credentials-manager-plugin' );

	const deleteDialogMessage = ( () => {
		if ( ! pendingDeleteIds ) {
			return '';
		}

		if ( pendingDeleteRow ) {
			return sprintf(
				/* translators: %s: credential block title. */
				__( 'Are you sure you want to delete "%s"? This action cannot be undone.', 'credentials-manager-plugin' ),
				pendingDeleteRow.title || __( '(no title)', 'credentials-manager-plugin' )
			);
		}

		return sprintf(
			/* translators: %d: number of selected credential blocks. */
			_n(
				'Are you sure you want to delete %d selected credential block? This action cannot be undone.',
				'Are you sure you want to delete %d selected credential blocks? This action cannot be undone.',
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
		<Card className={ toolbarCardStyles.toolbarCard }>
			<Toolbar aria-label={ __( 'Credential Blocks actions', 'credentials-manager-plugin' ) }>
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
					content={ __( 'Create a new credential block. Deselect all blocks to enable this button.', 'credentials-manager-plugin' ) }
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
					content={ __( "Edit the selected credential block's details. Select exactly one block to enable this button.", 'credentials-manager-plugin' ) }
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
					content={ __( 'Permanently delete the selected credential block(s). Select one or more blocks to enable this button.', 'credentials-manager-plugin' ) }
					relationship="label"
					withArrow
				>
					<ToolbarButton
						icon={ <DeleteRegular /> }
						disabledFocusable={ 0 === selectedIds.size }
						onClick={ () => setPendingDeleteIds( Array.from( selectedIds ) ) }
					/>
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
				ariaLabel={ __( 'Credential Blocks', 'credentials-manager-plugin' ) }
				selectAllTooltip={ __( 'Select or deselect every credential block currently shown in the list.', 'credentials-manager-plugin' ) }
				selectAllLabel={ __( 'Select all credential blocks', 'credentials-manager-plugin' ) }
				selectRowLabel={ __( 'Select credential block', 'credentials-manager-plugin' ) }
				noItemsText={ config.noItemsText }
			/>
			{ deleteDialog }
		</>
	);
}

const root = document.getElementById( 'credpl-credentials-blocks-list-root' );

if ( root ) {
	createRoot( root ).render(
		<FluentProvider theme={ webLightTheme }>
			<CredentialBlocksList />
		</FluentProvider>
	);
}
