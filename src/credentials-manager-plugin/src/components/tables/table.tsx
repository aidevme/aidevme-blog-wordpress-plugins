/**
 * A generic Fluent UI 9 list table — not specific to any one entity. Every
 * list screen in this plugin (Credentials, Credential Blocks, Microsoft
 * Certifications, Microsoft Exams, Skills) renders through it, so the
 * multi-select checkboxes, the sortable header cells with their tooltips,
 * the selected-row highlight, the empty state, and the record-count footer
 * live in one place.
 *
 * What it deliberately does *not* own:
 * - **Selection state.** The screen's toolbar (Edit/Delete enablement) needs
 *   to read the selection, so the parent owns it (see `useRowSelection()`)
 *   and passes it in; this component only reports changes through
 *   `onSelectionChange`.
 * - **Sorting.** Every screen sorts by reloading to a new
 *   `?orderby=…&order=…` URL (see `src/tools/listUrls.ts`), and this
 *   component knows nothing about URLs — a click on a sortable header just
 *   calls `onSortColumn( columnId )`.
 * - **Strings.** Every label is passed in already translated, so each
 *   screen's `__()` call sites (and therefore its translation strings) stay
 *   in the screen's own file.
 * - **The toolbar and the confirmation dialogs**, which vary by screen.
 */

import type { ReactNode } from 'react';
import {
	Table,
	TableHeader,
	TableHeaderCell,
	TableRow,
	TableBody,
	TableCell,
	TableSelectionCell,
	Tooltip,
	tokens,
} from '@fluentui/react-components';
import { useTableStyles } from '../../styles';
import { TableFooter } from './table-footer';

/**
 * One column of a list. `id` is also what `onSortColumn()` receives, so for
 * a sortable column it must be the exact string the screen's
 * `Credpl_Data::get_*()` allowlist accepts as `orderby`.
 */
export interface ColumnDef<TRow> {
	id: string;
	label: string;
	sortable: boolean;
	headerTooltip: string;
	renderCell: ( row: TRow ) => ReactNode;
}

export interface DataTableProps<TRow extends { id: number }> {
	rows: TRow[];
	columns: ColumnDef<TRow>[];
	/** The column the list is currently sorted by — only that header shows a sort arrow. */
	sortColumnId: string;
	sortDirection: 'ascending' | 'descending';
	onSortColumn: ( columnId: string ) => void;
	selectedIds: Set<number>;
	onSelectionChange: ( selectedIds: Set<number> ) => void;
	/** The table's accessible name, e.g. "Microsoft Exams". */
	ariaLabel: string;
	/** Tooltip on the header's select-all checkbox. */
	selectAllTooltip: string;
	/** Accessible name of the header's select-all checkbox. */
	selectAllLabel: string;
	/** Accessible name of each row's checkbox. */
	selectRowLabel: string;
	/** Shown in place of the table when `rows` is empty. */
	noItemsText: string;
}

export function DataTable<TRow extends { id: number }>( {
	rows,
	columns,
	sortColumnId,
	sortDirection,
	onSortColumn,
	selectedIds,
	onSelectionChange,
	ariaLabel,
	selectAllTooltip,
	selectAllLabel,
	selectRowLabel,
	noItemsText,
}: DataTableProps<TRow> ) {
	const styles = useTableStyles();

	if ( 0 === rows.length ) {
		return <p className={ styles.noItems }>{ noItemsText }</p>;
	}

	const allSelected = rows.every( ( row ) => selectedIds.has( row.id ) );
	const someSelected = ! allSelected && rows.some( ( row ) => selectedIds.has( row.id ) );

	function toggleRow( id: number ) {
		const next = new Set( selectedIds );

		if ( next.has( id ) ) {
			next.delete( id );
		} else {
			next.add( id );
		}

		onSelectionChange( next );
	}

	function toggleAllRows() {
		onSelectionChange( allSelected ? new Set() : new Set( rows.map( ( row ) => row.id ) ) );
	}

	return (
		<>
			<div className={ styles.tableWrap }>
				<Table aria-label={ ariaLabel }>
					<TableHeader>
						<TableRow>
							<Tooltip content={ selectAllTooltip } relationship="label" withArrow>
								<TableSelectionCell
									checked={ allSelected ? true : ( someSelected ? 'mixed' : false ) }
									onClick={ toggleAllRows }
									checkboxIndicator={ { 'aria-label': selectAllLabel } }
								/>
							</Tooltip>
							{ columns.map( ( column ) => (
								<Tooltip key={ column.id } content={ column.headerTooltip } relationship="label" withArrow>
									<TableHeaderCell
										style={ { fontWeight: tokens.fontWeightSemibold } }
										sortable={ column.sortable }
										sortDirection={ column.id === sortColumnId ? sortDirection : undefined }
										button={ column.sortable ? { onClick: () => onSortColumn( column.id ) } : undefined }
									>
										{ column.label }
									</TableHeaderCell>
								</Tooltip>
							) ) }
						</TableRow>
					</TableHeader>
					<TableBody>
						{ rows.map( ( row ) => {
							const selected = selectedIds.has( row.id );

							return (
								<TableRow key={ row.id } appearance={ selected ? 'brand' : 'none' } aria-selected={ selected }>
									<TableSelectionCell
										checked={ selected }
										onClick={ () => toggleRow( row.id ) }
										checkboxIndicator={ { 'aria-label': selectRowLabel } }
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
			<TableFooter recordCount={ rows.length } selectedCount={ selectedIds.size } />
		</>
	);
}
