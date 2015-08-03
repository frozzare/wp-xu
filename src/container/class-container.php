<?php

namespace Xu\Container;

/**
 * Container class.
 *
 * @package xu
 */
class Container implements \ArrayAccess {

	/**
	 * The keys holder.
	 *
	 * @var array
	 */
	protected $keys = [];

	/**
	 * The singletons holder.
	 *
	 * @var array
	 */
	protected $singletons = [];

	/**
	 * The values holder.
	 *
	 * @var array
	 */
	protected $values = [];

	/**
	 * Set a parameter or an object.
	 *
	 * @param string $id
	 * @param mixed $value
	 */
	public function bind( $id, $value ) {
		if ( isset( $this->singletons[$id] ) && $this->values[$id] === false ) {
			throw new \Exception( sprintf( 'Identifier [%s] is a singleton and cannot be rebind', $id ) );
		}

		if ( ! $value instanceof Closure ) {
			$value = function() use ( $value ) {
				return $value;
			};
		}

		$this->values[$id] = $value;
		$this->keys[$id] = true;
	}

	/**
	 * Check if identifier is set or not.
	 *
	 * @param string $id
	 *
	 * @return bool
	 */
	public function exists( $id ) {
		return isset( $this->keys[$id] );
	}

	/**
	 *
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function make( $id ) {
		if ( ! isset( $this->keys[$id] ) ) {
			throw new \InvalidArgumentException( sprintf( 'Identifier [%s] is not defined', $id ) );
		}

		if ( isset( $this->singletons[$id] ) ) {
			return $this->singletons[$id]();
		}

		return $this->values[$id]();
	}

	/**
	 * Set a parameter or an object.
	 *
	 * @param string $id
	 * @param mixed $value
	 */
	public function singleton( $id, $value ) {
		if ( isset( $this->singletons[$id] ) && $this->values[$id] === false ) {
			throw new \Exception( sprintf( 'Identifier [%s] is a singleton and cannot be rebind', $id ) );
		}

		if ( ! $value instanceof Closure ) {
			$value = function() use( $value ) {
				return $value;
			};
		}

		$this->keys[$id] = true;
		$this->singletons[$id] = $value;
		$this->values[$id] = false;
	}

	/**
	 * Unset value by identifier.
	 *
	 * @param string $id
	 */
	public function remove( $id ) {
		unset( $this->keys[$id], $this->values[$id] );
	}

	/**
	 * Check if identifier is set or not.
	 *
	 * @param string $id
	 *
	 * @return bool
	 */
	// @codingStandardsIgnoreStart
	public function offsetExists( $id ) {
	// @codingStandardsIgnoreEnd
		return $this->exists( $id );
	}

	/**
	 * Get value by identifier.
	 *
	 * @param string $id
	 *
	 * @return mixed
	 */
	// @codingStandardsIgnoreStart
	public function offsetGet( $id ) {
	// @codingStandardsIgnoreEnd
		return $this->make( $id );
	}

	/**
	 * Set a parameter or an object.
	 *
	 * @param string $id
	 * @param mixed $value
	 */
	// @codingStandardsIgnoreStart
	public function offsetSet( $id, $value ) {
	// @codingStandardsIgnoreEnd
		$this->bind( $id, $value );
	}

	/**
	 * Unset value by identifier.
	 *
	 * @param string $id
	 */
	// @codingStandardsIgnoreStart
	public function offsetUnset( $id ) {
	// @codingStandardsIgnoreEnd
		$this->remove( $id );
	}
}
