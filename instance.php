<?php
/**
 * Instantiates the Public Ajax plugin
 *
 * @package PublicAjax
 */

namespace PublicAjax;

global $public_ajax_plugin;

require_once __DIR__ . '/php/class-plugin-base.php';
require_once __DIR__ . '/php/class-plugin.php';

$public_ajax_plugin = new Plugin();

/**
 * Public Plugin Instance
 *
 * @return Plugin
 */
function get_plugin_instance() {
	global $public_ajax_plugin;
	return $public_ajax_plugin;
}
