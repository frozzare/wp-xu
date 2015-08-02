<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Replacing whitespace and underscore with a dash.
 *
 * @param string $str
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
 * Strip spaces from string.
 *
 * @param string $str
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
 * @throws Exception
 *
 * @return string
 */
function xu_underscorify( $str ) {
	if ( ! is_string( $str ) ) {
		throw new InvalidArgumentException( 'Invalid argument. Must be string.' );
	}

	return str_replace( ' ', '_', str_replace( '-', '_', $str ) );
}
