<?php
/**
 * Page callbacks and save/delete handlers for the Microsoft Exams admin
 * screens (list + add/edit). See SPECIFICATION.md §6.5.
 *
 * Mirrors Credpl_Admin_Ms_Certifications's architecture closely: same
 * uid-uniqueness validation, same JSON-array-as-newline-Textarea editing
 * for locales/courses/levels/roles/products/providers, same raw-JSON
 * Textarea for study_guide, and the same "Sync" action reading the same
 * catalog API response's `exams` array instead of its `certifications`
 * one — the two tables hold sibling entities from the same Microsoft
 * Learn catalog.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Admin_Ms_Exams {

	const SAVE_ACTION   = 'credpl_save_ms_exam';
	const DELETE_ACTION = 'credpl_delete_ms_exam';
	const SYNC_ACTION   = 'credpl_sync_ms_exams';

	/**
	 * Same catalog endpoint Credpl_Admin_Ms_Certifications::sync() already
	 * fetches — that response carries both a `certifications` array and an
	 * `exams` array in one request; this class just reads the other one.
	 * Fixed, not user-supplied, so there's no SSRF surface here.
	 */
	const CATALOG_API_URL = 'https://learn.microsoft.com/api/catalog/?type=certifications,exams&locale=en-us';

	public static function init() {
		add_action( 'admin_post_' . self::SAVE_ACTION, array( __CLASS__, 'save' ) );
		add_action( 'admin_post_' . self::DELETE_ACTION, array( __CLASS__, 'delete' ) );
		add_action( 'admin_post_' . self::SYNC_ACTION, array( __CLASS__, 'sync' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	/**
	 * Load the React-built Add/Edit Microsoft Exam form only on that
	 * screen. Checked via $_GET['page'] for the same reason as
	 * Credpl_Admin_Credentials::enqueue_assets().
	 */
	public static function enqueue_assets() {
		if ( ! isset( $_GET['page'] ) || Credpl_Admin_Menu::PAGE_MS_EXAM_NEW !== $_GET['page'] ) {
			return;
		}

		$asset_file = CREDPL_PLUGIN_DIR . 'build/ms-exam.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'credpl-ms-exam-form',
			plugins_url( 'build/ms-exam.js', CREDPL_PLUGIN_FILE ),
			$asset['dependencies'],
			$asset['version'],
			true
		);

		$id   = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
		$exam = $id ? Credpl_Data::get_ms_exam( $id ) : null;

		if ( $id && ! $exam ) {
			return;
		}

		wp_localize_script(
			'credpl-ms-exam-form',
			'credplMsExamForm',
			array(
				'id'           => $id,
				'nonce'        => wp_create_nonce( self::SAVE_ACTION ),
				'actionUrl'    => admin_url( 'admin-post.php' ),
				'uid'          => $exam ? $exam['uid'] : '',
				'title'        => $exam ? $exam['title'] : '',
				'subtitle'     => $exam ? $exam['subtitle'] : '',
				'displayName'  => $exam ? $exam['display_name'] : '',
				'url'          => $exam ? $exam['url'] : '',
				'iconUrl'      => $exam ? $exam['icon_url'] : '',
				'locales'      => $exam ? self::decode_string_list( $exam['locales'] ) : '',
				'lastModified' => $exam ? self::format_datetime_local( $exam['last_modified'] ) : '',
				'type'         => $exam ? $exam['type'] : '',
				'courses'      => $exam ? self::decode_string_list( $exam['courses'] ) : '',
				'levels'       => $exam ? self::decode_string_list( $exam['levels'] ) : '',
				'roles'        => $exam ? self::decode_string_list( $exam['roles'] ) : '',
				'products'     => $exam ? self::decode_string_list( $exam['products'] ) : '',
				'providers'    => $exam ? self::decode_string_list( $exam['providers'] ) : '',
				'studyGuide'   => $exam ? self::pretty_json( $exam['study_guide'] ) : '',
			)
		);
	}

	/**
	 * The "Microsoft Exams" list screen.
	 */
	public static function render_list_page() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}

		$list_table = new Credpl_Ms_Exams_List_Table();
		$list_table->prepare_items();

		$add_new_url = add_query_arg(
			array( 'page' => Credpl_Admin_Menu::PAGE_MS_EXAM_NEW ),
			admin_url( 'admin.php' )
		);

		$sync_url = wp_nonce_url(
			add_query_arg( array( 'action' => self::SYNC_ACTION ), admin_url( 'admin-post.php' ) ),
			self::SYNC_ACTION
		);
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'Microsoft Exams', 'credentials-manager-plugin' ); ?></h1>
			<a href="<?php echo esc_url( $add_new_url ); ?>" class="page-title-action"><?php esc_html_e( 'Add New', 'credentials-manager-plugin' ); ?></a>
			<a
				href="<?php echo esc_url( $sync_url ); ?>"
				class="page-title-action"
				onclick="return confirm('<?php echo esc_js( __( 'Sync exams from Microsoft Learn now? This fetches the full catalog and may take a minute.', 'credentials-manager-plugin' ) ); ?>');"
			><?php esc_html_e( 'Sync Exams', 'credentials-manager-plugin' ); ?></a>
			<hr class="wp-header-end" />
			<?php self::maybe_render_notice(); ?>
			<form method="get">
				<input type="hidden" name="page" value="<?php echo esc_attr( Credpl_Admin_Menu::PAGE_MS_EXAMS ); ?>" />
				<?php $list_table->display(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * The "Add New Microsoft Exam" / "Edit Microsoft Exam" screen: a mount
	 * point for the React form built from src/ms-exam.tsx (see
	 * enqueue_assets() for the localized data it hydrates from) — no
	 * PHP-rendered form markup here. The React form submits as a plain
	 * HTML form POST to admin-post.php, so save() below is unchanged by
	 * anything about how the form is rendered. When `$_GET['updated']` is
	 * present (i.e. a create or update just redirected back here), a
	 * "Back to All Microsoft Exams" button is shown, same pattern as
	 * Credpl_Admin_Blocks::render_edit_page().
	 */
	public static function render_edit_page() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}

		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;

		if ( $id && ! Credpl_Data::get_ms_exam( $id ) ) {
			wp_die( esc_html__( 'Microsoft Exam not found.', 'credentials-manager-plugin' ) );
		}

		$heading = $id
			? __( 'Edit Microsoft Exam', 'credentials-manager-plugin' )
			: __( 'Add New Microsoft Exam', 'credentials-manager-plugin' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( $heading ); ?></h1>
			<?php self::maybe_render_notice(); ?>

			<?php if ( isset( $_GET['updated'] ) ) : ?>
				<p>
					<a
						href="<?php echo esc_url( add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_MS_EXAMS ), admin_url( 'admin.php' ) ) ); ?>"
						class="button"
					><?php esc_html_e( 'Back to All Microsoft Exams', 'credentials-manager-plugin' ); ?></a>
				</p>
			<?php endif; ?>

			<div id="credpl-ms-exam-form-root"></div>
		</div>
		<?php
	}

	/**
	 * Save handler (admin-post.php?action=credpl_save_ms_exam).
	 */
	public static function save() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'credentials-manager-plugin' ) );
		}

		check_admin_referer( self::SAVE_ACTION );

		$id  = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;
		$uid = isset( $_POST['uid'] ) ? sanitize_text_field( wp_unslash( $_POST['uid'] ) ) : '';

		// uid carries a UNIQUE KEY, but unlike credential_blocks.block_key
		// it's admin-typed, not server-generated — check it explicitly so
		// a duplicate surfaces as a friendly validation error instead of a
		// raw "Duplicate entry" database error from the insert/update
		// below. Same rationale as Credpl_Admin_Ms_Certifications::save().
		if ( '' !== $uid && Credpl_Data::ms_exam_uid_exists( $uid, $id ) ) {
			self::store_error_notice( __( 'A Microsoft Exam with this UID already exists.', 'credentials-manager-plugin' ) );

			$redirect_url = add_query_arg(
				array(
					'page'  => Credpl_Admin_Menu::PAGE_MS_EXAM_NEW,
					'id'    => $id,
					'error' => 1,
				),
				admin_url( 'admin.php' )
			);

			wp_safe_redirect( $redirect_url );
			exit;
		}

		$data = array(
			'uid'           => $uid,
			'title'         => isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '',
			'subtitle'      => isset( $_POST['subtitle'] ) ? wp_kses_post( wp_unslash( $_POST['subtitle'] ) ) : '',
			'display_name'  => isset( $_POST['display_name'] ) ? sanitize_text_field( wp_unslash( $_POST['display_name'] ) ) : '',
			'url'           => isset( $_POST['url'] ) ? esc_url_raw( wp_unslash( $_POST['url'] ) ) : '',
			'icon_url'      => isset( $_POST['icon_url'] ) ? esc_url_raw( wp_unslash( $_POST['icon_url'] ) ) : '',
			'locales'       => isset( $_POST['locales'] ) ? self::sanitize_string_list( wp_unslash( $_POST['locales'] ) ) : '[]',
			'last_modified' => isset( $_POST['last_modified'] ) ? self::sanitize_datetime( wp_unslash( $_POST['last_modified'] ) ) : null,
			'type'          => isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '',
			'courses'       => isset( $_POST['courses'] ) ? self::sanitize_string_list( wp_unslash( $_POST['courses'] ) ) : '[]',
			'levels'        => isset( $_POST['levels'] ) ? self::sanitize_string_list( wp_unslash( $_POST['levels'] ) ) : '[]',
			'roles'         => isset( $_POST['roles'] ) ? self::sanitize_string_list( wp_unslash( $_POST['roles'] ) ) : '[]',
			'products'      => isset( $_POST['products'] ) ? self::sanitize_string_list( wp_unslash( $_POST['products'] ) ) : '[]',
			'providers'     => isset( $_POST['providers'] ) ? self::sanitize_string_list( wp_unslash( $_POST['providers'] ) ) : '[]',
			'study_guide'   => isset( $_POST['study_guide'] ) ? self::sanitize_json_field( wp_unslash( $_POST['study_guide'] ) ) : '[]',
		);

		if ( $id ) {
			$result = Credpl_Data::update_ms_exam( $id, $data );
		} else {
			$result = Credpl_Data::insert_ms_exam( $data );
		}

		if ( is_wp_error( $result ) ) {
			self::store_error_notice( $result->get_error_message() );

			$redirect_url = add_query_arg(
				array(
					'page'  => Credpl_Admin_Menu::PAGE_MS_EXAM_NEW,
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
				'page'    => Credpl_Admin_Menu::PAGE_MS_EXAM_NEW,
				'id'      => $id,
				'updated' => 1,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * Delete handler (admin-post.php?action=credpl_delete_ms_exam&id=…).
	 */
	public static function delete() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'credentials-manager-plugin' ) );
		}

		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;

		check_admin_referer( 'credpl_delete_ms_exam_' . $id );

		if ( $id ) {
			Credpl_Data::delete_ms_exam( $id );
		}

		$redirect_url = add_query_arg(
			array(
				'page'    => Credpl_Admin_Menu::PAGE_MS_EXAMS,
				'deleted' => 1,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * "Sync Exams" handler (admin-post.php?action=credpl_sync_ms_exams).
	 * Fetches CATALOG_API_URL, then creates or updates one row per exam
	 * entry, matched by `uid` (Credpl_Data::get_ms_exam_by_uid()). Same
	 * single synchronous request/response cycle as
	 * Credpl_Admin_Ms_Certifications::sync() — no AJAX, no background job;
	 * acceptable for an admin-only action triggered manually and
	 * infrequently (§6.5).
	 */
	public static function sync() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'credentials-manager-plugin' ) );
		}

		check_admin_referer( self::SYNC_ACTION );

		// Best-effort — same rationale as
		// Credpl_Admin_Ms_Certifications::sync().
		if ( function_exists( 'set_time_limit' ) ) {
			// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_set_time_limit
			@set_time_limit( 120 );
		}

		$exams = self::fetch_catalog_exams();

		if ( is_wp_error( $exams ) ) {
			self::store_error_notice( $exams->get_error_message() );

			$redirect_url = add_query_arg(
				array(
					'page'       => Credpl_Admin_Menu::PAGE_MS_EXAMS,
					'sync_error' => 1,
				),
				admin_url( 'admin.php' )
			);

			wp_safe_redirect( $redirect_url );
			exit;
		}

		$created      = 0;
		$updated      = 0;
		$skipped      = 0;
		$first_reason = '';

		foreach ( $exams as $entry ) {
			if ( ! is_array( $entry ) ) {
				++$skipped;

				if ( '' === $first_reason ) {
					$first_reason = __( 'One or more catalog entries were not valid objects.', 'credentials-manager-plugin' );
				}

				continue;
			}

			$data = self::map_catalog_exam( $entry );

			if ( '' === $data['uid'] ) {
				++$skipped;

				if ( '' === $first_reason ) {
					$first_reason = __( 'One or more catalog entries had no "uid".', 'credentials-manager-plugin' );
				}

				continue;
			}

			$existing = Credpl_Data::get_ms_exam_by_uid( $data['uid'] );

			if ( $existing ) {
				$result = Credpl_Data::update_ms_exam( (int) $existing['id'], $data );
			} else {
				$result = Credpl_Data::insert_ms_exam( $data );
			}

			if ( is_wp_error( $result ) ) {
				++$skipped;

				if ( '' === $first_reason ) {
					$first_reason = $result->get_error_message();
				}

				continue;
			}

			if ( $existing ) {
				++$updated;
			} else {
				++$created;
			}
		}

		// Skips are otherwise silent — same diagnostic rationale as
		// Credpl_Admin_Ms_Certifications::sync() (§10 v21).
		if ( $skipped > 0 && '' !== $first_reason ) {
			self::store_error_notice( $first_reason );
		}

		// Prefixed sync_* so they can't collide with the plain
		// `updated`/`deleted` flags save()/delete() already use on
		// redirects to this same screen — same rationale as
		// Credpl_Admin_Ms_Certifications::sync().
		$redirect_url = add_query_arg(
			array(
				'page'         => Credpl_Admin_Menu::PAGE_MS_EXAMS,
				'synced'       => 1,
				'sync_created' => $created,
				'sync_updated' => $updated,
				'sync_skipped' => $skipped,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * Fetch and decode CATALOG_API_URL, returning just its `exams` array
	 * (the same response's `certifications` array is what
	 * Credpl_Admin_Ms_Certifications::sync() reads instead).
	 *
	 * @return array|WP_Error
	 */
	private static function fetch_catalog_exams() {
		$response = wp_remote_get(
			self::CATALOG_API_URL,
			array(
				'timeout' => 45,
			)
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$code = (int) wp_remote_retrieve_response_code( $response );

		if ( 200 !== $code ) {
			return new WP_Error(
				'credpl_sync_http_error',
				sprintf(
					/* translators: %d: HTTP status code. */
					__( 'Microsoft Learn returned an unexpected status code: %d', 'credentials-manager-plugin' ),
					$code
				)
			);
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! is_array( $body ) || ! isset( $body['exams'] ) || ! is_array( $body['exams'] ) ) {
			return new WP_Error(
				'credpl_sync_bad_response',
				__( 'Unexpected response format from Microsoft Learn — no "exams" list found.', 'credentials-manager-plugin' )
			);
		}

		return $body['exams'];
	}

	/**
	 * Map one decoded catalog API exam entry into the same $data shape
	 * save() builds from $_POST — same field-by-field sanitization rules
	 * (§8), since this is still untrusted external input regardless of the
	 * source's reputation.
	 */
	private static function map_catalog_exam( array $entry ) {
		return array(
			'uid'           => isset( $entry['uid'] ) ? sanitize_text_field( $entry['uid'] ) : '',
			'title'         => isset( $entry['title'] ) ? sanitize_text_field( $entry['title'] ) : '',
			'subtitle'      => isset( $entry['subtitle'] ) ? wp_kses_post( $entry['subtitle'] ) : '',
			'display_name'  => isset( $entry['display_name'] ) ? sanitize_text_field( $entry['display_name'] ) : '',
			'url'           => isset( $entry['url'] ) ? esc_url_raw( $entry['url'] ) : '',
			'icon_url'      => isset( $entry['icon_url'] ) ? esc_url_raw( $entry['icon_url'] ) : '',
			'locales'       => self::sanitize_array_of_strings( isset( $entry['locales'] ) ? $entry['locales'] : array() ),
			'last_modified' => isset( $entry['last_modified'] ) ? self::sanitize_iso8601_to_mysql( $entry['last_modified'] ) : null,
			'type'          => isset( $entry['type'] ) ? sanitize_text_field( $entry['type'] ) : '',
			'courses'       => self::sanitize_array_of_strings( isset( $entry['courses'] ) ? $entry['courses'] : array() ),
			'levels'        => self::sanitize_array_of_strings( isset( $entry['levels'] ) ? $entry['levels'] : array() ),
			'roles'         => self::sanitize_array_of_strings( isset( $entry['roles'] ) ? $entry['roles'] : array() ),
			'products'      => self::sanitize_array_of_strings( isset( $entry['products'] ) ? $entry['products'] : array() ),
			'providers'     => self::sanitize_array_of_strings( isset( $entry['providers'] ) ? $entry['providers'] : array() ),
			'study_guide'   => wp_json_encode( isset( $entry['study_guide'] ) ? $entry['study_guide'] : array() ),
		);
	}

	/**
	 * Convert the catalog API's ISO 8601 `last_modified` into the naive
	 * `Y-m-d H:i:s` this column stores, normalized to UTC. Same as
	 * Credpl_Admin_Ms_Certifications::sanitize_iso8601_to_mysql().
	 */
	private static function sanitize_iso8601_to_mysql( $value ) {
		$timestamp = strtotime( (string) $value );

		if ( ! $timestamp ) {
			return null;
		}

		return gmdate( 'Y-m-d H:i:s', $timestamp );
	}

	/**
	 * Sanitize an array of plain strings (locales/courses/levels/roles/
	 * products/providers) from the API response into the same
	 * JSON-encoded shape sanitize_string_list() produces from the form's
	 * Textareas. Same as
	 * Credpl_Admin_Ms_Certifications::sanitize_array_of_strings().
	 */
	private static function sanitize_array_of_strings( $value ) {
		if ( ! is_array( $value ) ) {
			return '[]';
		}

		$items = array_map( 'sanitize_text_field', $value );
		$items = array_filter(
			$items,
			static function ( $item ) {
				return '' !== $item;
			}
		);

		return wp_json_encode( array_values( $items ) );
	}

	/**
	 * `last_modified` is stored as a naive `Y-m-d H:i:s` (no timezone
	 * component). Reformat to `Y-m-d\TH:i` (what a native
	 * `<input type="datetime-local">` expects) with a plain string
	 * operation, not a timestamp round-trip, so no timezone conversion can
	 * shift the displayed value. Same as
	 * Credpl_Admin_Ms_Certifications::format_datetime_local().
	 */
	private static function format_datetime_local( $value ) {
		if ( ! $value ) {
			return '';
		}

		return str_replace( ' ', 'T', substr( $value, 0, 16 ) );
	}

	/**
	 * Validate a submitted `datetime-local` value into a clean
	 * `Y-m-d H:i:s` string or `null`. Same as
	 * Credpl_Admin_Ms_Certifications::sanitize_datetime().
	 */
	private static function sanitize_datetime( $value ) {
		$value = trim( (string) $value );

		if ( '' === $value ) {
			return null;
		}

		$date = DateTime::createFromFormat( 'Y-m-d\TH:i:s', $value );

		if ( ! $date ) {
			$date = DateTime::createFromFormat( 'Y-m-d\TH:i', $value );
		}

		if ( ! $date ) {
			return null;
		}

		return $date->format( 'Y-m-d H:i:s' );
	}

	/**
	 * `locales`/`courses`/`levels`/`roles`/`products`/`providers` round-trip
	 * through the form as plain Fluent UI Textareas, one value per line.
	 * Same as Credpl_Admin_Ms_Certifications::sanitize_string_list().
	 */
	private static function sanitize_string_list( $value ) {
		$lines = preg_split( '/\r\n|\r|\n/', (string) $value );
		$lines = array_map( 'sanitize_text_field', $lines );
		$lines = array_map( 'trim', $lines );
		$lines = array_filter(
			$lines,
			static function ( $line ) {
				return '' !== $line;
			}
		);

		return wp_json_encode( array_values( $lines ) );
	}

	/**
	 * Decode a JSON-encoded array column back into the newline-per-item
	 * text sanitize_string_list() expects on the way back in.
	 */
	private static function decode_string_list( $json ) {
		$items = json_decode( (string) $json, true );

		return is_array( $items ) ? implode( "\n", $items ) : '';
	}

	/**
	 * `study_guide`'s real shape is unspecified — edited as raw JSON text.
	 * Same as Credpl_Admin_Ms_Certifications::sanitize_json_field(). Not
	 * escaped as HTML on save because nothing renders it as HTML — this
	 * plugin doesn't expose Microsoft Exams on the front end at all (§7).
	 */
	private static function sanitize_json_field( $value ) {
		$value = trim( (string) $value );

		if ( '' === $value ) {
			return '[]';
		}

		$decoded = json_decode( $value, true );

		if ( JSON_ERROR_NONE !== json_last_error() ) {
			return '[]';
		}

		return wp_json_encode( $decoded );
	}

	/**
	 * Re-encode a stored JSON column with JSON_PRETTY_PRINT for display in
	 * the Study Guide Textarea. Same as
	 * Credpl_Admin_Ms_Certifications::pretty_json().
	 */
	private static function pretty_json( $json ) {
		$decoded = json_decode( (string) $json, true );

		if ( JSON_ERROR_NONE !== json_last_error() ) {
			return (string) $json;
		}

		return wp_json_encode( $decoded, JSON_PRETTY_PRINT );
	}

	/**
	 * Stash a save/update error message for the current user to display
	 * after the redirect — same transient-based pattern as
	 * Credpl_Admin_Credentials::store_error_notice().
	 */
	private static function store_error_notice( $message ) {
		set_transient( 'credpl_ms_exam_error_' . get_current_user_id(), $message, 45 );
	}

	private static function maybe_render_notice() {
		if ( isset( $_GET['updated'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Microsoft Exam saved.', 'credentials-manager-plugin' ) . '</p></div>';
		}

		if ( isset( $_GET['deleted'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Microsoft Exam deleted.', 'credentials-manager-plugin' ) . '</p></div>';
		}

		if ( isset( $_GET['synced'] ) ) {
			$skipped = isset( $_GET['sync_skipped'] ) ? absint( $_GET['sync_skipped'] ) : 0;

			$message = sprintf(
				/* translators: 1: number of new exams created, 2: number of existing exams updated, 3: number of entries skipped. */
				__( 'Sync complete: %1$d created, %2$d updated, %3$d skipped.', 'credentials-manager-plugin' ),
				isset( $_GET['sync_created'] ) ? absint( $_GET['sync_created'] ) : 0,
				isset( $_GET['sync_updated'] ) ? absint( $_GET['sync_updated'] ) : 0,
				$skipped
			);

			// A skip count alone doesn't say why — sync() stashes the
			// first reason it hit the same way save()'s own errors are
			// stashed, so surface it here rather than leaving "N skipped"
			// as a dead end.
			if ( $skipped > 0 ) {
				$key    = 'credpl_ms_exam_error_' . get_current_user_id();
				$reason = get_transient( $key );
				delete_transient( $key );

				if ( $reason ) {
					$message .= ' ' . sprintf(
						/* translators: %s: the reason the first skipped entry was skipped. */
						__( 'First reason: %s', 'credentials-manager-plugin' ),
						$reason
					);
				}
			}

			printf(
				'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
				esc_html( $message )
			);
		}

		if ( isset( $_GET['error'] ) || isset( $_GET['sync_error'] ) ) {
			$key     = 'credpl_ms_exam_error_' . get_current_user_id();
			$message = get_transient( $key );
			delete_transient( $key );

			if ( ! $message ) {
				$message = isset( $_GET['sync_error'] )
					? __( 'Something went wrong and the sync could not complete.', 'credentials-manager-plugin' )
					: __( 'Something went wrong and the Microsoft Exam could not be saved.', 'credentials-manager-plugin' );
			}

			echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
		}
	}
}
