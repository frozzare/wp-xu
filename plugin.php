<?php

/**
 * Plugin Name: xu
 * Description: Collection of useful WordPress and PHP functions and classes.
 * Author: Fredrik Forsmo
 * Author URI: https://frozzare.com
 * Version: 2.0.0
 * Plugin URI: https://github.com/wp-xu/xu
 * Textdomain: xu
 * Domain Path: /languages/
 */

// Load Composer if it exists.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Hook xu into WordPress.
 *
 * @return \Xu\Foundation\Foundation
 */
add_action( 'plugins_loaded', function () {
	new \Xu\Foundation\Foundation;
} );
