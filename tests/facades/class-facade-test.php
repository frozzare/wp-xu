<?php

namespace Xu\Tests\Foundation;

use Frozzare\Tank\Container;
use Xu\Facades\Facade;
use Xu\Contracts\Foundation\Foundation as FoundationContract;

class Facade_Test extends \WP_UnitTestCase {

    public function tearDown() {
        parent::tearDown();
        Facade::set_facade_instance( Container::get_instance() );
    }

    public function test_get_facades() {
        $this->assertEmpty( Facade::get_facades() );
        Facade::clear_facades();
        $this->assertEmpty( Facade::get_facades() );
    }

    public function test_set_facade_instance() {
        $foundation = new FoundationStub;
        FacadeStub::set_facade_instance( $foundation );
        $this->assertEquals( $foundation, FacadeStub::get_facade_instance() );
        $this->assertEquals( 'bar', FacadeStub::bar() );
    }

    public function test_get_facade_accessor() {
        try {
            FacadeStub2::get_facade();
        } catch ( \RuntimeException $e ) {
            $this->assertEquals( 'Facade does not implement getFacadeAccessor method.', $e->getMessage() );
        }
    }

    public function test_call_static() {
        $this->assertEquals( 'bar', FacadeStub3::bar() );
    }

}

class FooStub {
    public function bar() {
        return 'bar';
    }
}

class FoundationStub implements FoundationContract {
    protected $container = [];

    public function __construct() {
        $this['foo'] = new FooStub;
    }

	public function offsetExists( $id ) {
		return isset( $this->container[$id] );
	}

	public function offsetGet( $id ) {
        if ( isset( $this->container[$id] ) ) {
            return $this->container[$id];
        }
    }

	public function offsetSet( $id, $value ) {
        $this->container[$id] = $value;
	}

	public function offsetUnset( $id ) {
        unset( $this->container[$id] );
	}
}

class FacadeStub extends Facade {
    protected static function get_facade_accessor() {
        return 'foo';
    }
}

class FacadeStub2 extends Facade {
}

class FacadeStub3 extends Facade {
    protected static function get_facade_accessor() {
        return new FooStub;
    }
}
