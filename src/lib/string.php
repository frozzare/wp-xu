<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

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

	return str_replace( ' ', '-', str_replace( '_', '-', $str ) );
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

/**
 * Replacing whitespace and dash with a underscore.
 *
 * @param string $str
 *
 * @throws InvalidArgumentException if an argument is not of the expected type.
 *
 * @return string
 */
function xu_underscorify( $str ) {
	if ( ! is_string( $str ) ) {
		throw new InvalidArgumentException( 'Invalid argument. Must be string.' );
	}

	return str_replace( ' ', '_', str_replace( '-', '_', $str ) );
}
