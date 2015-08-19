<?php

namespace Xu\Tests\Foundation;

use Xu\Foundation\Foundation;

class Foundation_Test extends \WP_UnitTestCase {

    public function test_component() {
        $this->assertTrue( xu( '' ) instanceof Foundation );
        $this->assertEquals( Foundation::VERSION, xu( 'xu' )->version() );
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
