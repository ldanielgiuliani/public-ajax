<?php
/**
 * Endpoint Class.
 *
 * @package Dan\PublicAjax
 */

namespace Dan\PublicAjax;

/**
 * Adds front-facing enpoints.
 */
class Endpoint {
	/**
	 * Instantiates the class.
	 */
	function __construct() {
		add_action( 'init', [ $this, 'add_endpoints' ] );
		add_action( 'template_redirect', [ Route::init(), 'do_api' ] );
	}

	/**
	 * Add endpoints for the API
	 */
	function add_endpoints() {
		add_rewrite_tag( '%action%', '^[a-z0-9_\-]+' );
		add_rewrite_rule( 'public-ajax/^[a-z0-9_\-]+$/?', 'index.php?action=$matches[1]', 'top' );
	}
}
