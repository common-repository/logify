<?php
/**
 *
 * Logify
 *
 * Simple and Easy To Use Activity Log Plugin For WordPress
 *
 * @link      http://wordpress.org/plugins/logify
 * @author    KaizenCoders <hello@kaizencoders.com>
 * @license   GPL-2.0+
 * @package   Logify
 * @copyright 2024 KaizenCoders
 *
 * @wordpress-plugin
 * Plugin Name:       Logify
 * Plugin URI:        https://kaizencoders.com/logify
 * Description:       Simple and Easy To Use Activity Log Plugin For WordPress
 * Version:           1.0.9
 * Author:            KaizenCoders
 * Author URI:        https://kaizencoders.com
 * Tested up to:      6.6.2
 * Requires PHP:      5.6
 * Text Domain:       logify
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'KAIZENCODERS_LOGIFY_PLUGIN_VERSION' ) ) {
	define( 'KAIZENCODERS_LOGIFY_PLUGIN_VERSION', '1.0.9' );
}

if ( function_exists( 'logify_fs' ) ) {
	logify_fs()->set_basename( true, __FILE__ );
} else {
	// Create a helper function for easy SDK access.
	function logify_fs() {
		global $logify_fs;

		if ( ! isset( $logify_fs ) ) {
			// Include Freemius SDK.
			require_once dirname( __FILE__ ) . '/libs/fs/start.php';

			$logify_fs = fs_dynamic_init( [
				'id'                  => '16732',
				'slug'                => 'logify',
				'type'                => 'plugin',
				'public_key'          => 'pk_cb06f3bfd72f236ba69dad9f6f17b',
				'is_premium'          => false,
				'has_premium_version' => true,
				'has_addons'          => false,
				'has_paid_plans'      => true,
				'menu'                => [
					'slug'       => 'logify',
					'first-path' => 'admin.php?page=logify',
				],
			] );
		}

		return $logify_fs;
	}

	// Init Freemius.
	logify_fs();

	// Use custom icon for onboarding.
	logify_fs()->add_filter( 'plugin_icon', function () {
		return dirname( __FILE__ ) . '/assets/images/plugin-icon.png';
	} );

	// Signal that SDK was initiated.
	do_action( 'logify_fs_loaded' );


	if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
		require_once __DIR__ . '/vendor/autoload.php';
	}

	if ( ! function_exists( 'kaizencoders_logify_fail_php_version_notice' ) ) {

		/**
		 * Admin notice for minimum PHP version.
		 *
		 * Warning when the site doesn't have the minimum required PHP version.
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		function kaizencoders_logify_fail_php_version_notice() {
			/* translators: %s: PHP version */
			$message      = sprintf( esc_html__( 'Logify requires PHP version %s+, plugin is currently NOT RUNNING.',
				'logify' ), '5.6' );
			$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}
	}

	if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {

		add_action( 'admin_notices', 'kaizencoders_logify_fail_php_version_notice' );

		return;
	}

	// Plugin Folder Path.
	if ( ! defined( 'KAIZENCODERS_LOGIFY_PLUGIN_DIR' ) ) {
		define( 'KAIZENCODERS_LOGIFY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}

	if ( ! defined( 'KAIZENCODERS_LOGIFY_PLUGIN_BASE_NAME' ) ) {
		define( 'KAIZENCODERS_LOGIFY_PLUGIN_BASE_NAME', plugin_basename( __FILE__ ) );
	}

	if ( ! defined( 'KAIZENCODERS_LOGIFY_PLUGIN_FILE' ) ) {
		define( 'KAIZENCODERS_LOGIFY_PLUGIN_FILE', __FILE__ );
	}

	if ( ! defined( 'KAIZENCODERS_LOGIFY_PLUGIN_URL' ) ) {
		define( 'KAIZENCODERS_LOGIFY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in lib/Activator.php
	 */
	\register_activation_hook( __FILE__, '\KaizenCoders\Logify\Activator::activate' );

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in lib/Deactivator.php
	 */
	\register_deactivation_hook( __FILE__, '\KaizenCoders\Logify\Deactivator::deactivate' );

	if ( ! function_exists( 'kaizencoders_logify' ) ) {
		/**
		 * Initialize.
		 *
		 * @since 1.0.0
		 */
		function kaizencoders_logify() {
			return \KaizenCoders\Logify\Plugin::instance();
		}
	}

	add_action( 'plugins_loaded', function () {
		kaizencoders_logify()->run();
	} );
}

