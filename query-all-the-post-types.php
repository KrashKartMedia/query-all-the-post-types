<?php
/**
 * Plugin Name: Query All The Post Types
 * Plugin URI:  https://wordpress.org/plugins/query-all-the-post-types/
 * Description: A developer tool that displays all registered post types with their settings, supports, taxonomies, labels, and REST API endpoints. Find it under <strong>Tools &rarr; Query Post Types</strong>.
 * Version:     2.0.0
 * Author:      Russell Aaron
 * Author URI:  https://russellenvy.com
 * Text Domain: query-all-the-post-types
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package QueryAllThePostTypes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'QATP_VERSION', '2.0.0' );
define( 'QATP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'QATP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'QATP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once QATP_PLUGIN_DIR . 'includes/class-qatp-plugin.php';
require_once QATP_PLUGIN_DIR . 'includes/class-qatp-admin-page.php';
require_once QATP_PLUGIN_DIR . 'includes/class-qatp-post-type-classifier.php';
require_once QATP_PLUGIN_DIR . 'includes/class-qatp-post-type-renderer.php';
require_once QATP_PLUGIN_DIR . 'includes/class-qatp-signal-settings.php';
require_once QATP_PLUGIN_DIR . 'includes/class-qatp-signal-receiver.php';

add_action( 'plugins_loaded', array( 'QATP_Plugin', 'init' ) );

// Activation hook - record install time.
register_activation_hook( __FILE__, 'qatp_activate' );

// Deactivation hook - remove Signal Hub credentials.
register_deactivation_hook( __FILE__, 'qatp_deactivate' );

/**
 * Run on plugin activation.
 */
function qatp_activate() {
	// Record install time for signal delay calculations.
	if ( ! get_option( 'qatp_installed_time' ) ) {
		update_option( 'qatp_installed_time', time() );
	}
}

/**
 * Run on plugin deactivation.
 * Removes Signal Hub settings from the database.
 */
function qatp_deactivate() {
	// Remove Signal Hub settings.
	delete_option( 'qatp_signal_settings' );

	// Remove signal transients.
	delete_transient( 'signal_last_fetch_qatp' );
	delete_transient( 'signal_data_qatp' );
}
