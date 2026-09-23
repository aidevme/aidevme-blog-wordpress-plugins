<?php
/**
 * Page callbacks and save/delete handlers for the Skills admin screens
 * (list + add/edit). See SPECIFICATION.md §6.10.
 *
 * Same shape as Credpl_Admin_Blocks — a React/Fluent UI 9 list
 * (src/components/pages/skills/skills-list.tsx) and a React add/edit form
 * (src/components/pages/skills/skill.tsx), both hydrated from data
 * localized here, with the form submitting as a plain HTML POST to
 * admin-post.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Admin_Skills {

	const SAVE_ACTION        = 'credpl_save_skill';
	const BULK_DELETE_ACTION = 'credpl_bulk_delete_skills';

	public static function init() {
		add_action( 'admin_post_' . self::SAVE_ACTION, array( __CLASS__, 'save' ) );
		add_action( 'admin_post_' . self::BULK_DELETE_ACTION, array( __CLASS__, 'bulk_delete' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	/**
	 * Load the React-built Add/Edit Skill form or the React-built Skills
	 * list, depending on which of this screen's two pages is being
	 * requested (checked via `$_GET['page']`, same as
	 * Credpl_Admin_Blocks::enqueue_assets()).
	 */
	public static function enqueue_assets() {
		if ( ! isset( $_GET['page'] ) ) {
			return;
		}

		if ( Credpl_Admin_Menu::PAGE_SKILL_NEW === $_GET['page'] ) {
			self::enqueue_edit_form_assets();
		} elseif ( Credpl_Admin_Menu::PAGE_SKILLS === $_GET['page'] ) {
			self::enqueue_list_assets();
		}
	}

	private static function enqueue_edit_form_assets() {
		$asset_file = CREDPL_PLUGIN_DIR . 'build/skill.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'credpl-skill-form',
			plugins_url( 'build/skill.js', CREDPL_PLUGIN_FILE ),
			$asset['dependencies'],
			$asset['version'],
			true
		);

		$id    = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
		$skill = $id ? Credpl_Data::get_skill( $id ) : null;

		if ( $id && ! $skill ) {
			return;
		}

		wp_localize_script(
			'credpl-skill-form',
			'credplSkillForm',
			array(
				'id'          => $id,
				'nonce'       => wp_create_nonce( self::SAVE_ACTION ),
				'actionUrl'   => admin_url( 'admin-post.php' ),
				'skillName'   => $skill ? $skill['skill_name'] : '',
				'description' => $skill ? (string) $skill['description'] : '',
				'listUrl'     => add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_SKILLS ), admin_url( 'admin.php' ) ),
			)
		);
	}

	/**
	 * Load the React-built "All Skills" list. `orderby`/`order` are
	 * `sanitize_key()`'d here, then re-validated against
	 * `Credpl_Data::get_skills()`'s own fixed allowlist, falling back to
	 * `skill_name`/`ASC` for anything unrecognized.
	 */
	private static function enqueue_list_assets() {
		$asset_file = CREDPL_PLUGIN_DIR . 'build/skills-list.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'credpl-skills-list',
			plugins_url( 'build/skills-list.js', CREDPL_PLUGIN_FILE ),
			$asset['dependencies'],
			$asset['version'],
			true
		);

		$orderby = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : 'skill_name';
		$order   = isset( $_GET['order'] ) ? sanitize_key( $_GET['order'] ) : 'asc';

		$skills = Credpl_Data::get_skills(
			array(
				'orderby' => $orderby,
				'order'   => $order,
			)
		);

		$rows = array();

		foreach ( $skills as $skill ) {
			$rows[] = array(
				'id'          => (int) $skill['id'],
				'skillName'   => $skill['skill_name'],
				'description' => (string) $skill['description'],
				'editUrl'     => add_query_arg(
					array(
						'page' => Credpl_Admin_Menu::PAGE_SKILL_NEW,
						'id'   => (int) $skill['id'],
					),
					admin_url( 'admin.php' )
				),
			);
		}

		wp_localize_script(
			'credpl-skills-list',
			'credplSkillsList',
			array(
				'rows'          => $rows,
				'listUrl'       => add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_SKILLS ), admin_url( 'admin.php' ) ),
				'orderby'       => $orderby,
				'order'         => $order,
				'backUrl'       => add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_MANAGER ), admin_url( 'admin.php' ) ),
				'addNewUrl'     => add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_SKILL_NEW ), admin_url( 'admin.php' ) ),
				'bulkDeleteUrl' => wp_nonce_url(
					add_query_arg(
						array( 'action' => self::BULK_DELETE_ACTION ),
						admin_url( 'admin-post.php' )
					),
					self::BULK_DELETE_ACTION
				),
				'noItemsText'   => __( 'No skills yet.', 'credentials-manager-plugin' ),
			)
		);
	}

	/**
	 * The "Skills" list screen: page chrome in plain PHP, then a mount
	 * point for the React list from src/components/pages/skills/skills-list.tsx.
	 */
	public static function render_list_page() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'Skills', 'credentials-manager-plugin' ); ?></h1>
			<hr class="wp-header-end" />
			<?php self::maybe_render_notice(); ?>
			<div id="credpl-skills-list-root"></div>
		</div>
		<?php
	}

	/**
	 * The "Add Skill" / "Edit Skill" screen: a mount point for the React
	 * form from src/components/pages/skills/skill.tsx (see
	 * enqueue_edit_form_assets() for the localized data it hydrates from).
	 */
	public static function render_edit_page() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to access this page.', 'credentials-manager-plugin' ) );
		}

		$id    = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
		$skill = $id ? Credpl_Data::get_skill( $id ) : null;

		if ( $id && ! $skill ) {
			wp_die( esc_html__( 'Skill not found.', 'credentials-manager-plugin' ) );
		}

		$heading = $skill
			? __( 'Edit Skill', 'credentials-manager-plugin' )
			: __( 'Add Skill', 'credentials-manager-plugin' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( $heading ); ?></h1>
			<?php self::maybe_render_notice(); ?>

			<?php if ( isset( $_GET['updated'] ) ) : ?>
				<p>
					<a
						href="<?php echo esc_url( add_query_arg( array( 'page' => Credpl_Admin_Menu::PAGE_SKILLS ), admin_url( 'admin.php' ) ) ); ?>"
						class="button"
					><?php esc_html_e( 'Back to All Skills', 'credentials-manager-plugin' ); ?></a>
				</p>
			<?php endif; ?>

			<div id="credpl-skill-form-root"></div>
		</div>
		<?php
	}

	/**
	 * Save handler (admin-post.php?action=credpl_save_skill).
	 */
	public static function save() {
		if ( ! current_user_can( Credpl_Admin_Menu::CAPABILITY ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'credentials-manager-plugin' ) );
		}

		check_admin_referer( self::SAVE_ACTION );

		$id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;

		$data = array(
			'skill_name'  => isset( $_POST['skill_name'] ) ? sanitize_text_field( wp_unslash( $_POST['skill_name'] ) ) : '',
			'description' => isset( $_POST['description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['description'] ) ) : '',
		);

		$page_args = array( 'page' => Credpl_Admin_Menu::PAGE_SKILL_NEW );

		if ( $id ) {
			$page_args['id'] = $id;
		}

		if ( '' === $data['skill_name'] ) {
			// The form's `required` attribute normally stops this in the
			// browser; this is the server-side backstop.
			$page_args['error'] = 'missing_name';
		} elseif ( $id ) {
			$result = Credpl_Data::update_skill( $id, $data );

			if ( is_wp_error( $result ) ) {
				$page_args['error'] = 'save_failed';
			} else {
				$page_args['updated'] = 1;
			}
		} else {
			$id = Credpl_Data::insert_skill( $data );

			if ( is_wp_error( $id ) ) {
				unset( $page_args['id'] );
				$page_args['error'] = 'save_failed';
			} else {
				$page_args['id']      = $id;
				$page_args['updated'] = 1;
			}
		}

		wp_safe_redirect( add_query_arg( $page_args, admin_url( 'admin.php' ) ) );
		exit;
	}

	/**
	 * Bulk delete handler (admin-post.php?action=credpl_bulk_delete_skills&ids[]=…&ids[]=…),
	 * driven by the list screen's toolbar Delete button — one fixed nonce
	 * action string, not per-ID, since the selected ID set is only known
	 * client-side at click time (same as Credpl_Admin_Blocks::bulk_delete()).
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
			if ( Credpl_Data::delete_skill( $id ) ) {
				++$deleted_count;
			}
		}

		$redirect_url = add_query_arg(
			array(
				'page'         => Credpl_Admin_Menu::PAGE_SKILLS,
				'bulk_deleted' => $deleted_count,
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect_url );
		exit;
	}

	private static function maybe_render_notice() {
		if ( isset( $_GET['updated'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Skill saved.', 'credentials-manager-plugin' ) . '</p></div>';
		}

		if ( isset( $_GET['error'] ) ) {
			$message = 'missing_name' === $_GET['error']
				? __( 'A skill name is required.', 'credentials-manager-plugin' )
				: __( 'The skill could not be saved.', 'credentials-manager-plugin' );

			echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
		}

		if ( isset( $_GET['bulk_deleted'] ) ) {
			$count = absint( $_GET['bulk_deleted'] );
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html(
				sprintf(
					/* translators: %d: number of skills deleted. */
					_n( '%d skill deleted.', '%d skills deleted.', $count, 'credentials-manager-plugin' ),
					$count
				)
			) . '</p></div>';
		}
	}
}
