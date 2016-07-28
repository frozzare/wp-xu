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

	public function test_xu_current_url_to_postid() {
		// Wrong host.
		$this->assertSame( 0, xu_current_url_to_postid() );

		$post_id = $this->factory->post->create();
		$url = get_permalink( $post_id );
		$_SERVER['REQUEST_URI'] = '?p=' . $post_id;

		// Should be same post id if host
		$this->assertSame( $post_id, xu_current_url_to_postid() );

		// Should exists in the wp cache.
		$this->assertSame( $post_id, wp_cache_get( $url, 'xu_url_to_postid' ) );

		// Test to clean post cache.
		xu_clean_post_cache( $post_id );

		// Should not exists in the cache when cleaned.
		$this->assertFalse( wp_cache_get( $url, 'xu_url_to_postid' ) );

		$_SERVER['REQUEST_URI'] = null;
	}

	public function test_xu_url_to_postid() {
		// Wrong host.
		$this->assertSame( 0, xu_url_to_postid( 'https://wordpress.org' ) );

		$post_id = $this->factory->post->create();
		$url = get_permalink( $post_id );

		// Should be same post id if host
		$this->assertSame( $post_id, xu_url_to_postid( $url ) );

		// Should exists in the wp cache.
		$this->assertSame( $post_id, wp_cache_get( $url, 'xu_url_to_postid' ) );

		// Test to clean post cache.
		xu_clean_post_cache( $post_id );

		// Should not exists in the cache when cleaned.
		$this->assertFalse( wp_cache_get( $url, 'xu_url_to_postid' ) );
	}
}
