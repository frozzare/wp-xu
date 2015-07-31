<?php

use Xu\Container\Container;

/**
 * xu class.
 *
 * @package xu
 */

// @codingStandardsIgnoreStart
class xu extends Container {
// @codingStandardsIgnoreEnd

	/**
	 * Call xu functions as a static method.
	 *
	 * @param string $method
	 * @param array $args
	 *
	 * @return mixed
	 */
	public static function __callStatic( $method, $args ) {
		$method = 'xu_' . $method;

		if ( ! function_exists( $method ) ) {
			throw new \Exception( sprintf( '%s function does not exists', $method ) );
		}

		return call_user_func_array( $method, $args );
	}

}
