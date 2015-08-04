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
	 * The xu version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0-alpha';

	/**
	 * The instance of xu class.
	 *
	 * @var xu
	 */
	protected static $instance;

	/**
	 * Call xu functions as a static method.
	 *
	 * @param string $method
	 * @param array $args
	 *
	 * @return mixed
	 */
	public static function __callStatic( $method, $args ) {
		return xu()->fn( $method, $args );
	}

	/**
	 * The constructor.
	 */
	protected function __construct() {
		$this->load_aliases();
		$this->load_components();
	}

	/**
	 * xu instance.
	 *
	 * @return xu
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Get alias.
	 *
	 * @return array
	 */
	protected function load_aliases() {
		$aliases = require_once __DIR__ . '/aliases.php';

		foreach ( $aliases as $alias => $fn ) {
			$this->register_alias( $alias, $fn );
		}
	}

	/**
	 * Load components.
	 */
	protected function load_components() {
		$components = require_once __DIR__ . '/components.php';

		foreach ( $components as $component => $path ) {
			$this->register_component( $component, $path );
		}
	}

	/**
	 * Get alias function.
	 *
	 * @param string $fn
	 *
	 * @return string
	 */
	protected function get_method( $fn ) {
		$fn     = preg_replace( '/^xu\_/', '', $fn );
		$method = 'xu_';

		if ( $this->exists( 'alias.' . $fn ) ) {
			$method .= $this->make( 'alias.' . $fn );
		} else {
			$method .= $fn;
		}

		return $method;
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
		$method = $this->get_method( $method );

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
	 * Register alias.
	 *
	 * @param string $alias
	 * @param string $fn
	 *
	 * @throws Exception if alias or function exists.
	 * @throws InvalidArgumentException if an argument is not of the expected type.
	 */
	public function register_alias( $alias, $fn ) {
		if ( ! is_string( $alias ) ) {
			throw new InvalidArgumentException( 'Invalid argument. `$alias` must be string.' );
		}

		if ( ! is_string( $fn ) ) {
			throw new InvalidArgumentException( 'Invalid argument. `$fn` must be string.' );
		}

		$alias  = 'alias.' . preg_replace( '/^xu\_/', '', $alias );
		$method = $this->get_method( $fn );
		$fn     = preg_replace( '/^xu\_/', '', $fn );

		if ( ! function_exists( $method ) || $this->exists( $alias ) ) {
			throw new Exception( sprintf( '`%s` already exists', $alias ) );
		}

		$this->singleton( $alias, $fn );
	}

	/**
	 * Register component.
	 *
	 * @param string $component
	 * @param string $path
	 *
	 * @throws Exception if component exists.
	 * @throws InvalidArgumentException if an argument is not of the expected type.
	 */
	public function register_component( $component, $path ) {
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

}

/**
 * Get the xu class instance.
 *
 * @param string $component
 * @param array $arguments
 *
 * @return xu
 */
function xu( $component = '', array $arguments = [] ) {
	$instance = xu::instance();

	if ( is_string( $component ) && ! empty( $component ) ) {
		return $instance->component( $component, $arguments );
	}

	return $instance;
}
