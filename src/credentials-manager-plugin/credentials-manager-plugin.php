<?php
/**
 * Plugin Name:       Credentials Manager
 * Description:       Manage Credentials, Credential Blocks, Microsoft Certifications, and Microsoft Exams (Contact Form 7 style) in dedicated admin screens, and embed a block's selected credentials anywhere with a [credential-block id="…"] shortcode.
 * Version:           0.0.54
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            AIDevMe
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       credentials-manager-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'CREDPL_VERSION', '0.0.54' );
// Bumped from 1.0 to 1.1: triggers Credpl_Installer's one-time migration
// that renames the old `credential_forms` table (and its `form_key`
// column) to `credential_blocks`/`block_key` on sites that already
// installed 0.0.1. Bumped again to 1.2: adds credential_id,
// certification_number, earned_on, expires_on, description to
// `credentials` — dbDelta() adds these as new columns on the existing
// table automatically, no custom migration step needed for this one.
// Bumped again to 1.3: removes the badge_link column — dbDelta() only
// ever adds/alters columns, never drops one no longer listed in the
// CREATE TABLE statement, so this triggers Credpl_Installer's explicit
// maybe_drop_badge_link_column() migration on sites that already have it.
// Bumped again to 1.4: adds credentials_type to `credentials` — same as
// the 1.2 bump, dbDelta() adds it as a new column automatically.
// Bumped again to 1.5: adds description to `credential_blocks` — same
// category of change, dbDelta() adds it as a new column automatically.
// Bumped again to 1.6: adds status to `credentials` — same category of
// change, dbDelta() adds it as a new column automatically.
// Bumped again to 1.7: creates the new `microsoft_certifications` table —
// dbDelta() creates it automatically, same as the other two tables at
// initial install.
// Bumped again to 1.8: creates the new `microsoft_exams` table — same as
// the 1.7 bump, dbDelta() creates it automatically.
// Bumped again to 1.9: adds award_category and technology_area to
// `credentials` — same category of change as 1.4/1.6, dbDelta() adds
// them as new columns automatically.
define( 'CREDPL_DB_VERSION', '1.9' );
define( 'CREDPL_PLUGIN_FILE', __FILE__ );
define( 'CREDPL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-installer.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-data.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-admin-menu.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-admin-credentials.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-blocks-list-table.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-admin-blocks.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-ms-certifications-list-table.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-admin-ms-certifications.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-ms-exams-list-table.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-admin-ms-exams.php';
require_once CREDPL_PLUGIN_DIR . 'includes/class-credpl-shortcode.php';

/**
 * Boot the plugin: the schema-upgrade check, the admin screens, and the
 * front-end shortcode.
 */
function credpl_bootstrap() {
	Credpl_Installer::init();
	Credpl_Admin_Menu::init();
	Credpl_Admin_Credentials::init();
	Credpl_Admin_Blocks::init();
	Credpl_Admin_Ms_Certifications::init();
	Credpl_Admin_Ms_Exams::init();
	Credpl_Shortcode::init();
}
add_action( 'plugins_loaded', 'credpl_bootstrap' );

/**
 * Create the `credentials`, `credential_blocks`, `microsoft_certifications`,
 * and `microsoft_exams` tables on activation.
 */
register_activation_hook( __FILE__, array( 'Credpl_Installer', 'install' ) );

/**
 * Add a "View details" link to this plugin's row on the Plugins screen
 * (Plugins > Installed Plugins), next to "Version … | By AIDevMe". This
 * link only appears automatically for plugins WordPress can match to a
 * WordPress.org listing; since this plugin isn't published there, the
 * link is added manually here as a placeholder (href="#") until a real
 * details destination exists.
 */
function credpl_plugin_row_meta( $plugin_meta, $plugin_file ) {
	if ( plugin_basename( CREDPL_PLUGIN_FILE ) !== $plugin_file ) {
		return $plugin_meta;
	}

	$plugin_meta[] = '<a href="#" aria-label="' . esc_attr__( 'View details', 'credentials-manager-plugin' ) . '">' . esc_html__( 'View details', 'credentials-manager-plugin' ) . '</a>';

	return $plugin_meta;
}
add_filter( 'plugin_row_meta', 'credpl_plugin_row_meta', 10, 2 );
