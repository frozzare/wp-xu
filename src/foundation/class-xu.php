<?php

use Frozzare\Tank\Container;

/**
 * Global class to xu foundation class.
 */
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
        return Container::get_instance()->fn( $method, $args );
    }

}
