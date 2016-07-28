<?php

/**
 * Cached version of `attachment_url_to_postid`.
 *
 * @param  string $url
 *
 * @return int
 */
function xu_attachment_url_to_postid( $url = '' ) {
	// Only valid urls.
	if ( parse_url( $url, PHP_URL_HOST ) !== parse_url( home_url(), PHP_URL_HOST ) ) {
		return 0;
	}

	return xu_cache_get( 'attachment_url_to_postid', [$url], __FUNCTION__ );
}

/**
 * Get attachment post id from current url.
 *
 * @return string
 */
function xu_current_attachment_url_to_postid() {
	return xu_attachment_url_to_postid( xu_current_url() );
}

/**
 * Cached version of `wp_get_attachment_image`.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_get_attachment_image/
 *
 * @param  int          $attachment_id
 * @param  array|string $size
 * @param  bool         $icon
 * @param  string       $attr
 *
 * @return string
 */
function xu_wp_get_attachment_image( $attachment_id, $size = 'thumbnail', $icon = false, $attr = '' ) {
	return xu_cache_get(
		'wp_get_attachment_image',
		[$attachment_id, $size, $icon, $attr],
		xu_cache_key( __FUNCTION__, $attachment_id )
	);
}

/**
 * Cached version of `wp_get_attachment_image_sizes`.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_get_attachment_image_sizes/
 *
 * @param  int          $attachment_id
 * @param  array|string $size
 * @param  array        $image_meta
 *
 * @return string
 */
function xu_wp_get_attachment_image_sizes( $attachment_id, $size = 'medium', $image_meta = null ) {
	return xu_cache_get(
		'wp_get_attachment_image_sizes',
		[$attachment_id, $size, $image_meta],
		xu_cache_key( __FUNCTION__, $attachment_id )
	);
}

/**
 * Cached version of `wp_get_attachment_image_src`.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
 *
 * @param  int          $attachment_id
 * @param  array|string $size
 * @param  bool         $icon
 *
 * @return string
 */
function xu_wp_get_attachment_image_src( $attachment_id, $size = 'thumbnail', $icon = false ) {
	return xu_cache_get(
		'wp_get_attachment_image_src',
		[$attachment_id, $size, $icon],
		xu_cache_key( __FUNCTION__, $attachment_id )
	);
}

/**
 * Cached version of `wp_get_attachment_image_srcset`.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_get_attachment_image_srcset/
 *
 * @param  int          $attachment_id
 * @param  array|string $size
 * @param  array        $image_meta
 *
 * @return string
 */
function xu_wp_get_attachment_image_srcset( $attachment_id, $size = 'medium', $image_meta = null ) {
	return xu_cache_get(
		'wp_get_attachment_image_srcset',
		[$attachment_id, $size, $image_meta],
		xu_cache_key( __FUNCTION__, $attachment_id )
	);
}

/**
 * Cached version of `wp_get_attachment_url`.
 *
 * @param  int $post_id
 *
 * @return string
 */
function xu_wp_get_attachment_url( $post_id = 0 ) {
	return xu_cache_get( 'wp_get_attachment_url', [$post_id], __FUNCTION__ );
}
