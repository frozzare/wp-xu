<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Return the given object. Useful for chaining.
 *
 * @param mixed $obj
 *
 * @return mixed
 */
function xu_with( $obj ) {
	return $obj;
}

/**
 * Check if WordPress is the given version.
 *
 * @param string $version
 * @param string $operator
 *
 * @return bool
 */
function xu_is_wp( $version, $operator = '==' ) {
	if ( ! is_string( $version ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$version` must be string.' );
	}

	if ( ! is_string( $operator ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$operator` must be string.' );
	}

	return version_compare( get_bloginfo( 'version' ), $version, $operator );
}
