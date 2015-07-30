<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Is the current page the given `$post_type`?
 *
 * @param int $id
 * @param string $post_type
 *
 * @return bool
 */
function xu_is_post_type( $id, $post_type = '' ) {
	if ( ! is_numeric( $id ) ) {
		$post_type = $id;
		$id        = get_the_id();
	}

	return $post_type === get_post_type( $id );
}
