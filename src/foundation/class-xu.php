<?php

use Xu\Foundation\Foundation;

/**
 * Global class to xu foundation class.
 */
// @codingStandardsIgnoreStart
class xu extends Foundation {
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
        return self::instance()->fn( $method, $args );
    }

}
