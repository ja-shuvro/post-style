<?php
/**
 * Grid style template
 *
 * @package PostStyle
 * @var \WP_Query $query Query object
 * @var array     $atts  Shortcode attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="post-style-grid">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		?>
		<article class="post-style-item post-style-grid-item">
			<?php if ( 'yes' === $atts['show_image'] && has_post_thumbnail() ) : ?>
				<div class="post-style-image">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php the_post_thumbnail( 'medium_large', array( 'alt' => get_the_title() ) ); ?>
					</a>
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) && 'yes' === $atts['show_meta'] ) :
						?>
						<span class="post-style-category-badge">
							<?php echo esc_html( $categories[0]->name ); ?>
						</span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="post-style-grid-content">
				<?php if ( 'yes' === $atts['show_meta'] ) : ?>
					<div class="post-style-meta">
						<span class="post-style-date">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
								<line x1="16" y1="2" x2="16" y2="6"></line>
								<line x1="8" y1="2" x2="8" y2="6"></line>
								<line x1="3" y1="10" x2="21" y2="10"></line>
							</svg>
							<?php echo esc_html( get_the_date() ); ?>
						</span>
					</div>
				<?php endif; ?>

				<h3 class="post-style-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php echo esc_html( get_the_title() ); ?>
					</a>
				</h3>

				<?php if ( 'yes' === $atts['show_excerpt'] ) : ?>
					<div class="post-style-excerpt">
						<?php
						echo esc_html( wp_trim_words(
							get_the_excerpt(),
							$atts['excerpt_length'],
							'...'
						) );
						?>
					</div>
				<?php endif; ?>
			</div>
		</article>
	<?php endwhile; ?>
</div>

