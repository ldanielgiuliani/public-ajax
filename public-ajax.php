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
 *  @package PublicAjax
 */

if ( version_compare( phpversion(), '5.6.20', '>=' ) ) {
	require_once __DIR__ . '/instance.php';
} else {
	if ( defined( 'WP_CLI' ) ) {
		WP_CLI::warning( public_ajax_php_version_text() );
	} else {
		add_action( 'admin_notices', 'public_ajax_php_version_error' );
	}
}

/**
 * Admin notice for incompatible versions of PHP.
 */
function public_ajax_php_version_error() {
	printf( '<div class="error"><p>%s</p></div>', esc_html( public_ajax_php_version_text() ) );
}

/**
 * String describing the minimum PHP version.
 *
 * @return string
 */
function public_ajax_php_version_text() {
	return esc_html__( 'Public Ajax plugin error: Your version of PHP is too old to run this plugin. You must be running PHP 5.6.20 or higher.', 'public-ajax' );
}
