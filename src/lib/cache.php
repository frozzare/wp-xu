<?php

/**
 * Delete value from cache.
 *
 * @param  mixed  $key   The cache key, can be anything if `$md5` is set to true.
 * @param  string $group The cache group. Optional.
 *
 * @return bool
 */
function xu_cache_delete( $key, $group = '' ) {
	// Check for empty key.
	if ( empty( $key ) ) {
		return false;
	}

	if ( is_array( $key ) || is_object( $key ) ) {
		$key = md5( serialize( $key ) );
	}

	if ( ! is_string( $key ) ) {
		return false;
	}

	return wp_cache_delete( $key, $group );
}

/**
 * Removes cache contents for a given group.
 *
 * @codeCoverageIgnore
 *
 * @param  string $group  The cache group.
 * @param  string $suffix The suffix. Optional.
 *
 * @return bool
 */
function xu_cache_delete_group( $group, $suffix = '' ) {
	if ( ! function_exists( 'wp_cache_delete_group' ) ) {
		return false;
	}

	return wp_cache_delete_group( xu_cache_key( $group, $suffix ) );
}

/**
 * Get value from given functions cache or from function
 * if function cache don't exists.
 *
 * @param  string $key   The cache key, will be serialized if array or object.
 * @param  string $fn    The function.
 * @param  array  $args  The function arguments.
 * @param  string $group The cache group. Optional.
 *
 * @return mixed Cached value, function return value or false.
 */
function xu_cache_get( $key, $fn = '', $args = [], $group = '' ) {
	if ( ! empty( $fn ) && ! empty( $args ) && empty( $group ) ) {
		if ( is_string( $args ) ) {
			$group = $args;
		}

		$args = $fn;
		$fn   = $key;
		$key  = $args;
	}

	if ( is_array( $key ) && count( $key ) === 1 ) {
		$key = $key[0];
	}

	if ( is_array( $key ) || is_object( $key ) ) {
		$key = md5( serialize( $key ) );
	}

	if ( $value = wp_cache_get( $key, $group ) ) {
		return $value;
	}

	if ( ! is_callable( $fn ) ) {
		return false;
	}

	$value = call_user_func_array( $fn, $args );

	if ( empty( $value ) ) {
		return $value;
	}

	wp_cache_set( $key, $value, $group );

	return $value;
}

/**
 * Get xu cache key.
 *
 * @param  string $key
 * @param  mixed  $suffix
 *
 * @return null|string
 */
function xu_cache_key( $key, $suffix = '' ) {
	if ( ! is_string( $key ) ) {
		return;
	}

	$key = sanitize_title_with_dashes( $key );
	$key = str_replace( '-', '_', $key );

	if ( is_array( $suffix )||is_object( $suffix ) ) {
		$suffix = md5( serialize( $suffix ) );
	}

	if ( $suffix === false ) {
		$suffix = '0';
	}

	if ( $suffix === '' || $suffix === null ) {
		return $key;
	}

	return sprintf( '%s:%s', $key, $suffix );
}
