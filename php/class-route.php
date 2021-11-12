<?php
/**
 * Route class.
 *
 * @package PublicAjax
 */

namespace PublicAjax;

use PublicAjax\Plugin;
use PublicAjax\Auth;

/**
 * Dispatch and respond to requests to internal API
 */
class Route {
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
	}

	/**
	 * Main router for internal API.
	 *
	 * Checks permission, and dispatches and returns, or returns error.
	 * 
	 * @action template_redirect, 99
	 *
	 * @todo: optimisation and transients?
	 */
	public function template_redirect() {
		global $wp_query;

		$action = $wp_query->get( 'action' );

		if ( $action ) {
			$action_class = self::action_class( $action );
		
			if ( $action_class ) {
				$method = isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( $_SERVER['REQUEST_METHOD'] ) : '';
				$nonce  = isset( $_SERVER['HTTP_NONCE'] ) ? sanitize_text_field( $_SERVER['HTTP_NONCE'] ) : '';
				$params = self::get_args( $action_class::args(), $method );

				if ( Auth::check( $nonce ) ) {
					return self::respond( false, 401 );
				}

				return self::respond( $action_class::act( $params ), 200 );
			} else {
				return self::respond( 404 );
			}
		}
	}

	/**
	 * Get a static class object, by action.
	 *
	 * @param string $action Action name.
	 *
	 * @return object The class object.
	 */
	protected static function action_class( $action ) {
		$namespace    = __NAMESPACE__ . '\\Actions\\';
		$class_action = str_replace( '-', '', ucwords( $action, '-' ) );
		$class_action = str_replace( '_', '', ucwords( $class_action, '_' ) );
		$class        = $namespace . $class_action;

		if ( class_exists( $class ) ) {
			return $class;
		}
	}

	/**
	 * Returned an array of the specified args from GET or POST data
	 *
	 * @param array  $accept_args Arguments to allow.
	 * @param string $method HTTP method to use GET|POST.
	 *
	 * @return bool|array
	 */
	protected static function get_args( $accept_args, $method = 'GET' ) {
		$method = strtoupper( $method );

		// Disable phpcs - false positive. The request is verified on line: 64.
		// phpcs:disable
		switch ( $method ) {
			case 'GET':
				$input = $_GET;
				break;
			case 'POST':
				$input = $_POST;
				break;
			default:
				return false;
		}
		// phpcs:enable

		return self::sanitize( $input, $accept_args );

	}

	/**
	 * Sanitize incoming POST or GET var for accepted args.
	 *
	 * @param array $input The GET or POST data.
	 * @param array $accept_args Array of args to sanitize and return.
	 *
	 * @return bool|array
	 */
	protected static function sanitize( $input, $accept_args ) {
		$output = false;

		if ( $input ) {
			foreach ( $input as $key => $val ) {
				if ( in_array( $key, $accept_args, true ) ) {
					$output[ $key ] = sanitize_text_field( $val );
				}
			}
		}

		return $output;
	}

	/**
	 * Send the response
	 *
	 * @param string|array|integer $response Response to send. Will be encoded as JSON if is array.
	 * @param int|null             $status_code Optional. Status code to set for the response.
	 *
	 * @return string|void
	 */
	protected static function respond( $response, $status_code = null ) {
		if ( empty( $response ) ) {
			$status_code = 204;
		}

		if ( is_int( $response ) && $response > 1 ) {
			$response    = false;
			$status_code = $response;
		}

		wp_send_json( $response, $status_code );
	}
}
