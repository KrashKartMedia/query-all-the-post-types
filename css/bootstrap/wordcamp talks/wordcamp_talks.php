<?php
/**
 * Plugin Name: WordCamp Talks
 * Plugin URI: https://github.com/KrashKartMedia/wordcamp-talks
 * Description: plugin simply creates a post type called wordcamp talks & metaboxes
 * Version: 1.0.0
 * Author: Russell Aaron
 * Author URI: http://russellaaron.vegas
 * Text Domain: wordcamp_talks
 * License: GPL2
 */

//create custom post type called WordCamp Talks 
	 function wordcamp_talks_post_type() {
	  $labels = array(
	    'name' => 'WordCamp Talks',
	    'singular_name' => 'WordCamp Talk',
	    'add_new' => 'Add New WordCamp Talk',
	    'add_new_item' => 'Add New WordCamp Talk',
	    'edit_item' => 'Edit WordCamp Talk',
	    'new_item' => 'New WordCamp Talk',
	    'view_item' => 'View WordCamp Talk',
	    'search_items' => 'Search WordCamp Talks',
	    'not_found' =>  'No WordCamp Talks found',
	    'not_found_in_trash' => 'No WordCamp Talks found in trash',
	    'parent_item_colon' => '',
	    'menu_name' => 'WordCamp Talks'
	  );
	  $args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true, 
	    'show_in_menu' => true, 
	    'query_var' => true,
	    'rewrite' => true,
	    'capability_type' => 'post',
	    'has_archive' => true, 
	    'hierarchical' => false,
	    'menu_position' => null,
	    'supports' => array( 'title','editor','author', 'publicize','excerpt', 'revisions', 'custom-fields', 'thumbnail' ),
	    'taxonomies' => array('wordcamp-cities', 'wordcamp-years') // this is IMPORTANT
	  ); 
	  register_post_type( 'wordcamp-talks', $args );
	}
//initialize the post type
	add_action( 'init', 'wordcamp_talks_post_type' ); 


// create taxonomy for wordcamp talk city
	add_action( 'init', 'create_wordcamp_talks_taxonomies', 0 );
	function create_wordcamp_talks_taxonomies() {
	    register_taxonomy(
	        'wordcamp-cities',
	        'wordcamp-talks',
	        array(
	            'labels' => array(
	                'name' => 'WordCamp City',
	                'add_new_item' => 'Add City',
	                'new_item_name' => "New City"
	            ),
	            'show_ui' => true,
	            'show_tagcloud' => true,
	            'hierarchical' => true
	        )
	    );
	}
// create taxonomy for wordcamp talk year
	add_action( 'init', 'create_wordcamp_year_taxonomies', 0 );
	function create_wordcamp_year_taxonomies() {
	    register_taxonomy(
	        'wordcamp-years',
	        'wordcamp-talks',
	        array(
	            'labels' => array(
	                'name' => 'Year',
	                'add_new_item' => 'Add Year',
	                'new_item_name' => "New Year"
	            ),
	            'show_ui' => true,
	            'show_tagcloud' => true,
	            'hierarchical' => true
	        )
	    );
	}

//here comes the boom. Add custom meta boxes.

/**
* Adds a box to the main column on the Post and Page edit screens.
*/
	function wc_talks_add_meta_box() {

		$screens = array( 'wordcamp-talks' );

		foreach ( $screens as $screen ) {
			add_meta_box(
				'myplugin_sectionid',
				__( 'WordCamp Talks Links', 'wordcamp_talks' ),
				'wc_talks_meta_box_callback',
				$screen
			);
		}
	}
	add_action( 'add_meta_boxes', 'wc_talks_add_meta_box' );

/**
* Prints the box content.
* 
* @param WP_Post $post The object for the current post/page.
*/
	function wc_talks_meta_box_callback( $post ) {

// Add a nonce field so we can check for it later.
		wp_nonce_field( 'wc_talks_meta_box', 'wc_talks_meta_box_nonce' );

/*
* Use get_post_meta() to retrieve an existing value
* from the database and use the value for the form.
*/
		$value = get_post_meta( $post->ID, '_wc_talks_url_meta_value_key', true );
		$value_1 = get_post_meta( $post->ID, '_wc_presentation_url_meta_value_key', true );
		$value_2 = get_post_meta( $post->ID, '_wc_video_url_meta_value_key', true );

		echo '<p><label for="wc_talks_wordcamp_url">';
		_e( 'Link to WordCamp Site', 'wordcamp_talks' );
		echo '</label> ';
		echo '<input type="text" id="wc_talks_wordcamp_url" name="wc_talks_wordcamp_url" value="' . esc_attr( $value ) . '" size="50" /></p>';

		echo '<p><label for="wc_talks_wordcamp_presentation_url">';
		_e( 'Session Details Link', 'wordcamp_talks' );
		echo '</label> ';
		echo '<input type="text" id="wc_talks_wordcamp_presentation_url" name="wc_talks_wordcamp_presentation_url" value="' . esc_attr( $value_1 ) . '" size="50" /></p>';

		echo '<p><label for="wc_talks_wordcamp_presentation_url">';
		_e( 'Link to Video', 'wordcamp_talks' );
		echo '</label> ';
		echo '<input type="text" id="wc_talks_wordcamp_video_url" name="wc_talks_wordcamp_video_url" value="' . esc_attr( $value_2 ) . '" size="50" /></p>';

	}

/**
* When the post is saved, saves our custom data.
*
* @param int $post_id The ID of the post being saved.
*/
	function wc_talks_save_meta_box_data( $post_id ) {

/*
* We need to verify this came from our screen and with proper authorization,
* because the save_post action can be triggered at other times.
*/

		// Check if our nonce is set.
		if ( ! isset( $_POST['wc_talks_meta_box_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['wc_talks_meta_box_nonce'], 'wc_talks_meta_box' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */
		
		// Make sure that it is set.
		if ( ! isset( $_POST['wc_talks_wordcamp_url'] ) ) {
			return;
		}
		if ( ! isset( $_POST['wc_talks_wordcamp_presentation_url'] ) ) {
			return;
		}

		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['wc_talks_wordcamp_url'] );
		$my_data_1 = sanitize_text_field( $_POST['wc_talks_wordcamp_presentation_url'] );
		$my_data_2 = sanitize_text_field( $_POST['wc_talks_wordcamp_video_url'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_wc_talks_url_meta_value_key', $my_data );
		update_post_meta( $post_id, '_wc_presentation_url_meta_value_key', $my_data_1 );
		update_post_meta( $post_id, '_wc_video_url_meta_value_key', $my_data_2 );
	}
	add_action( 'save_post', 'wc_talks_save_meta_box_data' );

// stop boom of wordcamp metaboxes

// add shortcode for the wordcamp talks year
	function get_custom_field_wc_talk_year( $atts) {    
	global $post; 

	 extract( shortcode_atts( array(
	        'meta' => '_wc_presentation_url_meta_value_key',
	    ), $atts ) );

	 $custom_field_value = get_post_meta($post->ID, $meta, true); 
	 return '<a href="' . $custom_field_value . '">' . $custom_field_value . '</a>';
	 
	 } 

	add_shortcode('wc-presentation-url', 'get_custom_field_wc_talk_year');

// add shortcode for the wordcamp video url
	function get_custom_field_wc_talk_video( $atts) {    
	global $post; 

	 extract( shortcode_atts( array(
	        'meta' => '_wc_video_url_meta_value_key',
	    ), $atts ) );

	 $custom_field_value = get_post_meta($post->ID, $meta, true); 
	return '<a href="' . $custom_field_value . '">' . $custom_field_value . '</a>';
	} 

	add_shortcode('wc-talk-video', 'get_custom_field_wc_talk_video');
	
// add shortcode for the wordcamp talks url
	function get_custom_field_wc_talk_url( $atts) {    
	global $post; 

	 extract( shortcode_atts( array(
	        'meta' => '_wc_talks_url_meta_value_key'
	    ), $atts ) );

	 $custom_field_value1 = get_post_meta($post->ID, $meta, true); 

	 
	 return '<a href="' . $custom_field_value1 . '">' . $custom_field_value1 . '</a>'; 
	} 

	add_shortcode('wc-talk-url', 'get_custom_field_wc_talk_url');

// add shortcode that displays a loop of cpt posts on a page or post template
	function get_cpt_wc_talks( $atts) {   

	$args = array(
		'post_type' => 'wordcamp-talks',
	);

	$wcloop = new WP_Query( $args );

	while ( $wcloop->have_posts() ) : $wcloop->the_post();
			
	//get post meta info
	$wc_talks_url = get_post_meta( get_the_id(), '_wc_talks_url_meta_value_key', true);
	$wc_talks_pres_notes = get_post_meta( get_the_id(), '_wc_presentation_url_meta_value_key', true);
	$wc_talks_video_url = get_post_meta( get_the_id(), '_wc_video_url_meta_value_key', true);

	//echo some stuff out
	echo '<p>';
	echo '<a href="';
	echo the_permalink();
	echo '" title="';
	echo the_title();
	echo '">';
	echo the_post_thumbnail();
	echo '</a>';
	echo '<p><h3>';
	echo the_title();
	echo '</h3>';
	echo the_content();
	echo '</p>';
	echo '</p><hr/>' . '<p>Session Links: ' . '<a href="' . $wc_talks_url . '">Visit WordCamp Site</a> | <a href="' . $wc_talks_pres_notes . '">Sessions Details</a> | <a href="' . $wc_talks_video_url . '">Watch Session</a></p>' . the_taxonomies( $args );
			
	endwhile;
	wp_reset_query();

	}

// add shortcode that displays a loop of cpt posts on a page or post template
	add_shortcode('wordcamp-talks', 'get_cpt_wc_talks');

// function to add filter after content
	 function wc_links_after_content( $content ) { 
	    if ( is_singular('wordcamp-talks')) {
	        $wc_talks_url = get_post_meta( get_the_id(), '_wc_talks_url_meta_value_key', true);
	        $wc_talks_pres_notes = get_post_meta( get_the_id(), '_wc_presentation_url_meta_value_key', true);
	        $wc_talks_video_url = get_post_meta( get_the_id(), '_wc_video_url_meta_value_key', true);
	         $content = '<p>' . $content . '</p><hr/>' . '<p>Session Links: ' . '<a href="' . $wc_talks_url . '">Visit WordCamp Site</a> | <a href="' . $wc_talks_pres_notes . '">Sessions Details</a> | <a href="' . $wc_talks_video_url . '">Watch Session</a></p>';
			
			}
	    return $content;
		}

// hook filter after the content to insert metabox data
	add_filter( 'the_content', 'wc_links_after_content' ); 

//function to add filter after content on post type archive
	function wc_links_after_content_cpt_archive( $content ){
		if ( is_post_type_archive ( 'wordcamp-talks' )) {
			$wc_talks_url = get_post_meta( get_the_id(), '_wc_talks_url_meta_value_key', true);
	        $wc_talks_year = get_post_meta( get_the_id(), '_wc_presentation_url_meta_value_key', true);
	        $wc_talks_video_url = get_post_meta( get_the_id(), '_wc_video_url_meta_value_key', true);
        
	    $content = '<p>' . $content . '</p><hr/>' . '<p>Session Links: ' . '<a href="' . $wc_talks_url . '">Visit WordCamp Site</a> | <a href="' . $wc_talks_pres_notes . '">Sessions Details</a> | <a href="' . $wc_talks_video_url . '">Watch Session</a></p>';
     }
     return $content;
	}
//hook filter after the content on archive page
	add_filter( 'the_content', 'wc_links_after_content_cpt_archive' ); 



?>