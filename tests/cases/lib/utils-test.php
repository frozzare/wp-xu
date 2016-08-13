<?php

namespace Xu\Tests\Lib;

class Utils_Test extends \WP_UnitTestCase {

	public function test_xu_get_class_name() {
		$this->assertSame( 'Say', xu_get_class_name( XU_FIXTURE_DIR . '/classes/class-say.php' ) );

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
}
