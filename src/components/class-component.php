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

}
