<?php
/**
 * Plugin Name: Query All The Post Types
 * Plugin URI: https://wordpress.org/plugins/query-all-the-post-types/
 * Description: Returns a list of all the post types on your current install of wordpress.
 * Version: 1.2
 * Author: Russell Aaron
 * Author URI: http://russellenvy.com
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
  	add_options_page( 'Query All The Posts', 'Query The CPTs', 'manage_options', 'query_all_the_post_types', 'query_all_the_post_types_custom_menu_page'); 
  }

  //code used from Hugh Lashbrooke - http://www.hughlashbrooke.com/2012/07/wordpress-add-plugin-settings-link-to-plugins-page/
  function qatpt_settings_link( $links ) {
  $settings_link = '<a href="/wp-admin/options-general.php?page=query_all_the_post_types">' . __( 'Settings' ) . '</a>';
      array_push( $links, $settings_link );
    	return $links;
  }
  $plugin = plugin_basename( __FILE__ );
  add_filter( "plugin_action_links_$plugin", 'qatpt_settings_link' );

  //here is where we the post types thanks to https://codex.wordpress.org/Function_Reference/get_post_types
  function query_all_the_post_types_function() {
    $all_post_types = get_post_types();
    foreach ( $all_post_types as $post_type ) {
        // revision/nav_bar_item post types
        if ( in_array( $post_type, array( 'revision', 'nav_menu_item' ) ) ) {
            // Custom stuff here
        } else {
          //start the accordion div here
        	echo '<h3>' . esc_attr__( $post_type ) . '</h3>';
          echo '<div>';
          echo 'Post Type: ' . esc_attr__( $post_type ) . '<p><a class="posttype" href="' . admin_url( 'edit.php?post_type=' . $post_type ) . '"> Click here to see all the posts in ' . esc_attr__( $post_type ) . '&rsquo;s</a>';
          echo '<hr />';
          echo '<p><b>Taxonomies</b></p>';
          //let's query all the taxonomies per post type and list them out.
            $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
          foreach ( $taxonomy_objects as $taxonomy_object ) {
              //lets check to see if there are any of these, and remove them
              if ( in_array( $taxonomy_object, array( 'post_format' ) ) ) {
            // Custom stuff here
            } else {
              //if there is a taxonomy, echo it out
              echo '' .esc_attr__( $taxonomy_object ). ' - ';
              echo '<em><a href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '"> Click here to see all the posts in ' . esc_attr__( $taxonomy_object ) . '&rsquo;s</a></em></p>';
            }
          }
          //stop the accordion div here
         echo '</div>';
        }
    }
  }

  // create page in the admin dashboard
  function query_all_the_post_types_custom_menu_page(){
    	echo '<div class="wrap">';
    	echo '<p>';
  		echo '<h2>Query All The Post Types</h2>';
  		echo 'These are all of the <b>post types & custom post types</b> that are currently active (registered) on your WordPress install right now.</p> <p>We have <strong> excluded the <em>nav_menu_item</em> & <em>revision</em></strong> post types. These post types do not have an <strong>edit.php?post_type=</strong> page to link back to. They are still active on your WordPress install, jut not shown here.</p> <p>Please note that by deactivating a theme or plugin, a post type or custom post type will no longer be displayed on this page.</p>';

      echo '<p><b>New</b>: Not only are you being shown all the post types, you are now being shown each taxonomy that is related to the post type.</p>';
  		echo '<hr />';
      //add in the random accordion with a crazy name
      echo '<div id="accordiongs">';
  		echo query_all_the_post_types_function('', '');
      //stop the random accordion with a crazy name
      echo '</div>';
    	echo '</p>';
      echo '</div>';
      echo '<hr>';
      echo 'Query All The Post Types | Version 1.2';
    };

  //lets enqueue some scripts here
  add_action( 'admin_enqueue_scripts', 'qatptypes_admin_enqueue_scripts' );
  function qatptypes_admin_enqueue_scripts() {    
  //run a check to make sure that we're only queing scripts on our admin page
  if (isset($_GET['page']) && $_GET['page'] == 'query_all_the_post_types') {
      //enqueue bootstrap - make responsive better
      $handle = 'query-all-the-post-types';
      $src    = plugin_dir_url( __FILE__) . 'css/bootstrap/css/bootstrap.min.css';
      //enqueue the styles
      wp_register_style( $handle, $src );
      wp_enqueue_style( $handle );
      wp_enqueue_style( 'query-all-the-post-types-single', plugin_dir_url( __FILE__) . 'css/settings-styles.css' );
      wp_enqueue_style( 'query-all-the-post-types-jquery', plugin_dir_url( __FILE__) . 'css/jquery-theme-roller/jquery-ui.css' );
      //enqueue the js
      wp_enqueue_script( 'query-all-the-post-types-script', plugin_dir_url( __FILE__) . 'js/query-all-the-post-types.js', array( 'jquery-ui-accordion', ), '1.1' );
      };   
  }
?>