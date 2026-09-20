<?php
/**
 * Page callbacks and save/delete handlers for the Credential Blocks admin
 * screens (list + add/edit). See SPECIFICATION.md §6.3.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Admin_Blocks {

	const SAVE_ACTION        = 'credpl_save_credential_block';
	const DELETE_ACTION      = 'credpl_delete_credential_block';
	const BULK_DELETE_ACTION = 'credpl_bulk_delete_credential_blocks';

	public static function init() {
		add_action( 'admin_post_' . self::SAVE_ACTION, array( __CLASS__, 'save' ) );
		add_action( 'admin_post_' . self::DELETE_ACTION, array( __CLASS__, 'delete' ) );
		add_action( 'admin_post_' . self::BULK_DELETE_ACTION, array( __CLASS__, 'bulk_delete' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	/**
	 * Load the React-built Add/Edit Credential Block form and/or the
	 * React-built Credential Blocks list (§10 v59, mirroring
	 * Credpl_Admin_Credentials::enqueue_assets(), §10 v34) depending on
	 * which of this screen's two pages is being requested. Checked via
	 * $_GET['page'] rather than the $hook suffix WordPress passes in —
	 * that suffix's exact format depends on the parent/child slug
	 * combination and is easy to get wrong; the page query var is simple
	 * and unambiguous.
	 */
	public static function enqueue_assets() {
		if ( ! isset( $_GET['page'] ) ) {
			return;
		}

		if ( Credpl_Admin_Menu::PAGE_BLOCK_NEW === $_GET['page'] ) {
			self::enqueue_edit_form_assets();
		} elseif ( Credpl_Admin_Menu::PAGE_BLOCKS === $_GET['page'] ) {
			self::enqueue_list_assets();
		}
	}

	/**
	 * Load the React-built Add/Edit Credential Block form (Title field +
	 * the two-column drag-and-drop Credentials picker, both in
	 * src/credentials-block.tsx).
	 */
	private static function enqueue_edit_form_assets() {
		$asset_file = CREDPL_PLUGIN_DIR . 'build/credentials-block.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'credpl-credential-block-form',
			plugins_url( 'build/credentials-block.js', CREDPL_PLUGIN_FILE ),
			$asset['dependencies'],
			$asset['version'],
			true
		);

		$id    = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
		$block = $id ? Credpl_Data::get_credential_block( $id ) : null;

		if ( $id && ! $block ) {
			return;
		}

		$selected_ids = $block ? self::decode_credential_ids( $block['credential_ids'] ) : array();

		wp_localize_script(
			'credpl-credential-block-form',
			'credplCredentialBlockForm',
			array(
				'id'               => $id,
				'nonce'            => wp_create_nonce( self::SAVE_ACTION ),
				'actionUrl'        => admin_url( 'admin-post.php' ),
				'title'            => $block ? $block['title'] : '',
				'description'      => $block ? $block['description'] : '',
				'addCredentialUrl' => add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_CREDENTIAL_NEW ), admin_url( 'admin.php' ) ),
				'allCredentials'   => array_map( array( __CLASS__, 'prepare_credential_for_js' ), Credpl_Data::get_credentials() ),
				'selectedIds'      => $selected_ids,
			)
		);
	}

	/**
	 * Shape one $wpdb credentials row into what the picker's JS needs —
	 * just id/title/issuer/badgeMediaUrl, not the full row.
	 */
	private static function prepare_credential_for_js( array $credential ) {
		$badge_media_id = absint( $credential['badge_media'] );

		return array(
			'id'            => (int) $credential['id'],
			'title'         => $credential['title'],
			'issuer'        => $credential['issuer'],
			'badgeMediaUrl' => $badge_media_id ? wp_get_attachment_image_url( $badge_media_id, 'thumbnail' ) : '',
		);
	}

	/**
	 * Load the React-built "All Credential Blocks" list (§10 v59,
	 * mirroring Credpl_Admin_Credentials::enqueue_list_assets(), §10 v34).
	 * `orderby`/`order` are read and validated exactly as
	 * `Credpl_Blocks_List_Table::prepare_items()` used to (`sanitize_key()`'d
	 * here, then re-validated against `Credpl_Data::get_credential_blocks()`'s
	 * own fixed allowlist, falling back to `title`/`ASC` for anything
	 * unrecognized) before being used to query.
	 */
	private static function enqueue_list_assets() {
		$asset_file = CREDPL_PLUGIN_DIR . 'build/credentials-blocks-list.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'credpl-credentials-blocks-list',
			plugins_url( 'build/credentials-blocks-list.js', CREDPL_PLUGIN_FILE ),
			$asset['dependencies'],
			$asset['version'],
			true
		);

		$orderby = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : 'title';
		$order   = isset( $_GET['order'] ) ? sanitize_key( $_GET['order'] ) : 'asc';

		$blocks = Credpl_Data::get_credential_blocks(
			array(
				'orderby' => $orderby,
				'order'   => $order,
			)
		);

		$rows = array();

		foreach ( $blocks as $block ) {
			$rows[] = array(
				'id'          => (int) $block['id'],
				'title'       => $block['title'],
				'shortcode'   => Credpl_Shortcode::build_tag( $block ),
				'description' => $block['description'],
				'editUrl'     => add_query_arg(
					array(
						'page' => Credpl_Admin_Menu::PAGE_BLOCK_NEW,
						'id'   => (int) $block['id'],
					),
					admin_url( 'admin.php' )
				),
			);
		}

		wp_localize_script(
			'credpl-credentials-blocks-list',
			'credplCredentialBlocksList',
			array(
				'rows'          => $rows,
				'listUrl'       => add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_BLOCKS ), admin_url( 'admin.php' ) ),
				'orderby'       => $orderby,
				'order'         => $order,
				'addNewUrl'     => add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_BLOCK_NEW ), admin_url( 'admin.php' ) ),
				'bulkDeleteUrl' => wp_nonce_url(
					add_query_arg(
						array( 'action' => self::BULK_DELETE_ACTION ),
						admin_url( 'admin-post.php' )
					),
					self::BULK_DELETE_ACTION
				),
				'noItemsText'   => __( 'No credential blocks yet.', 'credentials-manager-plugin' ),
			)
		);
	}

	/**
	 * The "Credential Blocks" list screen: a mount point for the
	 * React-built DataGrid-style list from src/credentials-blocks-list.tsx
	 * (see enqueue_list_assets() for the localized row data it hydrates
	 * from), replacing the earlier `Credpl_Blocks_List_Table`-rendered
	 * HTML table (§10 v59, mirroring the Credentials list's own
	 * conversion, §10 v34). No `page-title-action` **Add New** link here
	 * any more (§10 v56 already did this for Credentials) — the toolbar's
	 * **New** button covers it.
	 */
	public static function render_list_page() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'Credential Blocks', 'credentials-manager-plugin' ); ?></h1>
			<hr class="wp-header-end" />
			<?php self::maybe_render_notice(); ?>
			<div id="credpl-credentials-blocks-list-root"></div>
		</div>
		<?php
	}

	/**
	 * The "Add Credential Block" / "Edit Credential Block" screen: a mount
	 * point for the React form built from src/credentials-block.tsx (see
	 * enqueue_assets() for the localized data it hydrates from) — no
	 * PHP-rendered form markup here anymore, aside from the read-only
	 * shortcode display above it, which isn't part of the form. The React
	 * form still submits as a plain HTML form POST to admin-post.php, so
	 * save() below is unchanged. When `$_GET['updated']` is present (i.e.
	 * a create or update just redirected back here), a "Back to All
	 * Credentials" button is shown above the shortcode box — a shortcut to
	 * the Credentials screen for going on to add/adjust the credentials
	 * that just got selected into this block.
	 */
	public static function render_edit_page() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}

		$id    = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
		$block = $id ? Credpl_Data::get_credential_block( $id ) : null;

		if ( $id && ! $block ) {
			wp_die( esc_html__( 'Credential block not found.', 'credentials-manager-plugin' ) );
		}

		$heading = $block
			? __( 'Edit Credential Block', 'credentials-manager-plugin' )
			: __( 'Add Credential Block', 'credentials-manager-plugin' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( $heading ); ?></h1>
			<?php self::maybe_render_notice(); ?>

			<?php if ( isset( $_GET['updated'] ) ) : ?>
				<p>
					<a
						href="<?php echo esc_url( add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_CREDENTIALS ), admin_url( 'admin.php' ) ) ); ?>"
						class="button"
					><?php esc_html_e( 'Back to All Credentials', 'credentials-manager-plugin' ); ?></a>
				</p>
			<?php endif; ?>

			<?php if ( $block ) : ?>
				<p>
					<label for="credpl-shortcode"><strong><?php esc_html_e( 'Shortcode', 'credentials-manager-plugin' ); ?></strong></label><br />
					<input
						type="text"
						id="credpl-shortcode"
						readonly="readonly"
						onclick="this.select();"
						class="large-text code"
						value="<?php echo esc_attr( Credpl_Shortcode::build_tag( $block ) ); ?>"
					/>
				</p>
				<p class="description"><?php esc_html_e( 'Copy and paste this shortcode into any page or post to display this block.', 'credentials-manager-plugin' ); ?></p>
			<?php endif; ?>

			<div id="credpl-credential-block-form-root"></div>
		</div>
		<?php
	}

	/**
	 * Save handler (admin-post.php?action=credpl_save_credential_block).
	 */
	public static function save() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'credentials-manager-plugin' ) );
		}

		check_admin_referer( self::SAVE_ACTION );

		$id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;

		$submitted_ids = isset( $_POST['credential_ids'] ) && is_array( $_POST['credential_ids'] )
			? array_map( 'absint', wp_unslash( $_POST['credential_ids'] ) )
			: array();

		// Only keep IDs that actually exist, so a deleted-in-another-tab
		// credential can't linger in a block's stored selection.
		$existing_ids = Credpl_Data::get_credential_ids();
		$selected_ids = array_values( array_intersect( $submitted_ids, $existing_ids ) );

		$data = array(
			'title'          => isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '',
			'description'    => isset( $_POST['description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['description'] ) ) : '',
			'credential_ids' => wp_json_encode( $selected_ids ),
		);

		if ( $id ) {
			Credpl_Data::update_credential_block( $id, $data );
		} else {
			$data['block_key'] = self::generate_block_key();
			$id                 = Credpl_Data::insert_credential_block( $data );
			$id                 = is_wp_error( $id ) ? 0 : $id;
		}

		$redirect_url = add_query_arg(
			array(
				'page'    => Credpl_Admin_Menu::PAGE_BLOCK_NEW,
				'id'      => $id,
				'updated' => 1,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * Delete handler (admin-post.php?action=credpl_delete_credential_block&id=…).
	 */
	public static function delete() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'credentials-manager-plugin' ) );
		}

		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;

		check_admin_referer( 'credpl_delete_credential_block_' . $id );

		if ( $id ) {
			Credpl_Data::delete_credential_block( $id );
		}

		$redirect_url = add_query_arg(
			array(
				'page'    => Credpl_Admin_Menu::PAGE_BLOCKS,
				'deleted' => 1,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * Bulk delete handler (admin-post.php?action=credpl_bulk_delete_credential_blocks&ids[]=…&ids[]=…),
	 * driven by the list screen's toolbar Delete button (§6.3.2) — one
	 * fixed nonce action string, not per-ID, since the selected ID set is
	 * only known client-side at click time (mirrors
	 * Credpl_Admin_Credentials::bulk_delete(), §10 v41).
	 */
	public static function bulk_delete() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'credentials-manager-plugin' ) );
		}

		check_admin_referer( self::BULK_DELETE_ACTION );

		$ids = isset( $_GET['ids'] ) && is_array( $_GET['ids'] ) ? array_map( 'absint', $_GET['ids'] ) : array();
		$ids = array_filter( $ids );

		$deleted_count = 0;

		foreach ( $ids as $id ) {
			if ( Credpl_Data::delete_credential_block( $id ) ) {
				++$deleted_count;
			}
		}

		$redirect_url = add_query_arg(
			array(
				'page'         => Credpl_Admin_Menu::PAGE_BLOCKS,
				'bulk_deleted' => $deleted_count,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * A short, unique, non-guessable public identifier for the shortcode's
	 * `id` attribute — regenerated on the astronomically rare event of a
	 * collision (checked against the table's UNIQUE KEY).
	 */
	private static function generate_block_key() {
		do {
			$block_key = strtolower( wp_generate_password( 7, false, false ) );
		} while ( Credpl_Data::block_key_exists( $block_key ) );

		return $block_key;
	}

	private static function decode_credential_ids( $json ) {
		$ids = json_decode( $json, true );

		if ( ! is_array( $ids ) ) {
			return array();
		}

		return array_map( 'absint', $ids );
	}

	private static function maybe_render_notice() {
		if ( isset( $_GET['updated'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Credential block saved.', 'credentials-manager-plugin' ) . '</p></div>';
		}

		if ( isset( $_GET['deleted'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Credential block deleted.', 'credentials-manager-plugin' ) . '</p></div>';
		}

		if ( isset( $_GET['bulk_deleted'] ) ) {
			$count = absint( $_GET['bulk_deleted'] );
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html(
				sprintf(
					/* translators: %d: number of credential blocks deleted. */
					_n( '%d credential block deleted.', '%d credential blocks deleted.', $count, 'credentials-manager-plugin' ),
					$count
				)
			) . '</p></div>';
		}
	}
}
