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
if ( version_compare( PHP_VERSION, '5.6.0', '<' ) ) {
	exit( 'xu for WordPress requires PHP version 5.6 or higher.' );
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require 'vendor/autoload.php';
}
