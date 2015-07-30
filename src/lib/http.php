<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Check if the request method is the same as the given method.
 *
 * @param string $method
 *
 * @return bool
 */
function xu_is_http_method( $method ) {
	if ( ! isset( $_SERVER['REQUEST_METHOD'] ) ) {
		return false;
	}

    if ( ! is_string( $method ) ) {
        return false;
    }

	return $_SERVER ['REQUEST_METHOD'] == strtoupper( $method );
}

/**
 * Get current url.
 *
 * @param bool $parse
 * @param bool $obj
 *
 * @return mixed
 */
function xu_current_url( $parse = false, $obj = true ) {
	$url = $_SERVER['REQUEST_URI'];
	$url = ltrim( $url, '/' );
	$url = home_url() . '/' . $url;

	if ( ! (bool) $parse ) {
		return $url;
	}

	$parts = parse_url( $url );

	if ( (bool) $parts === false ) {
		$parts = [];
	}

	if ( (bool) $obj ) {
		return (object) $parts;
	}

	return $parts;
}
