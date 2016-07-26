<?php

namespace Xu\Tests\Lib;

use Xu\Tests\Unit_Test_Case;

class String_Test extends Unit_Test_Case {

	public function test_xu_camel_case() {
		$this->assertSame( 'fooBar', xu_camel_case( 'foo-bar' ) );
		$this->assertSame( 'fooBar', xu_camel_case( 'foo bar' ) );
		$this->assertSame( 'fooBar', xu_camel_case( 'foo_bar' ) );
		$this->invalidArgumentTest( 'xu_camel_case' );
	}

	public function test_xu_contains() {
		$this->assertTrue( xu_contains( 'foobar', 'bar' ) );
		$this->assertFalse( xu_contains( 'foobar', 'foobars' ) );
		$this->invalidArgumentTest( 'xu_contains', ['string', 'string'] );
	}

	public function test_xu_convert_to_string() {
		$this->assertSame( 'false', xu_convert_to_string( false ) );
		$this->assertSame( 'true', xu_convert_to_string( true ) );
		$this->assertSame( '0.1', xu_convert_to_string( 0.1 ) );
		$this->assertSame( '1.1', xu_convert_to_string( 1.1 ) );
		$this->assertSame( '0', xu_convert_to_string( 0 ) );
		$this->assertEmpty( xu_convert_to_string( [] ) );
		$this->assertEmpty( xu_convert_to_string( new \stdClass() ) );
		$this->assertNotEmpty( xu_convert_to_string( new \ReflectionClass( 'ReflectionClass' ) ) );
	}

	public function test_xu_dashify() {
		$this->assertEquals( 'hello-world', xu_dashify( 'hello world' ) );
		$this->invalidArgumentTest( 'xu_dashify' );
	}

	public function test_xu_ends_with() {
		$this->assertTrue( xu_ends_with( 'hello world', 'world' ) );
		$this->assertFalse( xu_ends_with( 'hello world', 'hello' ) );
		$this->invalidArgumentTest( 'xu_ends_with', ['string', ['array', 'string']] );
	}

	public function test_xu_starts_with() {
		$this->assertTrue( xu_starts_with( 'hello world', 'hello' ) );
		$this->assertFalse( xu_starts_with( 'hello world', 'world' ) );
		$this->invalidArgumentTest( 'xu_starts_with', ['string', ['array', 'string']] );
	}

	public function test_xu_studly_case() {
		$this->assertSame( 'FooBar', xu_studly_case( 'foo-bar' ) );
		$this->assertSame( 'FooBar', xu_studly_case( 'foo bar' ) );
		$this->assertSame( 'FooBar', xu_studly_case( 'foo_bar' ) );
		$this->invalidArgumentTest( 'xu_studly_case' );
	}

	public function test_xu_strip_spaces() {
		$this->assertSame( 'hello world!', xu_strip_spaces( 'hello world!' ) );
		$this->assertSame( 'hello world!', xu_strip_spaces( 'hello world!' ) );
		$this->invalidArgumentTest( 'xu_strip_spaces' );
	}

	public function test_xu_snake_case() {
		$this->assertSame( 'hello_world_it', xu_snake_case( 'hello world-it' ) );
		$this->assertSame( 'hello_world_it', xu_snake_case( 'helloWorldIt' ) );
		$this->invalidArgumentTest( 'xu_snake_case', ['string', 'string'] );
	}

}
