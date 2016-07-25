<?php

namespace Xu\Tests\Lib;

use Xu\Tests\Unit_Test_Case;

class Utils_Test extends Unit_Test_Case {

	public function test_xu_is_http_method() {
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$this->assertTrue( xu_is_http_method( 'GET' ) );
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->assertTrue( xu_is_http_method( 'POST' ) );
		unset( $_SERVER['REQUEST_METHOD'] );
		$this->assertFalse( xu_is_http_method( 'POST' ) );
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->assertFalse( xu_is_http_method( false ) );
		$this->assertFalse( xu_is_http_method( true ) );
		$this->assertFalse( xu_is_http_method( null ) );
		$this->assertFalse( xu_is_http_method( 1 ) );
		$this->assertFalse( xu_is_http_method( [] ) );
		$this->assertFalse( xu_is_http_method( (object)[] ) );
	}

	public function test_xu_is_wp() {
		$this->assertTrue( xu_is_wp( get_bloginfo( 'version' ) ) );
		$this->assertTrue( xu_is_wp( get_bloginfo( 'version' ), '=' ) );
		$this->assertFalse( xu_is_wp( get_bloginfo( 'version' ), '>' ) );
		$this->assertFalse( xu_is_wp( '1.0' ) );
		$this->invalidArgumentTest( 'xu_is_wp', ['string', 'string'] );
	}

	public function test_xu_get_class_name() {
		$this->assertEmpty( xu_get_class_name( false ) );
		$this->assertSame( 'Say', xu_get_class_name( XU_FIXTURE_DIR . '/classes/class-say.php' ) );
		$this->assertSame( '\Xu\Components\Stringx\Stringx', xu_get_class_name( XU_FIXTURE_DIR . '/components/class-stringx.php' )  );
	}

	public function test_xu_with() {
		require_once XU_FIXTURE_DIR . '/classes/class-say.php';
		$this->assertSame( 'Hello Fredrik!', xu_with( new \Say )->hello( 'Fredrik' ) );
	}
}
