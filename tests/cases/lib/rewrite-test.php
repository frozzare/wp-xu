<?php

namespace Xu\Tests\Lib;

class Rewrite_Test extends \WP_UnitTestCase {

	public function test_xu_current_url() {
		// As string.
		$this->assertEquals( 'http://example.org/', xu_current_url() );

		// Parsed array.
		$actual   = xu_current_url( true );
		$expected = [
			'scheme' => 'http',
			'host'   => 'example.org',
			'path'   => '/'
		];

		$this->assertEquals( $actual, $expected );

		// Parsed object.
		$actual   = xu_current_url( true, true );
		$expected = (object) [
			'scheme' => 'http',
			'host'   => 'example.org',
			'path'   => '/'
		];

		$this->assertEquals( $actual, $expected );
	}

	public function test_xu_get_permalink() {
		// No post.
		$this->assertFalse( xu_get_permalink() );

		$post_id = $this->factory->post->create();

		// Should be the same.
		$this->assertSame( get_permalink( $post_id ), xu_get_permalink( $post_id ) );

		// Should exists in wp cache.
		$this->assertSame( get_permalink( $post_id ), wp_cache_get( md5( serialize( [$post_id, false] ) ), 'xu_get_permalink' ) );
	}

	public function test_xu_url_to_postid() {
		// Wrong host.
		$this->assertSame( 0, xu_url_to_postid( 'https://wordpress.org' ) );

		$post_id = $this->factory->post->create();
		$url = get_permalink( $post_id );

		// Should be same post id if host
		$this->assertSame( $post_id, xu_url_to_postid( $url ) );

		// Should exists in the wp cache.
		$this->assertSame( $post_id, wp_cache_get( md5( serialize( [$url] ) ), 'xu_url_to_postid' ) );
	}
}
