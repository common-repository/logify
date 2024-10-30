<?php

namespace KaizenCoders\Logify\DB;

/**
 * class
 *
 * @since 1.0.0
 */
class DB {
	/**
	 *
	 * @since 1.0.0
	 *
	 * @var Object|Activity_Logs
	 */
	public $activity_logs;

	/**
	 * constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->activity_logs = new Activity_Logs();
	}
}
