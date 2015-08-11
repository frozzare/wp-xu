<?php

/**
 * Global class to xu foundation class.
 */
// @codingStandardsIgnoreStart
class xu extends Xu\Foundation\Xu {
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
	$instance = xu::instance();

	if ( is_string( $component ) && ! empty( $component ) ) {
		return $instance->component( $component, $arguments );
	}

	return $instance;
}
