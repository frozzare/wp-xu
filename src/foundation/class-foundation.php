<?php

namespace Xu\Foundation;

use Exception;
use Xu\Container\Container;
use InvalidArgumentException;
use Xu\Facades\Facade;
use Xu\Contracts\Foundation\Foundation as FoundationContract;

/**
 * xu main class.
 */
class Foundation extends Container implements FoundationContract {

    /**
     * The xu version.
     *
     * @var string
     */
    const VERSION = '1.0.0-alpha';

    /**
     * The constructor.
     *
     * @codeCoverageIgnore
     */
    public function __construct() {
        $this->singleton( 'foundation', $this );
        static::set_instance( $this );
    }

    /**
     * Autoload files.
     */
    protected function autoload_files() {
        require_once __DIR__ . '/bootstrap/autoload.php';
    }

    /**
     * Boot the foundation.
     */
    public function boot() {
        $this->autoload_files();
        $this->register_facades();
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

    /**
     * Register component.
     *
     * @param array|string $component
     * @param string       $path
     *
     * @throws Exception if component exists.
     * @throws InvalidArgumentException if an argument is not of the expected type.
     */
    public function register_component( $component, $path = '' ) {
        if ( is_array( $component ) ) {
            foreach ( $component as $key => $value ) {
                $this->register_component( $key, $value );
            }
            return;
        }

        if ( ! is_string( $component ) ) {
            throw new InvalidArgumentException( 'Invalid argument. `$component` must be string.' );
        }

        if ( ! is_string( $path ) ) {
            throw new InvalidArgumentException( 'Invalid argument. `$path` must be string.' );
        }

        $component = strtolower( $component );

        if ( $this->exists( $component ) ) {
            throw new Exception( sprintf( '`%s` component exists.', $component ) );
        }

        if ( ! class_exists( $path ) ) {
            throw new Exception( sprintf( '`%s` class does not exists.', $path ) );
        }

        $instance = new $path( $this );
        $value    = $instance->bootstrap();

        if ( is_object( $value ) && class_exists( get_class( $value ) ) ) {
            $this->singleton( $component, $value );
        } else {
            $this->singleton( $component, $instance );
        }
    }

    /**
     * Register facades.
     */
    protected function register_facades() {
        Facade::clear_facades();
        Facade::set_facade_instance( $this );
    }

}
