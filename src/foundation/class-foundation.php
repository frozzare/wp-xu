<?php

namespace Xu\Foundation;

use Exception;
use Frozzare\Tank\Container;
use InvalidArgumentException;

/**
 * xu main class.
 */
class Foundation extends Container {

    /**
     * The xu version.
     *
     * @var string
     */
    const VERSION = '1.0.0-alpha';

    /**
     * The instance of xu class.
     *
     * @var \Xu\Foundation\Xu
     */
    protected static $instance;

    /**
     * The constructor.
     *
     * @codeCoverageIgnore
     */
    protected function __construct() {
    }

    /**
     * Boot foundation.
     */
    public static function boot() {
        require_once __DIR__ . '/../../bootstrap/autoload.php';
    }

    /**
     * xu instance.
     *
     * @codeCoverageIgnore
     *
     * @return \xu
     */
    public static function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Add component.
     *
     * @param array|string $component
     * @param string       $path
     *
     * @throws Exception if component exists.
     * @throws InvalidArgumentException if an argument is not of the expected type.
     */
    public static function add_component( $component, $path = '' ) {
        if ( is_array( $component ) ) {
            foreach ( $component as $key => $value ) {
                self::add_component( $key, $value );
            }
            return;
        }

        if ( ! is_string( $component ) ) {
            throw new InvalidArgumentException( 'Invalid argument. `$component` must be string.' );
        }

        if ( ! is_string( $path ) ) {
            throw new InvalidArgumentException( 'Invalid argument. `$path` must be string.' );
        }

        $component  = strtolower( $component );
        $foundation = self::instance();

        if ( $foundation->exists( $component ) ) {
            throw new Exception( sprintf( '`%s` component exists.', $component ) );
        }

        if ( ! class_exists( $path ) ) {
            throw new Exception( sprintf( '`%s` class does not exists.', $path ) );
        }

        $instance = new $path( $foundation );
        $value    = $instance->bootstrap();

        if ( is_object( $value ) && class_exists( get_class( $value ) ) ) {
            $foundation->singleton( $component, $value );
        } else {
            $foundation->singleton( $component, $instance );
        }
    }

    /**
     * Call function.
     *
     * @param string $method
     * @param mixed $args
     *
     * @throws Exception if function does not exists.
     *
     * @return mixed
     */
    public function fn( $method, $args ) {
        $method = $this->get_fn_name( $method );

        if ( ! is_array( $args ) ) {
            $args = [$args];
        }

        if ( ! function_exists( $method ) ) {
            throw new Exception( sprintf( '`%s` function does not exists', $method ) );
        }

        return call_user_func_array( $method, $args );
    }

    /**
     * Call component class.
     *
     * @param string $component
     * @param array $arguments
     *
     * @return object
     */
    public function component( $component, array $arguments = [] ) {
        if ( ! is_string( $component ) ) {
            throw new InvalidArgumentException( 'Invalid argument. `$component` must be string.' );
        }

        if ( ! $this->exists( $component ) ) {
            throw new Exception( sprintf( '`%s` component does not exist', $component ) );
        }

        $instance = $this->make( strtolower( $component ) );

        if ( ! is_object( $instance ) ) {
            return $instance;
        }

        switch ( get_class( $instance ) ) {
            case 'ReflectionClass':
                return $instance->newInstanceArgs( $arguments );
            case 'ReflectioFunction':
                return $instance->invokeArgs( $arguments );
            default:
                return $instance;
        }
    }

    /**
     * Get method that should be called.
     *
     * @param string $fn
     *
     * @return string
     */

    protected function get_fn_name( $fn ) {
        return 'xu_' . preg_replace( '/^xu\_/', '', $fn );
    }

}
