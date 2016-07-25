<?php

namespace Frozzare\Tests\WordPress\Go\Lib;

class Menu_Test extends \WP_UnitTestCase {

	public function test_xu_wp_nav_menu() {
		$this->assertSame( '<div class="menu"></div>', trim( xu_wp_nav_menu( ['echo'=>false] ) ) );

		$tag_id = $this->factory->tag->create();
		$menu_id = wp_create_nav_menu( rand_str() );

		wp_update_nav_menu_item( $menu_id, 0, [
			'menu-item-type'      => 'taxonomy',
			'menu-item-object'    => 'post_tag',
			'menu-item-object-id' => $tag_id,
			'menu-item-status'    => 'publish'
		] );

		$args = [
			'echo'      => false,
			'container' => '',
			'menu'      => $menu_id
		];
		$menu = xu_wp_nav_menu( $args );

		$this->assertSame( 0, strpos( $menu, '<ul' ) );

		// Should exists in the wp cache.
		$this->assertSame( 0, strpos( wp_cache_get( md5( serialize( [$args] ) ), 'xu_wp_nav_menu' ), '<ul' ) );
	}
}
