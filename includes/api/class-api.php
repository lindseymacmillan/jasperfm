<?php
/**
 * Common functionality for admin screens.
 *
 * @package JasperFM
 */

namespace JasperFM;

defined( 'ABSPATH' ) || exit;

/**
 * Common functionality for admin screens. Override this class.
 */
abstract class API {

	/**
	 * The slug of this screen. Override this.
	 *
	 * @var string
	 */
    protected static $route = '';
    
    /**
	 * The slug of this screen. Override this.
	 *
	 * @var array
	 */
    protected static $actions = [];

	/**
	 * Initialize.
	 */
	public function __construct() {
		self::$actions = $this->get_api_actions();
    }
    
    protected function get_api_actions() {

        $methods = get_class_methods($this);
        $actions = [];

        foreach($methods as $method) {
            if (strpos($method, 'action_') !== false) {
                $action = substr($method, 7);
                $actions[$action] = $method;
            }
        }

        return $actions;

    }

	public function register_rest_route () {
        register_rest_route( 'jasperfm/v1', '/' . static::$route , [
            'methods' => \WP_REST_Server::EDITABLE,
            'callback' => [$this, 'handle_route'],
        ]);
    }

    public function handle_route (\WP_REST_Request $data) {

        $method = self::$actions[$data['action']];
        $return = $this->$method($data['payload']);

        $response = [
            'action' => $data['action'],
            'payload' => $data['payload'],
            'return' => $return
        ];

        return $response;
    }

}
