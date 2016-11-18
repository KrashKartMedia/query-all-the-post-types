<?php
/**
 * Plugin Name: Query All The Post Types
 * Plugin URI: https://wordpress.org/plugins/query-all-the-post-types/
 * Description: Returns a list of all the post types on your current install of wordpress.
 * Version: 1.6.1
 * Author: Russell Aaron
 * Author URI: http://russellenvy.com
 * Text Domain: query_all_the_post_types
 * License: GPL2
 */
  if ( ! defined( 'ABSPATH' ) ) {exit;}
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
  include 'enqueue-scripts.php';


?>