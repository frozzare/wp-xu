<?php

namespace Xu\Model;

use ArrayAccess;
use ReflectionClass;

abstract class Model implements ArrayAccess {

    /**
     * Model attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Determine if a attribute exists or not.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function __isset( $key ) {
        $attributes = $this->get_attributes_array();
        return isset( $attributes[$key] );
    }

    /**
     * Get post property by key.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get( $key ) {
        if ( $attribute = $this->get( $key ) ) {
            return $attribute;
        }

        switch ( $key ) {
            case 'id':
                return get_the_ID() ?: null;
            case 'post':
                return get_post();
            default:
                break;
        }
    }

    /**
     * Set attribute value.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function __set( $key, $value ) {
        $this->attributes[$key] = $value;
    }

    /**
     * Unset attribute key.
     *
     * @param string $key
     */
    public function __unset( $key ) {
        unset( $this->attributes[$key] );
    }

    /**
     * Call method with parameters.
     *
     * @param  string $name
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call( $method, array $parameters = [] ) {
        return call_user_func_array( $method, $parameters );
    }

    /**
     * Call static method with paramters.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public static function __callStatic( $method, array $parameters = [] ) {
        $instance = new static;
        return call_user_func_array( [$instance, $method], $arguments );
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function json_serialize() {
        return $this->to_array();
    }

    /**
     * Get model attribute.
     *
     * @param  string $key
     * @param  mixed  $default
     *
     * @return mixed
     */
    public function get( $key, $default = null ) {
        if ( empty( $key ) || ! is_string( $key ) ) {
            return;
        }

        $key        = explode( '.', $key );
        $attributes = $this->get_attributes_array();

        foreach ( $key as $part ) {
            if ( ! is_array( $attributes ) || ! array_key_exists( $part, $attributes ) ) {
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
     * Get the model attributes.
     *
     * @return array
     */
    public function get_attributes() {
        return [];
    }

    /**
     * Get attributes array.
     *
     * @return array
     */
    public function get_attributes_array() {
        $attributes = $this->get_attributes();
        $attributes = is_array( $attributes ) ? $attributes : [];
        return array_merge( $attributes, $this->attributes );
    }

    /**
     * Get a model with in a model instance.
     *
     * @param  string $model
     *
     * @return mixed
     */
    public function get_model( $model ) {
        return xu_get_model( $model );
    }

    /**
     * Create a new model instance.
     *
     * @return mixed
     */
    public static function model() {
        $reflection = new ReflectionClass( static::class );
        return $reflection->newInstanceArgs( func_get_args() );
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  mixed $offset
     *
     * @return bool
     */
    public function offsetExists( $offset ) {
        return isset( $this->$offset );
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed $offset
     *
     * @return mixed
     */
    public function offsetGet( $offset ) {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $value ) {
        $this->$offset = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param mixed $offset
     */
    public function offsetUnset( $offset ) {
        unset( $this->$offset );
    }

    /**
     * Set model attribute.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set( $key, $value ) {
        $this->$key = $value;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function to_array() {
        return $this->get_attributes_array();
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int $options
     *
     * @return string
     */
    public function to_json( $options = 0 ) {
        return json_encode( $this->json_serialize(), $options );
    }
}
