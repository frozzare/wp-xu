<?php

namespace Xu\Tests\Model;

require_once XU_FIXTURE_DIR . '/models/class-foo-model.php';
require_once XU_FIXTURE_DIR . '/models/class-bar-model.php';

class Model_Test extends \WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		$this->foo = \Foo_Model::model();
		$this->bar = new \Bar_Model;
	}

	public function tearDown() {
		parent::tearDown();
		unset( $this->foo, $this->bar );
	}

	public function test_isset() {
		$this->assertTrue( isset( $this->bar->name ) );
		$this->assertFalse( isset( $this->foo->name ) );
	}

	public function test_get_name() {
		$this->assertSame( 'Fredrik', $this->bar->name );
		$this->assertNull( $this->foo->name );
	}

	public function test_get_id() {
		$this->assertNull( $this->foo->id );

		$post_id = $this->factory->post->create();
		global $post;
		$post = get_post( $post_id );
		$this->assertSame( $post_id, $this->bar->id );
		$post = null;
	}

	public function test_get_post() {
		$this->assertNull( $this->foo->post );

		$post_id = $this->factory->post->create();
		global $post;
		$post = get_post( $post_id );
		$this->assertSame( $post_id, $this->bar->post->ID );
		$post = null;
	}

	public function test_get() {
		$this->assertEmpty( $this->foo->get( 'stuff.tea' ) );
		$this->assertTrue( $this->bar->get( 'stuff.tea' ) );

		$this->bar->set( 'bar', $this->bar );
		$this->assertTrue( $this->bar->get( 'bar.stuff.tea' ) );
	}

	public function test_get_attributes() {
		$this->assertNotEmpty( $this->bar->get_attributes() );
		$this->assertEmpty( $this->foo->get_attributes() );
	}

	public function test_get_attributes_array() {
		$this->assertNotEmpty( $this->bar->get_attributes_array() );
		$this->assertEmpty( $this->foo->get_attributes_array() );
	}

	public function test_set() {
		$this->foo->set( 'name', 'Fredrik' );
		$this->assertSame( 'Fredrik', $this->foo->name );
		$this->bar->set( 'name', 'Per' );
		$this->assertSame( 'Per', $this->bar->name );
	}

	public function test_set_name() {
		$this->foo->name = 'Fredrik';
		$this->assertSame( 'Fredrik', $this->foo->name );
		$this->bar->name = 'Per';
		$this->assertSame( 'Per', $this->bar->name );
	}

	public function test_unset() {
		$this->bar->type = 'post';
		$this->assertSame( 'post', $this->bar->type );
		unset( $this->bar->type );
		$this->assertNull( $this->bar->type );
	}

	public function test_get_model() {
		$this->assertInstanceOf( 'Foo_Model', $this->bar->get_model( '\\Foo_Model' ) );
		$this->assertInstanceOf( 'Bar_Model', $this->foo->get_model( '\\Bar_Model' ) );
	}

	public function test_model() {
		$this->assertInstanceOf( 'Foo_Model', \Foo_Model::model() );
		$this->assertInstanceOf( 'Bar_Model', \Bar_Model::model() );
	}

	public function test_offsetExists() {
		$this->assertTrue( isset( $this->bar['name'] ) );
		$this->assertFalse( isset( $this->foo['name'] ) );
	}

	public function test_offsetGet() {
		$this->assertSame( 'Fredrik', $this->bar['name'] );
		$this->assertNull( $this->foo['name'] );
	}

	public function test_offsetSet() {
		$this->foo['name'] = 'Fredrik';
		$this->assertSame( 'Fredrik', $this->foo['name'] );
		$this->bar['name'] = 'Per';
		$this->assertSame( 'Per', $this->bar['name'] );
	}

	public function test_offsetUnset() {
		$this->bar['type'] = 'post';
		$this->assertSame( 'post', $this->bar['type'] );
		unset( $this->bar['type'] );
		$this->assertNull( $this->bar['type'] );
	}

	public function test_json_serialize() {
		$this->assertEquals( [], $this->foo->json_serialize() );
		$this->assertEquals( ['name' => 'Fredrik', 'stuff' => ['tea' => true]], $this->bar->json_serialize() );
	}

	public function test_collection() {
		$models     = [
			\Bar_Model::create( ['os' => 'Mac'] ),
			\Bar_Model::create( ['os' => 'Mac'] )
		];
		$collection = \Bar_Model::collection( $models );
		$this->assertSame( $models, $collection->all() );
	}

	public function test_create() {
		$model = \Bar_Model::create( ['os' => 'Mac'] );
		$this->assertSame( 'Mac', $model->get( 'os' ) );
	}

	public function test_set_attributes() {
		$this->bar->set_attributes( ['os' => 'Mac'] );
		$this->assertSame( 'Mac', $this->bar->get( 'os' ) );
	}

	public function test_to_array() {
		$this->assertEquals( [], $this->foo->to_array() );
		$this->assertEquals( ['name' => 'Fredrik', 'stuff' => ['tea' => true]], $this->bar->to_array() );
	}

	public function test_to_json() {
		$this->assertEquals( '[]', $this->foo->to_json() );
		$this->assertEquals( '{"name":"Fredrik","stuff":{"tea":true}}', $this->bar->to_json() );

		$bar = new \Bar_Model;
		$bar->set( 'foo', $this->foo );
		$this->assertEquals( '{"name":"Fredrik","stuff":{"tea":true},"foo":[]}', $bar->to_json() );
	}
}
