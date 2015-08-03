<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Convert a value to camel case.
 *
 * @param string $str
 *
 * @throws InvalidArgumentException if an argument is not of the expected type.
 *
 * @return string
 */
function xu_camel_case( $str ) {
	if ( ! is_string( $str ) ) {
		throw new InvalidArgumentException( 'Invalid argument. Must be string.' );
	}

	return lcfirst( xu_studly_case( $str ) );
}

/**
 * Determine if a given string contains a given substring.
 *
 * @param string $haystack
 * @param string|array $needles
 *
 * @throws InvalidArgumentException if an arguments is not of the expected types.
 *
 * @return bool
 */
function xu_contains( $haystack, $needles ) {
	if ( ! is_string( $haystack ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$haystack` must be string.' );
	}

	if ( ! is_array( $needles ) && ! is_string( $needles ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$needles` must be string.' );
	}

	foreach ( (array) $needles as $needle ) {
		if ( (string) $needle !== '' && strpos( $haystack, $needle ) !== false ) {
			return true;
		}
	}

	return false;
}

/**
 * Replacing whitespace and underscore with a dash.
 *
 * @param string $str
 *
 * @throws InvalidArgumentException if an argument is not of the expected type.
 *
 * @return string
 */
function xu_dashify( $str ) {
	if ( ! is_string( $str ) ) {
		throw new InvalidArgumentException( 'Invalid argument. Must be string.' );
	}

	return xu_strip_spaces( strtolower( preg_replace( '/(.)(?=[A-Z])|\_|\s/', '$1-', $str ) ) );
}

/**
 * Determine if a given string ends with a given substring.
 *
 * @param string $haystack
 * @param string|array $needles
 *
 * @throws InvalidArgumentException if an arguments is not of the expected types.
 *
 * @return bool
 */
function xu_ends_with( $haystack, $needles ) {
	if ( ! is_string( $haystack ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$haystack` must be string.' );
	}

	if ( ! is_array( $needles ) && ! is_string( $needles ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$needles` must be string.' );
	}

	foreach ( (array) $needles as $needle ) {
		if ( (string) $needle === substr( $haystack, -strlen( $needle ) ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Determine if a given string starts with a given substring.
 *
 * @param string $haystack
 * @param string|array $needles
 *
 * @throws InvalidArgumentException if an arguments is not of the expected types.
 *
 * @return bool
 */
function xu_starts_with( $haystack, $needles ) {
	if ( ! is_string( $haystack ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$haystack` must be string.' );
	}

	if ( ! is_array( $needles ) && ! is_string( $needles ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$needles` must be string.' );
	}

	foreach ( (array) $needles as $needle ) {
		if ( (string) $needle !== '' && strpos( $haystack, $needle ) === 0 ) {
			return true;
		}
	}

	return false;
}

/**
 * Convert a string to snake case.
 *
 * @param string $str
 * @param string $delimiter
 *
 * @throws InvalidArgumentException if an arguments is not of the expected types.
 *
 * @return string
 */
function xu_snake_case( $str, $delimiter = '_' ) {
	if ( ! is_string( $str ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$str` must be string.' );
	}

	if ( ! is_string( $delimiter ) ) {
		throw new InvalidArgumentException( 'Invalid argument. `$delimiter` must be string.' );
	}

	return xu_strip_spaces( strtolower( preg_replace( '/(.)(?=[A-Z])|\-|\s/', '$1'.$delimiter, $str ) ) );
}


/**
 * Convert a value to studly caps case.
 *
 * @param string $str
 *
 * @throws InvalidArgumentException if an argument is not of the expected type.
 *
 * @return string
 */
function xu_studly_case( $str ) {
	if ( ! is_string( $str ) ) {
		throw new InvalidArgumentException( 'Invalid argument. Must be string.' );
	}

	return str_replace( ' ', '', ucwords( str_replace( ['-', '_'], ' ', $str ) ) );
}

/**
 * Strip spaces from string.
 *
 * @param string $str
 *
 * @throws InvalidArgumentException if an argument is not of the expected type.
 *
 * @return string
 */
function xu_strip_spaces( $str ) {
	if ( ! is_string( $str ) ) {
		throw new InvalidArgumentException( 'Invalid argument. Must be string.' );
	}

	return  trim( preg_replace( '/\s+/', ' ', $str ) );
}
