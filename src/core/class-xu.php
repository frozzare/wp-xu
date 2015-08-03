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
		return xu()->call_fn( $method, $args );
	}

	/**
	 * The constructor.
	 */
	private function __construct() {
		$this->load_alias();
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
	public function load_alias() {
		if ( ! $this->exists( 'xu.alias' ) ) {
			$alias = require_once __DIR__ . '/alias.php';
			$this->bind( 'xu.alias', $alias );
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
		$alias  = $this->make( 'xu.alias' );
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
	public function call_fn( $method, $args ) {
		$method = $this->get_method( $method );

		if ( ! is_array( $args ) ) {
			$args = [$args];
		}

		if ( ! function_exists( $method ) ) {
			throw new \Exception( sprintf( '%s function does not exists', $method ) );
		}

		return call_user_func_array( $method, $args );
	}

}

/**
 * Get the xu class instance.
 *
 * @return xu
 */
function xu() {
	return xu::instance();
}
