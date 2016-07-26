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
 * Get namespace name and/or class name from file.
 *
 * @param  string $file The file path.
 *
 * @throws InvalidArgumentException if an argument is not of the expected type.
 * @throws Exception if file don't exists.
 *
 * @return string
 */
function xu_get_class_name( $file ) {
	if ( ! is_string( $file ) ) {
		throw new InvalidArgumentException( 'Invalid argument. Must be string.' );
	}

	if ( ! file_exists( $file ) ) {
		throw new Exception( sprintf( '`%s`does not exist.', __FUNCTION__ ) );
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
 * @param  mixed $obj
 *
 * @return mixed
 */
function xu_with( $obj ) {
	return $obj;
}
