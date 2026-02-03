<?php
/**
 * Uninstall Query All The Post Types
 *
 * This file runs when the plugin is deleted from the Plugins page.
 * Currently, this plugin does not store any data in the database,
 * so there is nothing to clean up.
 *
 * @package QueryAllThePostTypes
 */

// Exit if uninstall not called from WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// No data to clean up - plugin does not store options, transients, or user meta.
