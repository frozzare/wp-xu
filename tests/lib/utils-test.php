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

	public function test_xu_get_class_name() {
        $class_name = xu_get_class_name( __FILE__ );
		$this->assertEquals( '\Xu\Tests\Lib\Utils_Test', $class_name );

		$this->assertEmpty( xu_get_class_name( null ) );
		$this->assertEmpty( xu_get_class_name( true ) );
		$this->assertEmpty( xu_get_class_name( false ) );
		$this->assertEmpty( xu_get_class_name( 1 ) );
		$this->assertEmpty( xu_get_class_name( [] ) );
		$this->assertEmpty( xu_get_class_name( (object) [] ) );

		$class_name = xu_get_class_name( XU_FIXTURE_DIR . '/classes/class-hello-world.php' );
		$this->assertEquals( 'HelloWorld', $class_name );
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

	public function test_xu_remove_trailing_quotes() {
		$this->assertEquals( '"hello" "world"', xu_remove_trailing_quotes( '\"hello\" \"world\"' ) );
		$this->assertEmpty( xu_remove_trailing_quotes( null ) );
		$this->assertEmpty( xu_remove_trailing_quotes( true ) );
		$this->assertEmpty( xu_remove_trailing_quotes( false ) );
		$this->assertEmpty( xu_remove_trailing_quotes( 1 ) );
		$this->assertEmpty( xu_remove_trailing_quotes( [] ) );
		$this->assertEmpty( xu_remove_trailing_quotes( (object) [] ) );
	}

	public function test_xu_slugify() {
		$this->assertEquals( 'hello-world-aao', xu_slugify( 'hello world åäö' ) );
		$this->assertEmpty( xu_slugify( null ) );
		$this->assertEmpty( xu_slugify( true ) );
		$this->assertEmpty( xu_slugify( false ) );
		$this->assertEmpty( xu_slugify( 1 ) );
		$this->assertEmpty( xu_slugify( [] ) );
		$this->assertEmpty( xu_slugify( (object) [] ) );
		$this->assertEquals( 'hello-aao', xu_slugify( 'hello world åäö', [ 'world' ] ) );
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
