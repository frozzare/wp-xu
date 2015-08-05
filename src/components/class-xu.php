<?php

namespace Xu\Components;

/**
 * xu component class.
 *
 * @package xu
 */
// @codingStandardsIgnoreStart
class xu extends Component {
// @codingStandardsIgnoreEnd

    /**
     * Bootstrap the version component.
     *
     * @return string
     */
    public function bootstrap() {
    }

    /**
     * When converting the object to a string, the version is returned.
     *
     * @return string
     */
    public function __toString() {
        return $this->version();
    }

    /**
     * Get xu version.
     *
     * @return string
     */
    public function version() {
        return constant( 'xu::VERSION' );
    }

}
