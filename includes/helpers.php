<?php
/**
 * Helper functions
 *
 * @package PostStyle
 * @subpackage Core
 */

namespace PostStyle\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize HTML output
 *
 * @param string $html HTML content.
 * @return string Sanitized HTML
 */
function sanitize_html( $html ) {
	return wp_kses_post( $html );
}

/**
 * Get post excerpt with custom length
 *
 * @param int    $length Excerpt length.
 * @param string $more   More text.
 * @return string Excerpt
 */
function get_post_excerpt( $length = 20, $more = '...' ) {
	$excerpt = get_the_excerpt();
	if ( empty( $excerpt ) ) {
		$excerpt = get_the_content();
	}
	return wp_trim_words( $excerpt, $length, $more );
}

/**
 * Get post thumbnail URL with fallback
 *
 * @param string $size Image size.
 * @return string|false Image URL or false
 */
function get_post_thumbnail_url( $size = 'medium' ) {
	if ( has_post_thumbnail() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
		return $image ? $image[0] : false;
	}
	return false;
}

