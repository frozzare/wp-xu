<?php

namespace Xu\Components;

/**
 * Personnummer component class.
 */
class Personnummer extends Component {

	/**
	 * Validate Swedish personal identify numbers.
	 *
	 * @param string|int $str
	 *
	 * @return bool
	 */
	public function valid( $str ) {
		return \Frozzare\Personnummer\Personnummer::valid( $str );
	}

}
