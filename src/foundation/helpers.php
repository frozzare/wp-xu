<?php

use Xu\Foundation\Xu as XuFoundation;

/**
 * Global class to xu foundation class.
 */
// @codingStandardsIgnoreStart
class xu extends XuFoundation {
// @codingStandardsIgnoreEnd
}

/**
 * Get a component or return the xu instance.
 *
 * @param string $component
 * @param array $arguments
 *
 * @return \xu
 */
function xu( $component = '', array $arguments = [] ) {
	$instance = XuFoundation::instance();

	if ( is_string( $component ) && ! empty( $component ) ) {
		return $instance->component( $component, $arguments );
	}

	return $instance;
}
