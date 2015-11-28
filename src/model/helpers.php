<?php

/**
 * Get a model.
 *
 * @param  string $model
 * @param  string $dir
 *
 * @return mixed
 */
function xu_get_model( $model, array $args = [], $dir = 'models' ) {
    if ( method_exists( $model, 'model' ) ) {
        return call_user_func_array( [$model, 'model'], $args );
    }

    $file = locate_template( sprintf( '%s/%s.php', $dir, $model ), true );

    if ( empty( $file ) ) {
        return;
    }

    $class_name = xu_get_class_name( $file );
    $reflection = new ReflectionClass( $class_name );

    return $reflection->newInstanceArgs( $args );
}
