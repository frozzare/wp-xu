<?php

/**
 * Delete transient by key.
 *
 * @param  string $key Transient name.
 *
 * @return bool
 */
function xu_delete_transient( $key ) {
	return delete_transient( $key );
}

/**
 * Delete site transient by key.
 *
 * @param  string $key Transient name.
 *
 * @return bool
 */
function xu_delete_site_transient( $key ) {
	return delete_site_transient( $key );
}

/**
 * Get/Set transient.
 *
 * @param  string $key        Transient name. Should be 172 (40 on site) characters or less since WordPress will prefix the name.
 * @param  mixed  $value      Transient value. Expected to not be SQL-escaped. Can be callable value. Optional.
 * @param  int    $expiration Time until expiration in seconds from now, or 0 for never expires. Default 0.
 * @param  bool   $site       Set to true if site transient. Default false.
 *
 * @return mixed
 */
function xu_get_transient( $key, $value = null, $expiration = 0, $site = false ) {
	if ( ! is_string( $key ) ) {
		return false;
	}

	$transient_value = ( $site ? get_site_transient( $key ) : get_transient( $key ) );

	// Return transient value if it exists or the return value if given value is null.
	if ( $transient_value || is_null( $value ) ) {
		return $transient_value;
	}

	// Support callable values.
	if ( is_callable( $value ) ) {
		$value = call_user_func( $value );

		// Return false if null value.
		if ( is_null( $value ) ) {
			return false;
		}
	}

	if ( $site ) {
		set_site_transient( $key, $value, $expiration );
	} else {
		set_transient( $key, $value, $expiration );
	}

	return $value;
}

/**
 * Get/Set site transient.
 *
 * @param  string $key        Transient name. Should be 40 characters or less since WordPress will prefix the name.
 * @param  mixed  $value      Transient value. Expected to not be SQL-escaped. Can be callable value. Optional.
 * @param  int    $expiration Time until expiration in seconds from now, or 0 for never expires. Default 0.
 *
 * @return mixed
 */
function xu_get_site_transient( $key, $value = null, $expiration = 0 ) {
	return xu_get_transient( $key, $value, $expiration, true );
}
