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
		
		if ( 'yes' === $atts['pagination'] && $query->max_num_pages > 1 ) {
			$this->render_pagination( $query, $atts );
		}
		
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
		$atts['pagination']     = in_array( $atts['pagination'], array( 'yes', 'true', '1' ), true ) ? 'yes' : 'no';

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

	/**
	 * Render pagination
	 *
	 * @param \WP_Query $query Query object.
	 * @param array     $atts Shortcode attributes.
	 */
	private function render_pagination( $query, $atts ) {
		$current_page = max( 1, isset( $_GET['ps_page'] ) ? absint( $_GET['ps_page'] ) : 1 );
		$total_pages  = $query->max_num_pages;
		
		if ( $total_pages <= 1 ) {
			return;
		}

		$base_url = get_permalink();
		if ( ! $base_url ) {
			$base_url = home_url( '/' );
		}

		echo '<nav class="post-style-pagination" aria-label="' . esc_attr__( 'Post pagination', 'post-style' ) . '">';
		echo '<ul class="post-style-pagination-list">';

		if ( $current_page > 1 ) {
			$prev_url = add_query_arg( 'ps_page', $current_page - 1, $base_url );
			echo '<li class="post-style-pagination-item post-style-pagination-prev">';
			echo '<a href="' . esc_url( $prev_url ) . '#post-style-' . esc_attr( $atts['style'] ) . '" class="post-style-pagination-link">';
			echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>';
			echo '<span>' . esc_html__( 'Previous', 'post-style' ) . '</span>';
			echo '</a>';
			echo '</li>';
		}

		$start = max( 1, $current_page - 2 );
		$end   = min( $total_pages, $current_page + 2 );

		if ( $start > 1 ) {
			$first_url = add_query_arg( 'ps_page', 1, $base_url );
			echo '<li class="post-style-pagination-item"><a href="' . esc_url( $first_url ) . '#post-style-' . esc_attr( $atts['style'] ) . '" class="post-style-pagination-link">1</a></li>';
			if ( $start > 2 ) {
				echo '<li class="post-style-pagination-item post-style-pagination-dots"><span>...</span></li>';
			}
		}

		for ( $i = $start; $i <= $end; $i++ ) {
			if ( $i === $current_page ) {
				echo '<li class="post-style-pagination-item post-style-pagination-current"><span class="post-style-pagination-link">' . esc_html( $i ) . '</span></li>';
			} else {
				$page_url = add_query_arg( 'ps_page', $i, $base_url );
				echo '<li class="post-style-pagination-item"><a href="' . esc_url( $page_url ) . '#post-style-' . esc_attr( $atts['style'] ) . '" class="post-style-pagination-link">' . esc_html( $i ) . '</a></li>';
			}
		}

		if ( $end < $total_pages ) {
			if ( $end < $total_pages - 1 ) {
				echo '<li class="post-style-pagination-item post-style-pagination-dots"><span>...</span></li>';
			}
			$last_url = add_query_arg( 'ps_page', $total_pages, $base_url );
			echo '<li class="post-style-pagination-item"><a href="' . esc_url( $last_url ) . '#post-style-' . esc_attr( $atts['style'] ) . '" class="post-style-pagination-link">' . esc_html( $total_pages ) . '</a></li>';
		}

		if ( $current_page < $total_pages ) {
			$next_url = add_query_arg( 'ps_page', $current_page + 1, $base_url );
			echo '<li class="post-style-pagination-item post-style-pagination-next">';
			echo '<a href="' . esc_url( $next_url ) . '#post-style-' . esc_attr( $atts['style'] ) . '" class="post-style-pagination-link">';
			echo '<span>' . esc_html__( 'Next', 'post-style' ) . '</span>';
			echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>';
			echo '</a>';
			echo '</li>';
		}

		echo '</ul>';
		echo '</nav>';
	}
}

