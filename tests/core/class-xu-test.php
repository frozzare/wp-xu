<?php

namespace Xu\Tests\Core;

use xu;

class Xu_Test extends \WP_UnitTestCase {

    public function test_static_method() {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue( xu::is_http_method( 'GET' ) );
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertTrue( xu::is_http_method( 'POST' ) );
        unset( $_SERVER['REQUEST_METHOD'] );
        $this->assertFalse( xu::is_http_method( 'POST' ) );
        $_SERVER['REQUEST_METHOD'] = 'POST';

        try {
            xu::fake_method();
            $this->assertTrue( false );
        } catch ( \Exception $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }
    }

    public function test_get_method() {
        $this->assertEquals( 'xu_dashify', xu()->get_method( 'xu_dashify' ) );
        $this->assertEquals( 'xu_dashify', xu()->get_method( 'dashify' ) );
    }

    public function test_call_fn() {
        $this->assertEquals( 'xu-dashify', xu()->call_fn( 'xu_dashify', ['xu_dashify'] ) );
        $this->assertEquals( 'xu-dashify', xu()->call_fn( 'dashify', 'xu_dashify' ) );
    }

}
