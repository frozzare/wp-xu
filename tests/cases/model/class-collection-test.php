<?php

namespace Xu\Tests\Model;

require_once XU_FIXTURE_DIR . '/models/class-foo-model.php';
require_once XU_FIXTURE_DIR . '/models/class-bar-model.php';

use Foo_Model;
use Bar_Model;
use Xu\Model\Collection;

class Collection_Test extends \WP_UnitTestCase {

    public function setUp() {
        parent::setUp();
        $this->foo = Foo_Model::model();
        $this->bar = new Bar_Model;
    }

    public function tearDown() {
        parent::tearDown();
        unset( $this->foo, $this->bar );
    }

    public function create_bar_collection() {
        return new Collection( [
            Bar_Model::create( ['name' => 'Fredrik'] ),
            Bar_Model::create( ['name' => 'Per'] )
        ] );
    }

    public function test_all() {
        $collection = $this->create_bar_collection();
        $all = $collection->all();
        $this->assertSame( 'Fredrik', $all[0]->name );
        $this->assertSame( 'Per', $all[1]->name );
    }

    public function test_count() {
        $collection = $this->create_bar_collection();
        $this->assertSame( 2, $collection->count() );
    }

    public function test_filter() {
        $collection = $this->create_bar_collection();
        $result = $collection->filter( 'name', 'Fredrik' );
        $this->assertSame( 1, $result->count() );
        $this->assertSame( $collection[0]->name, $result[0]->name );

        $collection = $this->create_bar_collection();
        $result = $collection->filter( function ( $item ) {
            return $item->name === 'Fredrik';
        } );
        $this->assertSame( 1, $result->count() );
        $this->assertSame( $collection[0]->name, $result[0]->name );
    }

    public function test_first() {
        $collection = $this->create_bar_collection();
        $this->assertSame( 'Fredrik', $collection->first()->name );

        $collection = $this->create_bar_collection();
        $result = $collection->first( function( $item ) {
            return $item->name === 'Per';
        } );
        $this->assertSame( 'Per', $result->name );
    }

    public function test_is_empty() {
        $collection = new Collection();
        $this->assertTrue( $collection->is_empty() );
        $collection = $this->create_bar_collection();
        $this->assertFalse( $collection->is_empty() );
    }

    public function test_last() {
        $collection = $this->create_bar_collection();
        $this->assertSame( 'Per', $collection->last()->name );

        $collection = $this->create_bar_collection();
        $result = $collection->first( function( $item ) {
            return $item->name === 'Fredrik';
        } );
        $this->assertSame( 'Fredrik', $result->name );
    }

    public function test_map() {
        $collection = $this->create_bar_collection();
        $collection = $collection->map( function( $item ) {
            return $item->name = sprintf( 'Hello %s', $item->name );
        } );
        $this->assertSame( 'Hello Fredrik', $collection->first() );
        $this->assertSame( 'Hello Per', $collection->last() );
    }

    public function test_offsetExists() {
        $collection = new Collection();
        $this->assertFalse( isset( $collection[0] ) );
        $collection = $this->create_bar_collection();
        $this->assertTrue( isset( $collection[0] ) );
    }

    public function test_offsetGet() {
        $collection = $this->create_bar_collection();
        $this->assertSame( 'Fredrik', $collection[0]->name );
        $this->assertSame( 'Per', $collection[1]->name );
    }

    public function test_offsetSet() {
        $collection = $this->create_bar_collection();
        $this->assertSame( 'Fredrik', $collection[0]->name );
        $this->assertSame( 'Per', $collection[1]->name );

        $collection[0]->name = 'Per';
        $collection[1]->name = 'Fredrik';

        $this->assertSame( 'Fredrik', $collection[1]->name );
        $this->assertSame( 'Per', $collection[0]->name );
    }

    public function test_offsetUnset() {
        $collection = $this->create_bar_collection();
        $this->assertSame( 'Fredrik', $collection[0]->name );

        unset( $collection[0] );
        $this->assertFalse( isset( $collection[0] ) );
    }

    public function test_pluck() {
        $collection = $this->create_bar_collection();
        $this->assertSame( ['Fredrik', 'Per'], $collection->pluck( 'name' ) );
    }

    public function test_pop() {
        $collection = $this->create_bar_collection();
        $this->assertSame( 'Per', $collection->pop()->name );
    }

    public function test_reject() {
        $collection = $this->create_bar_collection();
        $result = $collection->reject( 'name', 'Fredrik' );
        $this->assertSame( 1, $result->count() );
        $this->assertSame( 'Per', $result[0]->name );

        $collection = $this->create_bar_collection();
        $result = $collection->reject( function ( $item ) {
            return $item->name === 'Per';
        } );
        $this->assertSame( 1, $result->count() );
        $this->assertSame( $collection[0]->name, $result[0]->name );
    }

    public function test_reverse() {
        $collection = $this->create_bar_collection();
        $reversed = array_reverse( $collection->to_array() );
        $this->assertSame( $reversed, $collection->reverse()->to_array() );
    }

    public function test_shift() {
        $collection = $this->create_bar_collection();
        $this->assertSame( 'Fredrik', $collection->shift()->name );
    }

    public function test_sort() {
        $collection = new Collection( [
            Bar_Model::create( ['name' => 2] ),
            Bar_Model::create( ['name' => 1] )
        ] );

        $this->assertSame( 2, $collection->first()->name );
        $this->assertSame( 1, $collection->last()->name );

        $collection = $collection->sort( function ( $a, $b ) {
            return $a > $b ? 1 : -1;
        } );

        $this->assertSame( 1, $collection->first()->name );
        $this->assertSame( 2, $collection->last()->name );
    }

    public function test_where() {
        $collection = $this->create_bar_collection();
        $collection = $collection->where( 'name', 'Fredrik' );
        $this->assertSame( 1, $collection->count() );
        $this->assertSame( 'Fredrik', $collection->first()->name );

        $collection = $this->create_bar_collection();
        $collection = $collection->where( function ( $item ) {
            return $item->name === 'Per';
        } );
        $this->assertSame( 1, $collection->count() );
        $this->assertSame( 'Per', $collection->first()->name );
    }

    public function test_to_json() {
        $collection = $this->create_bar_collection();
        $json = $collection->to_json();
        $this->assertSame( '[{"name":"Fredrik","stuff":{"tea":true}},{"name":"Per","stuff":{"tea":true}}]', $json );
    }

    public function test_to_array() {
        $collection = $this->create_bar_collection();
        $this->assertEquals( $collection->all(), $collection->to_array() );
    }
}
