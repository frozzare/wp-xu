<?php

namespace Xu\Components\Foo;

use Xu\Foundation\Foundation;
use Xu\Components\Component;

/**
 * Foo component class.
 */
class Foo extends Component {

    /**
     * Bootstrap the component.
     *
     * @return string
     */
    public function bootstrap() {
        return new \ReflectionClass( __NAMESPACE__ . '\\FooStub' );
    }

}

class FooStub {
    public function __construct() {
        return $this->__toString();
    }
    public function __toString() {
        return 'foo';
    }
}
