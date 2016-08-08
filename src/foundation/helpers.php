<?php

use Xu\Foundation\Foundation;

/**
 * Load xu class that is used when calling static methods.
 */
require_once __DIR__ . '/class-xu.php';

/**
 * Get a component or return the xu instance.
 *
 * @param  string $component
 * @param  mixed  $arguments
 *
 * @return \Xu\Foundation\Foundation
 */
function xu( $component = '', $arguments = [] ) {
	if ( is_string( $component ) && ! empty( $component ) ) {
		return Foundation::get_instance()->component( $component, $arguments );
	}

	return Foundation::get_instance();
}
