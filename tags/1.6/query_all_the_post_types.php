<?php
/**
 * Plugin Name: Query All The Post Types
 * Plugin URI: https://wordpress.org/plugins/query-all-the-post-types/
 * Description: Returns a list of all the post types on your current install of wordpress.
 * Version: 1.6
 * Author: Russell Aaron
 * Author URI: http://russellenvy.com
 * Text Domain: query_all_the_post_types
 * License: GPL2
 */
  if ( ! defined( 'ABSPATH' ) ) {exit;}
  include 'create-menu.php';
  include 'qatp.php';
  include 'enqueue-scripts.php';
?>