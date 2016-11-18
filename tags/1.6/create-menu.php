<?php
//creates the options page insde of wp-admin dashboard.
  add_action( 'admin_menu', 'wpquery_all_post_types_custom_menu_page' );
  function wpquery_all_post_types_custom_menu_page(){
  	add_options_page( 'Query All The Posts', 'Query The CPTs', 'manage_options', 'query_all_the_post_types', 'query_all_the_post_types_custom_menu_page');
  }
//code used from Hugh Lashbrooke - http://www.hughlashbrooke.com/2012/07/wordpress-add-plugin-settings-link-to-plugins-page/
  function qatpt_settings_link( $links ) {
  $settings_link = '<a href="' . admin_url() . 'options-general.php?page=query_all_the_post_types">' . __( 'Settings' ) . '</a>';
      array_push( $links, $settings_link );
    	return $links;
  }
  add_filter( "plugin_action_links", 'qatpt_settings_link' );
?>