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
		return '';
	}

	return str_replace( ' ', '-', str_replace( '_', '-', $str ) );
}

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

/**
 * Replacing whitespace and dash with a underscore.
 *
 * @param string $str
 *
 * @return string
 */
function xu_underscorify( $str ) {
	if ( ! is_string( $str ) ) {
		return '';
	}

	return str_replace( ' ', '_', str_replace( '-', '_', $str ) );
}
