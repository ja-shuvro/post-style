<?php
/**
 * Core plugin loader class
 *
 * @package PostStyle
 * @subpackage Core
 */

namespace PostStyle\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin loader class
 *
 * Orchestrates all plugin components and manages hooks
 */
class Loader {

	/**
	 * Single instance of the class
	 *
	 * @var Loader
	 */
	private static $instance = null;

	/**
	 * Shortcode manager instance
	 *
	 * @var Shortcode_Manager
	 */
	public $shortcode_manager;

	/**
	 * Assets manager instance
	 *
	 * @var Assets_Manager
	 */
	public $assets_manager;

	/**
	 * Template renderer instance
	 *
	 * @var Template_Renderer
	 */
	public $template_renderer;

	/**
	 * Query builder instance
	 *
	 * @var Query_Builder
	 */
	public $query_builder;

	/**
	 * Get singleton instance
	 *
	 * @return Loader
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->load_dependencies();
		$this->init_components();
		$this->register_hooks();
	}

	/**
	 * Load required dependencies
	 */
	private function load_dependencies() {
		require_once POST_STYLE_PLUGIN_DIR . 'includes/class-shortcode-manager.php';
		require_once POST_STYLE_PLUGIN_DIR . 'includes/class-assets-manager.php';
		require_once POST_STYLE_PLUGIN_DIR . 'includes/class-template-renderer.php';
		require_once POST_STYLE_PLUGIN_DIR . 'includes/class-query-builder.php';
	}

	/**
	 * Initialize plugin components
	 */
	private function init_components() {
		$this->query_builder      = new Query_Builder();
		$this->template_renderer   = new Template_Renderer();
		$this->assets_manager      = new Assets_Manager();
		$this->shortcode_manager   = new Shortcode_Manager( $this->template_renderer, $this->query_builder );
	}

	/**
	 * Register WordPress hooks
	 */
	private function register_hooks() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		register_activation_hook( POST_STYLE_PLUGIN_BASENAME, array( $this, 'activate' ) );
		register_deactivation_hook( POST_STYLE_PLUGIN_BASENAME, array( $this, 'deactivate' ) );
	}

	/**
	 * Load plugin textdomain for translations
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'post-style',
			false,
			dirname( POST_STYLE_PLUGIN_BASENAME ) . '/languages'
		);
	}

	/**
	 * Plugin activation hook
	 */
	public function activate() {
		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivation hook
	 */
	public function deactivate() {
		flush_rewrite_rules();
	}
}

