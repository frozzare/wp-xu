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
        $this->assertFalse( xu_is_post_type( (object)[] ) );

        try {
            xu_is_post_type( $post_id, false );
            $this->assertTrue( false );
        } catch ( \Exception $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }
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
			$this->assertEquals( 'null is not a instance of WP_Post', $e->getMessage() );
		}
	}

}
