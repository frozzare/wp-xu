<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Check if the given object is empty or not.
 * Values like "0", 0 and false should not return true.
 *
 * @param mixed $obj
 *
 * @return bool
 */
function xu_is_empty( $obj ) {
	if ( is_string( $obj ) ) {
		return empty( $obj ) && ! is_numeric( $obj );
	}

	if ( is_bool( $obj ) || is_numeric( $obj ) ) {
		return false;
	}

	return empty( $obj );
}
