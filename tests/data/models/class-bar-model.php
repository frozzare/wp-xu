<?php

/**
 * Bar model class.
 */
class Bar_Model extends \Xu\Model\Model {

    /**
     * The hello.
     *
     * @var string
     */
    public $hello = null;

    /**
     * The construct.
     *
     * @param string $hello
     */
    public function __construct( $hello = null ) {
        $this->hello = $hello;
    }

    /**
     * Get model attributes.
     *
     * @return array
     */
    public function get_attributes() {
        return [
            'name'  => 'Fredrik',
            'stuff' => [
                'tea' => true
            ]
        ];
    }
}
