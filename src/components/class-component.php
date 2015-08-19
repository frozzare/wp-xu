<?php

namespace Xu\Components;

use Xu\Foundation\Foundation;

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
     * @param \Xu\Foundation\Foundation $xu
     */
    public function __construct( Foundation $xu ) {
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
