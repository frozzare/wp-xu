<?php

namespace Xu\Tests\Foundation;

use Xu\Foundation\Foundation;
use Xu\Facades\Foundation as FoundationFacade;

class Foundation_Test extends \WP_UnitTestCase {

    public function test_component() {
        $this->assertEquals( Foundation::VERSION, xu( 'xu' )->version() );
    }

    public function test_register_component() {
        $this->assertTrue( \xu( '' ) instanceof Foundation );

        try {
            $test = \xu( 'test_version' ) instanceof Foundation;
        } catch ( \Exception $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }

        FoundationFacade::register_component( 'test_xu', 'Xu\\Components\\Xu\\Xu' );
        $this->assertEquals( Foundation::VERSION, \xu( 'test_xu' )->version() );

        try {
            FoundationFacade::register_component( null, 'dashify' );
        } catch ( \Exception $e ) {
            $this->assertEquals( 'Invalid argument. `$component` must be string.', $e->getMessage() );
        }

        try {
            FoundationFacade::register_component( 'dashify', null );
        } catch ( \Exception $e ) {
            $this->assertEquals( 'Invalid argument. `$path` must be string.', $e->getMessage() );
        }

        try {
            FoundationFacade::register_component( 'xu', 'dashify' );
        } catch ( \Exception $e ) {
            $this->assertEquals( '`xu` component exists.', $e->getMessage() );
        }

        try {
            FoundationFacade::register_component( 'dashify', 'xu\\fake\\test' );
        } catch ( \Exception $e ) {
            $this->assertEquals( '`xu\fake\test` class does not exists.', $e->getMessage() );
        }

        FoundationFacade::register_component( [
             'test_xu_s_1' => 'Xu\\Components\\Xu\\Xu',
             'test_xu_s_2' => 'Xu\\Components\\Xu\\Xu'
        ] );
        $this->assertEquals( Foundation::VERSION, \xu( 'test_xu_s_1' )->version() );
        $this->assertEquals( Foundation::VERSION, \xu( 'test_xu_s_2' )->version() );
    }

    public function test_fn_method() {
        $this->assertEquals( 'xu-dashify', \xu()->fn( 'xu_dashify', ['xu_dashify'] ) );
        $this->assertEquals( 'xu-dashify', \xu()->fn( 'dashify', 'xu_dashify' ) );
    }

    public function test_component_method() {
        try {
            \xu()->component( null );
        } catch ( \Exception $e ) {
            $this->assertEquals( 'Invalid argument. `$component` must be string.', $e->getMessage() );
        }
    }

}
