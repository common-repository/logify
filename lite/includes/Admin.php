<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       https://kaizencoders.com
 * @since      1.0.0
 *
 * @package    Logify
 * @subpackage Logify/admin
 */

namespace KaizenCoders\Logify;

use KaizenCoders\Logify\Admin\Activity_Logs_Table;
use KaizenCoders\Logify\Helper;

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Logify
 * @subpackage Logify/admin
 * @author     KaizenCoders <hello@kaizencoders.com>
 */
class Admin {
	/**
	 * The plugin's instance.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    Plugin $plugin This plugin's instance.
	 */
	private $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 *
	 * @param  Plugin $plugin  This plugin's instance.
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Logify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Logify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( Helper::is_plugin_admin_screen() ) {

			\wp_enqueue_style(
				'logify-main',
				\plugin_dir_url( __DIR__ ) . 'dist/styles/app.css',
				array(),
				$this->plugin->get_version(),
				'all'
			);
		}
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Logify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Logify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	}

	public function add_admin_menu() {
		add_menu_page(
			__( 'Logify', 'logify' ),
			__( 'Logify', 'logify' ),
			'manage_options',
			'logify',
			array(
				$this,
				'render_dashboard',
			),
			'dashicons-buddicons-activity',
			30
		);

		add_submenu_page(
			'logify',
			__( 'Dashboard', 'logify' ),
			__( 'Dashboard', 'logify' ),
			'manage_options',
			'logify',
			array(
				$this,
				'render_dashboard',
			)
		);

		$hook = add_submenu_page(
			'logify',
			__( 'Activity Logs', 'logify' ),
			__( 'Activity Logs', 'logify' ),
			'manage_options',
			'logify-activity-logs',
			array(
				$this,
				'render_logs_page',
			)
		);

		add_action( "load-$hook", array( '\KaizenCoders\Logify\Admin\Activity_Logs_Table', 'screen_options' ) );

		do_action( 'kaizencoders_logify_admin_menu' );
	}

	public function render_dashboard() {
		include_once KAIZENCODERS_LOGIFY_ADMIN_TEMPLATES_DIR . '/landing.php';
	}

	public function render_logs_page() {
		$logs_table = new Activity_Logs_Table();
		$logs_table->render();
	}
}
