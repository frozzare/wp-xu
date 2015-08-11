<?php

namespace Xu\Components;

use Xu\Foundation\xu;

/**
 * Component class.
 */
abstract class Component {

    /**
     * xu instance.
     *
     * @var \Xu\Foundation\xu
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
