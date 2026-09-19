<?php
/**
 * List table for the Credential Blocks admin screen. See
 * SPECIFICATION.md §6.3.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Credpl_Blocks_List_Table extends WP_List_Table {

	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'credential_block',
				'plural'   => 'credential_blocks',
				'ajax'     => false,
			)
		);
	}

	public function get_columns() {
		return array(
			'title'       => __( 'Title', 'credentials-manager-plugin' ),
			'shortcode'   => __( 'Shortcode', 'credentials-manager-plugin' ),
			'description' => __( 'Description', 'credentials-manager-plugin' ),
		);
	}

	/**
	 * Title and Description are sortable — `orderby` values pass straight
	 * through to Credpl_Data::get_credential_blocks(), which validates
	 * them against its own allowlist. Shortcode isn't meaningful to sort
	 * by (it's a generated identifier, not descriptive data), so it's left
	 * out — same reasoning as Badge/Icon on the other three list tables.
	 */
	public function get_sortable_columns() {
		return array(
			'title'       => array( 'title', false ),
			'description' => array( 'description', false ),
		);
	}

	public function prepare_items() {
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

		$orderby = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : 'title';
		$order   = isset( $_GET['order'] ) ? sanitize_key( $_GET['order'] ) : 'asc';

		$this->items = Credpl_Data::get_credential_blocks(
			array(
				'orderby' => $orderby,
				'order'   => $order,
			)
		);
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'shortcode':
				return self::render_shortcode_field( $item );
			case 'description':
				return $item['description'] ? esc_html( $item['description'] ) : '&#8212;';
			default:
				return '';
		}
	}

	public static function render_shortcode_field( array $item ) {
		$shortcode = Credpl_Shortcode::build_tag( $item );

		return sprintf(
			'<input type="text" readonly="readonly" onclick="this.select();" class="large-text code" value="%s" />',
			esc_attr( $shortcode )
		);
	}

	public function column_title( $item ) {
		$edit_url = add_query_arg(
			array(
				'page' => Credpl_Admin_Menu::PAGE_BLOCK_NEW,
				'id'   => absint( $item['id'] ),
			),
			admin_url( 'admin.php' )
		);

		$delete_url = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'credpl_delete_credential_block',
					'id'     => absint( $item['id'] ),
				),
				admin_url( 'admin-post.php' )
			),
			'credpl_delete_credential_block_' . absint( $item['id'] )
		);

		$title = $item['title'] ? $item['title'] : __( '(no title)', 'credentials-manager-plugin' );

		$actions = array(
			'edit'   => sprintf( '<a href="%s">%s</a>', esc_url( $edit_url ), esc_html__( 'Edit', 'credentials-manager-plugin' ) ),
			'delete' => sprintf(
				'<a href="%s" onclick="return confirm(\'%s\');">%s</a>',
				esc_url( $delete_url ),
				esc_js( __( 'Delete this credential block?', 'credentials-manager-plugin' ) ),
				esc_html__( 'Delete', 'credentials-manager-plugin' )
			),
		);

		return sprintf(
			'<strong><a href="%s">%s</a></strong>%s',
			esc_url( $edit_url ),
			esc_html( $title ),
			$this->row_actions( $actions )
		);
	}

	public function no_items() {
		esc_html_e( 'No credential blocks yet.', 'credentials-manager-plugin' );
	}
}
