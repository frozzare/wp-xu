<?php

// Load Composer autoload if it exists.
if ( file_exists( __DIR__ . '/../vendor/autoload.php' ) ) {
	require __DIR__ . '/../vendor/autoload.php';
}

// Register the WordPress autoload.
// It will load files that has `class-` or `trait-` as prefix.
register_wp_autoload( 'Xu\\', __DIR__ . '/../src' );

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

// Bootstrap config
require_once __DIR__ . '/config.php';
