<?php

namespace Xu\Tests\Lib;

use Xu\Tests\Unit_Test_Case;

class Conditional_Test extends Unit_Test_Case {

	public function test_xu_doing_ajax() {
		$this->assertFalse( xu_doing_ajax() );
		define( 'DOING_AJAX', true );
		$this->assertTrue( xu_doing_ajax() );
	}

	public function test_xu_is_empty() {
		$this->assertTrue( xu_is_empty( null ) );
		$this->assertFalse( xu_is_empty( 'false' ) );
		$this->assertFalse( xu_is_empty( true ) );
		$this->assertFalse( xu_is_empty( false ) );
		$this->assertFalse( xu_is_empty( 0 ) );
		$this->assertFalse( xu_is_empty( 0.0 ) );
		$this->assertFalse( xu_is_empty( "0" ) );
	}

	public function test_xu_is_http_method() {
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$this->assertTrue( xu_is_http_method( 'GET' ) );
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->assertTrue( xu_is_http_method( 'POST' ) );
		unset( $_SERVER['REQUEST_METHOD'] );
		$this->assertFalse( xu_is_http_method( 'POST' ) );
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->assertFalse( xu_is_http_method( false ) );
		$this->assertFalse( xu_is_http_method( true ) );
		$this->assertFalse( xu_is_http_method( null ) );
		$this->assertFalse( xu_is_http_method( 1 ) );
		$this->assertFalse( xu_is_http_method( [] ) );
		$this->assertFalse( xu_is_http_method( (object)[] ) );
	}

	public function test_xu_is_json() {
		$this->assertTrue( xu_is_json( '{"foo": "bar"}' ) );
		$this->assertTrue( xu_is_json( '{"foo": true}' ) );
		$this->assertFalse( xu_is_json( 'hello world' ) );
		$this->invalidArgumentTest( 'xu_is_json' );
	}

	public function test_xu_is_wp() {
		$this->assertTrue( xu_is_wp( get_bloginfo( 'version' ) ) );
		$this->assertTrue( xu_is_wp( get_bloginfo( 'version' ), '=' ) );
		$this->assertFalse( xu_is_wp( get_bloginfo( 'version' ), '>' ) );
		$this->assertFalse( xu_is_wp( '1.0' ) );
		$this->invalidArgumentTest( 'xu_is_wp', ['string', 'string'] );
	}

	public function test_xu_is_xml() {
		$xml = "<?xml version='1.0'?><document><title>Foobar</title></document>";
		$this->assertTrue( xu_is_xml( $xml ) );
		$this->assertTrue( xu_is_xml( '<p>hello</p>' ) );
		$this->assertFalse( xu_is_xml( 'hello world' ) );
		$this->invalidArgumentTest( 'xu_is_xml' );
	}
}
