<?php

namespace Xu\Components;

use xu;

/**
 * Component class.
 *
 * @package xu
 */
abstract class Component {

    /**
     * xu instance.
     *
     * @var \xu
     */
    protected $xu;

    /**
     * Create a new component instance.
     *
     * @param xu $xu
     */
    public function __construct( xu $xu ) {
        $this->xu = $xu;
    }

    /**
     * Bootstrap the component.
     */
    abstract public function bootstrap();

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
