<?php
/**
 * The single place that talks to $wpdb for both custom tables. Every admin
 * screen and the shortcode renderer go through this class — see
 * SPECIFICATION.md §6.4.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Data {

	/* ---------------------------------------------------------------
	 * Credentials
	 * ------------------------------------------------------------- */

	public static function credentials_table() {
		global $wpdb;
		return $wpdb->prefix . 'credentials';
	}

	/**
	 * All credential rows, newest first by default.
	 */
	public static function get_credentials( array $args = array() ) {
		global $wpdb;

		$defaults = array(
			'orderby' => 'title',
			'order'   => 'ASC',
		);
		$args = wp_parse_args( $args, $defaults );

		$orderby = in_array( $args['orderby'], array( 'id', 'title', 'credentials_type', 'issuer', 'earned_on', 'expires_on', 'created_at' ), true )
			? $args['orderby']
			: 'title';
		$order = 'DESC' === strtoupper( $args['order'] ) ? 'DESC' : 'ASC';

		$table = self::credentials_table();

		// $orderby/$order are validated against fixed allowlists above, so
		// this interpolation is safe even though it can't go through
		// $wpdb->prepare() (identifiers can't be parameterized).
		$sql = "SELECT * FROM {$table} ORDER BY {$orderby} {$order}";

		$results = $wpdb->get_results( $sql, ARRAY_A );

		return is_array( $results ) ? $results : array();
	}

	/**
	 * Just the IDs of every existing credential, for validating a
	 * submitted `credential_ids` selection against what actually exists.
	 */
	public static function get_credential_ids() {
		global $wpdb;
		$table = self::credentials_table();

		$ids = $wpdb->get_col( "SELECT id FROM {$table}" );

		return is_array( $ids ) ? array_map( 'absint', $ids ) : array();
	}

	public static function get_credential( $id ) {
		global $wpdb;
		$table = self::credentials_table();

		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ),
			ARRAY_A
		);

		return $row ? $row : null;
	}

	public static function insert_credential( array $data ) {
		global $wpdb;
		$table = self::credentials_table();

		$now = current_time( 'mysql' );

		$row = array(
			'title'                => isset( $data['title'] ) ? $data['title'] : '',
			'credentials_type'     => isset( $data['credentials_type'] ) ? $data['credentials_type'] : '',
			'status'               => isset( $data['status'] ) ? $data['status'] : '',
			'award_category'       => isset( $data['award_category'] ) ? $data['award_category'] : '',
			'technology_area'      => isset( $data['technology_area'] ) ? $data['technology_area'] : '',
			'credential_link'      => isset( $data['credential_link'] ) ? $data['credential_link'] : '',
			'badge_media'          => isset( $data['badge_media'] ) ? absint( $data['badge_media'] ) : 0,
			'issuer'               => isset( $data['issuer'] ) ? $data['issuer'] : '',
			'credential_id'        => isset( $data['credential_id'] ) ? $data['credential_id'] : '',
			'certification_number' => isset( $data['certification_number'] ) ? $data['certification_number'] : '',
			'earned_on'            => isset( $data['earned_on'] ) ? $data['earned_on'] : null,
			'expires_on'           => isset( $data['expires_on'] ) ? $data['expires_on'] : null,
			'description'          => isset( $data['description'] ) ? $data['description'] : null,
			'created_at'           => $now,
			'updated_at'           => $now,
		);

		$inserted = $wpdb->insert( $table, $row );

		if ( false === $inserted ) {
			return new WP_Error(
				'credpl_insert_failed',
				sprintf(
					/* translators: %s: the database error message. */
					__( 'Could not save the credential. Database said: %s', 'credentials-manager-plugin' ),
					$wpdb->last_error
				)
			);
		}

		$insert_id = (int) $wpdb->insert_id;

		if ( ! $insert_id ) {
			// Some hosting setups (connection pooling/proxies in front of
			// MySQL) don't reliably surface LAST_INSERT_ID() via
			// $wpdb->insert_id, even though the insert itself succeeded.
			// Fall back to looking the row back up by exactly what was
			// just written — title + the created_at timestamp we set
			// above — so callers (and the redirect that follows a save)
			// still get a real ID instead of silently landing back on a
			// blank "Add New Credential" screen.
			$insert_id = (int) $wpdb->get_var(
				$wpdb->prepare(
					"SELECT id FROM {$table} WHERE title = %s AND created_at = %s ORDER BY id DESC LIMIT 1",
					$row['title'],
					$now
				)
			);
		}

		return $insert_id;
	}

	/**
	 * @return true|WP_Error `true` on success (including a successful query
	 *                       that changed zero rows, e.g. saving unchanged
	 *                       values again), or a WP_Error with the database's
	 *                       own error message if the query itself failed.
	 */
	public static function update_credential( $id, array $data ) {
		global $wpdb;
		$table = self::credentials_table();

		$row               = $data;
		$row['updated_at'] = current_time( 'mysql' );

		if ( isset( $row['badge_media'] ) ) {
			$row['badge_media'] = absint( $row['badge_media'] );
		}

		$updated = $wpdb->update( $table, $row, array( 'id' => absint( $id ) ) );

		if ( false === $updated ) {
			return new WP_Error(
				'credpl_update_failed',
				sprintf(
					/* translators: %s: the database error message. */
					__( 'Could not update the credential. Database said: %s', 'credentials-manager-plugin' ),
					$wpdb->last_error
				)
			);
		}

		return true;
	}

	public static function delete_credential( $id ) {
		global $wpdb;
		$table = self::credentials_table();

		$deleted = $wpdb->delete( $table, array( 'id' => absint( $id ) ) );

		return false !== $deleted;
	}

	/* ---------------------------------------------------------------
	 * Credential Blocks
	 * ------------------------------------------------------------- */

	public static function blocks_table() {
		global $wpdb;
		return $wpdb->prefix . 'credential_blocks';
	}

	/**
	 * All Credential Block rows, title A–Z by default. Same
	 * `$args`/allowlist shape as get_credentials()/get_ms_certifications()/
	 * get_ms_exams() — added when the Credential Blocks list gained
	 * sortable columns (§10 v27); title-only ordering before that.
	 */
	public static function get_credential_blocks( array $args = array() ) {
		global $wpdb;

		$defaults = array(
			'orderby' => 'title',
			'order'   => 'ASC',
		);
		$args = wp_parse_args( $args, $defaults );

		$orderby = in_array( $args['orderby'], array( 'id', 'title', 'description', 'created_at' ), true )
			? $args['orderby']
			: 'title';
		$order = 'DESC' === strtoupper( $args['order'] ) ? 'DESC' : 'ASC';

		$table = self::blocks_table();

		// $orderby/$order are validated against fixed allowlists above, so
		// this interpolation is safe even though it can't go through
		// $wpdb->prepare() (identifiers can't be parameterized).
		$sql = "SELECT * FROM {$table} ORDER BY {$orderby} {$order}";

		$results = $wpdb->get_results( $sql, ARRAY_A );

		return is_array( $results ) ? $results : array();
	}

	public static function get_credential_block( $id ) {
		global $wpdb;
		$table = self::blocks_table();

		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ),
			ARRAY_A
		);

		return $row ? $row : null;
	}

	public static function get_credential_block_by_key( $block_key ) {
		global $wpdb;
		$table = self::blocks_table();

		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$table} WHERE block_key = %s", $block_key ),
			ARRAY_A
		);

		return $row ? $row : null;
	}

	public static function block_key_exists( $block_key ) {
		global $wpdb;
		$table = self::blocks_table();

		$id = $wpdb->get_var(
			$wpdb->prepare( "SELECT id FROM {$table} WHERE block_key = %s", $block_key )
		);

		return null !== $id;
	}

	public static function insert_credential_block( array $data ) {
		global $wpdb;
		$table = self::blocks_table();

		$now = current_time( 'mysql' );

		$row = array(
			'block_key'      => isset( $data['block_key'] ) ? $data['block_key'] : '',
			'title'          => isset( $data['title'] ) ? $data['title'] : '',
			'description'    => isset( $data['description'] ) ? $data['description'] : '',
			'credential_ids' => isset( $data['credential_ids'] ) ? $data['credential_ids'] : '[]',
			'created_at'     => $now,
			'updated_at'     => $now,
		);

		$inserted = $wpdb->insert( $table, $row );

		if ( false === $inserted ) {
			return new WP_Error( 'credpl_insert_failed', __( 'Could not save the credential block.', 'credentials-manager-plugin' ) );
		}

		$insert_id = (int) $wpdb->insert_id;

		if ( ! $insert_id ) {
			// Same fallback as insert_credential() — some hosts don't
			// reliably surface LAST_INSERT_ID() via $wpdb->insert_id.
			// Here it's even more reliable: block_key is a UNIQUE KEY, so
			// this lookup can't match the wrong row.
			$insert_id = (int) $wpdb->get_var(
				$wpdb->prepare( "SELECT id FROM {$table} WHERE block_key = %s", $row['block_key'] )
			);
		}

		return $insert_id;
	}

	public static function update_credential_block( $id, array $data ) {
		global $wpdb;
		$table = self::blocks_table();

		$row               = $data;
		$row['updated_at'] = current_time( 'mysql' );

		$updated = $wpdb->update( $table, $row, array( 'id' => absint( $id ) ) );

		return false !== $updated;
	}

	public static function delete_credential_block( $id ) {
		global $wpdb;
		$table = self::blocks_table();

		$deleted = $wpdb->delete( $table, array( 'id' => absint( $id ) ) );

		return false !== $deleted;
	}

	/* ---------------------------------------------------------------
	 * Microsoft Certifications
	 * ------------------------------------------------------------- */

	public static function ms_certifications_table() {
		global $wpdb;
		return $wpdb->prefix . 'microsoft_certifications';
	}

	/**
	 * All Microsoft Certification rows, title A–Z by default.
	 */
	public static function get_ms_certifications( array $args = array() ) {
		global $wpdb;

		$defaults = array(
			'orderby' => 'title',
			'order'   => 'ASC',
		);
		$args = wp_parse_args( $args, $defaults );

		$orderby = in_array( $args['orderby'], array( 'id', 'uid', 'title', 'certification_type', 'type', 'last_modified', 'created_at' ), true )
			? $args['orderby']
			: 'title';
		$order = 'DESC' === strtoupper( $args['order'] ) ? 'DESC' : 'ASC';

		$table = self::ms_certifications_table();

		// $orderby/$order are validated against fixed allowlists above, so
		// this interpolation is safe even though it can't go through
		// $wpdb->prepare() (identifiers can't be parameterized).
		$sql = "SELECT * FROM {$table} ORDER BY {$orderby} {$order}";

		$results = $wpdb->get_results( $sql, ARRAY_A );

		return is_array( $results ) ? $results : array();
	}

	public static function get_ms_certification( $id ) {
		global $wpdb;
		$table = self::ms_certifications_table();

		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ),
			ARRAY_A
		);

		return $row ? $row : null;
	}

	/**
	 * Look up a row by its external `uid` rather than the internal `id` —
	 * used by Credpl_Admin_Ms_Certifications::sync() to decide whether an
	 * incoming catalog API entry is a create or an update.
	 */
	public static function get_ms_certification_by_uid( $uid ) {
		global $wpdb;
		$table = self::ms_certifications_table();

		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$table} WHERE uid = %s", $uid ),
			ARRAY_A
		);

		return $row ? $row : null;
	}

	/**
	 * Whether another row already uses this `uid` — `uid` carries a
	 * UNIQUE KEY, but it's admin-typed (not server-generated like
	 * `credential_blocks.block_key`), so a duplicate is a realistic
	 * mistake worth catching with a friendly validation error before it
	 * ever reaches the database (§6.4/§8).
	 */
	public static function ms_certification_uid_exists( $uid, $exclude_id = 0 ) {
		global $wpdb;
		$table = self::ms_certifications_table();

		if ( $exclude_id ) {
			$id = $wpdb->get_var(
				$wpdb->prepare( "SELECT id FROM {$table} WHERE uid = %s AND id != %d", $uid, absint( $exclude_id ) )
			);
		} else {
			$id = $wpdb->get_var(
				$wpdb->prepare( "SELECT id FROM {$table} WHERE uid = %s", $uid )
			);
		}

		return null !== $id;
	}

	public static function insert_ms_certification( array $data ) {
		global $wpdb;
		$table = self::ms_certifications_table();

		$now = current_time( 'mysql' );

		$row = array(
			'uid'                => isset( $data['uid'] ) ? $data['uid'] : '',
			'title'              => isset( $data['title'] ) ? $data['title'] : '',
			'subtitle'           => isset( $data['subtitle'] ) ? $data['subtitle'] : '',
			'url'                => isset( $data['url'] ) ? $data['url'] : '',
			'icon_url'           => isset( $data['icon_url'] ) ? $data['icon_url'] : '',
			'last_modified'      => isset( $data['last_modified'] ) ? $data['last_modified'] : null,
			'type'               => isset( $data['type'] ) ? $data['type'] : '',
			'certification_type' => isset( $data['certification_type'] ) ? $data['certification_type'] : '',
			'exams'              => isset( $data['exams'] ) ? $data['exams'] : '[]',
			'levels'             => isset( $data['levels'] ) ? $data['levels'] : '[]',
			'roles'              => isset( $data['roles'] ) ? $data['roles'] : '[]',
			'study_guide'        => isset( $data['study_guide'] ) ? $data['study_guide'] : '[]',
			'created_at'         => $now,
			'updated_at'         => $now,
		);

		$inserted = $wpdb->insert( $table, $row );

		if ( false === $inserted ) {
			return new WP_Error(
				'credpl_insert_failed',
				sprintf(
					/* translators: %s: the database error message. */
					__( 'Could not save the Microsoft Certification. Database said: %s', 'credentials-manager-plugin' ),
					$wpdb->last_error
				)
			);
		}

		$insert_id = (int) $wpdb->insert_id;

		if ( ! $insert_id ) {
			// Same fallback as insert_credential()/insert_credential_block()
			// — some hosts don't reliably surface LAST_INSERT_ID() via
			// $wpdb->insert_id. Here it's reliable: uid is a UNIQUE KEY, so
			// this lookup can't match the wrong row.
			$insert_id = (int) $wpdb->get_var(
				$wpdb->prepare( "SELECT id FROM {$table} WHERE uid = %s", $row['uid'] )
			);
		}

		return $insert_id;
	}

	/**
	 * @return true|WP_Error `true` on success (including a successful query
	 *                       that changed zero rows), or a WP_Error with the
	 *                       database's own error message if the query
	 *                       itself failed.
	 */
	public static function update_ms_certification( $id, array $data ) {
		global $wpdb;
		$table = self::ms_certifications_table();

		$row               = $data;
		$row['updated_at'] = current_time( 'mysql' );

		$updated = $wpdb->update( $table, $row, array( 'id' => absint( $id ) ) );

		if ( false === $updated ) {
			return new WP_Error(
				'credpl_update_failed',
				sprintf(
					/* translators: %s: the database error message. */
					__( 'Could not update the Microsoft Certification. Database said: %s', 'credentials-manager-plugin' ),
					$wpdb->last_error
				)
			);
		}

		return true;
	}

	public static function delete_ms_certification( $id ) {
		global $wpdb;
		$table = self::ms_certifications_table();

		$deleted = $wpdb->delete( $table, array( 'id' => absint( $id ) ) );

		return false !== $deleted;
	}

	/* ---------------------------------------------------------------
	 * Microsoft Exams
	 * ------------------------------------------------------------- */

	public static function ms_exams_table() {
		global $wpdb;
		return $wpdb->prefix . 'microsoft_exams';
	}

	/**
	 * All Microsoft Exam rows, title A–Z by default.
	 */
	public static function get_ms_exams( array $args = array() ) {
		global $wpdb;

		$defaults = array(
			'orderby' => 'title',
			'order'   => 'ASC',
		);
		$args = wp_parse_args( $args, $defaults );

		$orderby = in_array( $args['orderby'], array( 'id', 'uid', 'title', 'display_name', 'type', 'last_modified', 'created_at' ), true )
			? $args['orderby']
			: 'title';
		$order = 'DESC' === strtoupper( $args['order'] ) ? 'DESC' : 'ASC';

		$table = self::ms_exams_table();

		// $orderby/$order are validated against fixed allowlists above, so
		// this interpolation is safe even though it can't go through
		// $wpdb->prepare() (identifiers can't be parameterized).
		$sql = "SELECT * FROM {$table} ORDER BY {$orderby} {$order}";

		$results = $wpdb->get_results( $sql, ARRAY_A );

		return is_array( $results ) ? $results : array();
	}

	public static function get_ms_exam( $id ) {
		global $wpdb;
		$table = self::ms_exams_table();

		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ),
			ARRAY_A
		);

		return $row ? $row : null;
	}

	/**
	 * Look up a row by its external `uid` rather than the internal `id` —
	 * same rationale as get_ms_certification_by_uid() above.
	 */
	public static function get_ms_exam_by_uid( $uid ) {
		global $wpdb;
		$table = self::ms_exams_table();

		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$table} WHERE uid = %s", $uid ),
			ARRAY_A
		);

		return $row ? $row : null;
	}

	/**
	 * Whether another row already uses this `uid` — same rationale as
	 * ms_certification_uid_exists() above.
	 */
	public static function ms_exam_uid_exists( $uid, $exclude_id = 0 ) {
		global $wpdb;
		$table = self::ms_exams_table();

		if ( $exclude_id ) {
			$id = $wpdb->get_var(
				$wpdb->prepare( "SELECT id FROM {$table} WHERE uid = %s AND id != %d", $uid, absint( $exclude_id ) )
			);
		} else {
			$id = $wpdb->get_var(
				$wpdb->prepare( "SELECT id FROM {$table} WHERE uid = %s", $uid )
			);
		}

		return null !== $id;
	}

	public static function insert_ms_exam( array $data ) {
		global $wpdb;
		$table = self::ms_exams_table();

		$now = current_time( 'mysql' );

		$row = array(
			'uid'           => isset( $data['uid'] ) ? $data['uid'] : '',
			'title'         => isset( $data['title'] ) ? $data['title'] : '',
			'subtitle'      => isset( $data['subtitle'] ) ? $data['subtitle'] : '',
			'display_name'  => isset( $data['display_name'] ) ? $data['display_name'] : '',
			'url'           => isset( $data['url'] ) ? $data['url'] : '',
			'icon_url'      => isset( $data['icon_url'] ) ? $data['icon_url'] : '',
			'locales'       => isset( $data['locales'] ) ? $data['locales'] : '[]',
			'last_modified' => isset( $data['last_modified'] ) ? $data['last_modified'] : null,
			'type'          => isset( $data['type'] ) ? $data['type'] : '',
			'courses'       => isset( $data['courses'] ) ? $data['courses'] : '[]',
			'levels'        => isset( $data['levels'] ) ? $data['levels'] : '[]',
			'roles'         => isset( $data['roles'] ) ? $data['roles'] : '[]',
			'products'      => isset( $data['products'] ) ? $data['products'] : '[]',
			'providers'     => isset( $data['providers'] ) ? $data['providers'] : '[]',
			'study_guide'   => isset( $data['study_guide'] ) ? $data['study_guide'] : '[]',
			'created_at'    => $now,
			'updated_at'    => $now,
		);

		$inserted = $wpdb->insert( $table, $row );

		if ( false === $inserted ) {
			return new WP_Error(
				'credpl_insert_failed',
				sprintf(
					/* translators: %s: the database error message. */
					__( 'Could not save the Microsoft Exam. Database said: %s', 'credentials-manager-plugin' ),
					$wpdb->last_error
				)
			);
		}

		$insert_id = (int) $wpdb->insert_id;

		if ( ! $insert_id ) {
			// Same fallback as the other insert_*() methods — some hosts
			// don't reliably surface LAST_INSERT_ID() via $wpdb->insert_id.
			// Here it's reliable: uid is a UNIQUE KEY, so this lookup can't
			// match the wrong row.
			$insert_id = (int) $wpdb->get_var(
				$wpdb->prepare( "SELECT id FROM {$table} WHERE uid = %s", $row['uid'] )
			);
		}

		return $insert_id;
	}

	/**
	 * @return true|WP_Error `true` on success (including a successful query
	 *                       that changed zero rows), or a WP_Error with the
	 *                       database's own error message if the query
	 *                       itself failed.
	 */
	public static function update_ms_exam( $id, array $data ) {
		global $wpdb;
		$table = self::ms_exams_table();

		$row               = $data;
		$row['updated_at'] = current_time( 'mysql' );

		$updated = $wpdb->update( $table, $row, array( 'id' => absint( $id ) ) );

		if ( false === $updated ) {
			return new WP_Error(
				'credpl_update_failed',
				sprintf(
					/* translators: %s: the database error message. */
					__( 'Could not update the Microsoft Exam. Database said: %s', 'credentials-manager-plugin' ),
					$wpdb->last_error
				)
			);
		}

		return true;
	}

	public static function delete_ms_exam( $id ) {
		global $wpdb;
		$table = self::ms_exams_table();

		$deleted = $wpdb->delete( $table, array( 'id' => absint( $id ) ) );

		return false !== $deleted;
	}
}
