<?php
/**
 * Plugin Name: Query All The Post Types
 * Plugin URI: https://wordpress.org/plugins/query-all-the-post-types/
 * Description: A top level view of all the active post types, custom post types & associated taxonomies currently registered on your WordPress install.
 * Version: 1.9.4
 * Author: Russell Aaron
 * Author URI: http://russellenvy.com
 * Text Domain: query_all_the_post_types
 * License: GPL2
 */
  if ( ! defined( 'ABSPATH' ) ) {exit;}
define( 'qatp_version', '1.9.4' );
include 'create-menu.php';
//code used from Hugh Lashbrooke - http://www.hughlashbrooke.com/2012/07/wordpress-add-plugin-settings-link-to-plugins-page/
  function qatpt_settings_link( $links ) {
  $settings_link = '<a href="/wp-admin/options-general.php?page=query_all_the_post_types">' . __( 'Settings' ) . '</a>';
      array_push( $links, $settings_link );
    	return $links;
  }
  $plugin = plugin_basename( __FILE__ );
  add_filter( "plugin_action_links_$plugin", 'qatpt_settings_link' );
  include 'qatp.php';
?>