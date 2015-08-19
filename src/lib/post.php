<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Is the current page the given `$post_type`?
 *
 * @param int $id
 * @param string $post_type
 *
 * @throws Exception if post type is not a string
 *
 * @return bool
 */
function xu_is_post_type( $id, $post_type = '' ) {
    if ( ! is_numeric( $id ) ) {
        $post_type = is_string( $id ) ? $id : '';
        $id        = get_the_id();
    }

    if ( ! is_string( $post_type ) ) {
        throw new Exception( sprintf( '`%s` requires a valid post type.', __FUNCTION__ ) );
    }

    return $post_type === get_post_type( $id );
}

/**
 * Get top-most parent post.
 *
 * @param  WP_Post|int $post
 *
 * @throws Exception if post is not a instance of WP_Post
 *
 * @return WP_Post|array|null
 */
function xu_get_top_parent_post( $post ) {
	if ( is_numeric( $post ) ) {
		$post = get_post( (int)$post );
	}

	if ( $post instanceof WP_Post === false ) {
		throw new Exception( sprintf( '%s is not a instance of WP_Post', strtolower( gettype( $post ) ) ) );
	}

    if ( $post->post_parent ) {
        $ancestors = get_post_ancestors( $post->ID );
        $root      = count( $ancestors ) - 1;
        return get_post( $ancestors[$root] );
    } else {
        return $post;
    }
}
