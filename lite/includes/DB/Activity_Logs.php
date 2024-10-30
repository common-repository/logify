<?php

namespace KaizenCoders\Logify\DB;

use KaizenCoders\Logify\Helper;

class Activity_Logs extends Base_DB {
	/**
	 * Table Name
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $table_name;

	/**
	 * Table Version
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $version;

	/**
	 * Primary key
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $primary_key;

	/**
	 * Initialize
	 *
	 * constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct();

		$this->table_name = $this->db->prefix . 'kc_lf_activity_logs';

		$this->version = '1.0';

		$this->primary_key = 'id';
	}

	/**
	 * Get columns and formats
	 *
	 * @since 1.0.0
	 */
	public function get_columns() {
		return [
			'id'          => '%d',
			'site_id'     => '%d',
			'event_id'    => '%d',
			'object'      => '%s',
			'event_type'  => '%s',
			'severity'    => '%d',
			'ip'          => '%s',
			'user_agent'  => '%s',
			'user_roles'  => '%s',
			'user_id'     => '%d',
			'username'    => '%s',
			'session_id'  => '%s',
			'post_id'     => '%d',
			'post_type'   => '%s',
			'post_status' => '%s',
			'created_at'  => '%s',
		];
	}

	/**
	 * Get default column values.
	 *
	 * @since 1.0.0
	 */
	public function get_column_defaults() {
		return [
			'site_id'     => 1,
			'event_id'    => '',
			'object'      => '',
			'event_type'  => '',
			'severity'    => 0,
			'ip'          => '',
			'user_agent'  => '',
			'user_roles'  => '',
			'user_id'     => null,
			'username'    => null,
			'session_id'  => null,
			'post_id'     => null,
			'post_type'   => null,
			'post_status' => null,
			'created_at'  => Helper::get_current_date_time(),
		];
	}
}
