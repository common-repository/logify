<?php

namespace KaizenCoders\Logify\Admin;

use KaizenCoders\Logify\DB\Activity_Logs;
use KaizenCoders\Logify\Helper;

/**
 * Class Activity_Logs_Table
 *
 * @since   1.0.0
 * @package KaizenCoders\Logify\Admin
 */
class Activity_Logs_Table extends US_List_Table {
	/**
	 * @since 1.0.0
	 * @var string
	 */
	public static $option_per_page = 'lg_logs_per_page';

	/**
	 * @var Activity_Logs
	 */
	public $db;

	/**
	 * Activity_Logs_Table constructor.
	 */
	public function __construct() {

		parent::__construct(
			[
				'singular' => __( 'Activity Log', 'logify' ), // singular name of the listed records
				'plural'   => __( 'Activity Log', 'logify' ), // plural name of the listed records
				'ajax'     => false, // does this table support ajax?
				'screen'   => 'activity_logs',
			]
		);

		$this->db = new Activity_Logs();
	}

	/**
	 * Add Screen Option
	 *
	 * @since 1.0.0
	 */
	public static function screen_options() {
	}

	/**
	 * Render links page
	 *
	 * @since 1.0.0
	 */
	public function render() {
		try {

			$template_data = [
				'object' => $this,
				'title'  => __( 'Activity Logs', 'logify' ),
			];

			ob_start();

			include KAIZENCODERS_LOGIFY_ADMIN_TEMPLATES_DIR . '/activity-logs.php';

		} catch ( \Exception $e ) {

		}
	}

	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {

		$columns = [
			'created_at' => __( 'Created', 'logify' ),
			'user'       => __( 'User', 'logify' ),
			'object'     => __( 'Object', 'logify' ),
			'event_type' => __( 'Event Type', 'logify' ),
		];

		return apply_filters( 'kaizencoders_logify_filter_activity_logs_columns', $columns );
	}

	/**
	 * @param  string  $column_name
	 *
	 * @param  object  $item
	 *
	 * @return string|void
	 * @since 1.0.0
	 *
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'created_at':
				return Helper::format_date_time( $item[ $column_name ] );
				break;
			case 'user':
				return get_userdata( $item['user_id'] )->display_name;
				break;
			default:
				return $item[ $column_name ];
		}
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param  array  $item
	 *
	 * @return string
	 * @since 1.0.0
	 *
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="activity_log_ids[]" value="%s"/>',
			$item['id']
		);
	}

	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return [
			'created_at' => [ 'created_at', true ],
		];
	}

	/**
	 * @param  int  $page_number
	 * @param  bool  $do_count_only
	 *
	 * @param  int  $per_page
	 *
	 * @return array
	 * @since 1.0.0
	 *
	 */
	public function get_lists( $per_page = 10, $page_number = 1, $do_count_only = false ) {
		global $wpdb;

		$order_by = sanitize_sql_orderby( 'created_at' );

		/* phpcs:ignore WordPress.Security.NonceVerification.Recommended */
		$order = isset( $_GET['order'] ) ? sanitize_text_field( wp_unslash( $_GET['order'] ) ) : 'desc';

		if ( ! $do_count_only ) {
			$expected_order_values = [ 'asc', 'desc' ];

			if ( ! in_array( $order, $expected_order_values ) ) {
				$order = 'desc';
			}

			$offset = ( $page_number - 1 ) * $per_page;

			/* phpcs:ignore */
			$query = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'kc_lf_activity_logs ORDER BY %1$s %2$s LIMIT %3$d OFFSET %4$d', $order_by, $order, $per_page, $offset );

			/* phpcs:ignore */
			$result = $wpdb->get_results( $query, 'ARRAY_A' );
		} else {
			/* phpcs:ignore */
			$result = $wpdb->get_var( "SELECT count(*) as total FROM {$wpdb->prefix}kc_lf_activity_logs" );
		}

		return $result;
	}

	/**
	 * No items
	 *
	 * @since 1.0.0
	 */
	public function no_items() {
		esc_html_e( 'No Logs Found', 'logify' );
	}
}
