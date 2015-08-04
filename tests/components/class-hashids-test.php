<?php

namespace Xu\Tests\Components;

use xu;

class Hashids_Test extends \WP_UnitTestCase {

    public function test_encode() {
        $hashids = xu( 'hashids' );
        $this->assertEquals( 'o2fXhV', $hashids->encode( 1, 2, 3 ) );
    }

    public function test_decode() {
        $hashids = xu( 'hashids' );
        $id = $hashids->encode( 1, 2, 3 );
        $this->assertEquals( [1, 2, 3], $hashids->decode( $id ) );
    }

    public function test_encode_with_arguments() {
        $hashids = xu( 'hashids', ['this is my salt', 8, 'abcdefghij1234567890'] );
        $this->assertEquals( '514cdi42', $hashids->encode( 1, 2, 3 ) );
    }

    public function test_decode_with_arguments() {
        $hashids = xu( 'hashids', ['this is my salt', 8, 'abcdefghij1234567890'] );
        $id = $hashids->encode( 1, 2, 3 );
        $this->assertEquals( [1, 2, 3], $hashids->decode( $id ) );
    }

}
