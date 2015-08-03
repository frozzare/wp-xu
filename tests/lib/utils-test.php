<?php

namespace Xu\Tests\Lib;

class Utils_Test extends \WP_UnitTestCase {

	public function test_xu_with() {
		require_once XU_FIXTURE_DIR . '/classes/class-say.php';
		$this->assertEquals( 'Hello Fredrik!', xu_with( new \Say )->hello( 'Fredrik' ) );
	}

}
