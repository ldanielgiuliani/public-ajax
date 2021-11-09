<?php
/**
 * Route class.
 *
 * @package Dan\PublicAjax
 */

namespace Dan\PublicAjax;

/**
 * Dispatch and respond to requests to internal API
 */
class Route {
	/**
	 * Holds the instance of this class.
	 *
	 * @var    object
	 */
	private static $instance;

	/**
	 * Returns an instance of this class.
	 *
	 * @return Route|object
	 */
	public static function init() {

		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Main router for internal API.
	 *
	 * Checks permission, and dispatches and returns, or returns error.
	 *
	 * @todo: optimisation and transients?
	 */
	public static function do_api() {
		global $wp_query;

		$action = $wp_query->get( 'action' );

		if ( $action && strpos( $_SERVER['REQUEST_URI'], 'public-ajax' ) ) {
			$action_class = self::action_class( $action );

			if ( $action_class ) {
				$params = self::get_args( $action_class::args(), $action_class::method() );
				$nonce  = $params['nonce'] ?? '';

				if ( Auth::check( $nonce ) && is_array( $params ) ) {
					return self::respond( $action_class::act( $params ), 200 );
				} else {
					return self::respond( false, 401 );
				}
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
		$namespace = __NAMESPACE__ . '\\Actions\\';
		$class     = $namespace . $action;

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
		foreach ( $input as $key => $val ) {
			if ( in_array( $key, $accept_args, true ) ) {
				$output[ $key ] = sanitize_text_field( $val );
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

		if ( ! is_null( $status_code ) ) {
			$status_code = 200;
		}

		wp_send_json( $response, $status_code );
	}
}
