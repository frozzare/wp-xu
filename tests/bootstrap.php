<?php

// Load Composer autoload.
require __DIR__ . '/../vendor/autoload.php';

// Define fixtures directory constant
define( 'XU_FIXTURE_DIR', __DIR__ . '/fixtures' );

// Load xu file as plugin.
WP_Test_Suite::load_plugins( __DIR__ . '/../src/autoload.php' );

// Load files.
WP_Test_Suite::load_files( __DIR__ . '/class-unit-test-case.php' );

// Add xu test component.
require_once XU_FIXTURE_DIR . '/components/class-xu.php';
\Xu\Foundation\Foundation::add_component( 'xu', 'Xu\\Components\\Xu\\Xu' );

// Run the WordPress test suite.
WP_Test_Suite::run();
