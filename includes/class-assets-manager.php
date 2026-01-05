<?php
/**
 * Assets manager class
 *
 * @package PostStyle
 * @subpackage Core
 */

namespace PostStyle\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manages CSS and JavaScript assets
 */
class Assets_Manager {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->register_hooks();
	}

	/**
	 * Register WordPress hooks
	 */
	private function register_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style_assets' ), 20 );
	}

	/**
	 * Enqueue common assets
	 */
	public function enqueue_assets() {
		wp_enqueue_style(
			'post-style-base',
			POST_STYLE_PLUGIN_URL . 'assets/css/base.css',
			array(),
			POST_STYLE_VERSION
		);

		wp_enqueue_style(
			'post-style-pagination',
			POST_STYLE_PLUGIN_URL . 'assets/css/styles/pagination.css',
			array( 'post-style-base' ),
			POST_STYLE_VERSION
		);
	}

	/**
	 * Enqueue style-specific assets based on used shortcodes
	 */
	public function enqueue_style_assets() {
		global $post;

		if ( ! is_a( $post, 'WP_Post' ) ) {
			return;
		}

		$content = $post->post_content;
		$styles  = $this->detect_used_styles( $content );

		foreach ( $styles as $style ) {
			$this->enqueue_style_asset( $style );
		}
	}

	/**
	 * Detect which post styles are used in content
	 *
	 * @param string $content Post content.
	 * @return array Array of style names
	 */
	private function detect_used_styles( $content ) {
		$styles = array();
		$pattern = '/\[post_style[^\]]*style=["\']([^"\']+)["\']/i';

		if ( preg_match_all( $pattern, $content, $matches ) ) {
			$styles = array_unique( $matches[1] );
		} else {
			$pattern = '/\[post_style[^\]]*\]/i';
			if ( preg_match( $pattern, $content ) ) {
				$styles[] = 'list';
			}
		}

		return apply_filters( 'post_style_detected_styles', $styles, $content );
	}

	/**
	 * Enqueue assets for a specific style
	 *
	 * @param string $style Style name.
	 */
	private function enqueue_style_asset( $style ) {
		$style = sanitize_file_name( $style );
		$css_file = POST_STYLE_PLUGIN_DIR . "assets/css/styles/{$style}.css";
		$js_file  = POST_STYLE_PLUGIN_DIR . "assets/js/styles/{$style}.js";

		if ( file_exists( $css_file ) ) {
			wp_enqueue_style(
				"post-style-{$style}",
				POST_STYLE_PLUGIN_URL . "assets/css/styles/{$style}.css",
				array( 'post-style-base' ),
				POST_STYLE_VERSION
			);
		}

		if ( file_exists( $js_file ) ) {
			wp_enqueue_script(
				"post-style-{$style}",
				POST_STYLE_PLUGIN_URL . "assets/js/styles/{$style}.js",
				array( 'jquery' ),
				POST_STYLE_VERSION,
				true
			);
		}
	}
}

