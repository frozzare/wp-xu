<?php

namespace Xu\Tests;

use InvalidArgumentException;

class Unit_Test_Case extends \WP_UnitTestCase {

    /**
     * Get random string.
     *
     * @return string
     */
    public function getRandomString() {
        return substr( 'abcdefghijklmnopqrstuvwxyz' , mt_rand( 0 , 25 ) , 1 ) .substr( md5( time( ) ) , 1 );
    }

    /**
     * Test invalid argument in given function.
     *
     * @param string $fn
     * @param array $args
     */
    public function invalidArgumentTest( $fn, array $types_args = [] ) {
        if ( ! is_string( $fn ) ) {
            throw new InvalidArgumentException( 'Invalid argument. `$fn` must be string.' );
        }

        if ( empty( $types_args ) ) {
            $types_args = ['string'];
        }

        $types = [
            'array'  => [],
            'false'  => false,
            'float'  => abs( 1 - mt_rand()/mt_rand() ),
            'int'    => rand(),
            'null'   => null,
            'object' => (object) [],
            'string' => $this->getRandomString(),
            'true'   => true
        ];

        $done = [];

        for ( $i = 0, $l = count( $types_args ); $i < $l; $i++ ) {
            $type = $types_args[$i];

            if ( ! is_array( $type ) ) {
                $type = [$type];
            }

            $temp = $types;

            foreach ( $type as $t ) {
                if ( $t === 'bool' ) {
                    unset( $temp['false'] );
                    unset( $temp['true'] );
                } else if ( isset( $temp[$t] ) ) {
                    unset( $temp[$t] );
                }
            }

            $args = [];

            for ( $j = 0; $j < $l; $j++ ) {
                $arg = $types_args[$j];

                if ( ! is_array( $arg ) ) {
                    $arg = [$arg];
                }

                if ( isset( $done[$i - 1] ) && $j === $i - 1 ) {
                    $args[] = $types[$arg[0]];
                    $continue = false;
                } else {
                    $args[] = $types[array_rand( $temp )];
                    if ( ! isset( $done[$i] ) ) {
                        $done[$i] = $type;
                    }
                }
            }

            $this->runInvalidArgumentExceptionTest( $fn, $args );
        }
    }

    /**
     * Run invalid argument test.
     *
     * @param string $fn
     * @param array $args
     */
    public function runInvalidArgumentExceptionTest( $fn, array $args = [] ) {
        try {
            call_user_func_array( $fn, $args );
        } catch( InvalidArgumentException $e ) {
            $this->assertNotEmpty( $e->getMessage() );
        }
    }

}
