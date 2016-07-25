<?php

namespace Xu\Tests\Model;

require_once XU_FIXTURE_DIR . '/models/class-foo-model.php';
require_once XU_FIXTURE_DIR . '/models/class-bar-model.php';

class Helpers_Test extends \WP_UnitTestCase {

	public function test_xu_get_model() {
		$this->assertInstanceOf( 'Foo_Model', xu_get_model( '\\Foo_Model' ) );
		$this->assertInstanceOf( 'Bar_Model', xu_get_model( '\\Bar_Model' ) );
	}

	public function test_xu_get_model_args() {
		$bar = xu_get_model( '\\Bar_Model', ['Foo'] );
		$this->assertSame( 'Foo', $bar->hello );
	}
}
