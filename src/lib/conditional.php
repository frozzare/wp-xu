<?php

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
 * Check if the given string is a JSON string or not.
 *
 * @param string $str
 *
 * @return bool
 */
function xu_is_json( $str ) {
    if ( ! is_string( $str ) ) {
        return false;
    }

    json_decode( $str );
    return json_last_error() === JSON_ERROR_NONE;
}

/**
 * Check if the given string is XML or not.
 *
 * @param string $str
 *
 * @return bool
 */
function xu_is_xml( $str ) {
    if ( ! is_string( $str ) ) {
        return false;
    }

    libxml_use_internal_errors( true );
    $doc = simplexml_load_string( $str );
    $xml = explode( "\n", $str );

    if ( $doc ) {
        $errors = libxml_get_errors();
        return empty( $errors );
    }

    return false;
}
