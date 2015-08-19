<?php

namespace Xu\Container;

use Frozzare\Tank\Container as Tank;

class Container extends Tank {

    /**
     * The container instance if any.
     *
     * @var \Xu\Container\Container
     */
    protected static $instance;

    /**
     * Get the container instance if any.
     *
     * @return \Xu\Container\Container
     */
    public static function get_instance() {
    	return static::$instance;
    }

    /**
     * Get the container instance if any.
     *
     * @return \Xu\Container\Container
     */
    public static function set_instance( Container $instance ) {
    	static::$instance = $instance;
    }

}
