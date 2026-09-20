/**
 * Shared sort/bulk-delete URL helpers for this plugin's four list screens
 * (`credentials-list.tsx`, `credentials-blocks-list.tsx`,
 * `ms-certifications-list.tsx`, `ms-exams-list.tsx`) — see
 * REACT-DEVELOPER-GUIDE.md for the "server-rendered-once" data flow these
 * support (a full page reload on sort/bulk-delete rather than a
 * client-side re-fetch). Every screen's own PHP-localized config
 * interface (`CredentialsListConfig`, `MsExamsListConfig`, …) has more
 * fields than these functions need — `ListUrlConfig` below is just the
 * four fields every one of them has in common, so any screen's config
 * object can be passed straight through with no extra glue.
 *
 * Extracted from four near-identical, independently hand-written copies
 * of this same logic (one per screen) — see CHANGE_LOG.md for the
 * version this extraction landed in.
 */

export interface ListUrlConfig {
	listUrl: string;
	orderby: string;
	order: string;
	bulkDeleteUrl: string;
}

export const EM_DASH = '—';

export type SortDirection = 'ascending' | 'descending';

/**
 * The direction the currently-sorted column (`config.orderby`) is sorted
 * in — only meaningful for whichever column ID matches `config.orderby`;
 * every other column's header renders with no arrow at all.
 */
export function getCurrentSortDirection( order: string ): SortDirection {
	return 'desc' === order.toLowerCase() ? 'descending' : 'ascending';
}

/**
 * `config.listUrl` never carries `orderby`/`order` of its own (PHP builds
 * it from just `?page=…`, see each screen's own `enqueue_list_assets()`),
 * so this only ever needs to append them, never replace an existing pair.
 */
export function buildSortUrl( config: ListUrlConfig, columnId: string, direction: SortDirection ): string {
	const separator = config.listUrl.includes( '?' ) ? '&' : '?';
	const order = 'descending' === direction ? 'desc' : 'asc';

	return `${ config.listUrl }${ separator }orderby=${ encodeURIComponent( columnId ) }&order=${ order }`;
}

/**
 * Clicking the already-sorted column's header toggles its direction;
 * clicking any other sortable column's header always starts that column
 * at ascending.
 */
export function buildNextSortUrl( config: ListUrlConfig, columnId: string ): string {
	const isCurrentColumn = columnId === config.orderby;
	const direction: SortDirection = isCurrentColumn && 'ascending' === getCurrentSortDirection( config.order )
		? 'descending'
		: 'ascending';

	return buildSortUrl( config, columnId, direction );
}

/**
 * `config.bulkDeleteUrl` is a nonce URL with no `ids[]` of its own (the
 * nonce action is a fixed string, not per-ID, so it isn't baked in
 * server-side) — the IDs being deleted are appended here, client-side, at
 * confirm time.
 */
export function buildBulkDeleteUrl( config: ListUrlConfig, ids: number[] ): string {
	const separator = config.bulkDeleteUrl.includes( '?' ) ? '&' : '?';
	const idsQuery = ids.map( ( id ) => `ids[]=${ encodeURIComponent( String( id ) ) }` ).join( '&' );

	return `${ config.bulkDeleteUrl }${ separator }${ idsQuery }`;
}
