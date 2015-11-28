<?php

namespace Xu\Components\Test;

use Xu\Foundation\Foundation;

/**
 * Test component class.
 */
class Test {

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
