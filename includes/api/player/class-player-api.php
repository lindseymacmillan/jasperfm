<?php
/**
 * JasperFM Quick Cards API
 *
 * @package JasperFM
 */

namespace JasperFM;

defined( 'ABSPATH' ) || exit;

require_once JASPERFM_ABSPATH . '/includes/api/class-api.php';

/**
 * Functionality and actions specific to the quick cards API
 */
class Player_API extends API {

	/**
	 * The route of the API
	 *
	 * @var string
	 */
    protected static $route = 'player';

    // API Actions 
    // denoted by 'action_' prefix followed by type

    public function action_query($data) {
        return 'oof did it work?';
    }

	
}
