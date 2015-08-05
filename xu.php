<?php

/**
 * Plugin Name: xu
 * Description: Collection of useful WordPress functions
 * Author: Fredrik Forsmo and xu contributors
 * Author URI: https://github.com/wp-xu/xu/graphs/contributors
 * Version: 1.0.0
 * Plugin URI: https://github.com/wp-xu/xu
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Framework requires PHP 5.4 or newer
if ( version_compare( PHP_VERSION, '5.4.0', '<' ) ) {
	exit( 'xu for WordPress requires PHP version 5.4 or higher.' );
}

// Load Composer autoload if it exists.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

// Register the WordPress autoload.
// It will load files that has `class-` or `trait-` as prefix.
register_wp_autoload( 'Xu\\', __DIR__ . '/src' );

// Load xu functions files.
// Please note that missing files will produce a fatal error.
$xu_includes = [
	'src/lib/utils.php',       // Utility functions
	'src/lib/conditional.php', // Conditional functions
	'src/lib/http.php',        // HTTP functions
	'src/lib/post.php',        // Post functions
	'src/lib/string.php',      // String functions
];

foreach ( $xu_includes as $file ) {
	$file = __DIR__ . '/' . $file;
	if ( file_exists( $file ) ) {
		require_once $file;
	} else {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'xu' ), $file ), E_USER_ERROR );
	}
}

unset( $file );

// Load xu main class.
require_once __DIR__ . '/src/core/class-xu.php';
