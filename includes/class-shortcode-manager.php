<?php
/**
 * Shortcode manager class
 *
 * @package PostStyle
 * @subpackage Core
 */

namespace PostStyle\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manages shortcode registration and rendering
 */
class Shortcode_Manager {

	/**
	 * Template renderer instance
	 *
	 * @var Template_Renderer
	 */
	private $template_renderer;

	/**
	 * Query builder instance
	 *
	 * @var Query_Builder
	 */
	private $query_builder;

	/**
	 * Constructor
	 *
	 * @param Template_Renderer $template_renderer Template renderer instance.
	 * @param Query_Builder     $query_builder Query builder instance.
	 */
	public function __construct( Template_Renderer $template_renderer, Query_Builder $query_builder ) {
		$this->template_renderer = $template_renderer;
		$this->query_builder     = $query_builder;
		$this->register_shortcode();
	}

	/**
	 * Register the main shortcode
	 */
	private function register_shortcode() {
		add_shortcode( 'post_style', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Render shortcode output
	 *
	 * @param array  $atts Shortcode attributes.
	 * @param string $content Shortcode content (not used).
	 * @return string Rendered HTML
	 */
	public function render_shortcode( $atts, $content = '' ) {
		$atts = $this->sanitize_attributes( $atts );

		$query_args = $this->query_builder->build_query_args( $atts );
		$query      = $this->query_builder->get_posts( $query_args );

		if ( ! $query->have_posts() ) {
			return $this->render_no_posts_message();
		}

		$style = sanitize_text_field( $atts['style'] );

		ob_start();
		$this->template_renderer->render( $style, $query, $atts );
		$output = ob_get_clean();

		wp_reset_postdata();

		return $output;
	}

	/**
	 * Sanitize shortcode attributes
	 *
	 * @param array $atts Raw attributes.
	 * @return array Sanitized attributes
	 */
	private function sanitize_attributes( $atts ) {
		$defaults = $this->query_builder->get_default_attributes();

		if ( ! is_array( $atts ) ) {
			$atts = array();
		}

		$atts = shortcode_atts( $defaults, $atts, 'post_style' );

		$atts['posts_per_page'] = absint( $atts['posts_per_page'] );
		$atts['columns']        = absint( $atts['columns'] );
		$atts['excerpt_length'] = absint( $atts['excerpt_length'] );
		$atts['show_excerpt']   = in_array( $atts['show_excerpt'], array( 'yes', 'true', '1' ), true ) ? 'yes' : 'no';
		$atts['show_meta']      = in_array( $atts['show_meta'], array( 'yes', 'true', '1' ), true ) ? 'yes' : 'no';
		$atts['show_image']     = in_array( $atts['show_image'], array( 'yes', 'true', '1' ), true ) ? 'yes' : 'no';

		return apply_filters( 'post_style_shortcode_atts', $atts );
	}

	/**
	 * Render message when no posts found
	 *
	 * @return string HTML output
	 */
	private function render_no_posts_message() {
		return '<div class="post-style-no-posts">' . esc_html__( 'No posts found.', 'post-style' ) . '</div>';
	}
}

