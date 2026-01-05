<?php
/**
 * Template renderer class
 *
 * @package PostStyle
 * @subpackage Core
 */

namespace PostStyle\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles template rendering for different post styles
 */
class Template_Renderer {

	/**
	 * Available post styles
	 *
	 * @var array
	 */
	private $available_styles = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->register_available_styles();
	}

	/**
	 * Register available post styles
	 */
	private function register_available_styles() {
		$this->available_styles = array(
			'list'     => __( 'List', 'post-style' ),
			'card'     => __( 'Card', 'post-style' ),
			'grid'     => __( 'Grid', 'post-style' ),
			'masonry'  => __( 'Masonry', 'post-style' ),
			'slider'   => __( 'Slider', 'post-style' ),
		);

		$this->available_styles = apply_filters( 'post_style_available_styles', $this->available_styles );
	}

	/**
	 * Get available styles
	 *
	 * @return array Available styles
	 */
	public function get_available_styles() {
		return $this->available_styles;
	}

	/**
	 * Render template for a specific style
	 *
	 * @param string   $style Style name.
	 * @param \WP_Query $query Query object.
	 * @param array    $atts Shortcode attributes.
	 */
	public function render( $style, $query, $atts ) {
		$style = sanitize_file_name( $style );

		if ( ! $this->is_valid_style( $style ) ) {
			$style = 'list';
		}

		$template_file = $this->locate_template( $style );

		if ( ! $template_file ) {
			return;
		}

		$wrapper_class = $this->get_wrapper_class( $style, $atts );
		$wrapper_id    = $this->get_wrapper_id( $style );

		echo '<div id="' . esc_attr( $wrapper_id ) . '" class="' . esc_attr( $wrapper_class ) . '" data-style="' . esc_attr( $style ) . '">';

		include $template_file;

		echo '</div>';
	}

	/**
	 * Check if style is valid
	 *
	 * @param string $style Style name.
	 * @return bool True if valid
	 */
	private function is_valid_style( $style ) {
		return array_key_exists( $style, $this->available_styles ) || file_exists( $this->locate_template( $style ) );
	}

	/**
	 * Locate template file for a style
	 *
	 * @param string $style Style name.
	 * @return string|false Template file path or false
	 */
	private function locate_template( $style ) {
		$template_file = POST_STYLE_PLUGIN_DIR . "templates/style-{$style}.php";

		$template_file = apply_filters( 'post_style_template_file', $template_file, $style );

		if ( file_exists( $template_file ) ) {
			return $template_file;
		}

		return false;
	}

	/**
	 * Get wrapper CSS class
	 *
	 * @param string $style Style name.
	 * @param array  $atts Attributes.
	 * @return string CSS classes
	 */
	private function get_wrapper_class( $style, $atts ) {
		$classes = array(
			'post-style-wrapper',
			"post-style-{$style}",
		);

		if ( ! empty( $atts['columns'] ) && in_array( $style, array( 'grid', 'masonry', 'card' ), true ) ) {
			$classes[] = "post-style-columns-{$atts['columns']}";
		}

		$classes = apply_filters( 'post_style_wrapper_classes', $classes, $style, $atts );

		return implode( ' ', $classes );
	}

	/**
	 * Get unique wrapper ID
	 *
	 * @param string $style Style name.
	 * @return string Unique ID
	 */
	private function get_wrapper_id( $style ) {
		static $instance_count = 0;
		$instance_count++;
		return 'post-style-' . $style . '-' . $instance_count;
	}
}

