<?php

use Frozzare\Tank\Container;

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
    if ( is_string( $component ) && ! empty( $component ) ) {
        return Container::get_instance()->component( $component, $arguments );
    }

    return Container::get_instance();
}
