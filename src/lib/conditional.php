<?php

/**
 * Check if WordPress is doing ajax or not.
 *
 * @return bool
 */
function xu_doing_ajax() {
	return defined( 'DOING_AJAX' ) && DOING_AJAX;
}

/**
 * Check if the given object is empty or not.
 * Values like "0", 0 and false should not return true.
 *
 * @param  mixed $obj
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

/**
 * Check if the request method is the same as the given method.
 *
 * @param  string $method
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

	return strtolower( $_SERVER ['REQUEST_METHOD'] ) === strtolower( $method );
}

/**
 * Check if the given string is a JSON string or not.
 *
 * @param  string $obj
 *
 * @return bool
 */
function xu_is_json( $obj ) {
	return is_string( $obj )
		&& is_array( json_decode( $obj, true ) )
		&& json_last_error() === JSON_ERROR_NONE;
}

/**
 * Check if WordPress is the given version.
 *
 * @param  string $version
 * @param  string $operator
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

/**
 * Check if the given string is XML or not.
 *
 * @param  string $str
 *
 * @return bool
 */
function xu_is_xml( $str ) {
	if ( ! is_string( $str ) ) {
		return false;
	}

	libxml_use_internal_errors( true );
	$doc = simplexml_load_string( $str );
	$xml = explode( "\n", $str );

	if ( $doc ) {
		$errors = libxml_get_errors();
		return empty( $errors );
	}

	return false;
}

/**
 * Validate Swedish personal identify numbers.
 *
 * @param  int|string $str
 *
 * @return bool
 */
function xu_valid_personnummer( $str ) {
	return \Frozzare\Personnummer\Personnummer::valid( $str );
}
