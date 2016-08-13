<?php

use Xu\Foundation\Foundation;

// @codingStandardsIgnoreStart
class xu {
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
		return Foundation::get_instance()->fn( $method, $args );
	}
}
