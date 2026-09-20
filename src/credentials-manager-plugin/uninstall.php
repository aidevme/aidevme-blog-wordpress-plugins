<?php
/**
 * Fires when the plugin is deleted via the WordPress admin.
 *
 * Intentionally a no-op: the `{$wpdb->prefix}credentials`,
 * `{$wpdb->prefix}credential_blocks`, and `{$wpdb->prefix}microsoft_certifications`
 * tables, and every row in them, are left in the database. Dropping a site
 * owner's credential records on uninstall would be destructive and
 * surprising, so removal is not automatic (see SPECIFICATION.md §5 and
 * §10, Migration Notes).
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}
