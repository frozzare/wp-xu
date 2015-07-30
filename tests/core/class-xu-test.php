<?php

namespace Xu\Tests\Core;

use Xu\Core\xu;

class Xu_Test extends \WP_UnitTestCase {

    public function test_static_method() {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue( xu::is_http_method( 'GET' ) );
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertTrue( xu::is_http_method( 'POST' ) );
        unset( $_SERVER['REQUEST_METHOD'] );
        $this->assertFalse( xu::is_http_method( 'POST' ) );
        $_SERVER['REQUEST_METHOD'] = 'POST';
    }

}
