<?php

/**
 * Add large option value to hidden post type.
 *
 * @param  string $name  Option name.
 * @param  mixed  $value Option value.
 *
 * @return mixed Returns false on failure.
 */
function xu_add_option( $name, $value ) {
	$name = xu_get_option_name( $name );

	if ( empty( $name ) ) {
		return false;
	}

	if ( xu_get_option( $name ) !== false ) {
		return false;
	}

	$post_id = wp_insert_post( [
		'post_type'   => 'xu_large_option',
		'post_name'   => $name,
		'post_title'  => $name
	] );

	if ( is_wp_error( $post_id ) ) {
		return false;
	}

	if ( ! update_post_meta( $post_id, 'option_value', $value ) ) {
		return false;
	}

	wp_cache_set( $name, $value, 'xu_large_option' );

	return true;
}

/**
 * Delete option value from to hidden post type.
 *
 * @param  string $name Option name
 *
 * @return bool
 */
function xu_delete_option( $name ) {
	$name = xu_get_option_name( $name );

	if ( empty( $name ) ) {
		return false;
	}

	if ( ! ( $post_id = xu_get_option_post_id( $name ) ) ) {
		return false;
	}

	wp_cache_delete( $name, 'xu_large_option' );

	return is_object( wp_delete_post( $post_id, true ) );
}

/**
 * Get option value from to hidden post type or default value.
 *
 * @param  string $name    Option name.
 * @param  bool   $default Default value.
 *
 * @return mixed
 */
function xu_get_option( $name, $default = false ) {
	$name = xu_get_option_name( $name );

	if ( empty( $name ) ) {
		return $default;
	}

	if ( $value = wp_cache_get( $name, __FUNCTION__ ) ) {
		return $value;
	}

	if ( ! ( $post_id = xu_get_option_post_id( $name ) ) ) {
		return $default;
	}

	if ( $value = get_post_meta( $post_id, 'option_value', true ) ) {
		return $value;
	}

	return $default;
}

/**
 * Get option name.
 *
 * @param  string $name Option name.
 *
 * @return string
 */
function xu_get_option_name( $name ) {
	if ( ! is_string( $name ) ) {
		return;
	}

	return sanitize_title( trim( $name ) );
}

/**
 * Get option post id.
 *
 * @param  string $name Option name.
 *
 * @return int
 */
function xu_get_option_post_id( $name ) {
	$name = xu_get_option_name( $name );

	if ( empty( $name ) ) {
		return 0;
	}

	$query = new WP_Query( [
		'fields'         => 'ids',
		'name'           => $name,
		'post_type'      => 'xu_large_option',
		'posts_per_page' => 1
	] );

	$posts = $query->get_posts();

	if ( count( $posts ) ) {
		return $posts[0];
	}

	return 0;
}

/**
 * Update or add option value to hidden post type.
 *
 * @param  string $name  Option name.
 * @param  mixed  $value Option value.
 *
 * @return mixed Returns false on failure.
 */
function xu_update_option( $name, $value ) {
	$name = xu_get_option_name( $name );

	if ( empty( $name ) ) {
		return false;
	}

	$old = xu_get_option( $name );

	if ( $old === $value ) {
		return false;
	}

	if ( $old === false ) {
		return xu_add_option( $name, $value );
	}

	if ( ! ( $post_id = xu_get_option_post_id( $name ) ) ) {
		return $default;
	}

	if ( ! update_post_meta( $post_id, 'option_value', $value ) ) {
		return false;
	}

	wp_cache_replace( $name, $value, 'xu_large_option' );

	return true;
}

/**
 * Register `xu_large_option` hidden post type.
 */
function xu_register_large_option_post_type() {
	register_post_type( 'xu_large_option', [
		'can_export'          => true,
		'capability_type'     => 'xu_large_option',
		'exclude_from_search' => true,
		'has_archive'         => false,
		'public'              => false,
		'publicly_queryable'  => false,
		'rewrite'             => false,
		'query_var'           => false,
		'show_ui'             => false,
		'show_in_admin_bar'   => false,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => false,
	] );
}
