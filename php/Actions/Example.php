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
class Example extends Base {
	/**
	 * Action handler
	 *
	 * @param array $params An array of params, defined by self::args().
	 *
	 * @return mixed
	 */
	public static function act( $params ) {
		$post = get_post( 1 );

		return $post;
	}
}
