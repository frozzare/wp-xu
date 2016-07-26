<?php

/**
 * Add action.
 *
 * @see https://developer.wordpress.org/reference/functions/add_action/
 *
 * @param  string   $tag
 * @param  callable $fn
 * @param  int      $priority
 * @param  int      $accepted_args
 *
 * @return string
 */
function xu_add_action( $tag, $fn, $priority = 10, $accepted_args = 1 ) {
	return xu_add_filter( $tag, $fn, $priority, $accepted_args );
}

/**
 * Add filter.
 *
 * @see https://developer.wordpress.org/reference/functions/add_filter/
 *
 * @param  string   $tag
 * @param  callable $fn
 * @param  int      $priority
 * @param  int      $accepted_args
 *
 * @return string
 */
function xu_add_filter( $tag, $fn, $priority = 10, $accepted_args = 1 ) {
	if ( function_exists( 'add_filter' ) ) {
		return add_filter( $tag, $fn, $priority, $accepted_args );
	}

	return idx_add_filter( $tag, $fn, $priority, $accepted_args );
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

	return strtolower( $_SERVER ['REQUEST_METHOD'] ) == strtolower( $method );
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

/**
 * Get namespace name and/or class name from file.
 *
 * @param  string $file
 *
 * @return string
 */
function xu_get_class_name( $file ) {
	if ( ! is_string( $file ) ) {
		return '';
	}

	$content         = file_get_contents( $file );
	$tokens          = token_get_all( $content );
	$class_name      = '';
	$namespace_name  = '';
	$i               = 0;
	$len             = count( $tokens );

	for ( ; $i < $len; $i++ ) {
		if ( $tokens[$i][0] === T_NAMESPACE ) {
			for ( $j = $i + 1; $j < $len; $j++ ) {
				if ( $tokens[$j][0] === T_STRING ) {
					 $namespace_name .= '\\' . $tokens[$j][1];
				} else if ( $tokens[$j] === '{' || $tokens[$j] === ';' ) {
					 break;
				}
			}
		}

		if ( $tokens[$i][0] === T_CLASS ) {
			for ( $j = $i + 1; $j < $len; $j++ ) {
				if ( $tokens[$j] === '{' ) {
					$class_name = $tokens[$i + 2][1];
				}
			}
		}
	}

	if ( empty( $class_name ) ) {
		return '';
	}

	if ( empty( $namespace_name ) ) {
		return $class_name;
	}

	return $namespace_name . '\\' . $class_name;
}

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
