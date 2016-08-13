<?php

namespace Xu\Foundation;

use Exception;
use Frozzare\Tank\Container;
use InvalidArgumentException;

class Foundation extends Container {

	/**
	 * Foundation instance.
	 *
	 * @var \Xu\Foundation\Foundation
	 */
	protected static $instance;

	/**
	 * The constructor.
	 */
	public function __construct() {
		$this->require_files();
		$this->boot();
	}

	/**
	 * Boot the foundation.
	 */
	public function boot() {
		xu_register_large_option_post_type();
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
