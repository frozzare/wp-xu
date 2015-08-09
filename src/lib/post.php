<?php

/**
 * This file is a part of xu.
 *
 * @package xu
 */

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
