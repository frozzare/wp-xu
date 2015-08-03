<?php

namespace Xu\Components;

/**
 * Version component class.
 *
 * @package xu
 */
class Version extends Component {

    /**
     * Bootstrap the version component.
     *
     * @return string
     */
    public function bootstrap() {
        return constant( 'xu::VERSION' );
    }

}
