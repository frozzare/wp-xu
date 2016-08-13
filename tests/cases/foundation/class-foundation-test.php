<?php

namespace Xu\Tests\Foundation;

use Xu\Foundation\Foundation;

class Foundation_Test extends \WP_UnitTestCase {

	public function test_fn_method() {
		$this->assertEquals( 'xu-dashify', \xu()->fn( 'xu_dashify', ['xu_dashify'] ) );
		$this->assertEquals( 'xu-dashify', \xu()->fn( 'dashify', 'xu_dashify' ) );
	}
}
