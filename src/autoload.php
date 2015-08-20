<?php

/**
 * Load Composer autoload if it exists.
 *
 * @codeCoverageIgnore
 */
if ( file_exists( __DIR__ . '/../vendor/autoload.php' ) ) {
    require __DIR__ . '/../vendor/autoload.php';
}

/**
 * Register the WordPress autoload.
 *
 * @codeCoverageIgnore
 */
register_wp_autoload( 'Xu\\', __DIR__ . '/../src' );
