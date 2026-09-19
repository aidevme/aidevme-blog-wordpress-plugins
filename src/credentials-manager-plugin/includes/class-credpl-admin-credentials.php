<?php
/**
 * Page callbacks and save/delete handlers for the Credentials admin
 * screens (list + add/edit). See SPECIFICATION.md §6.2.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Admin_Credentials {

	const SAVE_ACTION        = 'credpl_save_credential';
	const DELETE_ACTION      = 'credpl_delete_credential';
	const BULK_DELETE_ACTION = 'credpl_bulk_delete_credentials';

	/**
	 * The fixed set of values the Credentials Type dropdown offers (§6.2).
	 * Shared between the save handler's server-side validation and the
	 * localized data that populates the React form's Dropdown options, so
	 * the two can't drift apart.
	 */
	const CREDENTIALS_TYPES = array( 'Applied Skills', 'Certifications', 'Awards' );

	/**
	 * The fixed set of values the Status dropdown offers (§6.2). Same
	 * shared-allow-list rationale as CREDENTIALS_TYPES above.
	 */
	const STATUSES = array( 'Active', 'Expired' );

	public static function init() {
		add_action( 'admin_post_' . self::SAVE_ACTION, array( __CLASS__, 'save' ) );
		add_action( 'admin_post_' . self::DELETE_ACTION, array( __CLASS__, 'delete' ) );
		add_action( 'admin_post_' . self::BULK_DELETE_ACTION, array( __CLASS__, 'bulk_delete' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	/**
	 * Load the React-built Add/Edit Credential form and/or the React-built
	 * Credentials list (§10 v34) depending on which of this screen's two
	 * pages is being requested. Checked via $_GET['page'] rather than the
	 * $hook suffix WordPress passes in — that suffix's exact format
	 * depends on the parent/child slug combination and is easy to get
	 * wrong; the page query var is simple and unambiguous.
	 */
	public static function enqueue_assets() {
		if ( ! isset( $_GET['page'] ) ) {
			return;
		}

		if ( Credpl_Admin_Menu::PAGE_CREDENTIAL_NEW === $_GET['page'] ) {
			self::enqueue_edit_form_assets();
		} elseif ( Credpl_Admin_Menu::PAGE_CREDENTIALS === $_GET['page'] ) {
			self::enqueue_list_assets();
		}
	}

	private static function enqueue_edit_form_assets() {
		$asset_file = CREDPL_PLUGIN_DIR . 'build/credential.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_media();

		wp_enqueue_script(
			'credpl-credential-form',
			plugins_url( 'build/credential.js', CREDPL_PLUGIN_FILE ),
			$asset['dependencies'],
			$asset['version'],
			true
		);

		$id         = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
		$credential = $id ? Credpl_Data::get_credential( $id ) : null;

		if ( $id && ! $credential ) {
			return;
		}

		$badge_media_id = $credential ? (int) $credential['badge_media'] : 0;

		wp_localize_script(
			'credpl-credential-form',
			'credplCredentialForm',
			array(
				'id'                     => $id,
				'nonce'                  => wp_create_nonce( self::SAVE_ACTION ),
				'actionUrl'              => admin_url( 'admin-post.php' ),
				'title'                  => $credential ? $credential['title'] : '',
				'credentialsType'        => $credential ? $credential['credentials_type'] : '',
				'credentialsTypeOptions' => self::CREDENTIALS_TYPES,
				'status'                 => $credential ? $credential['status'] : '',
				'statusOptions'          => self::STATUSES,
				'awardCategory'          => $credential ? $credential['award_category'] : '',
				'technologyArea'         => $credential ? $credential['technology_area'] : '',
				'issuer'                 => $credential ? $credential['issuer'] : '',
				'credentialLink'         => $credential ? $credential['credential_link'] : '',
				'badgeMediaId'           => $badge_media_id,
				'badgeMediaUrl'          => $badge_media_id ? wp_get_attachment_image_url( $badge_media_id, 'thumbnail' ) : '',
				'credentialId'           => $credential ? $credential['credential_id'] : '',
				'certificationNumber'    => $credential ? $credential['certification_number'] : '',
				'earnedOn'               => $credential ? $credential['earned_on'] : '',
				'expiresOn'              => $credential ? $credential['expires_on'] : '',
				'description'            => $credential ? $credential['description'] : '',
			)
		);
	}

	/**
	 * Load the React-built "All Credentials" list (§7 replaced by §6.2's
	 * DataGrid, §10 v34). `orderby`/`order` are read and validated exactly
	 * as the old `Credpl_Credentials_List_Table::prepare_items()` did —
	 * `sanitize_key()`'d here, then re-validated against
	 * `Credpl_Data::get_credentials()`'s own fixed allowlist (falling back
	 * to `title`/`ASC` for anything unrecognized) before being used to
	 * query — so an unexpected value can't reach SQL unvalidated, same
	 * safety property the PHP list table relied on.
	 */
	private static function enqueue_list_assets() {
		$asset_file = CREDPL_PLUGIN_DIR . 'build/credentials-list.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'credpl-credentials-list',
			plugins_url( 'build/credentials-list.js', CREDPL_PLUGIN_FILE ),
			$asset['dependencies'],
			$asset['version'],
			true
		);

		$orderby = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : 'title';
		$order   = isset( $_GET['order'] ) ? sanitize_key( $_GET['order'] ) : 'asc';

		$credentials = Credpl_Data::get_credentials(
			array(
				'orderby' => $orderby,
				'order'   => $order,
			)
		);

		$date_format = get_option( 'date_format' );
		$rows        = array();

		foreach ( $credentials as $credential ) {
			$badge_media_id = absint( $credential['badge_media'] );

			$rows[] = array(
				'id'               => (int) $credential['id'],
				'title'            => $credential['title'],
				'editUrl'          => add_query_arg(
					array(
						'page' => Credpl_Admin_Menu::PAGE_CREDENTIAL_NEW,
						'id'   => (int) $credential['id'],
					),
					admin_url( 'admin.php' )
				),
				'deleteUrl'        => wp_nonce_url(
					add_query_arg(
						array(
							'action' => self::DELETE_ACTION,
							'id'     => (int) $credential['id'],
						),
						admin_url( 'admin-post.php' )
					),
					self::DELETE_ACTION . '_' . (int) $credential['id']
				),
				'credentialsType'  => $credential['credentials_type'],
				'issuer'           => $credential['issuer'],
				'earnedOnDisplay'  => $credential['earned_on'] ? date_i18n( $date_format, strtotime( $credential['earned_on'] ) ) : '',
				'earnedOnRaw'      => $credential['earned_on'] ? $credential['earned_on'] : '',
				'expiresOnDisplay' => $credential['expires_on'] ? date_i18n( $date_format, strtotime( $credential['expires_on'] ) ) : '',
				'expiresOnRaw'     => $credential['expires_on'] ? $credential['expires_on'] : '',
				'status'           => $credential['status'],
				'badgeUrl'         => $badge_media_id ? (string) wp_get_attachment_image_url( $badge_media_id, array( 40, 40 ) ) : '',
				'description'      => $credential['description'],
			);
		}

		wp_localize_script(
			'credpl-credentials-list',
			'credplCredentialsList',
			array(
				'rows'          => $rows,
				'listUrl'       => add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_CREDENTIALS ), admin_url( 'admin.php' ) ),
				'orderby'       => $orderby,
				'order'         => $order,
				'addNewUrl'     => add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_CREDENTIAL_NEW ), admin_url( 'admin.php' ) ),
				'bulkDeleteUrl' => wp_nonce_url(
					add_query_arg(
						array( 'action' => self::BULK_DELETE_ACTION ),
						admin_url( 'admin-post.php' )
					),
					self::BULK_DELETE_ACTION
				),
				'noItemsText'   => __( 'No credentials yet.', 'credentials-manager-plugin' ),
			)
		);
	}

	/**
	 * The "Credentials" list screen: a mount point for the React-built
	 * DataGrid from src/credentials-list.tsx (see enqueue_list_assets()
	 * for the localized row data it hydrates from), replacing the earlier
	 * `Credpl_Credentials_List_Table`-rendered HTML table (§10 v34). The
	 * surrounding chrome (heading, Add New button, notices) stays
	 * PHP-rendered, same pattern the Add/Edit React forms already use.
	 */
	public static function render_list_page() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}

		$add_new_url = add_query_arg(
			array( 'page' => Credpl_Admin_Menu::PAGE_CREDENTIAL_NEW ),
			admin_url( 'admin.php' )
		);
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'Credentials', 'credentials-manager-plugin' ); ?></h1>
			<a href="<?php echo esc_url( $add_new_url ); ?>" class="page-title-action"><?php esc_html_e( 'Add New', 'credentials-manager-plugin' ); ?></a>
			<hr class="wp-header-end" />
			<?php self::maybe_render_notice(); ?>
			<div id="credpl-credentials-list-root"></div>
		</div>
		<?php
	}

	/**
	 * The "Add New Credential" / "Edit Credential" screen: a mount point
	 * for the React form built from src/credential.tsx (see enqueue_assets()
	 * for the localized data it hydrates from) — no PHP-rendered form
	 * markup here anymore. The React form still submits as a plain HTML
	 * form POST to admin-post.php, so save() below is unchanged. When
	 * `$_GET['updated']` is present (i.e. a create or update just
	 * redirected back here), a "Back to All Credentials" button is shown,
	 * same pattern as Credpl_Admin_Blocks::render_edit_page().
	 */
	public static function render_edit_page() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}

		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;

		if ( $id && ! Credpl_Data::get_credential( $id ) ) {
			wp_die( esc_html__( 'Credential not found.', 'credentials-manager-plugin' ) );
		}

		$heading = $id
			? __( 'Edit Credential', 'credentials-manager-plugin' )
			: __( 'Add New Credential', 'credentials-manager-plugin' );
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

			<div id="credpl-credential-form-root"></div>
		</div>
		<?php
	}

	/**
	 * Save handler (admin-post.php?action=credpl_save_credential).
	 */
	public static function save() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'credentials-manager-plugin' ) );
		}

		check_admin_referer( self::SAVE_ACTION );

		$id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;

		$data = array(
			'title'                => isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '',
			'credentials_type'     => isset( $_POST['credentials_type'] ) ? self::sanitize_credentials_type( wp_unslash( $_POST['credentials_type'] ) ) : '',
			'status'               => isset( $_POST['status'] ) ? self::sanitize_status( wp_unslash( $_POST['status'] ) ) : '',
			'award_category'       => isset( $_POST['award_category'] ) ? sanitize_text_field( wp_unslash( $_POST['award_category'] ) ) : '',
			'technology_area'      => isset( $_POST['technology_area'] ) ? sanitize_text_field( wp_unslash( $_POST['technology_area'] ) ) : '',
			'issuer'               => isset( $_POST['issuer'] ) ? sanitize_text_field( wp_unslash( $_POST['issuer'] ) ) : '',
			'credential_link'      => isset( $_POST['credential_link'] ) ? esc_url_raw( wp_unslash( $_POST['credential_link'] ) ) : '',
			'badge_media'          => isset( $_POST['badge_media'] ) ? absint( $_POST['badge_media'] ) : 0,
			'credential_id'        => isset( $_POST['credential_id'] ) ? sanitize_text_field( wp_unslash( $_POST['credential_id'] ) ) : '',
			'certification_number' => isset( $_POST['certification_number'] ) ? sanitize_text_field( wp_unslash( $_POST['certification_number'] ) ) : '',
			'earned_on'            => isset( $_POST['earned_on'] ) ? self::sanitize_date( wp_unslash( $_POST['earned_on'] ) ) : null,
			'expires_on'           => isset( $_POST['expires_on'] ) ? self::sanitize_date( wp_unslash( $_POST['expires_on'] ) ) : null,
			'description'          => isset( $_POST['description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['description'] ) ) : '',
		);

		if ( $id ) {
			$result = Credpl_Data::update_credential( $id, $data );
		} else {
			$result = Credpl_Data::insert_credential( $data );
		}

		if ( is_wp_error( $result ) ) {
			self::store_error_notice( $result->get_error_message() );

			$redirect_url = add_query_arg(
				array(
					'page'  => Credpl_Admin_Menu::PAGE_CREDENTIAL_NEW,
					'id'    => $id,
					'error' => 1,
				),
				admin_url( 'admin.php' )
			);

			wp_safe_redirect( $redirect_url );
			exit;
		}

		if ( ! $id ) {
			$id = $result;
		}

		$redirect_url = add_query_arg(
			array(
				'page'    => Credpl_Admin_Menu::PAGE_CREDENTIAL_NEW,
				'id'      => $id,
				'updated' => 1,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * Delete handler (admin-post.php?action=credpl_delete_credential&id=…).
	 */
	public static function delete() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'credentials-manager-plugin' ) );
		}

		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;

		check_admin_referer( 'credpl_delete_credential_' . $id );

		if ( $id ) {
			Credpl_Data::delete_credential( $id );
		}

		$redirect_url = add_query_arg(
			array(
				'page'    => Credpl_Admin_Menu::PAGE_CREDENTIALS,
				'deleted' => 1,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * Bulk delete handler (admin-post.php?action=credpl_bulk_delete_credentials&ids[]=…&ids[]=…),
	 * driven by the list screen's toolbar Delete button (§6.2.3) — enabled
	 * whenever one or more rows are selected, unlike the single-row Delete
	 * action above (§6.2, row-level, one nonce per ID). This one nonce
	 * (`BULK_DELETE_ACTION`, a fixed action string, not tied to any
	 * specific ID the way DELETE_ACTION's per-row nonce is) covers
	 * whichever `ids[]` the client attaches, since the set of selected
	 * rows is only known client-side at click time.
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
			if ( Credpl_Data::delete_credential( $id ) ) {
				++$deleted_count;
			}
		}

		$redirect_url = add_query_arg(
			array(
				'page'         => Credpl_Admin_Menu::PAGE_CREDENTIALS,
				'bulk_deleted' => $deleted_count,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * Validate a submitted Credentials Type against the fixed dropdown
	 * options (CREDENTIALS_TYPES) rather than trusting the client — a raw
	 * POST request could send any string, bypassing the Dropdown's own
	 * closed set of options. Anything not in the allow-list is stored as
	 * '' (the same "not set" value as leaving the dropdown at its
	 * placeholder), never a made-up value.
	 */
	private static function sanitize_credentials_type( $value ) {
		$value = sanitize_text_field( $value );

		return in_array( $value, self::CREDENTIALS_TYPES, true ) ? $value : '';
	}

	/**
	 * Validate a submitted Status against the fixed dropdown options
	 * (STATUSES), same rationale as sanitize_credentials_type() above.
	 */
	private static function sanitize_status( $value ) {
		$value = sanitize_text_field( $value );

		return in_array( $value, self::STATUSES, true ) ? $value : '';
	}

	/**
	 * Validate a date input (from an HTML `<input type="date">`, which
	 * submits `YYYY-MM-DD` or an empty string) into either a clean
	 * `Y-m-d` string or `null`. WordPress has no built-in "sanitize a
	 * date" helper, so this checks the value actually parses as a real
	 * calendar date rather than trusting the browser's own validation
	 * (a raw POST request bypasses that entirely).
	 */
	private static function sanitize_date( $value ) {
		$value = trim( (string) $value );

		if ( '' === $value ) {
			return null;
		}

		$date = DateTime::createFromFormat( 'Y-m-d', $value );

		if ( ! $date || $date->format( 'Y-m-d' ) !== $value ) {
			return null;
		}

		return $value;
	}

	/**
	 * Stash a save/update error message for the current user to display
	 * after the redirect — a transient rather than a query arg, so the
	 * (potentially detailed, DB-error-containing) message doesn't end up
	 * sitting in the browser's URL/history.
	 */
	private static function store_error_notice( $message ) {
		set_transient( 'credpl_credential_error_' . get_current_user_id(), $message, 45 );
	}

	private static function maybe_render_notice() {
		if ( isset( $_GET['updated'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Credential saved.', 'credentials-manager-plugin' ) . '</p></div>';
		}

		if ( isset( $_GET['deleted'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Credential deleted.', 'credentials-manager-plugin' ) . '</p></div>';
		}

		if ( isset( $_GET['bulk_deleted'] ) ) {
			$count = absint( $_GET['bulk_deleted'] );
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html(
				sprintf(
					/* translators: %d: number of credentials deleted. */
					_n( '%d credential deleted.', '%d credentials deleted.', $count, 'credentials-manager-plugin' ),
					$count
				)
			) . '</p></div>';
		}

		if ( isset( $_GET['error'] ) ) {
			$key     = 'credpl_credential_error_' . get_current_user_id();
			$message = get_transient( $key );
			delete_transient( $key );

			if ( ! $message ) {
				$message = __( 'Something went wrong and the credential could not be saved.', 'credentials-manager-plugin' );
			}

			echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
		}
	}
}
