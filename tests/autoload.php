<?php

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

/**
 * Require files.
 */
require_once XU_FIXTURE_DIR . '/components/class-xu.php';

/**
 * Create a new foundation.
 */
$foundation = new \Xu\Foundation\Foundation;

/**
 * Boot the foundation.
 */
$foundation->boot();

/**
 * Register the xu test component.
 */
$foundation->register_component( 'xu', 'Xu\\Components\\Xu\\Xu' );
