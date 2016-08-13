<?php

/**
 * Clean attachment cache.
 *
 * @param  int $post_id
 */
function xu_clean_attachment_cache( $post_id = 0 ) {
	$groups = [
		'xu_wp_get_attachment_image',
		'xu_wp_get_attachment_image_sizes',
		'xu_wp_get_attachment_image_src',
		'xu_wp_get_attachment_image_srcset'
	];

	// Delete all group keys for this post.
	foreach ( $groups as $group ) {
		xu_cache_delete_group( $group, $post_id );
	}

	// Cache to delete on save post.
	// Order: key (mixed), group (string)
	$delete_items = [
		[get_permalink( $post_id ), 'xu_attachment_url_to_postid'],
		[$post_id, 'xu_wp_get_attachment_url']
	];

	// Delete cache items on save.
	foreach ( $delete_items as $item ) {
		call_user_func_array( 'xu_cache_delete', $item );
	}
}
add_action( 'clean_attachment_cache', 'xu_clean_attachment_cache' );

/**
 * Clean nav menu cache.
 */
function xu_clean_nav_menu_cache() {
	xu_cache_delete_group( 'xu_wp_nav_menu' );
}
add_action( 'wp_create_nav_menu', 'xu_clean_nav_menu_cache' );
add_action( 'wp_update_nav_menu', 'xu_clean_nav_menu_cache' );
add_action( 'wp_delete_nav_menu', 'xu_clean_nav_menu_cache' );

/**
 * Clean post cache.
 *
 * @param  int $post_id
 */
function xu_clean_post_cache( $post_id = 0 ) {
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! get_post_status( $post_id ) ) {
		return;
	}

	$groups = [
		'xu_get_posts'
	];

	// Delete all group keys.
	foreach ( $groups as $group ) {
		xu_cache_delete_group( $group );
	}

	// Cache to delete on save post.
	// Order: key (mixed), group (string)
	$delete_items = [
		[get_permalink( $post_id ), 'xu_url_to_postid']
	];

	// Delete cache items on save.
	foreach ( $delete_items as $item ) {
		call_user_func_array( 'xu_cache_delete', $item );
	}
}
add_action( 'clean_post_cache', 'xu_clean_post_cache' );
