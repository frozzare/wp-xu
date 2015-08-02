<?php

namespace Xu\Tests\Lib;

class Utils_Test extends \WP_UnitTestCase {

	public function test_xu_is_empty() {
		$this->assertTrue( xu_is_empty( null ) );
		$this->assertFalse( xu_is_empty( 'false' ) );
		$this->assertFalse( xu_is_empty( true ) );
		$this->assertFalse( xu_is_empty( false ) );
		$this->assertFalse( xu_is_empty( 0 ) );
		$this->assertFalse( xu_is_empty( 0.0 ) );
		$this->assertFalse( xu_is_empty( "0" ) );
	}

}
