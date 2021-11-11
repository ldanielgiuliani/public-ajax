<?php
/**
 * Example action class.
 *
 * @package PublicAjax
 */

namespace PublicAjax\Actions;

/**
 * Example "action class" for illustrating how this might be use.
 */
class Base {
	/**
	 * Action handler
	 *
	 * @param array $params An array of params, defined by self::args().
	 *
	 * @return mixed
	 */
	public static function act( $params ) {
		return $params;
	}

	/**
	 * Params for this route
	 *
	 * Used to define what keys are in the array passed to self::act()
	 *
	 * @return array
	 */
	public static function args() {
		return [ 'nonce' ];
	}

	/**
	 * Define the HTTP method this action uses
	 *
	 * @return string
	 */
	public static function method() {
		return 'GET';
	}

}
