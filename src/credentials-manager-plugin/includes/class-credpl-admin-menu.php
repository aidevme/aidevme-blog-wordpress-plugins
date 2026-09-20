<?php
/**
 * Registers the top-level "Credentials Manager" admin menu and its five
 * visible submenus (plus four registered-but-CSS-hidden "Add …" ones —
 * see the note on hide_add_screens_from_menu() below). See
 * SPECIFICATION.md §6.1.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Admin_Menu {

	const CAPABILITY = 'manage_options';

	const PAGE_CREDENTIALS          = 'credpl-credentials';
	const PAGE_CREDENTIAL_NEW       = 'credpl-credential-new';
	const PAGE_BLOCKS               = 'credpl-credential-blocks';
	const PAGE_BLOCK_NEW            = 'credpl-credential-block-new';
	const PAGE_MS_CERTIFICATIONS    = 'credpl-ms-certifications';
	const PAGE_MS_CERTIFICATION_NEW = 'credpl-ms-certification-new';
	const PAGE_MS_EXAMS             = 'credpl-ms-exams';
	const PAGE_MS_EXAM_NEW          = 'credpl-ms-exam-new';
	const PAGE_INTEGRATION          = 'credpl-integration';

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register' ) );
		add_action( 'admin_head', array( __CLASS__, 'hide_add_screens_from_menu' ) );
	}

	/**
	 * Submenu order mirrors Contact Form 7's "Contact" menu: the primary
	 * list (here, Credential Blocks) first, so the top-level menu item's
	 * own click target is the Blocks list (PAGE_BLOCKS) — clicking
	 * "Credentials Manager" and clicking "All Credential Blocks" land on
	 * the same page, which is why both use the PAGE_BLOCKS slug below.
	 *
	 * All nine submenus, including the four "Add …" ones, are registered
	 * normally here — see hide_add_screens_from_menu() for why those four
	 * are hidden via CSS afterward rather than unregistered.
	 */
	public static function register() {
		add_menu_page(
			__( 'Credentials Manager', 'credentials-manager-plugin' ),
			__( 'Credentials Manager', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_BLOCKS,
			array( 'Credpl_Admin_Blocks', 'render_list_page' ),
			'dashicons-awards',
			25
		);

		add_submenu_page(
			self::PAGE_BLOCKS,
			__( 'All Credential Blocks', 'credentials-manager-plugin' ),
			__( 'All Credential Blocks', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_BLOCKS,
			array( 'Credpl_Admin_Blocks', 'render_list_page' )
		);

		add_submenu_page(
			self::PAGE_BLOCKS,
			__( 'Add Credential Block', 'credentials-manager-plugin' ),
			__( 'Add Credential Block', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_BLOCK_NEW,
			array( 'Credpl_Admin_Blocks', 'render_edit_page' )
		);

		add_submenu_page(
			self::PAGE_BLOCKS,
			__( 'All Credentials', 'credentials-manager-plugin' ),
			__( 'All Credentials', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_CREDENTIALS,
			array( 'Credpl_Admin_Credentials', 'render_list_page' )
		);

		add_submenu_page(
			self::PAGE_BLOCKS,
			__( 'Add Credential', 'credentials-manager-plugin' ),
			__( 'Add Credential', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_CREDENTIAL_NEW,
			array( 'Credpl_Admin_Credentials', 'render_edit_page' )
		);

		add_submenu_page(
			self::PAGE_BLOCKS,
			__( 'All Microsoft Certifications', 'credentials-manager-plugin' ),
			__( 'All Microsoft Certifications', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_MS_CERTIFICATIONS,
			array( 'Credpl_Admin_Ms_Certifications', 'render_list_page' )
		);

		add_submenu_page(
			self::PAGE_BLOCKS,
			__( 'Add Microsoft Certification', 'credentials-manager-plugin' ),
			__( 'Add Microsoft Certification', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_MS_CERTIFICATION_NEW,
			array( 'Credpl_Admin_Ms_Certifications', 'render_edit_page' )
		);

		add_submenu_page(
			self::PAGE_BLOCKS,
			__( 'All Microsoft Exams', 'credentials-manager-plugin' ),
			__( 'All Microsoft Exams', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_MS_EXAMS,
			array( 'Credpl_Admin_Ms_Exams', 'render_list_page' )
		);

		add_submenu_page(
			self::PAGE_BLOCKS,
			__( 'Add Microsoft Exam', 'credentials-manager-plugin' ),
			__( 'Add Microsoft Exam', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_MS_EXAM_NEW,
			array( 'Credpl_Admin_Ms_Exams', 'render_edit_page' )
		);

		add_submenu_page(
			self::PAGE_BLOCKS,
			__( 'Integration', 'credentials-manager-plugin' ),
			__( 'Integration', 'credentials-manager-plugin' ),
			self::CAPABILITY,
			self::PAGE_INTEGRATION,
			array( __CLASS__, 'render_integration_page' )
		);
	}

	/**
	 * Hides the four "Add …" items from the visible admin menu via CSS
	 * (`admin_head`, so it applies site-wide, not just on this plugin's own
	 * screens — the WP admin sidebar is global) — deliberately **not**
	 * `remove_submenu_page()`, which was tried first and reverted (§10
	 * v28): it strips the entry from the `$submenu` global, but WordPress
	 * core's own `get_admin_page_parent()` — called by
	 * `user_can_access_admin_page()`, which core runs before dispatching
	 * *any* `admin.php?page=…` request, before this plugin's own callback
	 * ever runs — resolves a page's parent by searching that exact same
	 * `$submenu` array. With the entry gone, no parent is found, access is
	 * denied, and *every* direct link to that page (each list's Add New
	 * button, every row's Edit link, and the §10 v24/v25 "Back to All …"
	 * buttons — all of which link straight to these same page slugs) broke
	 * with "Sorry, you are not allowed to access this page.", not just the
	 * sidebar entry. CSS-hiding the `<li>` leaves `$submenu`, and therefore
	 * every one of those links, completely unaffected — only the visible
	 * menu item disappears.
	 */
	public static function hide_add_screens_from_menu() {
		$hidden_pages = array(
			self::PAGE_BLOCK_NEW,
			self::PAGE_CREDENTIAL_NEW,
			self::PAGE_MS_CERTIFICATION_NEW,
			self::PAGE_MS_EXAM_NEW,
		);

		echo '<style>';
		foreach ( $hidden_pages as $page ) {
			printf( '#adminmenu a[href$="page=%s"]{display:none;}', esc_attr( $page ) );
		}
		echo '</style>';
	}

	/**
	 * Placeholder "Integration" screen — mirrors Contact Form 7's
	 * Integration tab, which lists third-party services a form can hook
	 * into. Nothing to integrate with is specified yet, so this is a stub
	 * rather than a real settings screen.
	 */
	public static function render_integration_page() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Integration', 'credentials-manager-plugin' ); ?></h1>
			<p><?php esc_html_e( 'No integrations are available yet.', 'credentials-manager-plugin' ); ?></p>
		</div>
		<?php
	}
}
