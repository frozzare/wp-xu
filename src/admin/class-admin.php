<?php

namespace Xu\Admin;

class Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->setup_actions();
	}

	/**
	 * Save post.
	 *
	 * @param int $post_id
	 */
	public function save_post( $post_id ) {
		if ( wp_is_post_revision( $post_id ) ) {
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

	/**
	 * Save attachment.
	 *
	 * @param int $post_id
	 */
	public function save_attachment( $post_id ) {
		$groups = [
			'xu_wp_get_attachment_image',
			'xu_wp_get_attachment_image_sizes',
			'xu_wp_get_attachment_image_src',
			'xu_wp_get_attachment_image_srcset',
			'xu_wp_get_attachment_url'
		];

		// Delete all group keys for this post.
		foreach ( $groups as $group ) {
			xu_cache_delete_group( $group, $post_id );
		}

		// Cache to delete on save post.
		// Order: key (mixed), group (string)
		$delete_items = [
			[get_permalink( $post_id ), 'xu_attachment_url_to_postid']
		];

		// Delete cache items on save.
		foreach ( $delete_items as $item ) {
			call_user_func_array( 'xu_cache_delete', $item );
		}
	}

	/**
	 * Update nav menu.
	 */
	public function update_nav_menu() {
		xu_cache_delete_group( 'xu_wp_nav_menu' );
	}

	/**
	 * Setup action hooks.
	 */
	protected function setup_actions() {
		add_action( 'save_post', [$this, 'save_post'] );
		add_action( 'delete_post', [$this, 'save_post'] );
		add_action( 'edit_attachment', [$this, 'save_attachment'] );
		add_action( 'delete_attachment', [$this, 'save_attachment'] );
		add_action( 'wp_create_nav_menu', [$this, 'update_nav_menu'] );
		add_action( 'wp_update_nav_menu', [$this, 'update_nav_menu'] );
		add_action( 'wp_delete_nav_menu', [$this, 'update_nav_menu'] );
	}
}
