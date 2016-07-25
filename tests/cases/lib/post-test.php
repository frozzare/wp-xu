<?php

namespace Xu\Tests\Lib;

class Post_Test extends \WP_UnitTestCase {

	public function test_xu_is_post_type() {
		$post_id = $this->factory->post->create();
		global $post;
		$post = get_post( $post_id );
		$this->assertTrue( xu_is_post_type( $post_id, 'post' ) );
		$this->assertTrue( xu_is_post_type( 'post' ) );
		$this->assertFalse( xu_is_post_type( false ) );
		$this->assertFalse( xu_is_post_type( true ) );
		$this->assertFalse( xu_is_post_type( null ) );
		$this->assertFalse( xu_is_post_type( 1 ) );
		$this->assertFalse( xu_is_post_type( [] ) );
		$this->assertFalse( xu_is_post_type( (object) [] ) );

		try {
			xu_is_post_type( $post_id, false );
			$this->assertTrue( false );
		} catch ( \Exception $e ) {
			$this->assertNotEmpty( $e->getMessage() );
		}
	}

	public function test_xu_get_posts() {
		$this->assertEmpty( xu_get_posts() );

		$post_id = $this->factory->post->create();
		$posts = xu_get_posts();

		$this->assertSame( $post_id, $posts[0]->ID );

		// Should exists in the wp cache.
		$this->assertEquals( $posts, wp_cache_get( md5( serialize( [['suppress_filters'=>false]] ) ), 'xu_get_posts' ) );
	}

	public function test_xu_get_top_parent_post_global() {
		global $post;
		$post_id = $this->factory->post->create();
		$post    = get_post( $post_id );

		$this->assertEquals( $post, xu_get_top_parent_post() );
	}

	public function test_xu_get_top_parent_post() {
		$post_id = $this->factory->post->create();
		$post    = get_post( $post_id );
		$this->assertEquals( $post, xu_get_top_parent_post( $post ) );

		$post_id = $this->factory->post->create( [
			'post_parent' => $post_id
		] );
		$this->assertEquals( $post, xu_get_top_parent_post( get_post( $post_id ) ) );
		$this->assertEquals( $post, xu_get_top_parent_post( $post_id ) );

		try {
			xu_get_top_parent_post( null );
		} catch ( \Exception $e ) {
			$this->assertSame( 'null is not a instance of WP_Post', $e->getMessage() );
		}
	}

	public function test_xu_get_top_parent_post_type_global() {
		global $post;
		$post_id = $this->factory->post->create();
		$post    = get_post( $post_id );

		$this->assertSame( 'post', xu_get_top_parent_post_type() );
	}

	public function test_xu_get_top_parent_post_type() {
		$post_id = $this->factory->post->create();
		$post    = get_post( $post_id );
		$this->assertSame( 'post', xu_get_top_parent_post_type( $post ) );

		$post_id = $this->factory->post->create( [
			'post_parent' => $post_id
		] );
		$this->assertSame( 'post', xu_get_top_parent_post_type( get_post( $post_id ) ) );
		$this->assertSame( 'post', xu_get_top_parent_post_type( $post_id ) );

		try {
			xu_get_top_parent_post_type( null );
		} catch ( \Exception $e ) {
			$this->assertSame( 'null is not a instance of WP_Post', $e->getMessage() );
		}
	}

	public function test_xu_get_top_parent_post_type_object_global() {
		global $post;
		$post_id = $this->factory->post->create();
		$post    = get_post( $post_id );

		$this->assertTrue( is_object( xu_get_top_parent_post_type_object() ) );
	}

	public function test_xu_get_top_parent_post_type_object() {
		$post_id = $this->factory->post->create();
		$post    = get_post( $post_id );
		$this->assertTrue( is_object( xu_get_top_parent_post( $post ) ) );

		$post_id = $this->factory->post->create( [
			'post_parent' => $post_id
		] );

		$this->assertTrue( is_object( xu_get_top_parent_post_type_object( get_post( $post_id ) ) ) );
		$this->assertTrue( is_object( xu_get_top_parent_post_type_object( $post_id ) ) );

		try {
			xu_get_top_parent_post_type_object( null );
		} catch ( \Exception $e ) {
			$this->assertSame( 'null is not a instance of WP_Post', $e->getMessage() );
		}
	}

}
