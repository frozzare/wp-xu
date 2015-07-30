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
 * Get namespace name and/or class name from file.
 *
 * @param string $file
 * @param bool $trait
 *
 * @return string
 */
function xu_get_class_name( $file, $trait = false ) {
	if ( ! is_string( $file ) ) {
		return '';
	}

	$content         = file_get_contents( $file );
	$tokens          = token_get_all( $content );
	$class_name      = '';
	$namespace_name  = '';
	$i               = 0;
	$len             = count( $tokens );

	for ( ; $i < $len;$i++ ) {
		if ( $tokens[$i][0] === T_NAMESPACE ) {
			for ( $j = $i + 1; $j < $len; $j++ ) {
				if ( $tokens[$j][0] === T_STRING ) {
					 $namespace_name .= '\\' . $tokens[$j][1];
				} else if ( $tokens[$j] === '{' || $tokens[$j] === ';' ) {
					 break;
				}
			}
		}

        if ( (bool) $trait ) {
            if ( $tokens[$i][0] === T_TRAIT ) {
    			for ( $j = $i + 1; $j < $len; $j++ ) {
    				if ( $tokens[$j] === '{' ) {
    					$class_name = $tokens[$i + 2][1];
    				}
    			}
    		}
        } else {
    		if ( $tokens[$i][0] === T_CLASS ) {
    			for ( $j = $i + 1; $j < $len; $j++ ) {
    				if ( $tokens[$j] === '{' ) {
    					$class_name = $tokens[$i + 2][1];
    				}
    			}
    		}
        }
	}

	if ( empty( $namespace_name ) ) {
		return $class_name;
	} else if ( empty( $class_name ) ) {
        return '';
    }

	return $namespace_name . '\\' . $class_name;
}

/**
 * Get namespace name and/or trait name from file.
 *
 * @param string $file
 *
 * @return string
 */
function xu_get_trait_name( $file ) {
    return xu_get_class_name( $file, true );
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
 * Remove trailing dobule quote.
 * PHP's $_POST object adds this automatic.
 *
 * @param string $str The string to check.
 *
 * @return string
 */
function xu_remove_trailing_quotes( $str ) {
    if ( ! is_string( $str ) ) {
		return '';
	}

	return str_replace( "\'", "'", str_replace( '\"', '"', $str ) );
}

/**
 * Slugify the given string.
 *
 * @param string $str
 * @param array $replace
 * @param string $delimiter
 *
 * @return string
 */
function xu_slugify( $str, $replace = [], $delimiter = '-' ) {
	if ( ! is_string( $str ) ) {
		return '';
	}

    setlocale( LC_ALL, 'en_US.UTF8' );

    if ( ! empty( $replace ) ) {
		$str = str_replace( (array) $replace, ' ', $str );
	}

    $clean = iconv( 'UTF-8', 'ASCII//TRANSLIT', $str );
	$clean = preg_replace( '/[^a-zA-Z0-9\/_|+ -]/', '', $clean );
	$clean = strtolower( trim( $clean, '-' ) );
	$clean = preg_replace( '/[\/_|+ -]+/', $delimiter, $clean );

    return trim( $clean );
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
