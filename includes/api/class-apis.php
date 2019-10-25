<?php
/**
 * JasperFM Screens manager.
 *
 * @package JasperFM
 */

namespace JasperFM;

defined( 'ABSPATH' ) || exit;

/**
 * Manages the settings.
 */
class APIs {

	/**
	 * Information about all of the APIs.
	 * See `init` for structure of the data.
	 *
	 * @var array
	 */
	protected static $apis = [];

	/**
	 * Initialize and register all of the screens.
	 */
	public static function init() {
		static::$apis = [
			'distribution' => new Distribution_API(),
			'player' => new Player_API(),
		];

		add_action( 'rest_api_init', [__CLASS__, 'register_rest_routes'] );

	}

    /**
	 * Register all rest API routes
	 */
	public static function register_rest_routes() {
		foreach (static::$apis as $api) {
			$api->register_rest_route();
		}
    }

}
APIs::init();