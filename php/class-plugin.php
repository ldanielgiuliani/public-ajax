<?php
/**
 * Bootstraps the Public Ajax plugin.
 *
 * @package PublicAjax
 */

namespace PublicAjax;

use PublicAjax\Endpoint;
use PublicAjax\Route;

/**
 * Main plugin bootstrap file.
 */
class Plugin extends Plugin_Base {

	/**
	 * Endpoint class.
	 *
	 * @var Endpoint
	 */
	public $endpoint;

	/**
	 * Route class.
	 *
	 * @var Route
	 */
	public $route;

	/**
	 * Initiate the plugin resources.
	 *
	 * Priority is 9 because WP_Customize_Widgets::register_settings() happens at
	 * after_setup_theme priority 10. This is especially important for plugins
	 * that extend the Customizer to ensure resources are available in time.
	 *
	 * @action after_setup_theme, 9
	 */
	public function init() {
		$this->config   = apply_filters( 'public_ajax_plugin_config', $this->config, $this );
		$this->endpoint = new Endpoint( $this );        
		$this->route    = new Route( $this );

		// Init classes.
		$this->endpoint->init();
		$this->route->init();
	}

	/**
	 * Enqueue front-end styles and scripts.
	 *
	 * @action wp_enqueue_scripts
	 */
	public function enqueue_front_end_assets() {}

	/**
	 * Register Customizer scripts.
	 *
	 * @action wp_default_scripts, 11
	 *
	 * @param \WP_Scripts $wp_scripts Instance of \WP_Scripts.
	 */
	public function register_scripts( \WP_Scripts $wp_scripts ) {}

	/**
	 * Register Customizer styles.
	 *
	 * @action wp_default_styles, 11
	 *
	 * @param \WP_Styles $wp_styles Instance of \WP_Styles.
	 */
	public function register_styles( \WP_Styles $wp_styles ) {}
}
