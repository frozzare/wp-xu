<?php

class HTTP_Test extends WP_UnitTestCase {

	public function test_xu_current_url() {
		$this->assertEquals( 'http://example.org/', xu_current_url() );

		$actual   = xu_current_url( true );
		$expected = (object) [
			'scheme' => 'http',
			'host'   => 'example.org',
			'path'   => '/'
		];

		$this->assertEquals( $actual, $expected );

		$actual   = xu_current_url( true, false );
		$expected = [
			'scheme' => 'http',
			'host'   => 'example.org',
			'path'   => '/'
		];

		$this->assertEquals( $actual, $expected );
	}

    public function test_xu_is_http_method() {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue( xu_is_http_method( 'GET' ) );
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertTrue( xu_is_http_method( 'POST' ) );
        $_SERVER['REQUEST_METHOD'] = '';
        $this->assertFalse( xu_is_http_method( 'POST' ) );
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertFalse( xu_is_http_method( false ) );
        $this->assertFalse( xu_is_http_method( true ) );
        $this->assertFalse( xu_is_http_method( null ) );
        $this->assertFalse( xu_is_http_method( 1 ) );
        $this->assertFalse( xu_is_http_method( [] ) );
        $this->assertFalse( xu_is_http_method( (object)[] ) );
    }

}
