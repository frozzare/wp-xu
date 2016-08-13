<?php

/**
 * Cached version of `wp_nav_menu`.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_nav_menu/
 *
 * @param  array $args
 *
 * @return mixed
 */
function xu_wp_nav_menu( array $args = [] ) {
	// Store echo value for later use.
	$echo = isset( $args['echo'] ) ? $args['echo'] : true;

	// Set echo argument to false so `wp_nav_menu` don't echo.
	$args['echo'] = false;

	// Get cached value.
	$value = xu_cache_get( 'wp_nav_menu', [$args], __FUNCTION__ );

	// Don't print anything if false.
	if ( $value === false ) {
		return $value;
	}

	// Echo value if it should be echo.
	if ( $echo ) {
		echo $value; // WPCS: xss ok
	} else {
		return $value;
	}
}
