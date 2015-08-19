<?php

/**
 * Load Composer autoload.
 */
require __DIR__ . '/../vendor/autoload.php';

/**
 * Define fixtures directory constant
 */
define( 'XU_FIXTURE_DIR', __DIR__ . '/fixtures' );

/**
 * Load files.
 */
WP_Test_Suite::load_files( __DIR__ . '/class-unit-test-case.php' );

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
 * Run the WordPress test suite.
 */
WP_Test_Suite::run();
