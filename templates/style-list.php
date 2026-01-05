<?php
/**
 * List style template
 *
 * @package PostStyle
 * @var \WP_Query $query Query object
 * @var array     $atts  Shortcode attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<ul class="post-style-list">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		?>
		<li class="post-style-item post-style-list-item">
			<?php if ( 'yes' === $atts['show_image'] && has_post_thumbnail() ) : ?>
				<div class="post-style-image">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
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

			<div class="post-style-content">
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
						<?php
						$categories = get_the_category();
						if ( ! empty( $categories ) ) :
							?>
							<span class="post-style-category">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
									<line x1="7" y1="7" x2="7.01" y2="7"></line>
								</svg>
								<?php echo esc_html( $categories[0]->name ); ?>
							</span>
						<?php endif; ?>
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

				<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-style-read-more">
					<?php esc_html_e( 'Read More', 'post-style' ); ?>
				</a>
			</div>
		</li>
	<?php endwhile; ?>
</ul>

