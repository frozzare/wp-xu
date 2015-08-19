<?php

namespace Xu\Facades;

abstract class Facade {

    /**
     * Facades.
     *
     * @var array
     */
    protected static $facades;

    /**
     * The foundation instance.
     *
     * @var \Xu\Foundation\Foundation
     */
    protected static $instance;

    /**
     * Clear facades.
     */
    public static function clear_facades() {
        static::$facades = [];
    }

    /**
     * Get the facade.
     *
     * @return mixed
     */
    public static function get_facade() {
        $facade = static::get_facade_accessor();

        if ( is_object( $facade ) ) {
            return $facade;
        }

        if ( isset( static::$facades[$facade] ) ) {
            return static::$facades[$facade];
        }

        return static::$facades[$facade] = static::$instance[$facade];
    }

    /**
     * Get the registered name of the component.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected static function get_facade_accessor() {
        throw new RuntimeException( 'Facade does not implement getFacadeAccessor method.' );
    }

    /**
     * Get facade instance.
     *
     * @return \Xu\Foundation\Foundation
     */
    public static function get_facade_instance() {
        return static::$instance;
    }

    /**
     * Set facade instance.
     *
     * @param \Xu\Foundation\Foundation $instance
     */
    public static function set_facade_instance( $instance ) {
        static::$instance = $instance;
    }

    /**
     * Call static method on the facade.
     *
     * @param  string $method
     * @param  array  $args
     *
     * @return mixed
     */
    public static function __callStatic( $method, $args ) {
        $instance = static::get_facade();

        switch ( count( $args ) ) {
            case 0:
                return $instance->$method();
            case 1:
                return $instance->$method( $args[0] );
            case 2:
                return $instance->$method( $args[0], $args[1] );
            case 3:
                return $instance->$method( $args[0], $args[1], $args[2] );
            case 4:
                return $instance->$method( $args[0], $args[1], $args[2], $args[3] );
            default:
                return call_user_func_array( [$instance, $method], $args );
        }
    }

}
