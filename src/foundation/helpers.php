<?php

use Xu\Foundation\Foundation;

/**
 * Load xu class that is used when calling static methods.
 */
require_once __DIR__ . '/class-xu.php';

/**
 * Get a component or return the xu instance.
 *
 * @param string $component
 * @param array $arguments
 *
 * @return \xu
 */
function xu( $component = '', array $arguments = [] ) {
    $instance = Foundation::instance();

    if ( is_string( $component ) && ! empty( $component ) ) {
        return $instance->component( $component, $arguments );
    }

    return $instance;
}
