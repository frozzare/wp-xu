<?php

namespace Xu\Tests\Lib;

class Utils_Test extends \WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		$_GET  = [];
		$_POST = [];
	}

	public function tearDown() {
		parent::tearDown();
		$_GET  = [];
		$_POST = [];
	}

	public function test_xu_dashify() {
		$this->assertEquals( 'hello-world', xu_dashify( 'hello world' ) );
		$this->assertEmpty( xu_dashify( null ) );
		$this->assertEmpty( xu_dashify( true ) );
		$this->assertEmpty( xu_dashify( false ) );
		$this->assertEmpty( xu_dashify( 1 ) );
		$this->assertEmpty( xu_dashify( [] ) );
		$this->assertEmpty( xu_dashify( (object) [] ) );
	}

	public function test_xu_is_empty() {
		$this->assertTrue( xu_is_empty( null ) );
		$this->assertFalse( xu_is_empty( 'false' ) );
		$this->assertFalse( xu_is_empty( true ) );
		$this->assertFalse( xu_is_empty( false ) );
		$this->assertFalse( xu_is_empty( 0 ) );
		$this->assertFalse( xu_is_empty( 0.0 ) );
		$this->assertFalse( xu_is_empty( "0" ) );
	}

	public function test_xu_underscorify() {
		$this->assertEquals( 'hello_world_it', xu_underscorify( 'hello world-it' ) );
		$this->assertEmpty( xu_underscorify( null ) );
		$this->assertEmpty( xu_underscorify( true ) );
		$this->assertEmpty( xu_underscorify( false ) );
		$this->assertEmpty( xu_underscorify( 1 ) );
		$this->assertEmpty( xu_underscorify( [] ) );
		$this->assertEmpty( xu_underscorify( (object) [] ) );
	}

}
