<?php
//here is where we the post types thanks to https://codex.wordpress.org/Function_Reference/get_post_types
  function query_all_the_post_types_function() {
    $all_post_types = get_post_types();
    foreach ( $all_post_types as $post_type ) {
      $obj = get_post_type_object( $post_type );
        // if core / hidden post types with no edit screen
      if ( in_array( $post_type, array( 'revision', 'tribe-ea-record', 'deleted_event', 'nav_menu_item', 'edd_log', 'edd_payment', 'edd_discount', 'product_variation', 'shop_order_refund', 'custom_css', 'customize_changeset', 'give_log', 'give_payment', '_pods_pod', '_pods_field' ) ) ) {
        echo '<div class="postbox">';
        echo '<div style="background-color:#82878c;width:100%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>' . esc_attr__( $post_type ) . ' - hidden cpt</span></h2></div>';
          echo '<div class="inside">';
            echo '<table class="widefat" cellspacing="0">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                     echo 'Plural Name:' . ' ' . $obj->labels->name . '' ;
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Singular name:' . ' ' . $obj->labels->singular_name . '' ;
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                     echo 'Menu Name:' . ' ' . $obj->labels->menu_name . '' ;
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  $is_pub_query = $obj->publicly_queryable;
                    if ($is_pub_query === true){
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'nav_menu', 'yst_prominent_words', 'give_log_type', 'edd_log_type', 'product_shipping_class' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>, ';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
                   }
                  //stop the TR's
              echo '</tbody>';
            echo '</table>';
          echo '</div>';
      echo '</div>';
      } 
      //if contact form 7
        elseif ( in_array( $post_type, array( 'wpcf7_contact_form' ) ) ) {
        echo '<div class="postbox">';
        echo '<div style="background-color:#b4b9be;width:50%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>' . esc_attr__( $post_type ) . ' - other</span></h2></div>';
        echo '<div style="width:50%;display:inline-block;text-align:right;"><h2><span>
        <a class="button-secondary" href="' . admin_url( 'admin.php?page=wpcf7') . '">View All</a> 
        <a class="button-secondary" href="' . admin_url( 'admin.php?page=wpcf7-new' ) . '">Add New</a>
        </span></h2></div>';
          echo '<div class="inside">';
            echo '<table class="widefat" cellspacing="0">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                     echo 'Plural Name:' . ' ' . $obj->labels->name . '' ;
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Singular name:' . ' ' . $obj->labels->singular_name . '' ;
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                     echo 'Menu Name:' . ' ' . $obj->labels->menu_name . '' ;
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  $is_pub_query = $obj->publicly_queryable;
                    if ($is_pub_query === true){
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>, ';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
                   }
                  //stop the TR's
              echo '</tbody>';
            echo '</table>';
          echo '</div>';
      echo '</div>';
        }  
      else {
      echo '<div class="postbox">';
        echo '<div style="background-color: #00a0d2;color: #fff;">';
          echo '<div style="width:50%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>' . esc_attr__( $post_type ) . ' - regular cpt</span></h2></div>';
          echo '<div style="width:50%;display:inline-block;text-align:right;"><h2><span><a class="button-secondary" href="' . admin_url( 'edit.php?post_type=' . $post_type ) . '">View All</a> <a class="button-secondary" href="' . admin_url( 'post-new.php?post_type=' . $post_type ) . '">Add New</a>
          </span></h2></div>';
        echo '</div>';
          echo '<div class="inside">';
            echo '<table class="widefat" cellspacing="0">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                     echo 'Plural Name:' . ' ' . $obj->labels->name . '' ;
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Singular name:' . ' ' . $obj->labels->singular_name . '' ;
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                     echo 'Menu Name:' . ' ' . $obj->labels->menu_name . '' ;
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  $is_pub_query = $obj->publicly_queryable;
                    if ($is_pub_query === true){
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'yst_prominent_words', 'product_shipping_class' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>,';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
                   }
                  //stop the TR's
              echo '</tbody>';
            echo '</table>';
          echo '</div>';
      echo '</div>';
     }
    }
  }
  // create page in the admin dashboard
  function query_all_the_post_types_custom_menu_page(){
    //start wrap
    	echo '<div class="wrap">';
        echo '<h2>Query All The Post Types</h2>';
          echo '<div id="poststuff">';
            echo '<div id="post-body" class="metabox-holder columns-2">';
              echo '<div id="post-body-content">';
                echo '<div class="meta-box-sortables ui-sortable">';
                  echo query_all_the_post_types_function('', '');
                echo '</div>';
              echo '</div>';
    //start sidebar
    echo '<div id="postbox-container-1" class="postbox-container">';
      echo '<div class="meta-box-sortables">';
      //start postbox
        echo '<div class="postbox">';
          echo '<h2 style="background-color:#0074a2; color:#fff;"><span>About the plugin</span></h2>';
            echo '<div class="inside">';
              echo '<p>These are all of the <b>post types, custom post types &amp; associated taxonomies</b> currently active (registered) on your WordPress install right now.</p>';
            echo '</div>';
          echo ' </div>';
      //stop postbox
          //start postbox
         echo '<div class="postbox">';
            echo '<h2 style="background-color:#0074a2; color:#fff;"><span>Regular, Hidden, &amp; Other CPTS</span></h2>';
              echo '<div class="inside">';
                echo '<p><strong>Regular CPT</strong>: Registered post type showing all posts inside of the post type.</p>';
                echo '<p><strong>Hidden Post Types</strong>: Registered post types without an edit screen.</p>';
                echo '<p><strong>Other</strong>: A custom post type linking to a custom edit screen.</p>';
              echo '</div>';
            echo '</div>';
          echo '</div>';
          //stop postbox
          //start postbox
        echo '<div class="postbox">';
          echo '<h2 style="background-color:#0074a2; color:#fff;"><span>Tested On</span></h2>';
            echo '<div class="inside">';
              echo ' <p><strong>Plugins (19)</strong></p>
                      <ul>
                        <li>Jetpack By WordPress.com</li>
                        <li>Custom Post Type UI</li>
                        <li>Pods</li>
                        <li>Advanced Custom Fields</li>
                        <li>Contact Form 7</li>
                        <li>Hashtag URL Placeholder</li>
                        <li>WP-PageNavi</li>
                        <li>Google XML Sitemaps</li>
                        <li>Theme Check</li>
                        <li>Easy Digital Downloads</li>
                        <li>WooCommerce</li>
                        <li>TinyMCE Advanced</li>
                        <li>Give</li>
                        <li>The Events Calendar</li>
                        <li>bbPress</li>
                        <li>BuddyPress</li>
                        <li>Google Analytics by MonsterInsights</li>
                        <li>Yoast SEO</li>
                        <li>WordPress Importer</li>
                      </ul>
                      <p><strong>WordPress Core Versions (5)</strong></p>
                      <ul>
                        <li>4.7.2</li>
                        <li>4.7.1</li>
                        <li>4.7</li>
                        <li>4.6.2</li>
                        <li>4.6.1</li>
                        <li>4.6</li>
                      </ul>';
            echo '</div>';
          echo ' </div>';
      //stop postbox
      echo '</div>';
      echo '</div>';
      echo '<br class="clear">';
      echo '</div>';
        //stop wrap
        //start footer
        echo '<hr />';
        echo 'Query All The Post Types | Version - 1.8| <a style="text-decoration:none;" target="_blank" href="https://wordpress.org/plugins/query-all-the-post-types/changelog/">View Changelog</a>';
      echo '</div>';
    };
?>