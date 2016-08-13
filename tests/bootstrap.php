<?php

// Load Composer autoload.
require __DIR__ . '/../vendor/autoload.php';

// Define fixtures directory constant.
define( 'XU_FIXTURE_DIR', __DIR__ . '/data' );

// Load files.
WP_Test_Suite::load_files( __DIR__ . '/framework/class-unit-test-case.php' );

// Run the WordPress test suite.
WP_Test_Suite::run();
