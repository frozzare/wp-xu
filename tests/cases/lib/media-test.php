<?php

namespace Xu\Tests\Lib;

class Media_Test extends \WP_UnitTestCase {

	public function test_xu_current_attachment_url_to_postid() {
		// Wrong host.
		$this->assertSame( 0, xu_current_attachment_url_to_postid() );

		$post_id = $this->factory->post->create( ['post_type' => 'attachment'] );
		$url = get_permalink( $post_id );
		$_SERVER['REQUEST_URI'] = '?attachment_id=' . $post_id;

		add_filter( 'attachment_url_to_postid', function () use( $post_id ) {
			return $post_id;
		} );

		// Should be same post id if host
		$this->assertSame( $post_id, xu_current_attachment_url_to_postid() );

		// Should exists in the wp cache.
		$this->assertSame( $post_id, wp_cache_get( $url, 'xu_attachment_url_to_postid' ) );

		// Test to clean attachment cache.
		xu_clean_attachment_cache( $post_id );

		// Should not exists in the cache when cleaned.
		$this->assertFalse( wp_cache_get( $url, 'xu_attachment_url_to_postid' ) );

		$_SERVER['REQUEST_URI'] = null;
	}

	public function test_xu_attachment_url_to_postid() {
		// Wrong host.
		$this->assertSame( 0, xu_attachment_url_to_postid( 'https://wordpress.org' ) );

		$post_id = $this->factory->post->create( ['post_type' => 'attachment'] );
		$url = get_permalink( $post_id );

		add_filter( 'attachment_url_to_postid', function () use( $post_id ) {
			return $post_id;
		} );

		// Should be same post id if host
		$this->assertSame( $post_id, xu_attachment_url_to_postid( $url ) );

		// Should exists in the wp cache.
		$this->assertSame( $post_id, wp_cache_get( $url, 'xu_attachment_url_to_postid' ) );

		// Test to clean attachment cache.
		xu_clean_attachment_cache( $post_id );

		// Should not exists in the cache when cleaned.
		$this->assertFalse( wp_cache_get( $url, 'xu_attachment_url_to_postid' ) );
	}

	public function test_xu_wp_get_attachment_image() {
		$post_id = $this->factory->post->create( ['post_type' => 'attachment'] );

		$this->assertEmpty( xu_wp_get_attachment_image( $post_id ) );

		add_filter( 'wp_get_attachment_image_src', function () {
			return '/wp-content/uploads/2016/01/01/empty.png';
		} );

		$html = xu_wp_get_attachment_image( $post_id );
		$this->assertTrue( strpos( $html, '<img'  ) !== false );

		// Create cache key.
		$cache_key = md5( serialize( [$post_id, $size = 'thumbnail', $icon = false, $attr = ''] ) );

		// Should exists in the wp cache.
		$html = wp_cache_get( $cache_key, 'xu_wp_get_attachment_image:' . $post_id );
		$this->assertTrue( strpos( $html, '<img'  ) !== false );
	}

	public function test_xu_wp_get_attachment_image_src() {
		$post_id = $this->factory->post->create( ['post_type' => 'attachment'] );

		$this->assertEmpty( xu_wp_get_attachment_image_src( $post_id ) );

		add_filter( 'wp_get_attachment_image_src', function () {
			return '/wp-content/uploads/2016/01/01/empty.png';
		} );

		$this->assertSame( '/wp-content/uploads/2016/01/01/empty.png', xu_wp_get_attachment_image_src( $post_id ) );

		// Create cache key.
		$cache_key = md5( serialize( [$post_id, $size = 'thumbnail', $icon = false] ) );

		// Should exists in the wp cache.
		$this->assertSame( '/wp-content/uploads/2016/01/01/empty.png', wp_cache_get( $cache_key, 'xu_wp_get_attachment_image_src:' . $post_id ) );
	}


	public function test_xu_wp_get_attachment_url() {
		$this->assertEmpty( xu_wp_get_attachment_url() );

		$post_id = $this->factory->post->create( ['post_type' => 'attachment'] );
		$url = 'http://example.org/?attachment_id=' . $post_id;

		$this->assertSame( $url, xu_wp_get_attachment_url( $post_id ) );

		// Should exists in the wp cache.
		$this->assertSame( $url, wp_cache_get( $post_id, 'xu_wp_get_attachment_url' ) );

		// Test to clean attachment cache.
		xu_clean_attachment_cache( $post_id );

		// Should not exists in the cache when cleaned.
		$this->assertFalse( wp_cache_get( $post_id, 'xu_attachment_url_to_postid' ) );
	}
}
