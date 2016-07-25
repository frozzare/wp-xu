<?php

namespace Xu\Tests\Lib;

class Cache_Test extends \WP_UnitTestCase {

	public function test_xu_cache_delete() {
		// Empty key.
		$this->assertFalse( xu_cache_delete( '' ) );

		// Bad key.
		$this->assertFalse( xu_cache_delete( false ) );

		// Key that don't exists.
		$this->assertFalse( xu_cache_delete( 'hello' ) );

		// Only string key is allowed if last argument is false.
		$this->assertFalse( xu_cache_delete( false, 'hello' ) );

		// Key that exists.
		wp_cache_set( 'hello', 'hello' );
		$this->assertTrue( xu_cache_delete( 'hello' ) );

		// Serialized key that exists.
		$cache_key = md5( serialize( ['hello'] ) );
		wp_cache_set( $cache_key, 'hello' );
		$this->assertTrue( xu_cache_delete( $cache_key ) );

		// Key with group that exists.
		wp_cache_set( 'hello', 'hello', 'world' );
		$this->assertTrue( xu_cache_delete( 'hello', 'world' ) );

		// Serialized key that exists.
		$cache_key = md5( serialize( ['hello'] ) );
		wp_cache_set( $cache_key, 'hello' );
		$this->assertTrue( xu_cache_delete( ['hello'] ) );
	}

	public function test_xu_cache_get() {
		// Empty key and function.
		$this->assertFalse( xu_cache_get( '', '' ) );

		// Bad functions.
		$this->assertFalse( xu_cache_get( '', 'hello' ) );
		$this->assertFalse( xu_cache_get( '', false ) );

		// Key that don't exists should return function value.
		$this->assertNotEmpty( xu_cache_get( 'hello', 'uniqid' ) );
		$this->assertTrue( xu_cache_delete( 'hello' ) );

		// Callable function.
		$this->assertSame( 'hello', xu_cache_get( 'hello', [$this, '_hello'] ) );
		$this->assertTrue( xu_cache_delete( 'hello' ) );

		// Key that exists.
		wp_cache_set( 'hello', 'hello' );
		$this->assertSame( 'hello', xu_cache_get( 'hello' ) );

		// Serialized key that exists.
		$cache_key = md5( serialize( ['hello'] ) );
		wp_cache_set( $cache_key, 'hello' );
		$this->assertSame( 'hello', xu_cache_get( $cache_key ) );
	}

	public function test_xu_cache_key() {
		$this->assertNull( xu_cache_key( false ) );
		$this->assertSame( 'hello', xu_cache_key( 'hello' ) );
		$this->assertSame( 'hello', xu_cache_key( 'hello', null ) );
		$this->assertSame( 'hello:1', xu_cache_key( 'hello', 1 ) );
		$this->assertSame( 'hello:1', xu_cache_key( 'hello', true ) );
		$this->assertSame( 'hello:0', xu_cache_key( 'hello', false ) );
		$this->assertSame( 'hello:' . md5( serialize( ['hello'] ) ), xu_cache_key( 'hello', ['hello'] ) );
		$this->assertSame( 'hello:' . md5( serialize( (object)['hello'] ) ), xu_cache_key( 'hello', (object)['hello'] ) );
	}

	public function _hello() {
		return 'hello';
	}
}
