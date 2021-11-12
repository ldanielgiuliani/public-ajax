<?php
/**
 * Endpoint Class.
 *
 * @package PublicAjax
 */

namespace PublicAjax;

use PublicAjax\Plugin;

/**
 * Adds front-facing enpoints.
 */
class Endpoint {
	/**
	 * Plugin class.
	 *
	 * @var Plugin
	 */
	public $plugin;

	/**
	 * Constructor.
	 *
	 * @access public
	 *
	 * @param Plugin $plugin Plugin instance.
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Initiate the class.
	 *
	 * @access public
	 */
	public function init() {
		$this->plugin->add_doc_hooks( $this );

		add_rewrite_tag( '%action%', '([a-z0-9_\-]+)' );
		add_rewrite_rule( 'public-ajax/([a-z0-9_\-]+)/?', 'index.php?action=$matches[1]', 'top' );
	}
}
