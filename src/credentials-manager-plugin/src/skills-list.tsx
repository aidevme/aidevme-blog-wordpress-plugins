/**
 * React-based "All Skills" list screen, built with Fluent UI 9's plain
 * `Table` building blocks — the same pattern `src/ms-exams-list.tsx` and the
 * other list screens follow (see REACT-DEVELOPER-GUIDE.md for the full
 * write-up of why/how). Renders into #credpl-skills-list-root (see
 * Credpl_Admin_Skills::render_list_page()). Row data, the current sort, and
 * every Edit URL come pre-built from PHP via `window.credplSkillsList` — the
 * `Credpl_Data::get_skills()` query, localized rather than rendered as HTML.
 * Clicking a sortable column header does a full page reload to
 * `?orderby=…&order=…` rather than re-sorting client-side — this screen has
 * no client-side data source beyond what PHP already queried once.
 *
 * Toolbar: Back (to the Credentials Manager landing page), New, Edit,
 * Delete. There is no Sync button — unlike the Microsoft tables, skills
 * aren't filled from an external catalog.
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
import { useSkillsListStyles, useToolbarCardStyles } from './styles';
import { ConfirmationDialog, DataTable, useRowSelection, type ColumnDef } from './components';
import { EM_DASH, getCurrentSortDirection, buildNextSortUrl, buildBulkDeleteUrl } from './tools';

interface SkillRow {
	id: number;
	skillName: string;
	description: string;
	editUrl: string;
}

/**
 * The shape PHP's `wp_localize_script( 'credpl-skills-list',
 * 'credplSkillsList', […] )` call sends (see
 * Credpl_Admin_Skills::enqueue_list_assets()).
 */
interface SkillsListConfig {
	rows: SkillRow[];
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
		credplSkillsList?: SkillsListConfig;
	}
}

const config: SkillsListConfig = window.credplSkillsList || ( {
	rows: [],
	listUrl: '',
	orderby: 'skill_name',
	order: 'asc',
	backUrl: '',
	addNewUrl: '',
	bulkDeleteUrl: '',
	noItemsText: '',
} as SkillsListConfig );

/**
 * The direction the currently-sorted column (`config.orderby`) is sorted
 * in — only meaningful for whichever column ID matches `config.orderby`;
 * every other column's header renders with no arrow at all.
 */
const currentSortDirection: 'ascending' | 'descending' = getCurrentSortDirection( config.order );

/**
 * The Skill Name cell is a Fluent UI `Link` to the skill's Edit screen
 * (`row.editUrl`) — a plain navigation, not a form POST, so no nonce is
 * needed here any more than for the toolbar's Edit button.
 */
function SkillNameCell( { row }: { row: SkillRow } ) {
	return (
		<Link href={ row.editUrl }>
			{ row.skillName || __( '(no name)', 'credentials-manager-plugin' ) }
		</Link>
	);
}

function SkillDescriptionCell( { description }: { description: string } ) {
	const styles = useSkillsListStyles();

	if ( ! description ) {
		return <>{ EM_DASH }</>;
	}

	return <span className={ styles.descriptionCell } title={ description }>{ description }</span>;
}

/**
 * Column IDs (`skill_name`, `description`) are the exact strings
 * `Credpl_Data::get_skills()`'s allowlist already accepts —
 * `buildNextSortUrl()` passes them straight through as `orderby`, no mapping
 * layer needed. The GUID is deliberately not a column: it's an internal
 * identifier, not something the list shows.
 */
const columns: ColumnDef<SkillRow>[] = [
	{
		id: 'skill_name',
		label: __( 'Skill Name', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( "The skill's name, linking to its edit screen. Click this header to sort the list by skill name; click again to reverse the order.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <SkillNameCell row={ row } />,
	},
	{
		id: 'description',
		label: __( 'Description', 'credentials-manager-plugin' ),
		sortable: true,
		headerTooltip: __( "The skill's description. Click this header to sort the list by description; click again to reverse the order.", 'credentials-manager-plugin' ),
		renderCell: ( row ) => <SkillDescriptionCell description={ row.description } />,
	},
];

function SkillsList() {
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
		? __( 'Delete Skills', 'credentials-manager-plugin' )
		: __( 'Delete Skill', 'credentials-manager-plugin' );

	const deleteDialogMessage = ( () => {
		if ( ! pendingDeleteIds ) {
			return '';
		}

		if ( pendingDeleteRow ) {
			return sprintf(
				/* translators: %s: skill name. */
				__( 'Are you sure you want to delete "%s"? This action cannot be undone.', 'credentials-manager-plugin' ),
				pendingDeleteRow.skillName || __( '(no name)', 'credentials-manager-plugin' )
			);
		}

		return sprintf(
			/* translators: %d: number of selected skills. */
			_n(
				'Are you sure you want to delete %d selected skill? This action cannot be undone.',
				'Are you sure you want to delete %d selected skills? This action cannot be undone.',
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
			<Toolbar aria-label={ __( 'Skills actions', 'credentials-manager-plugin' ) }>
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
					content={ __( 'Create a new skill. Deselect all skills to enable this button.', 'credentials-manager-plugin' ) }
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
					content={ __( "Edit the selected skill's details. Select exactly one skill to enable this button.", 'credentials-manager-plugin' ) }
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
					content={ __( 'Permanently delete the selected skill(s). Select one or more skills to enable this button.', 'credentials-manager-plugin' ) }
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
				ariaLabel={ __( 'Skills', 'credentials-manager-plugin' ) }
				selectAllTooltip={ __( 'Select or deselect every skill currently shown in the list.', 'credentials-manager-plugin' ) }
				selectAllLabel={ __( 'Select all skills', 'credentials-manager-plugin' ) }
				selectRowLabel={ __( 'Select skill', 'credentials-manager-plugin' ) }
				noItemsText={ config.noItemsText }
			/>
			{ deleteDialog }
		</>
	);
}

const root = document.getElementById( 'credpl-skills-list-root' );

if ( root ) {
	createRoot( root ).render(
		<FluentProvider theme={ webLightTheme }>
			<SkillsList />
		</FluentProvider>
	);
}
