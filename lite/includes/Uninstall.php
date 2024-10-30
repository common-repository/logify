<?php


namespace KaizenCoders\Logify;


class Uninstall {
	/**
	 * Init Uninstall
	 *
	 * @since 1.8.1
	 */
	public function init() {
		logify_fs()->add_action( 'after_uninstall', [ $this, 'uninstall_cleanup' ] );
	}

	/**
	 * Delete plugin data
	 *
	 * @since 1.8.1
	 */
	public function uninstall_cleanup() {
		// TODO: Do Uninstall Cleanup.
	}
}