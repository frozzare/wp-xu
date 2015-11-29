<?php

namespace Xu\Model;

use ArrayAccess;
use ReflectionClass;
use Xu\Foundation\Jsonable;

class Collection extends Jsonable implements ArrayAccess {

    /**
     * The constructor.
     *
     * @param array $items
     */
    public function __construct( array $items = [] ) {
        $this->items = $items;
    }

    /**
     * Get all models in the collection.
     *
     * @return array
     */
    public function all() {
        return $this->items;
    }

    /**
     * Get number of items that exists in the collection.
     *
     * @return int
     */
    public function count() {
        return count( $this->items );
    }

    /**
     * Get item in collection.
     *
     * @param  string $offset
     *
     * @return mixed
     */
    public function eq( $offset ) {
        return $this->offsetGet( $offset );
    }

    /**
     * Create a collection of all elements that do pass
     * the given truth test.
     *
     * @param  callable|string $callback
     * @param  mixed $value
     *
     * @return array
     */
    public function filter( $callback, $value = null ) {
        if ( ! is_callable( $callback ) ) {
            $callback = function ( $item ) use ( $callback, $value ) {
                return $item[$callback] === $value;
            };
        }

        return new static( array_values( array_filter( $this->items, $callback ) ) );
    }

    /**
     * Find attribute value by key.
     *
     * @param  mixed  $attributes
     * @param  string $key
     * @param  mxied  $default
     *
     * @return mixed
     */
    protected function find_in_item( $attributes, $key, $default = null ) {
        if ( empty( $key ) || ! is_string( $key ) ) {
            return;
        }

        $key = explode( '.', $key );

        foreach ( $key as $part ) {
            if ( is_object( $attributes ) && get_class( $attributes ) === 'stdClass' ) {
                $attributes = (array) $attributes;
            }

            if ( $attributes instanceof Model === false && ( ! is_array( $attributes ) || ! array_key_exists( $part, $attributes ) ) ) {
                return $default;
            }

            $attributes = $attributes[$part];
        }

        if ( is_null( $attributes ) ) {
            return $default;
        }

        return $attributes;
    }

    /**
     * Get the first item in the collection.
     *
     * @param callable $callback
     *
     * @return mixed
     */
    public function first( callable $callback = null ) {
        if ( empty( $callback ) ) {
            return $this->items[0];
        }

        if ( $items = $this->filter( $callback ) ) {
            return $items->first();
        }
    }

    /**
     * Determine if the collection is empty or not.
     *
     * @return bool
     */
    public function is_empty() {
        return empty( $this->items );
    }

    /**
     * Get the last item in the collection.
     *
     * @param callable $callback
     *
     * @return mixed
     */
    public function last( callable $callback = null ) {
        if ( empty( $callback ) ) {
            return $this->items[count( $this->items ) - 1];
        }

        if ( $items = $this->filter( $callback ) ) {
            return $items->last();
        }
    }

    /**
     * Run map over each of the items.
     *
     * @param  callable $callback
     *
     * @return \Xu\Model\Collection
     */
    public function map( callable $callback ) {
        $keys  = array_keys( $this->items );
        $items = array_map( $callback, $this->items, $keys );
        return new static( array_combine( $keys, $items ) );
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  mixed $offset
     *
     * @return bool
     */
    public function offsetExists( $offset ) {
        return isset( $this->items[$offset] );
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed $offset
     *
     * @return mixed
     */
    public function offsetGet( $offset ) {
        return $this->items[$offset];
    }

    /**
     * Set the value for a given offset.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $value ) {
        $this->items[$offset] = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param mixed $offset
     */
    public function offsetUnset( $offset ) {
        unset( $this->items[$offset] );
    }

    /**
     * Pluck a certain field out of each item in a list.
     *
     * @param  string $key
     *
     * @return array
     */
    public function pluck( $key ) {
        return wp_list_pluck( $this->items, $key );
    }

    /**
     * Removes and return the last item from the collection.
     *
     * @return mixed
     */
    public function pop() {
        return array_pop( $this->items );
    }

    /**
     * Create a collection of all elements that do not pass
     * the given truth test.
     *
     * @param  callable|string $callback
     * @param  mixed $value
     *
     * @return \Xu\Model\Collection
     */
    public function reject( $callback, $value = null ) {
        if ( ! is_callable( $callback ) ) {
            $callback = function ( $item ) use ( $callback, $value ) {
                return $item[$callback] === $value;
            };
        }

        return $this->filter( function ( $item ) use ( $callback ) {
            return ! $callback( $item );
        } );
    }

    /**
     * Reverse the collection items.
     *
     * @return array
     */
    public function reverse() {
        return new static( array_reverse( $this->items ) );
    }

    /**
     * Removes and return the first item from the collection.
     *
     * @return mixed
     */
    public function shift() {
        return array_shift( $this->items );
    }

    /**
     * Extract a slice of the collection.
     *
     * @param  int  $offset
     * @param  int  $length
     * @param  bool $preserve_keys
     *
     * @return \Xu\Model\Collection
     */
    public function slice( $offset, $length = null, $preserve_keys = false ) {
        return new static( array_slice( $this->items, $offset ) );
    }

    /**
     * Sort through each item in the collection.
     *
     * @param  callable $callback
     *
     * @return \Xu\Model\Collection
     */
    public function sort( callable $callback ) {
        $items = $this->all();
        uasort( $items, $callback );
        return new static( array_values( $items ) );
    }

    /**
     * Filter models by the given key value pair.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return \Xu\Model\Collection
     */
    public function where( $key, $value = null ) {
        if ( is_callable( $key ) ) {
            return $this->filter( $key );
        }

        return $this->filter( function ( $item ) use ( $key, $value ) {
            return $this->find_in_item( $item, $key ) === $value;
        } );
    }

    /**
     * Convert the collection items to an array.
     *
     * @return array
     */
    public function to_array() {
        return $this->items;
    }
}
