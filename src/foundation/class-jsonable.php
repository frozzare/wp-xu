<?php

namespace Xu\Foundation;

abstract class Jsonable {

	/**
	 * Convert the object into something JSON serializable.
	 *
	 * @return array
	 */
	public function json_serialize() {
		$items = $this->to_array();

		foreach ( $items as $key => $value ) {
			if ( $value instanceof Jsonable ) {
				$items[$key] = $value->json_serialize();
			}
		}

		return $items;
	}

	/**
	 * Convert the class to array.
	 *
	 * @return array
	 */
	abstract public function to_array();

	/**
	 * Convert the class instance to JSON.
	 *
	 * @param  int $options
	 *
	 * @return string
	 */
	public function to_json( $options = 0 ) {
		return json_encode( $this->json_serialize(), $options );
	}
}
