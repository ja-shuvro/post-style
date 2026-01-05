<?php
/**
 * Card style template
 *
 * @package PostStyle
 * @var \WP_Query $query Query object
 * @var array     $atts  Shortcode attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="post-style-cards">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		?>
		<article class="post-style-item post-style-card">
			<?php if ( 'yes' === $atts['show_image'] && has_post_thumbnail() ) : ?>
				<div class="post-style-image">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php the_post_thumbnail( 'medium_large', array( 'alt' => get_the_title() ) ); ?>
					</a>
				</div>
			<?php endif; ?>

			<div class="post-style-card-content">
				<?php if ( 'yes' === $atts['show_meta'] ) : ?>
					<div class="post-style-meta">
						<span class="post-style-date">
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

				<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-style-read-more">
					<?php esc_html_e( 'Read More', 'post-style' ); ?>
				</a>
			</div>
		</article>
	<?php endwhile; ?>
</div>

