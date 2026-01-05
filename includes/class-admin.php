<?php
/**
 * Admin class
 *
 * @package PostStyle
 * @subpackage Admin
 */

namespace PostStyle\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles admin interface
 */
class Admin {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->register_hooks();
	}

	/**
	 * Register WordPress hooks
	 */
	private function register_hooks() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Add admin menu
	 */
	public function add_admin_menu() {
		add_menu_page(
			__( 'Post Style', 'post-style' ),
			__( 'Post Style', 'post-style' ),
			'manage_options',
			'post-style',
			array( $this, 'render_admin_page' ),
			'dashicons-layout',
			30
		);

		add_submenu_page(
			'post-style',
			__( 'Shortcode Generator', 'post-style' ),
			__( 'Shortcode Generator', 'post-style' ),
			'manage_options',
			'post-style-generator',
			array( $this, 'render_admin_page' )
		);

		add_submenu_page(
			'post-style',
			__( 'Documentation', 'post-style' ),
			__( 'Documentation', 'post-style' ),
			'manage_options',
			'post-style-docs',
			array( $this, 'render_docs_page' )
		);
	}

	/**
	 * Register plugin settings
	 */
	public function register_settings() {
		register_setting( 'post_style_settings', 'post_style_default_style' );
		register_setting( 'post_style_settings', 'post_style_default_posts_per_page' );
		register_setting( 'post_style_settings', 'post_style_default_columns' );
	}

	/**
	 * Enqueue admin assets
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( strpos( $hook, 'post-style' ) === false ) {
			return;
		}

		wp_enqueue_style(
			'post-style-admin',
			POST_STYLE_PLUGIN_URL . 'assets/css/admin.css',
			array(),
			POST_STYLE_VERSION
		);

		wp_enqueue_script(
			'post-style-admin',
			POST_STYLE_PLUGIN_URL . 'assets/js/admin.js',
			array( 'jquery' ),
			POST_STYLE_VERSION,
			true
		);

		wp_localize_script(
			'post-style-admin',
			'postStyleAdmin',
			array(
				'nonce' => wp_create_nonce( 'post_style_admin_nonce' ),
			)
		);
	}

	/**
	 * Render main admin page
	 */
	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$available_styles = apply_filters( 'post_style_available_styles', array(
			'list'    => __( 'List', 'post-style' ),
			'card'    => __( 'Card', 'post-style' ),
			'grid'    => __( 'Grid', 'post-style' ),
			'masonry' => __( 'Masonry', 'post-style' ),
			'slider'  => __( 'Slider', 'post-style' ),
		) );

		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$categories = get_categories( array( 'hide_empty' => false ) );

		include POST_STYLE_PLUGIN_DIR . 'admin/views/admin-page.php';
	}

	/**
	 * Render documentation page
	 */
	public function render_docs_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		include POST_STYLE_PLUGIN_DIR . 'admin/views/docs-page.php';
	}
}

