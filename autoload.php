<?php

/**
 * Plugin Name: xu
 */

// Load Composer autoload if file exists.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Hook xu into WordPress.
 *
 * @return \Xu\Foundation\Foundation
 */
xu_add_action( 'init', function () {
	new \Xu\Foundation\Foundation;
} );
