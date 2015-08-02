<?php

namespace Xu\Tests\Lib;

use InvalidArgumentException;

class String_Test extends \WP_UnitTestCase {

	public function test_xu_dashify() {
		$this->assertEquals( 'hello-world', xu_dashify( 'hello world' ) );

		try {
			xu_dashify( null );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_dashify( true );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_dashify( false );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_dashify( 1 );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_dashify( [] );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_dashify( (object) [] );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}
	}

	public function test_xu_strip_spaces() {
		$this->assertEquals( 'hello world!', xu_strip_spaces( ' hello world! ' ) );
		$this->assertEquals( 'hello world!', xu_strip_spaces( 'hello world!' ) );

		try {
			xu_strip_spaces( null );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_strip_spaces( true );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_strip_spaces( false );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_strip_spaces( 1 );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_strip_spaces( [] );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_strip_spaces( (object) [] );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}
	}

	public function test_xu_underscorify() {
		$this->assertEquals( 'hello_world_it', xu_underscorify( 'hello world-it' ) );

		try {
			xu_underscorify( null );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_underscorify( true );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_underscorify( false );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_underscorify( 1 );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_underscorify( [] );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}

		try {
			xu_underscorify( (object) [] );
		} catch( InvalidArgumentException $e ) {
			$this->assertEquals( 'Invalid argument. Must be string.', $e->getMessage() );
		}
	}

}
