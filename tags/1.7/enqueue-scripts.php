<?php 
  function qatptypes_admin_enqueue_scripts() {
  //run a check to make sure that we're only queing scripts on our admin page
  if (isset($_GET['page']) && $_GET['page'] == 'query_all_the_post_types') {
      $handle = 'query-all-the-post-types';
      $src    = plugin_dir_url( __FILE__) . 'css/bootstrap/css/bootstrap.min.css';
      wp_register_style( $handle, $src );
      wp_enqueue_style( $handle );
      wp_enqueue_style( 'query-all-the-post-types-single', plugin_dir_url( __FILE__) . 'css/settings-styles.css' );
      wp_enqueue_style( 'query-all-the-post-types-jquery', plugin_dir_url( __FILE__) . 'css/jquery-theme-roller/jquery-ui.min.css' );
      wp_enqueue_script( 'query-all-the-post-types-script', plugin_dir_url( __FILE__) . 'js/query-all-the-post-types.js', array( 'jquery-ui-accordion', ), '1.1' );
      };
  }
    add_action( 'admin_enqueue_scripts', 'qatptypes_admin_enqueue_scripts' );
?>