<?php
/**
 * Plugin Name: Here's what I'm listening to right now
 * Plugin URI: http://russellenvy.com
 * Description: plugin simply creates a post type called listen-to and etc.
 * Version: 1.0.0
 * Author: Russell Aaron
 * Author URI: http://russellenvy.com
 * Text Domain: listen_to
 * License: GPL2
 */

//create custom post type called Listen To
	 function listen_to_post_type() {
	  $labels = array(
	    'name' => 'Listen To',
	    'singular_name' => 'Listen To',
	    'add_new' => 'Add New Listen To',
	    'add_new_item' => 'Add New Listen To',
	    'edit_item' => 'Edit Listen To',
	    'new_item' => 'New Listen To',
	    'view_item' => 'View Listen To',
	    'search_items' => 'Search Listen To',
	    'not_found' =>  'No Listen To found',
	    'not_found_in_trash' => 'No Listen To found in trash',
	    'parent_item_colon' => '',
	    'menu_name' => 'Listen To Music'
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
	    'supports' => array( 'title','editor','author', 'publicize','excerpt', 'revisions', 'custom-fields', 'comments', 'thumbnail' ),
	    'taxonomies' => array('music-genre') // this is IMPORTANT
	  );
	  register_post_type( 'listen-to', $args );
	}
//initialize the post type
	add_action( 'init', 'listen_to_post_type' );


// create taxonomy for Listen To city
	add_action( 'init', 'create_listen_too_taxonomies', 0 );
	function create_listen_too_taxonomies() {
	    register_taxonomy(
	        'music-genre',
	        'listen-to',
	        array(
	            'labels' => array(
	                'name' => 'Music Genre',
	                'add_new_item' => 'Add New Genre',
	                'new_item_name' => "Music Genre"
	            ),
	            'show_ui' => true,
	            'show_tagcloud' => true,
	            'hierarchical' => true
	        )
	    );
	}
?>
