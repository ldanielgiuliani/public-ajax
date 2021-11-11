<?php
/**
 * Auth Class.
 *
 * @package PublicAjax
 */

namespace PublicAjax;

/**
 * Check if action is authorized
 */
class Auth {
	/**
	 * Authorization checks
	 *
	 * @param string $nonce Security Nonce.
	 * @return int|false
	 */
	public static function check( $nonce ) {
		return wp_verify_nonce( $nonce, '_wpnonce' );
	}
}
