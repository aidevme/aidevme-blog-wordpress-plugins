<?php
/**
 * Page callback and asset loading for the top-level "Credentials Manager"
 * landing screen. See SPECIFICATION.md §6.1.
 *
 * A React/Fluent UI 9 page built from
 * src/components/pages/credentials-manager/credentials-manager-page.tsx: one
 * four full-width section cards (Main, Miscellaneous, Style, Integrations)
 * holding clickable navigation cards. The only PHP→React data is the
 * destination URLs; there are no save/delete handlers here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Admin_Manager {

	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	/**
	 * Load the React-built Credentials Manager page, only on its own screen.
	 */
	public static function enqueue_assets() {
		if ( ! isset( $_GET['page'] ) || Credpl_Admin_Menu::PAGE_MANAGER !== $_GET['page'] ) {
			return;
		}

		$asset_file = CREDPL_PLUGIN_DIR . 'build/credentials-manager-page.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'credpl-credentials-manager-page',
			plugins_url( 'build/credentials-manager-page.js', CREDPL_PLUGIN_FILE ),
			$asset['dependencies'],
			$asset['version'],
			true
		);

		// One URL per navigation card; React supplies each card's label,
		// icon, and which section it sits in, and just looks up its
		// destination here, so no WordPress URL knowledge lives on the
		// TypeScript side.
		wp_localize_script(
			'credpl-credentials-manager-page',
			'credplCredentialsManagerPage',
			array(
				'urls' => array(
					'blocks'         => self::list_url( Credpl_Admin_Menu::PAGE_BLOCKS ),
					'credentials'    => self::list_url( Credpl_Admin_Menu::PAGE_CREDENTIALS ),
					'certifications' => self::list_url( Credpl_Admin_Menu::PAGE_MS_CERTIFICATIONS ),
					'exams'          => self::list_url( Credpl_Admin_Menu::PAGE_MS_EXAMS ),
					'skills'         => self::list_url( Credpl_Admin_Menu::PAGE_SKILLS ),
					'integrations'   => self::list_url( Credpl_Admin_Menu::PAGE_INTEGRATION ),
				),
			)
		);
	}

	private static function list_url( $page ) {
		return add_query_arg( array( 'page' => $page ), admin_url( 'admin.php' ) );
	}

	/**
	 * The "Credentials Manager" screen: page chrome in plain PHP, then a
	 * single empty mount point for the React page to take over.
	 */
	public static function render_page() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Credentials Manager', 'credentials-manager-plugin' ); ?></h1>
			<div id="credpl-credentials-manager-page-root"></div>
		</div>
		<?php
	}
}
