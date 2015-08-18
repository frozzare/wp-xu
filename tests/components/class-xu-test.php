<?php

namespace Xu\Tests\Components;

class Xu_Test extends \WP_UnitTestCase {

    public function test_version() {
        $this->assertEquals( constant( 'xu::VERSION' ), xu( 'xu' )->version() );
    }

    public function test_tostring() {
        $this->assertEquals( constant( 'xu::VERSION' ), (string) xu( 'xu' ) );
    }

}
