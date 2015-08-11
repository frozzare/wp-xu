<?php

namespace Xu\Components;

use Xu\Foundation\Xu;

/**
 * Component class.
 */
abstract class Component {

	/**
	 * xu instance.
	 *
	 * @var \Xu\Foundation\Xu
	 */
	protected $xu;

	/**
	 * Create a new component instance.
	 *
	 * @param \Xu\Foundation\Xu $xu
	 */
	public function __construct( Xu $xu ) {
		$this->xu = $xu;
	}

	/**
	 * Bootstrap the component.
	 *
	 * @codeCoverageIgnore
	 */
	public function bootstrap() {
	}

	/**
	 * Return the given object. Useful for chaining.
	 *
	 * @param mixed $obj
	 *
	 * @return mixed
	 */
	protected function with( $obj ) {
		return $obj;
	}

}
