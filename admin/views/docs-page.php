<?php
/**
 * Documentation page view
 *
 * @package PostStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap post-style-admin">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div class="post-style-docs">
		<div class="post-style-doc-section">
			<h2><?php esc_html_e( 'Basic Usage', 'post-style' ); ?></h2>
			<p><?php esc_html_e( 'The simplest way to use Post Style is with the default shortcode:', 'post-style' ); ?></p>
			<pre><code>[post_style]</code></pre>
			<p><?php esc_html_e( 'This will display 6 recent posts in a list layout.', 'post-style' ); ?></p>
		</div>

		<div class="post-style-doc-section">
			<h2><?php esc_html_e( 'Available Styles', 'post-style' ); ?></h2>
			<ul>
				<li><strong>list</strong> - <?php esc_html_e( 'Horizontal list with images and content', 'post-style' ); ?></li>
				<li><strong>card</strong> - <?php esc_html_e( 'Card-based layout with hover effects', 'post-style' ); ?></li>
				<li><strong>grid</strong> - <?php esc_html_e( 'Responsive grid layout', 'post-style' ); ?></li>
				<li><strong>masonry</strong> - <?php esc_html_e( 'Pinterest-style masonry layout', 'post-style' ); ?></li>
				<li><strong>slider</strong> - <?php esc_html_e( 'Carousel slider with navigation', 'post-style' ); ?></li>
			</ul>
		</div>

		<div class="post-style-doc-section">
			<h2><?php esc_html_e( 'Shortcode Attributes', 'post-style' ); ?></h2>
			<table class="widefat">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Attribute', 'post-style' ); ?></th>
						<th><?php esc_html_e( 'Description', 'post-style' ); ?></th>
						<th><?php esc_html_e( 'Default', 'post-style' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><code>style</code></td>
						<td><?php esc_html_e( 'Display style: list, card, grid, masonry, slider', 'post-style' ); ?></td>
						<td>list</td>
					</tr>
					<tr>
						<td><code>posts_per_page</code></td>
						<td><?php esc_html_e( 'Number of posts to display', 'post-style' ); ?></td>
						<td>6</td>
					</tr>
					<tr>
						<td><code>post_type</code></td>
						<td><?php esc_html_e( 'Post type to query', 'post-style' ); ?></td>
						<td>post</td>
					</tr>
					<tr>
						<td><code>category</code></td>
						<td><?php esc_html_e( 'Category ID to filter posts', 'post-style' ); ?></td>
						<td>-</td>
					</tr>
					<tr>
						<td><code>columns</code></td>
						<td><?php esc_html_e( 'Number of columns (for grid/card/masonry)', 'post-style' ); ?></td>
						<td>3</td>
					</tr>
					<tr>
						<td><code>orderby</code></td>
						<td><?php esc_html_e( 'Order by: date, title, menu_order, rand, comment_count', 'post-style' ); ?></td>
						<td>date</td>
					</tr>
					<tr>
						<td><code>order</code></td>
						<td><?php esc_html_e( 'Sort order: ASC or DESC', 'post-style' ); ?></td>
						<td>DESC</td>
					</tr>
					<tr>
						<td><code>show_image</code></td>
						<td><?php esc_html_e( 'Show featured image: yes or no', 'post-style' ); ?></td>
						<td>yes</td>
					</tr>
					<tr>
						<td><code>show_excerpt</code></td>
						<td><?php esc_html_e( 'Show excerpt: yes or no', 'post-style' ); ?></td>
						<td>yes</td>
					</tr>
					<tr>
						<td><code>show_meta</code></td>
						<td><?php esc_html_e( 'Show post meta: yes or no', 'post-style' ); ?></td>
						<td>yes</td>
					</tr>
					<tr>
						<td><code>excerpt_length</code></td>
						<td><?php esc_html_e( 'Number of words in excerpt', 'post-style' ); ?></td>
						<td>20</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="post-style-doc-section">
			<h2><?php esc_html_e( 'Examples', 'post-style' ); ?></h2>
			
			<h3><?php esc_html_e( 'Card Style with 9 Posts', 'post-style' ); ?></h3>
			<pre><code>[post_style style="card" posts_per_page="9" columns="3"]</code></pre>

			<h3><?php esc_html_e( 'Grid Style from Specific Category', 'post-style' ); ?></h3>
			<pre><code>[post_style style="grid" category="5" columns="4" posts_per_page="8"]</code></pre>

			<h3><?php esc_html_e( 'Slider for Custom Post Type', 'post-style' ); ?></h3>
			<pre><code>[post_style style="slider" post_type="portfolio" posts_per_page="5"]</code></pre>

			<h3><?php esc_html_e( 'Masonry Layout', 'post-style' ); ?></h3>
			<pre><code>[post_style style="masonry" posts_per_page="12" columns="3"]</code></pre>
		</div>

		<div class="post-style-doc-section">
			<h2><?php esc_html_e( 'Responsive Design', 'post-style' ); ?></h2>
			<p><?php esc_html_e( 'All styles are fully responsive and mobile-first. The plugin automatically adjusts column layouts based on screen size:', 'post-style' ); ?></p>
			<ul>
				<li><?php esc_html_e( 'Desktop: Full column layout', 'post-style' ); ?></li>
				<li><?php esc_html_e( 'Tablet: Reduced columns', 'post-style' ); ?></li>
				<li><?php esc_html_e( 'Mobile: Single column', 'post-style' ); ?></li>
			</ul>
		</div>

		<div class="post-style-doc-section">
			<h2><?php esc_html_e( 'Extending the Plugin', 'post-style' ); ?></h2>
			<p><?php esc_html_e( 'You can add custom post styles using WordPress filters. See the EXTENDING.md file in the plugin directory for detailed instructions.', 'post-style' ); ?></p>
		</div>
	</div>
</div>

