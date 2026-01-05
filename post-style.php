<?php
/**
 * Plugin Name: Post Style
 * Plugin URI: https://example.com/post-style
 * Description: Professional WordPress plugin for displaying posts in multiple responsive styles (list, card, grid, masonry, slider) via shortcodes.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: post-style
 * Domain Path: /languages
 * Requires at least: 5.8
 * Tested up to: 6.4
 * Requires PHP: 7.4
 *
 * @package PostStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'POST_STYLE_VERSION', '1.0.0' );
define( 'POST_STYLE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'POST_STYLE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'POST_STYLE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! class_exists( 'PostStyle\\Core\\Loader' ) ) {
	require_once POST_STYLE_PLUGIN_DIR . 'includes/class-loader.php';
}

function post_style() {
	return PostStyle\Core\Loader::get_instance();
}

post_style();

