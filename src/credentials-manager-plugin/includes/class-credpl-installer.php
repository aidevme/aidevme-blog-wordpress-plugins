<?php
/**
 * Creates and versions the plugin's four custom tables:
 * `{$wpdb->prefix}credentials`, `{$wpdb->prefix}credential_blocks`,
 * `{$wpdb->prefix}microsoft_certifications`, and
 * `{$wpdb->prefix}microsoft_exams`.
 *
 * See SPECIFICATION.md §4 (schema) and §5 (activation/versioning).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Installer {

	const DB_VERSION_OPTION      = 'credpl_db_version';
	const MIGRATION_ERROR_OPTION = 'credpl_migration_missing_columns';

	/**
	 * Hook the upgrade check into `plugins_loaded`. Initial installation
	 * happens via register_activation_hook() in the main plugin file,
	 * calling install() directly (see credentials-manager-plugin.php).
	 */
	public static function init() {
		add_action( 'plugins_loaded', array( __CLASS__, 'maybe_upgrade' ) );
		add_action( 'admin_notices', array( __CLASS__, 'maybe_render_migration_notice' ) );
	}

	/**
	 * Create (or update, via dbDelta()'s diffing) all four tables and
	 * record the current schema version.
	 */
	public static function install() {
		global $wpdb;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		self::maybe_rename_forms_table_to_blocks();
		self::maybe_drop_badge_link_column();

		$charset_collate = $wpdb->get_charset_collate();

		$credentials_table = $wpdb->prefix . 'credentials';
		$sql_credentials   = "CREATE TABLE $credentials_table (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			title varchar(255) NOT NULL DEFAULT '',
			credentials_type varchar(50) NOT NULL DEFAULT '',
			status varchar(20) NOT NULL DEFAULT '',
			award_category varchar(255) NOT NULL DEFAULT '',
			technology_area varchar(255) NOT NULL DEFAULT '',
			credential_link varchar(255) NOT NULL DEFAULT '',
			badge_media bigint(20) unsigned NOT NULL DEFAULT 0,
			issuer varchar(255) NOT NULL DEFAULT '',
			credential_id varchar(255) NOT NULL DEFAULT '',
			certification_number varchar(255) NOT NULL DEFAULT '',
			earned_on date DEFAULT NULL,
			expires_on date DEFAULT NULL,
			description text,
			created_at datetime DEFAULT NULL,
			updated_at datetime DEFAULT NULL,
			PRIMARY KEY  (id),
			KEY title (title),
			KEY issuer (issuer),
			KEY badge_media (badge_media),
			KEY credential_id (credential_id),
			KEY expires_on (expires_on)
		) $charset_collate;";

		$blocks_table = $wpdb->prefix . 'credential_blocks';
		$sql_blocks   = "CREATE TABLE $blocks_table (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			block_key varchar(20) NOT NULL,
			title varchar(255) NOT NULL DEFAULT '',
			description text,
			credential_ids longtext NOT NULL,
			created_at datetime DEFAULT NULL,
			updated_at datetime DEFAULT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY block_key (block_key)
		) $charset_collate;";

		$ms_certifications_table = $wpdb->prefix . 'microsoft_certifications';
		$sql_ms_certifications   = "CREATE TABLE $ms_certifications_table (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			uid varchar(255) NOT NULL,
			title varchar(255) NOT NULL DEFAULT '',
			subtitle longtext,
			url varchar(500) NOT NULL DEFAULT '',
			icon_url varchar(500) NOT NULL DEFAULT '',
			last_modified datetime DEFAULT NULL,
			type varchar(50) NOT NULL DEFAULT '',
			certification_type varchar(100) NOT NULL DEFAULT '',
			exams longtext NOT NULL,
			levels longtext NOT NULL,
			roles longtext NOT NULL,
			study_guide longtext NOT NULL,
			created_at datetime DEFAULT NULL,
			updated_at datetime DEFAULT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY uid (uid),
			KEY title (title),
			KEY certification_type (certification_type)
		) $charset_collate;";

		$ms_exams_table = $wpdb->prefix . 'microsoft_exams';
		$sql_ms_exams   = "CREATE TABLE $ms_exams_table (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			uid varchar(255) NOT NULL,
			title varchar(255) NOT NULL DEFAULT '',
			subtitle longtext,
			display_name varchar(255) NOT NULL DEFAULT '',
			url varchar(500) NOT NULL DEFAULT '',
			icon_url varchar(500) NOT NULL DEFAULT '',
			locales longtext NOT NULL,
			last_modified datetime DEFAULT NULL,
			type varchar(50) NOT NULL DEFAULT '',
			courses longtext NOT NULL,
			levels longtext NOT NULL,
			roles longtext NOT NULL,
			products longtext NOT NULL,
			providers longtext NOT NULL,
			study_guide longtext NOT NULL,
			created_at datetime DEFAULT NULL,
			updated_at datetime DEFAULT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY uid (uid),
			KEY title (title),
			KEY display_name (display_name)
		) $charset_collate;";

		dbDelta( $sql_credentials );
		dbDelta( $sql_blocks );
		dbDelta( $sql_ms_certifications );
		dbDelta( $sql_ms_exams );

		// dbDelta() doesn't report failure — if the DB user lacks ALTER
		// privileges (seen on some restrictive hosting setups), the
		// ADD COLUMN statements it generates internally can fail
		// completely silently, with no error and no exception. Without
		// this check, the code below would still mark the schema as
		// "up to date," and Credpl_Data::insert_credential() would then
		// fail on every single save with a confusing "Unknown column"
		// error, forever, since maybe_upgrade() would never retry.
		$missing = self::missing_credential_columns();

		if ( ! empty( $missing ) ) {
			update_option( self::MIGRATION_ERROR_OPTION, $missing );
			return;
		}

		delete_option( self::MIGRATION_ERROR_OPTION );
		update_option( self::DB_VERSION_OPTION, CREDPL_DB_VERSION );
	}

	/**
	 * Which of the columns install() expects on `credentials` are actually
	 * missing right now, per the live database (not per what dbDelta() was
	 * merely *asked* to do).
	 */
	private static function missing_credential_columns() {
		global $wpdb;

		$table    = $wpdb->prefix . 'credentials';
		$expected = array(
			'id',
			'title',
			'credentials_type',
			'status',
			'award_category',
			'technology_area',
			'credential_link',
			'badge_media',
			'issuer',
			'credential_id',
			'certification_number',
			'earned_on',
			'expires_on',
			'description',
			'created_at',
			'updated_at',
		);

		// get_col() always returns an array — empty (not null/false) if the
		// DESCRIBE itself fails, e.g. because dbDelta() couldn't create the
		// table at all (same underlying privilege problem this whole check
		// exists to catch). That correctly shows every expected column as
		// "missing" in that case too, which is an accurate description of
		// the actual problem, just at the whole-table level.
		$existing = $wpdb->get_col( "DESCRIBE {$table}", 0 );

		return array_values( array_diff( $expected, $existing ) );
	}

	/**
	 * A persistent admin notice on every wp-admin screen (not just this
	 * plugin's own) when the migration above detected missing columns —
	 * this is a "your database user probably lacks ALTER privileges, ask
	 * your host" situation, not something clicking around in this plugin
	 * can fix on its own, so it needs to stay visible everywhere until
	 * resolved.
	 */
	public static function maybe_render_migration_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$missing = get_option( self::MIGRATION_ERROR_OPTION );

		if ( empty( $missing ) ) {
			return;
		}
		?>
		<div class="notice notice-error">
			<p>
				<strong><?php esc_html_e( 'Credentials Manager: database update incomplete.', 'credentials-manager-plugin' ); ?></strong>
			</p>
			<p>
				<?php
				printf(
					/* translators: %s: comma-separated list of missing database column names. */
					esc_html__( 'The following columns are missing from the credentials table and could not be added automatically: %s. This usually means the WordPress database user does not have ALTER privileges. Ask your hosting provider to grant ALTER on this database, or add the columns manually, then reload this page.', 'credentials-manager-plugin' ),
					esc_html( implode( ', ', $missing ) )
				);
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * One-time migration for sites that already have data in the old
	 * `{$wpdb->prefix}credential_forms` table (this plugin's previous
	 * name for what's now called a "Credential Block").
	 *
	 * If the old table exists and the new one doesn't yet, rename it in
	 * place — preserving every row — and rename its `form_key` column to
	 * `block_key` to match. dbDelta() itself cannot rename tables or
	 * columns; it only creates tables or adds/alters columns on a table
	 * it already recognizes by name, which is why this runs as an
	 * explicit step before dbDelta() in install() above, not as part of
	 * the CREATE TABLE statement.
	 */
	private static function maybe_rename_forms_table_to_blocks() {
		global $wpdb;

		$old_table = $wpdb->prefix . 'credential_forms';
		$new_table = $wpdb->prefix . 'credential_blocks';

		$old_exists = (bool) $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $old_table ) );

		if ( ! $old_exists ) {
			return;
		}

		$new_exists = (bool) $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $new_table ) );

		if ( $new_exists ) {
			// Both tables exist — a previous migration attempt already
			// created the new one. Don't risk clobbering it; leave the
			// old table alone rather than guessing which has the data.
			return;
		}

		// phpcs:ignore -- identifiers can't be parameterized with $wpdb->prepare().
		$wpdb->query( "RENAME TABLE `{$old_table}` TO `{$new_table}`" );
		// phpcs:ignore
		$wpdb->query( "ALTER TABLE `{$new_table}` CHANGE `form_key` `block_key` varchar(20) NOT NULL" );
	}

	/**
	 * One-time migration: drops the `badge_link` column from `credentials`
	 * on sites that still have it from before the Badge Link field was
	 * removed (§10). `dbDelta()` only ever adds or alters columns to match
	 * the CREATE TABLE statement in install() — it never drops a column
	 * that's no longer listed there — so, like the table rename above,
	 * this needs an explicit step before dbDelta() runs. Safe to run
	 * repeatedly: it's a no-op once the column is already gone (including
	 * on a fresh install, where `credentials` doesn't exist yet either).
	 */
	private static function maybe_drop_badge_link_column() {
		global $wpdb;

		$table = $wpdb->prefix . 'credentials';

		$column_exists = (bool) $wpdb->get_var( $wpdb->prepare( "SHOW COLUMNS FROM {$table} LIKE %s", 'badge_link' ) );

		if ( ! $column_exists ) {
			return;
		}

		// phpcs:ignore -- identifiers can't be parameterized with $wpdb->prepare().
		$wpdb->query( "ALTER TABLE `{$table}` DROP COLUMN `badge_link`" );
	}

	/**
	 * Re-run install() if the site's recorded schema version doesn't match
	 * this plugin version's expected schema — covers plugin updates, since
	 * register_activation_hook() doesn't fire when a plugin is updated.
	 */
	public static function maybe_upgrade() {
		if ( get_option( self::DB_VERSION_OPTION ) !== CREDPL_DB_VERSION ) {
			self::install();
		}
	}
}
