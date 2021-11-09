<?php
/**
 * Example action class.
 *
 * @package Dan\PublicAjax
 */

namespace Dan\PublicAjax\Actions;

/**
 * Example "action class" for illustrating how this might be use.
 */
class Example {
	/**
	 * Do something with the params
	 *
	 * @param array $params An array of params, defined by self::args().
	 *
	 * @return any
	 */
	public static function act( $params ) {
		$post = get_post( 1 );

		return $post;
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
