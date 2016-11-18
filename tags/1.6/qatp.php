<?php
//here is where we the post types thanks to https://codex.wordpress.org/Function_Reference/get_post_types
  function query_all_the_post_types_function() {
    $all_post_types = get_post_types();
    foreach ( $all_post_types as $post_type ) {
        // revision/nav_bar_item post types
        if ( in_array( $post_type, array( 'revision', 'tribe-ea-record', 'deleted_event', 'nav_menu_item', 'edd_log', 'edd_payment', 'edd_discount', 'product_variation', 'shop_order_refund' ) ) ) {
            // Custom stuff here
        } else {
          //start the accordion div here
        	echo '<h3>' . esc_attr__( $post_type ) . '</h3>';
          echo '<div>';
          echo 'Post Type: ' . esc_attr__( $post_type ) . '<p><a class="posttype" href="' . admin_url( 'edit.php?post_type=' . $post_type ) . '"> See all ' . esc_attr__( $post_type ) . '&rsquo;s</a>';
          echo '<hr />';
          echo '<p><b>Taxonomies</b></p>';
          //let's query all the taxonomies per post type and list them out.
            $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
          foreach ( $taxonomy_objects as $taxonomy_object ) {
              //lets check to see if there are any of these, and remove them
              if ( in_array( $taxonomy_object, array( 'post_format', 'product_type' ) ) ) {
            // Custom stuff here
            } else {
              //if there is a taxonomy, echo it out
              echo '' .esc_attr__( $taxonomy_object ). ' - ';
              echo '<em><a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '"> See all ' . esc_attr__( $taxonomy_object ) . '&rsquo;s</a></em></p>';
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
      echo '<h2>Query All The Post Types</h2>';
        echo '<div class="row">';
          echo '<div class="col-md-8">';
      		echo '<p>These are all of the <b>post types & custom post types</b> that are currently active (registered) on your WordPress install right now.</p> <p>We have excluded <strong><a href="#TB_inline?width=600&height=550&inlineId=modal-window-id" class="thickbox">a list</a></strong> of post types. They are still active on your WordPress install, just not shown on this page.</p> <p>Please note that by deactivating a theme or plugin, a post type or custom post type will no longer be displayed on this page.</p>';
          echo '<p><b>New</b>: Not only are you being shown post types, you are now being shown each taxonomy that is related to the post type.</p>';
          //add thickbox
            add_thickbox();
            echo '<div id="modal-window-id" style="display:none;"><p><h5>Post Types Being Excluded From Our List</h5> <ul><li>revision</li><li>nav_menu_item</li><li>edd_log</li><li>edd_payment</li><li>edd_discount</li><li>product_variation</li><li>shop_order_refund</li></li><li>product_type</li></ul></p></div>';
          //stop thickbox
          //add in the random accordion with a crazy name
          echo '<div id="accordiongs">';
      		echo query_all_the_post_types_function('', '');
          //stop the random accordion with a crazy name
          echo '</div>';
        	echo '</p>';
          echo '</div>';
          //stop col-8
          echo '<div class="col-md-4">';
          //start add box
          echo '<div style="border:1px solid #e5e5e5; padding:10px; margin-bottom:10px;">';
          echo '<h4>Custom Post Type UI</h4>';
          echo '<p><img style="padding:6px;" align="left" src="' . plugin_dir_url( __FILE__) . '/img/cptui_9f6837bc649305a3397576efe6ec0126_97c3e299382fcfc5613639540a60e7b0.png" width="100" height="100">';
          echo 'This plugin provides an easy to use interface for creating and administrating custom post types and taxonomies in WordPress. This plugin is created for WordPress 3.0 and higher.</p>';
          echo '<p>Cost: Free | <a target="_blank" href="https://wordpress.org/plugins/custom-post-type-ui/">Download</a> | <a href="/wp-admin/plugin-install.php?s=custom+post+type+ui&tab=search&type=term">Install</a></p>';
          echo '</div>';
          //stop add box
          //start add box
          echo '<div style="border:1px solid #e5e5e5; padding:10px; margin-bottom:10px;">';
          echo '<h4>Pods</h4>';
          echo '<p><img style="padding:6px;" align="left" src="' . plugin_dir_url( __FILE__) . '/img/pods_a9e2c10a8cf9a9f0e36e55bcd23877a2_e4290e6893d6dcd1241e393940df1b55.png" width="100" height="100">';
          echo 'Pods is a framework for creating, managing, and deploying customized content types and fields. Create any type of content that you want -- small or large -- we havve got you covered. </p>';
          echo '<p>Cost: Free | <a target="_blank" href="https://wordpress.org/plugins/pods/">Download</a> | <a target="_blank" href="https://www.youtube.com/watch?v=bYEE2i3nPOM">Youtube Tutorial</a> | <a href="/wp-admin/plugin-install.php?s=pods&tab=search&type=term">Install</a></p>';
          echo '</div>';
          //stop add box
          //start add box
          echo '<div style="border:1px solid #e5e5e5; padding:10px; margin-bottom:10px;">';
          echo '<h4>Custom Post Type UI Extended</h4>';
          echo '<p><img style="padding:6px;" align="left" src="' . plugin_dir_url( __FILE__) . '/img/cptuiextended_241fb3ff778f8453352d837a5be006e4_bb289f97f006a3e9dde42f35beb20cd3.png" width="100" height="100">';
          echo 'Custom Post Type UI Extended makes displaying custom post type data simple. Take the power of CPTUI to the next level by adding CPT data to your pages and posts without hassle.</p>';
          echo '<p>Cost: $19.00 | <a target="_blank" href="https://pluginize.com/product/custom-post-type-ui-extended/">Purchase</a> | <a target="_blank" href="https://www.youtube.com/embed/y8VSRWe5i0s">Youtube Tutorial</a></p>';
          echo '</div>';
          //stop add box
          echo '<p><small><b>Note:</b> These advertisments are not paid in anyway. We simply believe in the products.</small></p>';
          echo '</div>';
          //stop col-4
        echo "</div>";

        echo '<hr />';
        echo 'Query All The Post Types | Version 1.5';
      echo '</div>';
    };
?>