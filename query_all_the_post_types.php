<?php
/**
 * Plugin Name: Query All The Post Types
 * Plugin URI: https://github.com/KrashKartMedia/query-all-the-post-types
 * Description: Returns a list of all the post types on your current install of wordpress.
 * Version: 1.0
 * Author: Russell Aaron
 * Author URI: http://russeenvy.com
 * Text Domain: query_all_the_post_types
 * License: GPL2
 * GitHub Plugin URI: https://github.com/KrashKartMedia/query-all-the-post-types
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
 
//creates the options page insde of wp-admin dashboard.
add_action( 'admin_menu', 'wpquery_all_post_types_custom_menu_page' );
//define the page title and attributes
function wpquery_all_post_types_custom_menu_page(){
	add_menu_page( 'Query All The Posts', 'Query The CPTs', 'manage_options', 'query_all_the_post_types', 'query_all_the_post_types_custom_menu_page'); 
}

//code used from Hugh Lashbrooke - http://www.hughlashbrooke.com/2012/07/wordpress-add-plugin-settings-link-to-plugins-page/
function qatpt_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=query_all_the_post_types">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'qatpt_settings_link' );


function query_all_the_post_types_function() {
  $all_post_types = get_post_types();
  foreach ( $all_post_types as $post_type ) {
      // revision/nav_bar_item post types
      if ( in_array( $post_type, array( 'revision', 'nav_menu_item' ) ) ) {
          // Custom stuff here
      } else {
      	echo '<p>' .esc_attr__( $post_type ). ' - ';
          echo ' <a href="' . admin_url( 'edit.php?post_type=' . $post_type ) . '"> view all ' . esc_attr__( $post_type ) . '&rsquo;s</a></p>';
      }
  }
}

// create page in the admin dashboard
function query_all_the_post_types_custom_menu_page(){
   	
	echo '<div class="wrap">';
		echo '<p>';
			echo '<h2>Query All The Post Types</h2>';
			echo 'These are all of the <b>custom post types</b> that are currently active on your WordPress install right now.</p> <p>We have <strong> excluded the <em>nav_menu_item</em> & <em>revision</em></strong> post types. These post types do not have an <strong>edit.php?post_type=</strong> page to link back to. They are still active on your WordPress install.</p> <p>Please note that by deactivating a theme or plugin, the custom post type will no longer be displayed on this page.</p>';
			echo '<hr />';
			echo query_all_the_post_types_function('', '');
		echo '</p>';
   	echo '</div>';

   	echo '<hr>';
   	echo 'Query All The Post Types | Version 1.0';

};

