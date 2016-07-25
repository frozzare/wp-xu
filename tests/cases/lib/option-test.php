<?php

namespace Xu\Tests\Lib;

class Option_Test extends \WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		xu_register_large_option_post_type();
	}

	public function test_xu_add_option() {
		$this->assertFalse( xu_add_option( '', '' ) );
		$this->assertFalse( xu_add_option( false, '' ) );

		xu_add_option( 'hello', 'world' );
		$this->assertSame( 'world', xu_get_option( 'hello' ) );

		// Add option with same key again should not work.
		$this->assertFalse( xu_add_option( 'hello', 'world' ) );

		xu_delete_option( 'hello' );
	}

	public function test_xu_delete_option() {
		$this->assertFalse( xu_delete_option( '' ) );
		$this->assertFalse( xu_delete_option( false ) );

		xu_add_option( 'hello', 'world' );
		$this->assertTrue( xu_delete_option( 'hello' ) );
	}

	public function test_xu_get_option() {
		$this->assertFalse( xu_get_option( '' ) );
		$this->assertFalse( xu_get_option( false ) );

		$this->assertFalse( xu_get_option( 'hello' ) );

		xu_add_option( 'hello', 'world' );
		$this->assertSame( 'world', xu_get_option( 'hello' ) );

		xu_update_option( 'hello', 'world2' );
		$this->assertSame( 'world2', xu_get_option( 'hello' ) );

		xu_delete_option( 'hello' );
	}

	public function test_xu_get_option_post_id() {
		$this->assertSame( 0, xu_get_option_post_id( '' ) );
		$this->assertSame( 0, xu_get_option_post_id( false ) );

		xu_add_option( 'hello', 'world' );
		$this->assertNotSame( 0, xu_get_option_post_id( 'hello' ) );

		xu_delete_option( 'hello' );
	}

	public function test_xu_get_option_name() {
		$this->assertEmpty( xu_get_option_name( '' ) );
		$this->assertEmpty( xu_get_option_name( false ) );
		$this->assertSame( 'hello', xu_get_option_name( 'hello' ) );
	}

	public function test_xu_update_option() {
		$this->assertFalse( xu_update_option( '', '' ) );
		$this->assertFalse( xu_update_option( false, '' ) );

		xu_update_option( 'hello', 'world' );
		$this->assertSame( 'world', xu_get_option( 'hello' ) );

		xu_update_option( 'hello', 'world2' );
		$this->assertSame( 'world2', xu_get_option( 'hello' ) );

		xu_delete_option( 'hello' );
	}
}
