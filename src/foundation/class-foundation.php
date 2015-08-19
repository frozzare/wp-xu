<?php

namespace Xu\Foundation;

use Exception;
use Frozzare\Tank\Container;
use InvalidArgumentException;

/**
 * xu main class.
 */
class Foundation {

    /**
     * Boot xu foundation.
     */
    public static function boot() {
        require __DIR__ . '/../../bootstrap/autoload.php';
    }

}
