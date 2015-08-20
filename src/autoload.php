<?php

// @codeCoverageIgnoreStart

/**
 * Load Composer autoload if it exists.
 */
if ( file_exists( __DIR__ . '/../vendor/autoload.php' ) ) {
    require __DIR__ . '/../vendor/autoload.php';
}

/**
 * Register the WordPress autoload.
 */
register_wp_autoload( 'Xu\\', __DIR__ . '/../src' );

// @codeCoverageIgnoreEnd
