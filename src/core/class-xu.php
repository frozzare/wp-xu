<?php

namespace Xu\Core;

/**
 * xu class.
 *
 * @package xu
 */
class xu {

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
            throw new xu\Errors\Exception;
        }

        return call_user_func_array( $method, $args );
    }

}
