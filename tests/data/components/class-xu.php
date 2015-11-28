<?php

namespace Xu\Components\Xu;

use Xu\Foundation\Foundation;
use Xu\Components\Component;

/**
 * xu component class.
 */
class Xu extends Component {

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
        return Foundation::VERSION;
    }

}