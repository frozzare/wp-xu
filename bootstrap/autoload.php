<?php

// Load xu functions files.
// Please note that missing files will produce a fatal error.
$xu_includes = require_once __DIR__ . '/includes.php';

foreach ( $xu_includes as $file ) {
    $file = __DIR__ . '/../src/' . $file;
    if ( file_exists( $file ) ) {
        require_once $file;
    } else {
        trigger_error( sprintf( __( 'Error locating %s for inclusion', 'xu' ), $file ), E_USER_ERROR );
    }
}

unset( $file );
