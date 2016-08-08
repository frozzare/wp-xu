<?php

/**
 * Get a model.
 *
 * @param  string $model
 * @param  array  $args
 * @param  string $dir
 *
 * @return mixed
 */
function xu_get_model( $model, array $args = [], $dir = 'models' ) {
	if ( method_exists( $model, 'model' ) ) {
		return call_user_func_array( [$model, 'model'], $args );
	}

	$file  = null;
	$names = [
		sprintf( '%s/class-%s.php', $dir, $model ),
		sprintf( '%s/%s.php', $dir, $model )
	];

	foreach ( $names as $name ) {
		/**
		 * Get model in different location than the theme.
		 *
		 * @param  string $name
		 *
		 * @return string
		 */
		if ( $file = apply_filters( 'xu_get_model', $model ) ) {
			if ( file_exists( $file ) ) {
				break;
			}
		}

		// Locate model in theme.
		if ( $file = locate_template( $name, true ) ) {
			if ( file_exists( $file ) ) {
				break;
			}
		}
	}

	if ( empty( $file ) ) {
		return;
	}

	$class_name = xu_get_class_name( $file );
	$reflection = new ReflectionClass( $class_name );

	return $reflection->newInstanceArgs( $args );
}
