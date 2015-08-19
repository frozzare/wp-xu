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
     * Components namespace.
     *
     * @var string
     */
    protected $components_namespace = 'Xu\\Components\\';

    /**
     * Foundation instance.
     *
     * @var \Xu\Foundation\Foundation
     */
    protected static $instance;

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
     * @return object|null
     */
    public function component( $component, array $arguments = [] ) {
        if ( ! is_string( $component ) ) {
            throw new InvalidArgumentException( 'Invalid argument. `$component` must be string.' );
        }

        $component = $this->get_namespace( $component );

        if ( ! $this->exists( $component ) ) {
            $this->register_component( $component, $component );
        }

        $instance = $this->make( $component );

        if ( ! is_object( $instance ) ) {
            $this->remove( $component );
            return;
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
     * Get foundation instance.
     *
     * @return \Xu\Foundation\Foundation
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            return self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Get namespace.
     *
     * @param  string $namespace
     *
     * @return string
     */
    protected function get_namespace( $namespace ) {
    	$parts = array_map( function( $part ) {
    		return strtolower( $part ) === $part ? ucfirst( $part ) : $part;
    	}, explode( '.', $namespace ) );

        if ( count( $parts ) === 1 ) {
            $parts[] = $parts[0];
        }

        return $this->components_namespace . implode( '\\', $parts );
    }

    /**
     * Register component.
     *
     * @param string $component
     * @param string $path
     *
     * @throws Exception if component exists or component class does not exists.
     */
    protected function register_component( $component, $path = '' ) {
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

}
