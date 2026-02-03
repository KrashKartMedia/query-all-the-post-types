<?php
/**
 * Plugin Name: Query All The Post Types
 * Plugin URI:  https://wordpress.org/plugins/query-all-the-post-types/
 * Description: A developer tool that displays all registered post types with their settings, supports, taxonomies, labels, and REST API endpoints. Find it under <strong>Tools &rarr; Query Post Types</strong>.
 * Version:     2.0.1
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

define( 'QATP_VERSION', '2.0.1' );
define( 'QATP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'QATP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'QATP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once QATP_PLUGIN_DIR . 'includes/class-qatp-plugin.php';
require_once QATP_PLUGIN_DIR . 'includes/class-qatp-admin-page.php';
require_once QATP_PLUGIN_DIR . 'includes/class-qatp-post-type-classifier.php';
require_once QATP_PLUGIN_DIR . 'includes/class-qatp-post-type-renderer.php';

add_action( 'plugins_loaded', array( 'QATP_Plugin', 'init' ) );
