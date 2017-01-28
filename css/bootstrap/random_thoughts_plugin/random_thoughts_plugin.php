<?php
/**
 * Plugin Name: Random Thoughts Plugin
 * Plugin URI: http://russellaaron.vegas
 * Description: plugin simply creates a post type called random thoughts
 * Version: 1.0.0
 * Author: Russell Aaron
 * Author URI: http://russellaaron.vegas
 * Text Domain: random_thoughts
 * License: GPL2
 */

 
 
 
 
 function random_thoughts_post_type() {
  $labels = array(
    'name' => 'Random Thoughts',
    'singular_name' => 'Random Thought',
    'add_new' => 'Add New Random Thought',
    'add_new_item' => 'Add New Random Thought',
    'edit_item' => 'Edit Random Thought',
    'new_item' => 'New Random Thought',
    'view_item' => 'View Random Thought',
    'search_items' => 'Search Random Thoughts',
    'not_found' =>  'No Random Thoughts found',
    'not_found_in_trash' => 'No Random Thoughts found in trash',
    'parent_item_colon' => '',
    'menu_name' => 'Random Thoughts'
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
    'supports' => array( 'title','editor','author', 'publicize','excerpt', 'revisions', 'comments', 'custom-fields', 'thumbnail' ),
    'taxonomies' => array('thought_cats') // this is IMPORTANT
  ); 
  register_post_type( 'random_thoughts', $args );
}
add_action( 'init', 'random_thoughts_post_type' ); 



?>