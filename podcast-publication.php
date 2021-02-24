<?php
/*
Plugin Name:Podcast Publication
Description:It's a simple custom post type podcast plugin with pagination.
Version:1.2
Author:Naveenkumar C
License:GPL2

Copyright 2014-2017 Naveenkumar C (email: cnaveen777 at gmail.com)

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details. 

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA.
*/

// Exit you access directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Activate the plugin.
 */
function podcastpublication_activate() { 
    // Trigger our function that registers the custom post type plugin.
    podcast_custom_post_type(); 
    // Clear the permalinks after the post type has been registered.
    flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'podcastpublication_activate' );

/**
 * Deactivation hook.
 */
function podcastpublication_deactivate() {
    // Unregister the post type, so the rules are no longer in memory.
    unregister_post_type( 'podcast' );
    // Clear the permalinks to remove our post type's rules from the database.
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'podcastpublication_deactivate' );

/**
 * Register the "Podcast" custom post type
 */
function podcast_custom_post_type(){
	
	$singular = "Podcast";
	$Plural = "Podcasts";
	$menuname = "Podcasts";
	
	$labels = array(
		'name'               =>	$Plural,
		'singular_name'      => $singular,
		'menu_name'          => $menuname,
		'name_admin_bar'     => $singular,
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New ' .$singular,
		'new_item'           => 'New '. $singular,
		'edit_item'          => 'Edit '. $singular,
		'view_item'          => 'View '. $singular,
		'all_items'          => 'All '. $Plural,
		'search_items'       => 'Search'. $Plural,
		'parent_item_colon'  => 'Parent'. $Plural.':',
		'not_found'          => 'No '. $Plural. 'found.',
		'not_found_in_trash' => 'No '. $Plural.' found in Trash.'
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'podcast' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'		     => 'dashicons-format-audio',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'podcast' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);	
	register_post_type('podcast',$args);
	
}
add_action('init', 'podcast_custom_post_type');

/**
 * Register a 'types' taxonomy for post type 'podcast'.
 */
function podcast_taxonomy() {
    register_taxonomy( 'types', 'podcast', array(
        'label'        => __( 'Types', 'podcast' ),
        'rewrite'      => array( 'slug' => 'types' ),
        'hierarchical' => true,
    ) );
}
add_action( 'init', 'podcast_taxonomy', 0 );

/**
 * Register a 'Podcast Tags' taxonomy for post type 'podcast'.
 */
function reggister_podcast_tag() {
     register_taxonomy_for_object_type('post_tag', 'podcast');
}
add_action('init', 'reggister_podcast_tag');

/**
* Register meta box(es).
*/
add_action( 'add_meta_boxes', 'add_podcast_metaboxes' );
function add_podcast_metaboxes() {
	add_meta_box( 'add_podcast_metaboxes', 'Custom field Details', 'display_podcast_metaboxes','podcast', 'normal', 'high' );
}

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function display_podcast_metaboxes( $post ) {
	require_once('inc/custom-podcat-metabox.php');
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function podcast_save_meta_box( $post_id ) {
    // Save logic goes here.
	global $post; 
	if ( $post->post_type == 'podcast' ) {
		if ( isset( $_POST['meta'] ) ) {
			foreach( $_POST['meta'] as $key => $value ){
				update_post_meta( $post_id, $key, $value );
			}
		}
	}
}
add_action( 'save_post', 'podcast_save_meta_box' );

/**
 * Settings Page
 * Post per page and Thumbnail hide show option
*/
add_action('admin_menu', 'podcast_settings_page');

function podcast_settings_page() {
    add_submenu_page('edit.php?post_type=podcast', 'Settings','Settings','manage_options', 'podcast-limit-settings',     'podcast_option_display');
}

add_action( 'admin_init', 'podcast_options_init' );
function podcast_options_init(){
	register_setting( 'podcast_option_group', 'podcast_option_name', 'intval' );
}

function podcast_option_display(){
	require_once('inc/podcat-settings.php');
}

/**
 * Register the plugin script.
 * Scripts and Stylesheet 
 * User End
 */
function podcast_userend_enqueue() {
	wp_enqueue_style( 'bootstrap-css' , 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
	wp_enqueue_style( 'podcast' ,  plugin_dir_url( __FILE__ ) . 'css/podcast-userend.css' );
	//wp_register_script( 'jquerycdn','https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
	wp_register_script( 'bootstrap-js','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js');
	
	wp_register_script( 'podcast-js', plugin_dir_url( __FILE__ ) .'js/podcast.js');
	wp_localize_script( 'podcast-js', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'podcast-js' );
}
add_action('wp_enqueue_scripts', 'podcast_userend_enqueue');

/**
 * Ajax callback.
 */
add_action( 'wp_ajax_podcastpaginationCallback', 'podcastpaginationCallback' );
add_action( 'wp_ajax_nopriv_podcastpaginationCallback', 'podcastpaginationCallback' );

function podcastpaginationCallback(){
	//print_r($_POST);
	require_once('inc/podcat-callback.php');
}

add_action('wp_head','jquerydefault');
function jquerydefault(){
	echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>';
}

/**
 * Register the plugin script.
 * Scripts and Stylesheet 
 * Admin End
 */
function podcast_admin_enqueue(){
	wp_enqueue_style( 'podcast-admin' ,  plugin_dir_url( __FILE__ ) . 'css/podcast-backend.css' );
}
add_action('admin_enqueue_scripts','podcast_admin_enqueue');

/**
 * Create Shortcode for displaying podcast
 */
add_action( 'init', 'add_custom_shortcode' );
 
function add_custom_shortcode() {
    add_shortcode( 'listingallpodcast', 'podcast_display_func' );
}

function podcast_display_func(){
	require_once('inc/podcat-shortcode.php');
}

?>