<?php
/**
 * Admin page view
 *
 * @package PostStyle
 * @var array $available_styles Available post styles
 * @var array $post_types Available post types
 * @var array $categories Available categories
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap post-style-admin">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div class="post-style-admin-container">
		<div class="post-style-admin-main">
			<div class="post-style-section">
				<h2><?php esc_html_e( 'Shortcode Generator', 'post-style' ); ?></h2>
				<p class="description">
					<?php esc_html_e( 'Configure your shortcode settings below and copy the generated shortcode to use in your posts or pages.', 'post-style' ); ?>
				</p>

				<form id="post-style-generator" class="post-style-form">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">
									<label for="style"><?php esc_html_e( 'Display Style', 'post-style' ); ?></label>
								</th>
								<td>
									<select name="style" id="style" class="regular-text">
										<?php foreach ( $available_styles as $value => $label ) : ?>
											<option value="<?php echo esc_attr( $value ); ?>">
												<?php echo esc_html( $label ); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p class="description">
										<?php esc_html_e( 'Choose how posts should be displayed.', 'post-style' ); ?>
									</p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="post_type"><?php esc_html_e( 'Post Type', 'post-style' ); ?></label>
								</th>
								<td>
									<select name="post_type" id="post_type" class="regular-text">
										<?php foreach ( $post_types as $post_type ) : ?>
											<option value="<?php echo esc_attr( $post_type->name ); ?>">
												<?php echo esc_html( $post_type->label ); ?>
											</option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="posts_per_page"><?php esc_html_e( 'Number of Posts', 'post-style' ); ?></label>
								</th>
								<td>
									<input type="number" name="posts_per_page" id="posts_per_page" value="6" min="1" max="50" class="small-text">
									<p class="description">
										<?php esc_html_e( 'Number of posts to display (1-50).', 'post-style' ); ?>
									</p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="columns"><?php esc_html_e( 'Columns', 'post-style' ); ?></label>
								</th>
								<td>
									<input type="number" name="columns" id="columns" value="3" min="1" max="6" class="small-text">
									<p class="description">
										<?php esc_html_e( 'Number of columns for grid/card/masonry styles (1-6).', 'post-style' ); ?>
									</p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="category"><?php esc_html_e( 'Category', 'post-style' ); ?></label>
								</th>
								<td>
									<select name="category" id="category" class="regular-text">
										<option value=""><?php esc_html_e( 'All Categories', 'post-style' ); ?></option>
										<?php foreach ( $categories as $category ) : ?>
											<option value="<?php echo esc_attr( $category->term_id ); ?>">
												<?php echo esc_html( $category->name ); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p class="description">
										<?php esc_html_e( 'Filter posts by category (optional).', 'post-style' ); ?>
									</p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="orderby"><?php esc_html_e( 'Order By', 'post-style' ); ?></label>
								</th>
								<td>
									<select name="orderby" id="orderby" class="regular-text">
										<option value="date"><?php esc_html_e( 'Date', 'post-style' ); ?></option>
										<option value="title"><?php esc_html_e( 'Title', 'post-style' ); ?></option>
										<option value="menu_order"><?php esc_html_e( 'Menu Order', 'post-style' ); ?></option>
										<option value="rand"><?php esc_html_e( 'Random', 'post-style' ); ?></option>
										<option value="comment_count"><?php esc_html_e( 'Comment Count', 'post-style' ); ?></option>
									</select>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="order"><?php esc_html_e( 'Order', 'post-style' ); ?></label>
								</th>
								<td>
									<select name="order" id="order" class="regular-text">
										<option value="DESC"><?php esc_html_e( 'Descending', 'post-style' ); ?></option>
										<option value="ASC"><?php esc_html_e( 'Ascending', 'post-style' ); ?></option>
									</select>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label><?php esc_html_e( 'Display Options', 'post-style' ); ?></label>
								</th>
								<td>
									<fieldset>
										<label>
											<input type="checkbox" name="show_image" id="show_image" value="yes" checked>
											<?php esc_html_e( 'Show Featured Image', 'post-style' ); ?>
										</label><br>
										<label>
											<input type="checkbox" name="show_excerpt" id="show_excerpt" value="yes" checked>
											<?php esc_html_e( 'Show Excerpt', 'post-style' ); ?>
										</label><br>
										<label>
											<input type="checkbox" name="show_meta" id="show_meta" value="yes" checked>
											<?php esc_html_e( 'Show Post Meta', 'post-style' ); ?>
										</label>
									</fieldset>
								</td>
							</tr>

							<tr id="excerpt_length_row" style="display: none;">
								<th scope="row">
									<label for="excerpt_length"><?php esc_html_e( 'Excerpt Length', 'post-style' ); ?></label>
								</th>
								<td>
									<input type="number" name="excerpt_length" id="excerpt_length" value="20" min="5" max="100" class="small-text">
									<p class="description">
										<?php esc_html_e( 'Number of words in excerpt (5-100).', 'post-style' ); ?>
									</p>
								</td>
							</tr>
						</tbody>
					</table>

					<div class="post-style-shortcode-output">
						<h3><?php esc_html_e( 'Generated Shortcode', 'post-style' ); ?></h3>
						<div class="post-style-shortcode-box">
							<code id="generated-shortcode">[post_style]</code>
							<button type="button" class="button button-primary" id="copy-shortcode">
								<?php esc_html_e( 'Copy Shortcode', 'post-style' ); ?>
							</button>
						</div>
						<p class="description">
							<?php esc_html_e( 'Copy this shortcode and paste it into any post or page.', 'post-style' ); ?>
						</p>
					</div>
				</form>
			</div>
		</div>

		<div class="post-style-admin-sidebar">
			<div class="post-style-widget">
				<h3><?php esc_html_e( 'Quick Start', 'post-style' ); ?></h3>
				<p><?php esc_html_e( 'Use the form to generate a shortcode, then copy and paste it into any post or page.', 'post-style' ); ?></p>
			</div>

			<div class="post-style-widget">
				<h3><?php esc_html_e( 'Available Styles', 'post-style' ); ?></h3>
				<ul>
					<?php foreach ( $available_styles as $value => $label ) : ?>
						<li><strong><?php echo esc_html( $label ); ?></strong> - <?php echo esc_html( ucfirst( $value ) ); ?> layout</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="post-style-widget">
				<h3><?php esc_html_e( 'Need Help?', 'post-style' ); ?></h3>
				<p>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=post-style-docs' ) ); ?>" class="button">
						<?php esc_html_e( 'View Documentation', 'post-style' ); ?>
					</a>
				</p>
			</div>
		</div>
	</div>
</div>

