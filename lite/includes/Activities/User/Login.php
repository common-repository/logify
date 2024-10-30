<?php

namespace KaizenCoders\Logify\Activities\User;

use KaizenCoders\Logify\Helper;

class Login {
	protected $event_id = 1000;

	private $event_type;

	protected $severity = 100;

	public function init() {
		add_action( 'wp_login', array( $this, 'log_login' ), 10, 2 );
	}

	public function log_login( $user_login, $user ) {
		$this->log(
			array(
				'event_id'   => $this->event_id,
				'object'     => 'user',
				'event_type' => 'login',
				'severity'   => $this->severity,
				'user_id'    => $user->ID,
				'username'   => $user->user_login,
				'session_id' => 'Users',
				'created_at' => Helper::get_current_date_time(),
			)
		);
	}

	public function log( $activity ) {
		kaizencoders_logify()->db->activity_logs->insert( $activity );
	}
}
