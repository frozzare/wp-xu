<?php

// Load Composer autoload if it exists.
if ( file_exists( __DIR__ . '/../vendor/autoload.php' ) ) {
    require __DIR__ . '/../vendor/autoload.php';
}

// Register the WordPress autoload.
// It will load files that has `class-` or `trait-` as prefix.
register_wp_autoload( 'Xu\\Components\\', __DIR__ . '/../src/components' );

// Bootstrap config
require_once __DIR__ . '/config.php';
