<?php
/**
 * List table for the Microsoft Certifications admin screen. See
 * SPECIFICATION.md §6.4.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Credpl_Ms_Certifications_List_Table extends WP_List_Table {

	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'ms_certification',
				'plural'   => 'ms_certifications',
				'ajax'     => false,
			)
		);
	}

	public function get_columns() {
		return array(
			'title'              => __( 'Title', 'credentials-manager-plugin' ),
			'icon'               => __( 'Icon', 'credentials-manager-plugin' ),
			'certification_type' => __( 'Certification Type', 'credentials-manager-plugin' ),
			'type'               => __( 'Type', 'credentials-manager-plugin' ),
			'last_modified'      => __( 'Last Modified', 'credentials-manager-plugin' ),
		);
	}

	/**
	 * Same rationale as the Credentials list screen's own sorting (now
	 * React/DataGrid-driven, §10 v34, but the underlying validation is
	 * identical) — `orderby` values pass straight through to
	 * Credpl_Data::get_ms_certifications(), which validates them against
	 * its own allowlist. Icon isn't meaningful to sort by, so it's left
	 * out.
	 */
	public function get_sortable_columns() {
		return array(
			'title'              => array( 'title', false ),
			'certification_type' => array( 'certification_type', false ),
			'type'               => array( 'type', false ),
			'last_modified'      => array( 'last_modified', false ),
		);
	}

	public function prepare_items() {
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

		$orderby = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : 'title';
		$order   = isset( $_GET['order'] ) ? sanitize_key( $_GET['order'] ) : 'asc';

		$this->items = Credpl_Data::get_ms_certifications(
			array(
				'orderby' => $orderby,
				'order'   => $order,
			)
		);
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'certification_type':
			case 'type':
				return $item[ $column_name ] ? esc_html( $item[ $column_name ] ) : '&#8212;';
			case 'last_modified':
				return self::format_last_modified( $item['last_modified'] );
			default:
				return '';
		}
	}

	/**
	 * `last_modified` is a full DATETIME (unlike Credentials'
	 * `earned_on`/`expires_on`, which are date-only) — formatted with both
	 * the site's date_format and time_format options.
	 */
	private static function format_last_modified( $value ) {
		if ( ! $value ) {
			return '&#8212;';
		}

		$format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );

		return esc_html( date_i18n( $format, strtotime( $value ) ) );
	}

	public function column_icon( $item ) {
		if ( empty( $item['icon_url'] ) ) {
			return '&#8212;';
		}

		return sprintf(
			'<img src="%s" alt="" style="width:32px;height:32px;object-fit:contain;" />',
			esc_url( $item['icon_url'] )
		);
	}

	public function column_title( $item ) {
		$edit_url = add_query_arg(
			array(
				'page' => Credpl_Admin_Menu::PAGE_MS_CERTIFICATION_NEW,
				'id'   => absint( $item['id'] ),
			),
			admin_url( 'admin.php' )
		);

		$delete_url = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'credpl_delete_ms_certification',
					'id'     => absint( $item['id'] ),
				),
				admin_url( 'admin-post.php' )
			),
			'credpl_delete_ms_certification_' . absint( $item['id'] )
		);

		$title = $item['title'] ? $item['title'] : __( '(no title)', 'credentials-manager-plugin' );

		$actions = array(
			'edit'   => sprintf( '<a href="%s">%s</a>', esc_url( $edit_url ), esc_html__( 'Edit', 'credentials-manager-plugin' ) ),
			'delete' => sprintf(
				'<a href="%s" onclick="return confirm(\'%s\');">%s</a>',
				esc_url( $delete_url ),
				esc_js( __( 'Delete this Microsoft Certification?', 'credentials-manager-plugin' ) ),
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
		esc_html_e( 'No Microsoft Certifications yet.', 'credentials-manager-plugin' );
	}
}
