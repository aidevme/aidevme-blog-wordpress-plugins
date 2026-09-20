/**
 * React-based "All Microsoft Exams" list screen, built with Fluent UI 9's
 * plain `Table` building blocks — the same pattern
 * `src/credentials-list.tsx` (§10 v34–v56), `src/credentials-blocks-list.tsx`
 * (§10 v59), and `src/ms-certifications-list.tsx` (§10 v60) established
 * (see REACT-DEVELOPER-GUIDE.md for the full write-up of why/how).
 * Renders into #credpl-ms-exams-list-root (see
 * Credpl_Admin_Ms_Exams::render_list_page()). Row data, the current sort,
 * and every Edit URL come pre-built from PHP via
 * `window.credplMsExamsList` — the same `Credpl_Data::get_ms_exams()`
 * query the old `WP_List_Table` used, just localized instead of rendered
 * as HTML. Clicking a sortable column header still does a full page
 * reload to `?orderby=…&order=…` rather than re-sorting client-side —
 * this screen has no client-side data source beyond what PHP already
 * queried once.
 *
 * The one addition beyond the Credential Blocks pattern: a **Sync Exams**
 * toolbar button, replacing the old PHP-rendered `page-title-action`
 * "Sync Exams" link (with its inline `onclick="confirm(...)"`) with a
 * `ConfirmationDialog`-gated `ToolbarButton`. It's always enabled (no
 * selection required) and navigates to `config.syncUrl` — the exact same
 * nonce URL/handler (`Credpl_Admin_Ms_Exams::sync()`) the old link posted
 * to; only the trigger moved, the backend sync logic is unchanged (§6.5).
 */

import { createRoot, useState } from '@wordpress/element';
import { __, _n, sprintf } from '@wordpress/i18n';
import type { ReactNode } from 'react';
import {
	FluentProvider,
	webLightTheme,
	Table,
	TableHeader,
	TableHeaderCell,
	TableRow,
	TableBody,
	TableCell,
	TableSelectionCell,
	Toolbar,
	ToolbarButton,
	ToolbarDivider,
	Card,
	Link,
	Tooltip,
	tokens,
} from '@fluentui/react-components';
import { AddRegular, EditRegular, DeleteRegular, ArrowSyncRegular } from '@fluentui/react-icons';
import { useMsExamsListStyles, useToolbarCardStyles } from './styles';
import { ConfirmationDialog, TableFooter } from './components';
import { EM_DASH, getCurrentSortDirection, buildNextSortUrl, buildBulkDeleteUrl } from './tools';

interface MsExamRow {
	id: number;
	title: string;
	editUrl: string;
	iconUrl: string;
	displayName: string;
	type: string;
	lastModifiedDisplay: string;
	lastModifiedRaw: string;
}

/**
 * The shape PHP's `wp_localize_script( 'credpl-ms-exams-list',
 * 'credplMsExamsList', […] )` call sends (see
 * Credpl_Admin_Ms_Exams::enqueue_list_assets()).
 */
interface MsExamsListConfig {
	rows: MsExamRow[];
	listUrl: string;
	orderby: string;
	order: string;
	addNewUrl: string;
	bulkDeleteUrl: string;
	syncUrl: string;
	noItemsText: string;
}

declare global {
	interface Window {
		credplMsExamsList?: MsExamsListConfig;
	}
}

const config: MsExamsListConfig = window.credplMsExamsList || ( {
	rows: [],
	listUrl: '',
	orderby: 'title',
	order: 'asc',
	addNewUrl: '',
	bulkDeleteUrl: '',
	syncUrl: '',
	noItemsText: '',
} as MsExamsListConfig );

/**
 * The direction the currently-sorted column (`config.orderby`) is sorted
 * in — only meaningful for whichever column ID matches `config.orderby`;
 * every other column's header renders with no arrow at all.
 * `EM_DASH`/`buildNextSortUrl()`/`buildBulkDeleteUrl()` are shared across
 * all four list screens — see `src/tools/listUrls.ts`.
 */
const currentSortDirection: 'ascending' | 'descending' = getCurrentSortDirection( config.order );

/**
 * The Title cell is a Fluent UI `Link` to the exam's Edit screen
 * (`row.editUrl`), so clicking the title itself opens the record for
 * editing — a plain navigation, not a form POST, so no nonce is needed
 * here any more than for the toolbar's Edit button.
 */
function MsExamTitleCell( { row }: { row: MsExamRow } ) {
	return (
		<Link href={ row.editUrl }>
			{ row.title || __( '(no title)', 'credentials-manager-plugin' ) }
		</Link>
	);
}

function MsExamIconCell( { iconUrl }: { iconUrl: string } ) {
	const styles = useMsExamsListStyles();

	if ( ! iconUrl ) {
		return <>{ EM_DASH }</>;
	}

	return <img src={ iconUrl } alt="" className={ styles.iconImg } />;
}

function MsExamTextCell( { value }: { value: string } ) {
	return <>{ value || EM_DASH }</>;
}

function MsExamLastModifiedCell( { display, raw }: { display: string; raw: string } ) {
	if ( ! display ) {
		return <>{ EM_DASH }</>;
	}

	return <time dateTime={ raw }>{ display }</time>;
}

interface ColumnDef {
	id: string;
	label: string;
	sortable: boolean;
	headerTooltip: string;
	renderCell: ( row: MsExamRow ) => ReactNode;
}

/**
 * Column IDs that are sortable (`title`, `display_name`, `type`,
 * `last_modified`) are the exact strings `Credpl_Data::get_ms_exams()`'s
 * allowlist already accepts — `buildSortUrl()` passes them straight
 * through as `orderby`, no mapping layer needed. `icon` isn't sortable,
 * same as the old `WP_List_Table` (an image, not descriptive data) —
 * column order otherwise matches that table exactly: title, icon,
 * display_name, type, last_modified.
 */
const columns: ColumnDef[] = [
	{
		id: 'title',
		label: __( 'Title', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( "The exam's name, linking to its edit screen. Click this header to sort the list by title; click again to reverse the order.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsExamTitleCell row={ row } />,
	},
	{
		id: 'icon',
		label: __( 'Icon', 'credentials-manager-plugin' ),
		sortable: false,
		headerTooltip: __( "The exam's badge icon. This column is not sortable.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsExamIconCell iconUrl={ row.iconUrl } />,
	},
	{
		id: 'display_name',
		label: __( 'Display Name', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( "The exam's display name (e.g. its exam code and title). Click this header to sort the list by display name; click again to reverse the order.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsExamTextCell value={ row.displayName } />,
	},
	{
		id: 'type',
		label: __( 'Type', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'The catalog entry type from Microsoft Learn. Click this header to sort the list by type; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsExamTextCell value={ row.type } />,
	},
	{
		id: 'last_modified',
		label: __( 'Last Modified', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( 'When this exam was last modified. Click this header to sort the list by last modified date; click again to reverse the order.', 'credentials-manager-plugin' ),
		renderCell: ( row ) => <MsExamLastModifiedCell display={ row.lastModifiedDisplay } raw={ row.lastModifiedRaw } />,
	},
];

function MsExamsList() {
	const styles = useMsExamsListStyles();
	const toolbarCardStyles = useToolbarCardStyles();
	const [ selectedIds, setSelectedIds ] = useState<Set<number>>( () => new Set() );
	const [ pendingDeleteIds, setPendingDeleteIds ] = useState<number[] | null>( null );
	const [ pendingSync, setPendingSync ] = useState( false );

	const allSelected = config.rows.length > 0 && config.rows.every( ( row ) => selectedIds.has( row.id ) );
	const someSelected = ! allSelected && config.rows.some( ( row ) => selectedIds.has( row.id ) );

	function toggleRow( id: number ) {
		setSelectedIds( ( current ) => {
			const next = new Set( current );

			if ( next.has( id ) ) {
				next.delete( id );
			} else {
				next.add( id );
			}

			return next;
		} );
	}

	function toggleAllRows() {
		setSelectedIds( allSelected ? new Set() : new Set( config.rows.map( ( row ) => row.id ) ) );
	}

	/**
	 * Enablement rules: New only when nothing is selected, Edit only when
	 * exactly one row is, Delete whenever one or more are, Sync always.
	 */
	const singleSelectedId = 1 === selectedIds.size ? Array.from( selectedIds )[ 0 ] : undefined;
	const singleSelectedRow = undefined !== singleSelectedId
		? config.rows.find( ( row ) => row.id === singleSelectedId )
		: undefined;

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
		? __( 'Delete Microsoft Exams', 'credentials-manager-plugin' )
		: __( 'Delete Microsoft Exam', 'credentials-manager-plugin' );

	const deleteDialogMessage = ( () => {
		if ( ! pendingDeleteIds ) {
			return '';
		}

		if ( pendingDeleteRow ) {
			return sprintf(
				/* translators: %s: exam title. */
				__( 'Are you sure you want to delete "%s"? This action cannot be undone.', 'credentials-manager-plugin' ),
				pendingDeleteRow.title || __( '(no title)', 'credentials-manager-plugin' )
			);
		}

		return sprintf(
			/* translators: %d: number of selected exams. */
			_n(
				'Are you sure you want to delete %d selected Microsoft Exam? This action cannot be undone.',
				'Are you sure you want to delete %d selected Microsoft Exams? This action cannot be undone.',
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
			title={ __( 'Sync Exams', 'credentials-manager-plugin' ) }
			message={ __( 'Sync exams from Microsoft Learn now? This fetches the full catalog and may take a minute.', 'credentials-manager-plugin' ) }
			confirmLabel={ __( 'Sync', 'credentials-manager-plugin' ) }
			cancelLabel={ __( 'Cancel', 'credentials-manager-plugin' ) }
			onConfirm={ handleConfirmSync }
			onCancel={ handleCancelSync }
		/>
	);

	const toolbar = (
		<Card className={ toolbarCardStyles.toolbarCard }>
			<Toolbar aria-label={ __( 'Microsoft Exams actions', 'credentials-manager-plugin' ) }>
				<Tooltip
					content={ __( 'Create a new Microsoft Exam. Deselect all exams to enable this button.', 'credentials-manager-plugin' ) }
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
					content={ __( "Edit the selected Microsoft Exam's details. Select exactly one exam to enable this button.", 'credentials-manager-plugin' ) }
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
					content={ __( 'Permanently delete the selected Microsoft Exam(s). Select one or more exams to enable this button.', 'credentials-manager-plugin' ) }
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
					content={ __( 'Sync Exams from the Microsoft Learn catalog now.', 'credentials-manager-plugin' ) }
					relationship="label"
					withArrow
				>
					<ToolbarButton
						icon={ <ArrowSyncRegular /> }
						onClick={ () => setPendingSync( true ) }
					>
						{ __( 'Sync Exams', 'credentials-manager-plugin' ) }
					</ToolbarButton>
				</Tooltip>
			</Toolbar>
		</Card>
	);

	if ( 0 === config.rows.length ) {
		return (
			<>
				{ toolbar }
				<p className={ styles.noItems }>{ config.noItemsText }</p>
				{ deleteDialog }
				{ syncDialog }
			</>
		);
	}

	return (
		<>
			{ toolbar }
			<div className={ styles.tableWrap }>
				<Table aria-label={ __( 'Microsoft Exams', 'credentials-manager-plugin' ) }>
					<TableHeader>
						<TableRow>
							<Tooltip
								content={ __( 'Select or deselect every Microsoft Exam currently shown in the list.', 'credentials-manager-plugin' ) }
								relationship="label"
								withArrow
							>
								<TableSelectionCell
									checked={ allSelected ? true : ( someSelected ? 'mixed' : false ) }
									onClick={ toggleAllRows }
									checkboxIndicator={ { 'aria-label': __( 'Select all Microsoft Exams', 'credentials-manager-plugin' ) } }
								/>
							</Tooltip>
							{ columns.map( ( column ) => (
								<Tooltip key={ column.id } content={ column.headerTooltip } relationship="label" withArrow>
									<TableHeaderCell
										style={ { fontWeight: tokens.fontWeightSemibold } }
										sortable={ column.sortable }
										sortDirection={ column.id === config.orderby ? currentSortDirection : undefined }
										button={ column.sortable ? { onClick: () => {
											window.location.href = buildNextSortUrl( config, column.id );
										} } : undefined }
									>
										{ column.label }
									</TableHeaderCell>
								</Tooltip>
							) ) }
						</TableRow>
					</TableHeader>
					<TableBody>
						{ config.rows.map( ( row ) => {
							const selected = selectedIds.has( row.id );

							return (
								<TableRow key={ row.id } appearance={ selected ? 'brand' : 'none' } aria-selected={ selected }>
									<TableSelectionCell
										checked={ selected }
										onClick={ () => toggleRow( row.id ) }
										checkboxIndicator={ { 'aria-label': __( 'Select Microsoft Exam', 'credentials-manager-plugin' ) } }
									/>
									{ columns.map( ( column ) => (
										<TableCell key={ column.id }>{ column.renderCell( row ) }</TableCell>
									) ) }
								</TableRow>
							);
						} ) }
					</TableBody>
				</Table>
			</div>
			<TableFooter recordCount={ config.rows.length } selectedCount={ selectedIds.size } />
			{ deleteDialog }
			{ syncDialog }
		</>
	);
}

const root = document.getElementById( 'credpl-ms-exams-list-root' );

if ( root ) {
	createRoot( root ).render(
		<FluentProvider theme={ webLightTheme }>
			<MsExamsList />
		</FluentProvider>
	);
}
