<?php

namespace Xu\Tests\Lib;

use Xu\Tests\Unit_Test_Case;

class Utils_Test extends Unit_Test_Case {

	public function test_xu_add_action() {
		global $wp_filter;
		$wp_filter = [];

		xu_add_action( 'init', 'hello' );

		$this->assertEquals( [
			'init' => [
				10 => [
					'hello' => [
						'function'      => 'hello',
						'accepted_args' => 1
					]
				]
			]
		], $wp_filter );
	}

	public function test_xu_add_filter() {
		global $wp_filter;
		$wp_filter = [];

		xu_add_filter( 'init', 'hello' );

		$this->assertEquals( [
			'init' => [
				10 => [
					'hello' => [
						'function'      => 'hello',
						'accepted_args' => 1
					]
				]
			]
		], $wp_filter );
	}

	public function test_xu_get_class_name() {
		$this->assertSame( 'Say', xu_get_class_name( XU_FIXTURE_DIR . '/classes/class-say.php' ) );
		$this->assertSame( '\Xu\Components\Stringx\Stringx', xu_get_class_name( XU_FIXTURE_DIR . '/components/class-stringx.php' )  );

		try {
			xu_get_class_name( false );
			$this->assertTrue( false );
		} catch ( \Exception $e ) {
			$this->assertNotEmpty( $e->getMessage() );
		}

		try {
			xu_get_class_name( '/path/to/file.php' );
			$this->assertTrue( false );
		} catch ( \Exception $e ) {
			$this->assertNotEmpty( $e->getMessage() );
		}
	}

	public function test_xu_with() {
		require_once XU_FIXTURE_DIR . '/classes/class-say.php';
		$this->assertSame( 'Hello Fredrik!', xu_with( new \Say )->hello( 'Fredrik' ) );
	}
}
