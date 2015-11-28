<?php

namespace Xu\Components\Strtoupper;

use Xu\Foundation\Foundation;
use Xu\Components\Component;

/**
 * Strtoupper component class.
 */
class Strtoupper extends Component {

    /**
     * Bootstrap the component.
     *
     * @return string
     */
    public function bootstrap() {
        return new \ReflectionFunction( 'strtoupper' );
    }

}
