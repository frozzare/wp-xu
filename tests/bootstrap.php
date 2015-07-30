<?php

// Load Composer autoload.
require __DIR__ . '/../vendor/autoload.php';

// Register WordPress autoload.
register_wp_autoload( 'Xu\\', __DIR__ . '/../src' );

// Define fixtures directory constant
define( 'XU_FIXTURE_DIR', __DIR__ . '/fixtures' );

// Load xu file as plugin.
WP_Test_Suite::load_plugins( __DIR__ . '/../xu.php' );

// Run the WordPress test suite.
WP_Test_Suite::run();
