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
	 * The constructor.
	 *
	 * @codeCoverageIgnore
	 */
	public function __construct() {
		$this->require_files();
		$this->init();
	}

	/**
	 * Boot the foundation.
	 *
	 * @codeCoverageIgnore
	 */
	public function boot() {
	}

	/**
	 * Call function.
	 *
	 * @param  string $method
	 * @param  mixed $args
	 *
	 * @throws \Exception if function does not exists.
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
	 * @param  string $component
	 * @param  mixed $arguments
	 *
	 * @throws \InvalidArgumentException if `$component` is not string.
	 *
	 * @return object|null
	 */
	public function component( $component, $arguments = [] ) {
		if ( ! is_array( $arguments ) ) {
			$arguments = [$arguments];
		}

		if ( ! is_string( $component ) ) {
			throw new InvalidArgumentException( 'Invalid argument. `$component` must be string.' );
		}

		$component = $this->get_namespace( $component );

		if ( ! $this->exists( $component ) ) {
			$this->register_component( $component, $component );
		}

		$instance = $this->make( $component );

		switch ( get_class( $instance ) ) {
			case 'ReflectionClass':
				return $instance->newInstanceArgs( $arguments );
			case 'ReflectionFunction':
				return $instance->invokeArgs( $arguments );
			default:
				return $instance;
		}
	}

	/**
	 * Get method that should be called.
	 *
	 * @param  string $fn
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
		if ( strpos( $namespace, '\\' ) !== false ) {
			return strpos( $namespace, $this->components_namespace ) === false ?
				$this->components_namespace . ltrim( $namespace, '\\' ) : $namespace;
		}

		$parts = array_map( function( $part ) {
			return strtolower( $part ) === $part ? ucfirst( $part ) : $part;
		}, explode( '.', $namespace ) );

		if ( count( $parts ) === 1 ) {
			$parts[] = $parts[0];
		}

		return $this->components_namespace . implode( '\\', $parts );
	}

	/**
	 * Init xu.
	 */
	protected function init() {
	//	xu_register_large_option_post_type();
	}

	/**
	 * Register component.
	 *
	 * @param  string $component
	 * @param  string $path
	 *
	 * @throws \Exception if component class does not exists or is not a instance of Component class.
	 */
	protected function register_component( $component, $path = '' ) {
		if ( ! class_exists( $path ) ) {
			throw new Exception( sprintf( '`%s` class does not exists.', $path ) );
		}

		if ( ! is_subclass_of( $path, 'Xu\\Components\\Component' ) ) {
			throw new Exception( sprintf( '`%s` class is not a instance of Xu\\Components\\Component.', $path ) );
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
	 * Require library files.
	 */
	protected function require_files() {
		$files = [
			'helpers.php',
			'lib/cache.php',
			'lib/clean.php',
			'lib/conditional.php',
			'lib/http.php',
			'lib/media.php',
			'lib/menu.php',
			'lib/option.php',
			'lib/post.php',
			'lib/rewrite.php',
			'lib/string.php',
			'lib/transient.php',
			'lib/utils.php',
			'model/helpers.php'
		];

		foreach ( $files as $file ) {
			if ( strpos( $file, '/' ) !== false ) {
				$file = '../' . $file;
			}

			if ( file_exists( __DIR__ . '/' . $file ) ) {
				require_once __DIR__ . '/' . $file;
			}
		}

		unset( $file );
	}
}
