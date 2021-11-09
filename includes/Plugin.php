<?php
/**
 * Plugin class.
 *
 * @package Dan\PublicAjax
 */

namespace Dan\PublicAjax;

/**
 * WordPress plugin interface.
 */
class Plugin {
	/**
	 * Initiates the class
	 */
	public function init() {
		( new Endpoint() );
	}
}
