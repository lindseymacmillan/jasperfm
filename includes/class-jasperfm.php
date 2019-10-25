<?php
/**
 * JasperFM setup
 *
 * @package JasperFM
 */

namespace JasperFM;

defined( 'ABSPATH' ) || exit;

/**
 * Main JasperFM Class.
 */
final class JasperFM {

	protected static $options = [];

	protected static $defaultOptions = [];

	/**
	 * The single instance of the class.
	 *
	 * @var JasperFM
	 */
	protected static $_instance = null;

	/**
	 * Main JasperFM Instance.
	 * Ensures only one instance of JasperFM is loaded or can be loaded.
	 *
	 * @return JasperFM - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * JasperFM Constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init();
		add_action( 'admin_menu', [ $this, 'remove_all_jasperfm_options' ], 1 );
	}

	/**
	 * Define JasperFM Constants.
	 */
	private function define_constants() {
		define( 'JASPERFM_VERSION', '0.0.1' );
		define( 'JASPERFM_ABSPATH', dirname( JASPERFM_PLUGIN_FILE ) . '/' );

		// Define path and URL to the ACF plugin.
		define( 'JASPERFM_ACF_PATH', dirname( JASPERFM_PLUGIN_FILE ) . '/includes/acf/' );
		define( 'JASPERFM_ACF_URL', plugins_url( '/', JASPERFM_PLUGIN_FILE ) . 'includes/acf/' );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 * e.g. include_once JASPERFM_ABSPATH . 'includes/foo.php';
	 */
	private function includes() {

		//Include utility functions
		include_once JASPERFM_ABSPATH . 'includes/util.php';

		//Include API classes
		include_once JASPERFM_ABSPATH . 'includes/api/distribution/class-distribution-api.php';
		include_once JASPERFM_ABSPATH . 'includes/api/player/class-player-api.php';

		//Register APIs
		include_once JASPERFM_ABSPATH . 'includes/api/class-apis.php';
		
		//Include screen classes
		include_once JASPERFM_ABSPATH . 'includes/screens/distribution/class-distribution-screen.php';
		
		//Register screens
		include_once JASPERFM_ABSPATH . 'includes/screens/class-screens.php';

		//Include ACF
		include_once JASPERFM_ACF_PATH . 'acf.php';

		//Modify attachments
		include_once JASPERFM_ABSPATH . 'includes/attachments/class-attachments.php';
	}

	/**
	 * Init JasperFM options and configuration
	 *
	 * @return string URL
	 */
	public function init() {
		$this->manage_site_options();
		//add_action( 'init', [$this, 'register_dashboard_taxonomy'], 0 );
		//add_action( 'init', [$this, 'register_post_types'], 0 );

		// Customize ACF url setting to fix incorrect asset URLs.
		add_filter('acf/settings/url', [__CLASS__, 'acf_settings_url']);
	}

	public function acf_settings_url( $url ) {
		return JASPERFM_ACF_URL;
	}

	protected function manage_site_options() {
		$jasperfmOptions = get_option( 'jasperfm-options', false );
        if ($jasperfmSettings == false) {
            self::$options = self::$defaultOptions;
            add_option('jasperfm-options', self::$options, false, 'yes');
        } else {
            self::$options = $jasperfmOptions;
        }
	}

	/**
	 * Get the URL for the JasperFM plugin directory.
	 *
	 * @return string URL
	 */
	public static function plugin_url() {
		return untrailingslashit( plugins_url( '/', JASPERFM_PLUGIN_FILE ) );
	}

	/**
	 * Reset JasperFM by removing all jasperfm prefixed options. Triggered by the query param reset_jasperfm_settings=1
	 */
	public function remove_all_jasperfm_options() {
		if ( filter_input( INPUT_GET, 'reset_jasperfm_settings', FILTER_SANITIZE_STRING ) === '1' ) {
			$all_options = wp_load_alloptions();
			foreach ( $all_options as $key => $value ) {
				if ( strpos( $key, 'jasperfm' ) === 0 || strpos( $key, '_jasperfm' ) === 0 ) {
					delete_option( $key );
				}
			}
		}
	}
}
JasperFM::instance();
