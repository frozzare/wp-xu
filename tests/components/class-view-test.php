<?php

namespace Xu\Tests\Components;

class View_Test extends \WP_UnitTestCase {

    public function setUp() {
        parent::setUp();
        $this->view = xu( 'view' );
    }

    public function tearDown() {
        parent::tearDown();
        unset( $this->view );
    }

    public function test_from_dot() {
        $this->assertEquals( 'pages/index.php', $this->view->from_dot( 'pages.index' ) );
        $this->assertEquals( 'pages/index.php', $this->view->from_dot( 'pages.index.php' ) );
    }

    public function test_fetch() {
        $output = $this->view->fetch( XU_FIXTURE_DIR . '/views/index.php', [
            'title' => 'xu'
        ] );
        $this->assertTrue( strpos( $output, 'xu' ) !== false );
    }

    public function test_to_dot() {
        $this->assertEquals( 'pages.index.php', $this->view->to_dot( 'pages/index' ) );
        $this->assertEquals( 'pages.index.php', $this->view->to_dot( 'pages/index.php' ) );
    }

    public function test_render() {
        $this->view->render( XU_FIXTURE_DIR . '/views/index.php', [
            'title' => 'xu'
        ] );
        $this->expectOutputRegex( '/xu/' );
    }

}
