<?php
/**
 * Uninstall Query All The Post Types
 *
 * Cleans up all plugin data when the plugin is deleted.
 * This runs when the plugin is deleted from the Plugins page,
 * NOT when it's simply deactivated.
 *
 * @package QueryAllThePostTypes
 */

// Exit if uninstall not called from WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete Signal Hub settings (should already be removed on deactivation, but double-check).
delete_option( 'qatp_signal_settings' );

// Delete transients.
delete_transient( 'signal_last_fetch_qatp' );
delete_transient( 'signal_data_qatp' );

// Delete install time.
delete_option( 'qatp_installed_time' );

// Clean up user meta for dismissed signals.
global $wpdb;

// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$wpdb->delete(
	$wpdb->usermeta,
	array( 'meta_key' => 'signal_status_qatp' ) // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
);
