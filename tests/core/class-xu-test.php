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

    public function test_register_alias() {
        try {
            xu::test_alias();
        } catch ( \Exception $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }

        try {
            xu()->register_alias( 'dashify', 'xu_dashify' );
        } catch ( \Exception $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }

        xu()->register_alias( 'test_alias', 'xu_dashify' );
        $this->assertEquals( 'xu-dashify', xu::test_alias( 'xu_dashify' ) );
        $this->assertEquals( 'xu-dashify', xu::test_alias( 'xu_dashify' ) );

        try {
            xu()->register_alias( 'test_alias', 'xu_dashify' );
        } catch ( \Exception $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }

        try {
            xu()->register_alias( 'dashify', null );
        } catch ( \Exception $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }

        try {
            xu()->register_alias( null, 'dashify' );
        } catch ( \Exception $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }
    }

    public function test_component() {
        $this->assertEquals( constant( 'xu::VERSION' ), xu( 'xu' )->version() );
    }

    public function test_register_component() {
        $this->assertTrue( xu( '' ) instanceof xu );

        try {
            $test = xu( 'test_version' ) instanceof xu;
        } catch ( \Exception $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }

        xu()->register_component( 'test_xu', 'Xu\\Components\\xu' );
        $this->assertEquals( constant( 'xu::VERSION' ), xu( 'test_xu' )->version() );

        try {
            xu()->register_component( null, 'dashify' );
        } catch ( \Exception $e ) {
            $this->assertEquals( 'Invalid argument. `$component` must be string.', $e->getMessage() );
        }

        try {
            xu()->register_component( 'dashify', null );
        } catch ( \Exception $e ) {
            $this->assertEquals( 'Invalid argument. `$path` must be string.', $e->getMessage() );
        }

        try {
            xu()->register_component( 'xu', 'dashify' );
        } catch ( \Exception $e ) {
            $this->assertEquals( '`xu` component exists.', $e->getMessage() );
        }

        try {
            xu()->register_component( 'dashify', 'xu\\fake\\test' );
        } catch ( \Exception $e ) {
            $this->assertEquals( '`xu\fake\test` class does not exists.', $e->getMessage() );
        }
    }

    public function test_get_method() {
        $this->assertEquals( 'xu_dashify', xu()->get_method( 'xu_dashify' ) );
        $this->assertEquals( 'xu_dashify', xu()->get_method( 'dashify' ) );
    }

    public function test_fn() {
        $this->assertEquals( 'xu-dashify', xu()->fn( 'xu_dashify', ['xu_dashify'] ) );
        $this->assertEquals( 'xu-dashify', xu()->fn( 'dashify', 'xu_dashify' ) );
    }

}
