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
	private static $instance;

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
	private function __construct() {
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
	private function load_aliases() {
		$this->bind( 'aliases', require_once __DIR__ . '/aliases.php' );
	}

	/**
	 * Load components.
	 */
	private function load_components() {
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
	public function get_method( $fn ) {
		$alias  = $this->make( 'aliases' );
		$method = strpos( $fn, 'xu_' ) === 0 ? '' : 'xu_';

		if ( isset( $alias[$fn] ) ) {
			$method .= $alias[$fn];
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
	 *
	 * @return object|xu
	 */
	public function component( $component, $path = null, $replace = false ) {
		if ( is_string( $component ) && $this->exists( $component ) ) {
			return $this->make( $component );
		}

		return $this;
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

		$method  = $this->get_method( $fn );
		$aliases = $this->make( 'aliases' );
		$alias   = preg_replace( '/xu\_/', '', $alias );
		$fn      = preg_replace( '/xu\_/', '', $fn );

		if ( ! function_exists( $method ) || isset( $aliases[$alias] ) ) {
			throw new Exception( sprintf( '`%s` already exists', $alias ) );
		}

		$tmp = [];
		$tmp[$alias] = $fn;
		$this->bind( 'aliases', array_merge( $aliases, $tmp ) );
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

		$instance = new $path( $this );
		$value    = $instance->bootstrap();

		if ( is_null( $value ) ) {
			$this->singleton( $component, $instance );
		} else {
			$this->singleton( $component, $value );
		}

	}

}

/**
 * Get the xu class instance.
 *
 * @return xu
 */
function xu( $component = null ) {
	return xu::instance()->component( $component );
}
