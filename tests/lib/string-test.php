<?php

namespace Xu\Tests\Lib;

use Xu\Tests\Unit_Test_Case;

class String_Test extends Unit_Test_Case {

	public function test_xu_dashify() {
		$this->assertEquals( 'hello-world', xu_dashify( 'hello world' ) );
		$this->assertEquals( 'hello-world', xu::dashify( 'hello world' ) );
		$this->invalidArgumentTest( 'xu_dashify' );
	}

	public function test_xu_ends_with() {
		$this->assertTrue( xu_ends_with( 'hello world', 'world' ) );
		$this->assertTrue( xu::ends_with( 'hello world', 'world' ) );
		$this->assertFalse( xu_ends_with( 'hello world', 'hello' ) );
		$this->invalidArgumentTest( [
			'args' => ['string', ['array', 'string']],
			'fn'   => 'xu_ends_with'
		] );
	}

	public function test_xu_starts_with() {
		$this->assertTrue( xu_starts_with( 'hello world', 'hello' ) );
		$this->assertTrue( xu::starts_with( 'hello world', 'hello' ) );
		$this->assertFalse( xu_starts_with( 'hello world', 'world' ) );
		$this->invalidArgumentTest( [
			'args' => ['string', ['array', 'string']],
			'fn'   => 'xu_starts_with'
		] );
	}

	public function test_xu_strip_spaces() {
		$this->assertEquals( 'hello world!', xu_strip_spaces( 'hello world!' ) );
		$this->assertEquals( 'hello world!', xu::strip_spaces( 'hello world!' ) );
		$this->assertEquals( 'hello world!', xu_strip_spaces( 'hello world!' ) );
		$this->invalidArgumentTest( 'xu_strip_spaces' );
	}

	public function test_xu_underscorify() {
		$this->assertEquals( 'hello_world_it', xu_underscorify( 'hello world-it' ) );
		$this->assertEquals( 'hello_world_it', xu::underscorify( 'hello world-it' ) );
		$this->invalidArgumentTest( 'xu_underscorify' );
	}

}
