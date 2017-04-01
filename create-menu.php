<?php
if ( ! defined( 'ABSPATH' ) ) {exit;}
//creates the options page insde of wp-admin dashboard.
  add_action( 'admin_menu', 'wpquery_all_post_types_custom_menu_page' );
  function wpquery_all_post_types_custom_menu_page(){
  	add_options_page( 'Query All The Posts', 'Query The CPTs', 'manage_options', 'query_all_the_post_types', 'query_all_the_post_types_custom_menu_page');
  }
?>