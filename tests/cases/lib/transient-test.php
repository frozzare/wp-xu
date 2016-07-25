<?php

namespace Xu\Tests\Lib;

class Transient_Test extends \WP_UnitTestCase {

	public function test_xu_delete_transient() {
		$this->assertFalse( xu_delete_transient( 'missing' ) );
		$this->assertFalse( xu_delete_transient( false ) );

		$this->assertSame( 'hello', xu_get_transient( 'hello', 'hello' ) );
		$this->assertTrue( xu_delete_transient( 'hello' ) );
	}

	public function test_xu_delete_site_transient() {
		$this->assertFalse( xu_delete_site_transient( 'missing' ) );
		$this->assertFalse( xu_delete_site_transient( false ) );

		$this->assertSame( 'hello', xu_get_site_transient( 'hello', 'hello' ) );
		$this->assertTrue( xu_delete_site_transient( 'hello' ) );
	}

	public function test_xu_get_transient() {
		$this->assertFalse( xu_get_transient( 'missing' ) );
		$this->assertFalse( xu_get_transient( false ) );
		$this->assertFalse( xu_get_transient( 'hello', '__return_null' ) );

		$this->assertSame( 'hello', xu_get_transient( 'hello', 'hello' ) );
		$this->assertTrue( xu_delete_transient( 'hello' ) );

		$this->assertSame( 'hello', xu_get_transient( 'hello', function () {
			return 'hello';
		} ) );
		$this->assertTrue( xu_delete_transient( 'hello' ) );

		$this->assertSame( 'hello', xu_get_transient( 'hello', [$this, '_hello'] ) );
		$this->assertTrue( xu_delete_transient( 'hello' ) );
	}

	public function test_xu_get_site_transient() {
		$this->assertFalse( xu_get_site_transient( 'missing' ) );
		$this->assertFalse( xu_get_site_transient( false ) );
		$this->assertFalse( xu_get_site_transient( 'hello', '__return_null' ) );

		$this->assertSame( 'hello', xu_get_site_transient( 'hello', 'hello' ) );
		$this->assertTrue( xu_delete_site_transient( 'hello' ) );

		$this->assertSame( 'hello', xu_get_site_transient( 'hello', function () {
			return 'hello';
		} ) );
		$this->assertTrue( xu_delete_site_transient( 'hello' ) );

		$this->assertSame( 'hello', xu_get_site_transient( 'hello', [$this, '_hello'] ) );
		$this->assertTrue( xu_delete_site_transient( 'hello' ) );
	}

	public function _hello() {
		return 'hello';
	}
}
