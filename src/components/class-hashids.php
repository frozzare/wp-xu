<?php

namespace Xu\Components;

/**
 * Hashids component class.
 *
 * @package xu
 */
class Hashids extends Component {

    /**
     * Bootstrap the Hashids component.
     */
    public function bootstrap() {
        return new \ReflectionClass( '\\Hashids\\Hashids' );
    }

}
