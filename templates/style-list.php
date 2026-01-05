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
				</div>
			<?php endif; ?>

			<div class="post-style-content">
				<h3 class="post-style-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php echo esc_html( get_the_title() ); ?>
					</a>
				</h3>

				<?php if ( 'yes' === $atts['show_meta'] ) : ?>
					<div class="post-style-meta">
						<span class="post-style-date">
							<?php echo esc_html( get_the_date() ); ?>
						</span>
						<?php
						$categories = get_the_category();
						if ( ! empty( $categories ) ) :
							?>
							<span class="post-style-category">
								<?php echo esc_html( $categories[0]->name ); ?>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

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
		</li>
	<?php endwhile; ?>
</ul>

