<?php
/**
 * Query builder class for post queries
 *
 * @package PostStyle
 * @subpackage Core
 */

namespace PostStyle\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Builds and executes WordPress queries
 */
class Query_Builder {

	/**
	 * Build WP_Query arguments from shortcode attributes
	 *
	 * @param array $atts Shortcode attributes.
	 * @return array WP_Query arguments
	 */
	public function build_query_args( $atts ) {
		$defaults = $this->get_default_attributes();
		$atts     = wp_parse_args( $atts, $defaults );

		$query_args = array(
			'post_type'      => sanitize_text_field( $atts['post_type'] ),
			'posts_per_page' => absint( $atts['posts_per_page'] ),
			'post_status'    => 'publish',
			'orderby'        => sanitize_text_field( $atts['orderby'] ),
			'order'          => strtoupper( sanitize_text_field( $atts['order'] ) ) === 'ASC' ? 'ASC' : 'DESC',
		);

		if ( ! empty( $atts['category'] ) ) {
			if ( 'post' === $atts['post_type'] ) {
				$query_args['cat'] = absint( $atts['category'] );
			} else {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => $this->get_primary_taxonomy( $atts['post_type'] ),
						'field'    => 'term_id',
						'terms'    => absint( $atts['category'] ),
					),
				);
			}
		}

		if ( ! empty( $atts['taxonomy'] ) && ! empty( $atts['tax_term'] ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => sanitize_text_field( $atts['taxonomy'] ),
					'field'    => 'term_id',
					'terms'    => absint( $atts['tax_term'] ),
				),
			);
		}

		if ( ! empty( $atts['post__in'] ) ) {
			$post_ids = array_map( 'absint', explode( ',', $atts['post__in'] ) );
			$query_args['post__in'] = $post_ids;
			$query_args['orderby']  = 'post__in';
		}

		if ( ! empty( $atts['exclude'] ) ) {
			$exclude_ids = array_map( 'absint', explode( ',', $atts['exclude'] ) );
			$query_args['post__not_in'] = $exclude_ids;
		}

		$query_args = apply_filters( 'post_style_query_args', $query_args, $atts );

		return $query_args;
	}

	/**
	 * Execute query and return posts
	 *
	 * @param array $query_args WP_Query arguments.
	 * @return \WP_Query Query object
	 */
	public function get_posts( $query_args ) {
		return new \WP_Query( $query_args );
	}

	/**
	 * Get default shortcode attributes
	 *
	 * @return array Default attributes
	 */
	public function get_default_attributes() {
		return array(
			'post_type'      => 'post',
			'posts_per_page' => 6,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'category'       => '',
			'taxonomy'       => '',
			'tax_term'       => '',
			'post__in'       => '',
			'exclude'        => '',
			'style'          => 'list',
			'columns'        => 3,
			'show_excerpt'   => 'yes',
			'excerpt_length' => 20,
			'show_meta'      => 'yes',
			'show_image'     => 'yes',
		);
	}

	/**
	 * Get primary taxonomy for a post type
	 *
	 * @param string $post_type Post type name.
	 * @return string Taxonomy name
	 */
	private function get_primary_taxonomy( $post_type ) {
		$taxonomies = get_object_taxonomies( $post_type );
		if ( in_array( 'category', $taxonomies, true ) ) {
			return 'category';
		}
		return ! empty( $taxonomies ) ? $taxonomies[0] : '';
	}
}

