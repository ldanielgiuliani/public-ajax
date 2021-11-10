<?php
/**
 * Plugin Name:       Public Ajax Plugin
 * Plugin URI:        https://github.com/ldanielgiuliani/public-ajax
 * Description:       Front-facing endpoints for ajax calls using Rewrite Rules API.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Daniel Giuliani
 * Author URI:        https://github.com/ldanielgiuliani
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/ldanielgiuliani/public-ajax
 * Text Domain:       public-ajax
 *
 *  @package Dan\PublicAjax
 */

namespace Dan\PublicAjax;

// Support for site-level autoloading.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

$plugin = new Plugin();

add_action( 'plugins_loaded', [ $plugin, 'init' ] );
