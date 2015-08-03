<?php

namespace Xu\Tests\Lib;

use Xu\Tests\Unit_Test_Case;

class String_Test extends Unit_Test_Case {

	public function test_xu_camel_case() {
		$this->assertEquals( 'fooBar', xu_camel_case( 'foo-bar' ) );
		$this->assertEquals( 'fooBar', xu_camel_case( 'foo bar' ) );
		$this->assertEquals( 'fooBar', xu_camel_case( 'foo_bar' ) );
		$this->invalidArgumentTest( 'xu_camel_case' );
	}

	public function test_xu_contains() {
		$this->assertTrue( xu_contains( 'foobar', 'bar' ) );
		$this->assertFalse( xu_contains( 'foobar', 'foobars' ) );
		$this->invalidArgumentTest( 'xu_contains', ['string', 'string'] );
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
		$this->assertEquals( 'FooBar', xu_studly_case( 'foo-bar' ) );
		$this->assertEquals( 'FooBar', xu_studly_case( 'foo bar' ) );
		$this->assertEquals( 'FooBar', xu_studly_case( 'foo_bar' ) );
		$this->invalidArgumentTest( 'xu_studly_case' );
	}

	public function test_xu_strip_spaces() {
		$this->assertEquals( 'hello world!', xu_strip_spaces( 'hello world!' ) );
		$this->assertEquals( 'hello world!', xu_strip_spaces( 'hello world!' ) );
		$this->invalidArgumentTest( 'xu_strip_spaces' );
	}

	public function test_xu_snake_case() {
		$this->assertEquals( 'hello_world_it', xu_snake_case( 'hello world-it' ) );
		$this->assertEquals( 'hello_world_it', xu_snake_case( 'helloWorldIt' ) );
		$this->invalidArgumentTest( 'xu_snake_case', ['string', 'string'] );
	}

}
