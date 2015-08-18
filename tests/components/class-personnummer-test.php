<?php

namespace Xu\Tests\Components;

class Personnummer_Test extends \WP_UnitTestCase {

    public function test_valid() {
        $personnummer = xu( 'personnummer' );
        $this->assertTrue( $personnummer->valid( 6403273813 ) );
        $this->assertTrue( $personnummer->valid( '19130401+2931' ) );
        $this->assertFalse( $personnummer->valid( null ) );
        $this->assertFalse( $personnummer->valid( array() ) );
        $this->assertFalse( $personnummer->valid( true ) );
        $this->assertFalse( $personnummer->valid( false ) );
        $this->assertFalse( $personnummer->valid( 100101001 ) );
        $this->assertFalse( $personnummer->valid( '112233-4455' ) );
    }

}
