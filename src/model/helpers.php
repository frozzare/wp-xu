<?php

/**
 * Get a model.
 *
 * @param  mixed  $model The model name or a model object.
 * @param  array  $args  The model args. Default empty array.
 * @param  string $dir   The models directory. Default 'models'.
 *
 * @return mixed
 */
function xu_get_model( $model, array $args = [], $dir = 'models' ) {
	if ( method_exists( $model, 'model' ) ) {
		return call_user_func_array( [$model, 'model'], $args );
	}

	$model = str_replace( '.', '/', $model );
	$model = explode( '/', $model );
	$name  = array_pop( $model );
	$extra = implode( '/', $model );
	$extra = empty( $extra ) ? $extra : $extra . '/';
	$model = $name;

	$file  = null;
	$names = [
		sprintf( '%s/%sclass-%s.php', $dir, $extra, $model ),
		sprintf( '%s/%s%s.php', $dir, $extra, $model )
	];

	foreach ( $names as $name ) {
		/**
		 * Get model in different location than the theme.
		 *
		 * @param  string $name
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
