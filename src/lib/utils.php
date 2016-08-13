<?php

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
		throw new Exception( sprintf( '`%s`does not exist.', $file ) );
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
