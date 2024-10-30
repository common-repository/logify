<?php
// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared

namespace KaizenCoders\Logify\DB;

use KaizenCoders\Logify\Cache;

/**
 * Base_DB base class
 *
 * @since 1.0.0
 */
abstract class Base_DB {
	/**
	 * @since 1.0.0
	 * @var $table_name
	 */
	public $table_name;

	/**
	 * @since 1.0.0
	 * @var $version
	 */
	public $version;

	/**
	 * @since 1.0.0
	 * @var $primary_key
	 */
	public $primary_key;

	public $db;

	/**
	 * Base_DB constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		global $wpdb;

		$this->db = $wpdb;
	}

	/**
	 * Get default columns
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function get_columns() {
		return [];
	}

	/**
	 * @return array
	 * @since 1.0.0
	 */
	public function get_column_defaults() {
		return [];
	}

	/**
	 * Retrieve a row by the primary key
	 *
	 * @param  string  $output
	 *
	 * @param        $row_id
	 *
	 * @return array|object|void|null
	 * @since 1.0.0
	 *
	 */
	public function get( $row_id, $output = ARRAY_A ) {
		return $this->db->get_row( $this->db->prepare( "SELECT * FROM {$this->table_name} WHERE %s = %s LIMIT 1;",
			$this->primary_key, $row_id ), $output );
	}

	/**
	 * Insert a new row
	 *
	 * @param  string  $type
	 *
	 * @param        $data
	 *
	 * @return int
	 * @since 1.0.0
	 *
	 */
	public function insert( $data, $type = '' ) {
		// Set default values
		$data = wp_parse_args( $data, $this->get_column_defaults() );

		do_action( 'kaizencoders_logify_pre_insert_' . $type, $data );

		// Initialise column format array
		$column_formats = $this->get_columns();

		// Force fields to lower case
		$data = array_change_key_case( $data );

		// White list columns
		$data = array_intersect_key( $data, $column_formats );

		// Reorder $column_formats to match the order of columns given in $data
		$data_keys      = array_keys( $data );
		$column_formats = array_merge( array_flip( $data_keys ), $column_formats );

		$this->db->insert( $this->table_name, $data, $column_formats );
		$wpdb_insert_id = $this->db->insert_id;

		do_action( 'kaizencoders_logify_post_insert_' . $type, $wpdb_insert_id, $data );

		return $wpdb_insert_id;
	}
}