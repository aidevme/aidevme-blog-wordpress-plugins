/**
 * The selection state every list screen needs alongside `DataTable`: which
 * row IDs are checked, plus the one derived value the toolbar's Edit button
 * cares about. Kept in the screen (not inside `DataTable`) because the
 * toolbar — New/Edit/Delete enablement, the Delete confirmation — reads it
 * too.
 */

import { useState } from '@wordpress/element';

export function useRowSelection<TRow extends { id: number }>( rows: TRow[] ) {
	const [ selectedIds, setSelectedIds ] = useState<Set<number>>( () => new Set() );

	/**
	 * The one selected row when exactly one is selected, else `undefined` —
	 * what the toolbar's Edit button needs (enabled only for exactly one).
	 */
	const singleSelectedId = 1 === selectedIds.size ? Array.from( selectedIds )[ 0 ] : undefined;
	const singleSelectedRow = undefined !== singleSelectedId
		? rows.find( ( row ) => row.id === singleSelectedId )
		: undefined;

	return { selectedIds, setSelectedIds, singleSelectedRow };
}
