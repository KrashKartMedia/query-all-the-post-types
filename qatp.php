<?php
if ( ! defined( 'ABSPATH' ) ) {exit;}
//here is where we the post types thanks to https://codex.wordpress.org/Function_Reference/get_post_types
  function query_all_the_post_types_function() {
    $all_post_types = get_post_types();
    ksort( $all_post_types);
    foreach ( $all_post_types as $post_type ) {
      $obj = get_post_type_object( $post_type );
      //start core hidden cpts
       if ( in_array( $post_type, array( 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache', 'user_request', 'wp_block', ) ) ) {
        echo '<div class="postbox">';
          echo '<div style="background-color:#32373c;width:100%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>WordPress Core - Hidden CPT</span></h2></div>';
            echo '<div class="inside">';
              echo '<table class="widefat">';
                echo '<tbody>';
                    //start the TR's
                    //another tr
                    echo '<td class="row-title">';
                        echo 'Post Type Name:' . ' ' . $post_type . '' ;
                    echo '</td>';
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
                        echo 'Is Public Queryable: Yes';
                      echo '</td>';
                    echo '</tr>';
                     }
                     else{
                      echo '<tr>';
                      echo '<td class="row-title">';
                        echo 'Is Public Queryable: No';
                      echo '</td>';
                    echo '</tr>';
                     }
                     //another tr
                    $is_hie = $obj->hierarchical;
                      if ($is_hie === true){
                    echo '<tr class="alternate">';
                      echo '<td class="row-title">';
                        echo 'Is Hierarchical: Yes';
                      echo '</td>';
                    echo '</tr>';
                     }
                     else{
                     echo '<tr class="alternate">';
                      echo '<td class="row-title">';
                        echo 'Is Hierarchical: No';
                      echo '</td>';
                    echo '</tr>';
                    }
                    //another tr
                    echo '<tr>';
                      echo '<td class="row-title">';
                        echo 'Taxonomies:';
                        $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                        foreach ( $taxonomy_objects as $taxonomy_object ) {
                           if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'nav_menu', 'yst_prominent_words', 'give_log_type', 'edd_log_type', 'product_shipping_class', 'product_visibility' ) ) ) {
                            // Custom stuff here
                            echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                            } else {
                              //if there is a taxonomy, echo it out
                              echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>, ';
                            }
                        }
                      echo '</td>';
                    echo '</tr>';
                    //stop the TR's
                echo '</tbody>';
            echo '</table>';
          echo '</div>';
        echo '</div>';
       }
       //stop core hidden cpts
       //start core shown cpts
       else if ( in_array( $post_type, array( 'attachment', 'page', 'post', ) ) ) {
        echo '<div class="postbox">';
        echo '<div style="background-color: #0074a2;color: #fff;">';
          echo '<div style="width:50%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>WordPress Core - Regular CPT</span></h2></div>';
          echo '<div style="width:50%;display:inline-block;text-align:right;"><h2><span><a class="button-secondary" href="' . admin_url( 'edit.php?post_type=' . $post_type ) . '">View All</a> <a class="button-secondary" href="' . admin_url( 'post-new.php?post_type=' . $post_type ) . '">Add New</a>
          </span></h2></div>';
        echo '</div>';
          echo '<div class="inside">';
            echo '<table class="widefat">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<td class="row-title">';
                      echo 'Post Type Name:' . ' ' . $post_type . '' ;
                  echo '</td>';
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
                      echo 'Is Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Is Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                  }
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'yst_prominent_words', 'product_shipping_class', 'product_visibility' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>,';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
                  //stop the TR's
              echo '</tbody>';
            echo '</table>';
          echo '</div>';
      echo '</div>';
      //stop core shown post types
       } 
    //if woocommerce - not hidden cpt
     else if (in_array( $post_type, array('shop_webhook', 'shop_coupon', 'shop_order', 'product') ) ) {
       echo '<div class="postbox">';
        echo '<div style="background-color: #bb77ae;color: #fff;">';
          echo '<div style="width:50%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>WooCommerce Core Regular CPT</span></h2></div>';
          echo '<div style="width:50%;display:inline-block;text-align:right;"><h2><span><a class="button-secondary" href="' . admin_url( 'edit.php?post_type=' . $post_type ) . '">View All</a> <a class="button-secondary" href="' . admin_url( 'post-new.php?post_type=' . $post_type ) . '">Add New</a>
          </span></h2></div>';
        echo '</div>';
          echo '<div class="inside">';
            echo '<table class="widefat">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<td class="row-title">';
                      echo 'Post Type Name:' . ' ' . $post_type . '' ;
                  echo '</td>';
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
                      echo 'Is Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Is Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                  }
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'yst_prominent_words', 'product_shipping_class', 'product_visibility' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>,';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
                  //stop the TR's
              echo '</tbody>';
            echo '</table>';
          echo '</div>';
      echo '</div>';
     }
     //if woocommerce - is hidden cpt
     else if (in_array( $post_type, array('shop_order_refund', 'product_variation') ) ) {
        echo '<div class="postbox">';
        echo '<div style="background-color: #9E6595;color: #fff;">';
          echo '<div style="width:50%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>WooCommerce Core Hidden CPT</span></h2></div></div>';
          echo '<div class="inside">';
            echo '<table class="widefat">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<td class="row-title">';
                      echo 'Post Type Name:' . ' ' . $post_type . '' ;
                  echo '</td>';
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
                      echo 'Is Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Is Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                  }
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'yst_prominent_words', 'product_shipping_class', 'product_visibility' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>,';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
                  //stop the TR's
              echo '</tbody>';
            echo '</table>';
          echo '</div>';
      echo '</div>';
     }
      //if contact form 7
        elseif ( in_array( $post_type, array( 'wpcf7_contact_form' ) ) ) {
        echo '<div class="postbox">';
        echo '<div style="background-color: #a62f00;color: #fff;">';
          echo '<div style="width:50%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>Contact Form 7</span></h2></div>';
          echo '<div style="width:50%;display:inline-block;text-align:right;"><h2><span>
          <a class="button-secondary" href="' . admin_url( 'admin.php?page=wpcf7') . '">View All</a> 
          <a class="button-secondary" href="' . admin_url( 'admin.php?page=wpcf7-new' ) . '">Add New</a>
          </span></h2></div>';
        echo '</div>';
          echo '<div class="inside">';
            echo '<table class="widefat">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<td class="row-title">';
                      echo 'Post Type Name:' . ' ' . $post_type . '' ;
                  echo '</td>';
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
                      echo 'Is Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Is Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                  }
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'product_visibility' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>, ';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
                  //stop the TR's
              echo '</tbody>';
            echo '</table>';
          echo '</div>';
      echo '</div>';
      } 
      //Start Regular CPTs
      else if ( in_array( $post_type, array( 'acf', 'bp-email', 'download', 'forum', 'give_forms', 'reply', 'topic', 'tribe_events', 'tribe_organizer', 'tribe_venue', 'acf-field-group', 'cookielawinfo', 'elementor_library', ) ) ) {
        echo '<div class="postbox">';
        echo '<div style="background-color: #00a0d2;color: #fff;">';
          echo '<div style="width:50%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>Regular CPT</span></h2></div>';
          echo '<div style="width:50%;display:inline-block;text-align:right;"><h2><span><a class="button-secondary" href="' . admin_url( 'edit.php?post_type=' . $post_type ) . '">View All</a> <a class="button-secondary" href="' . admin_url( 'post-new.php?post_type=' . $post_type ) . '">Add New</a>
          </span></h2></div>';
        echo '</div>';
          echo '<div class="inside">';
            echo '<table class="widefat">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<td class="row-title">';
                      echo 'Post Type Name:' . ' ' . $post_type . '' ;
                  echo '</td>';
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
                      echo 'Is Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Is Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                  }
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'yst_prominent_words', 'product_shipping_class', 'product_visibility' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>,';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
                  //stop the TR's
              echo '</tbody>';
            echo '</table>';
          echo '</div>';
      echo '</div>';
      }
      //stop Regular CPTs
      // Start all hidden cpts
      else if ( in_array( $post_type, array( 'tribe-ea-record', 'deleted_event', 'edd_log', 'edd_payment', 'edd_discount', 'product_variation', 'shop_order_refund', 'give_log', 'give_payment', '_pods_pod', '_pods_field', 'tablepress_table', 'tribe-ea-record', 'deleted_event', 'edd_log', 'edd_payment', 'edd_discount', 'product_variation', 'shop_order_refund', 'maintainn-notes', 'acf-field', 'jp_pay_order', 'jp_pay_product', 'amn_exact-metrics', 'amn_mi-lite', 'amn_smtp', 'amn_wpforms-lite', 'display_type', 'displayed_gallery', 'flamingo_contact', 'flamingo_inbound', 'flamingo_outbound', 'gal_display_source', 'lightbox_library', 'mc4wp-form', 'ml-slide', 'ml-slider', 'nf_sub', 'ngg_album', 'ngg_gallery', 'ngg_pictures', 'omapi', 'scheduled-action', 'wpforms', 'wpforms_log', ) ) ) {
        echo '<div class="postbox">';
        echo '<div style="background-color:#82878c;width:100%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>Hidden CPT</span></h2></div>';
          echo '<div class="inside">';
            echo '<table class="widefat">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<td class="row-title">';
                    echo 'Post Type Name:' . ' ' . $post_type . '' ;
                  echo '</td>';
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
                      echo 'Is Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Is Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                  }
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'nav_menu', 'yst_prominent_words', 'give_log_type', 'edd_log_type', 'product_shipping_class', 'product_visibility' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>, ';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
                  //stop the TR's
              echo '</tbody>';
            echo '</table>';
          echo '</div>';
      echo '</div>';
      }
      //stop all hidden cpts
       else {
       echo '<div class="postbox">';
        echo '<div style="background-color:#000;width:100%;display:inline-block;vertical-align:middle;"><h2 style="color:#fff;"><span>Other</span></h2></div>';
          echo '<div class="inside">';
            echo '<table class="widefat">';
              echo '<tbody>';
                  //start the TR's
                  //another tr
                  echo '<td class="row-title">';
                      echo 'Post Type Name:' . ' ' . $post_type . '' ;
                  echo '</td>';
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
                      echo 'Is Public Queryable: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                    echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Is Public Queryable: No';
                    echo '</td>';
                  echo '</tr>';
                   }
                   //another tr
                  $is_hie = $obj->hierarchical;
                    if ($is_hie === true){
                  echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: Yes';
                    echo '</td>';
                  echo '</tr>';
                   }
                   else{
                   echo '<tr class="alternate">';
                    echo '<td class="row-title">';
                      echo 'Is Hierarchical: No';
                    echo '</td>';
                  echo '</tr>';
                }
                  //another tr
                  echo '<tr>';
                    echo '<td class="row-title">';
                      echo 'Taxonomies:';
                      $taxonomy_objects = get_object_taxonomies( $post_type, 'names' );
                      foreach ( $taxonomy_objects as $taxonomy_object ) {
                         if ( in_array( $taxonomy_object, array( 'post_format', 'product_type', 'nav_menu', 'yst_prominent_words', 'give_log_type', 'edd_log_type', 'product_shipping_class', 'product_visibility' ) ) ) {
                          // Custom stuff here
                          echo ' ' . esc_attr__( $taxonomy_object ) . ', ';
                          } else {
                            //if there is a taxonomy, echo it out
                            echo ' <a class="posttype" href="' . admin_url( 'edit-tags.php?taxonomy=' . $taxonomy_object . '&post_type=' . $post_type ) . '">' . esc_attr__( $taxonomy_object ) . '</a>, ';
                          }
                      }
                    echo '</td>';
                  echo '</tr>';
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
        echo '<h2>Query All The Post Types ' .  qatp_version . '</h2>';
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
          echo '<h2 style="background-color:#0074a2; color:#fff;"><span>About The Plugin</span></h2>';
            echo '<div class="inside">';
              echo '<p>These are all of the <b>post types, custom post types &amp; associated taxonomies</b> currently active (registered) on your WordPress install right now.</p>';
              echo '<p><strong>Please note</strong>: Deactivating a theme or plugin may result in removing a post type or custom post type.</p>';
              echo '<p><strong>Post type counter:</strong> Displays the total number of post types. Taking the total number of post types, minus the seven WP core post types, equals the number of post types added by plugins & themes.</p>';
              echo '<p>If you want to know more about post type details, visit <a href="https://codex.wordpress.org/Function_Reference/register_post_type" target="_blank" title="Visit the WordPress Codex">The WordPress Codex Register Post Type Page</a>.</p>';
              echo '<p>Version: ' . qatp_version . ' | <a style="text-decoration:none;" target="_blank" href="https://wordpress.org/plugins/query-all-the-post-types/changelog/">View Changelog</a></p>';
            echo '</div>';
          echo ' </div>';
          //stop postbox
          //start postbox
          echo '<div class="postbox">';
            echo '<h2 style="background-color:#0074a2; color:#fff;"><span>Post Type Counter</span></h2>';
              echo '<div class="inside">';
               echo '<p>WP Core Post Types: 7</p>'; 
               $wp_core_cpts = 7;
               $total_cpts = count( get_post_types() );
               $cpts_difference = $total_cpts - $wp_core_cpts;
               echo '<p>Added Post Types: ' . $cpts_difference . '</p>';
               echo '<p>Number of Total Post Types: ' . count( get_post_types() ) . '</p>';
              echo '</div>';
            echo ' </div>';
          //stop postbox
          //start postbox
         echo '<div class="postbox">';
            echo '<h2 style="background-color:#0074a2; color:#fff;"><span>Custom Post Type Details</span></h2>';
              echo '<div class="inside">';
              echo '<p style="color:#0074a2;"><strong>WordPress Core - Regular CPT</strong>: Registered post type inside the core of WordPress.</p>';
               echo '<p style="color:#32373c;"><strong>WordPress Core - Hidden CPT</strong>: Hidden post type inside the core of WordPress.</p>';
                echo '<p style="color:#00a0d2;"><strong>Regular CPT</strong>: Registered post type showing all posts inside of the post type.</p>';
                echo '<p style="color:#82878c;"><strong>Hidden CPT</strong>: Registered post types without an edit screen.</p>';
                echo '<p style="color:#bb77ae;"><strong>WooCommerce Core Regular CPT</strong>: A regular custom post type inside of WooCommerce.</p>';
                echo '<p style="color:#9E6595;"><strong>WooCommerce Core Hidden CPT</strong>: A hidden custom post type inside of WooCommerce.</p>';
                echo '<p style="color:#a62f00;"><strong>Contact Form 7</strong>: A custom post type specific to Contact form 7.</p>';
                echo '<p><strong>Other</strong>: A custom post type undefined.</p>';
              echo '</div>';
            echo '</div>';
          echo '</div>';
          //stop postbox
      echo '</div>';
      echo '</div>';
      echo '<br class="clear">';
      echo '</div>';
        //stop wrap
        //start footer
    };
?>