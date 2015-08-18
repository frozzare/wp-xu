<?php

namespace Xu\Components;

/**
 * View component class.
 */
class View extends Component {

    /**
     * The extensions.
     *
     * @var array
     */
    protected $extensions = ['.php'];

    /**
     * Fetch view and return it at string.
     *
     * @param string $view
     * @param array $data
     *
     * @return string
     */
    public function fetch( $view, array $data = [] ) {
        $ob_level = ob_get_level();

        ob_start();

        extract( $data );

        try {
            include $this->from_dot( $view );
        } catch ( \Exception $e ) {
            while ( ob_get_level() > $ob_level ) {
                ob_end_clean();
            }

            throw $e;
        }

        return ltrim( ob_get_clean() );
    }

    /**
     * Convert from dot template string to string with dashes.
     *
     * @param string $view
     *
     * @return string
     */
    public function from_dot( $view ) {
        $ext_reg = '/(' . implode( '|', $this->extensions ) . ')+$/';

    	if ( preg_match( '/\.\w+$/', $view, $matches ) && in_array( $matches[0], $this->extensions ) ) {
    		return str_replace( '.', '/', preg_replace( '/' . $matches[0] . '$/', '', $view ) ) . $matches[0];
        }

    	$view = str_replace( '.', '/', $view );

    	return substr( $view, -strlen( $this->extensions[0] ) ) === $this->extensions[0]
                ? $view : $view . $this->extensions[0];
    }

    /**
     * Render PHP view.
     *
     * @param string $view
     * @param array $data
     *
     * @throws
     */
    public function render( $view, array $data = [] ) {
        echo $this->fetch( $view, $data );
    }

    /**
     * Convert dashes template string to dot template string.
     *
     * @param string $view
     *
     * @return string
     */
    public function to_dot( $view ) {
        return str_replace( '/', '.', $this->from_dot( $view ) );
    }

}
