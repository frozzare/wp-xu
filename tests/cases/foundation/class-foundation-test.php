<?php

namespace Xu\Tests\Foundation;

use Xu\Foundation\Foundation;

class Foundation_Test extends \WP_UnitTestCase {

	public function test_component() {
		$this->assertTrue( xu( '' ) instanceof Foundation );
		$this->assertEquals( Foundation::VERSION, xu( 'xu' )->version() );
	}

	public function test_fn_method() {
		$this->assertEquals( 'xu-dashify', \xu()->fn( 'xu_dashify', ['xu_dashify'] ) );
		$this->assertEquals( 'xu-dashify', \xu()->fn( 'dashify', 'xu_dashify' ) );
	}

	public function test_component_method() {
		try {
			\xu()->component( null );
		} catch ( \Exception $e ) {
			$this->assertEquals( 'Invalid argument. `$component` must be string.', $e->getMessage() );
		}

		try {
			\xu()->component( 'frozzare.tank.container' );
		} catch ( \Exception $e ) {
			$this->assertEquals( '`Xu\\Components\\Frozzare\\Tank\\Container` class does not exists.', $e->getMessage() );
		}

		try {
			\xu()->component( 'test' );
		} catch ( \Exception $e ) {
			$this->assertEquals( '`Xu\\Components\\Test\\Test` class is not a instance of Xu\\Components\\Component.', $e->getMessage() );
		}

		try {
			\xu()->component( 'Test\\Test' );
		} catch ( \Exception $e ) {
			$this->assertEquals( '`Xu\\Components\\Test\\Test` class is not a instance of Xu\\Components\\Component.', $e->getMessage() );
		}

		$this->assertEquals( 'foo', \xu( 'foo' ) );
		$this->assertTrue( \xu( 'stringx' ) instanceof \Xu\Components\Stringx\Stringx );
		$this->assertEquals( 'FOO', \xu( 'strtoupper', 'foo' ) );
	}
}
