<?php
/**
 * JasperFM dashboard.
 *
 * @package JasperFM
 */

namespace JasperFM;

defined( 'ABSPATH' ) || exit;

require_once JASPERFM_ABSPATH . '/includes/screens/class-screen.php';

/**
 * Common functionality for admin screens. Override this class.
 */
class Distribution_Screen extends Screen {

	/**
	 * The slug of this screen.
	 *
	 * @var string
	 */
	protected $slug = 'jasperfm_distribution';

	/**
	 * The capability required to access this.
	 *
	 * @var string
	 */
	protected $capability = 'manage_options';

	/**
	 * Priority setting for ordering admin submenu items. Dashboard must come first.
	 *
	 * @var int.
	 */
	protected $menu_priority = 1;

	/**
	 * Initialize.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_page' ], 1 );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts_and_styles' ] );
	}

	/**
	 * Get the name for this screen.
	 *
	 * @return string The screen name.
	 */
	public function get_name() {
		return esc_html__( 'Distribution', 'jasperfm' );
	}

	/**
	 * Get the description of this screen.
	 *
	 * @return string The screen description.
	 */
	public function get_description() {
		return esc_html__( 'JasperFM Distribution Options', 'jasperfm' );
	}

	/**
	 * Load up JS/CSS.
	 */
	public function enqueue_scripts_and_styles() {
		parent::enqueue_scripts_and_styles();

		if ( filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING ) !== $this->slug ) {
			return;
		}

		wp_register_script(
			'jasperfm-distribution',
			JasperFM::plugin_url() . '/assets/dist/distribution.bundle.js',
			$this->get_script_dependencies(),
			filemtime( dirname( JASPERFM_PLUGIN_FILE ) . '/assets/dist/distribution.bundle.js' ),
			true
		);
		//wp_localize_script( 'jasperfm-dashboard', 'jasperfm_dashboard', $this->get_dashboard() );
		wp_enqueue_script( 'jasperfm-distribution' );

		// This script is just used for making jasperfm data available in JS vars.
		// It should not actually load a JS file.
		wp_register_script( 'jasperfm_data', '', [], '1.0', false );

		$data = ['testing'];

		$jasperfmSettings = get_option( 'jasperfm-options', false );
		if ($jasperfmSettings != false) {
			$data['options'] = $jasperfmSettings;
		}

		wp_localize_script( 'jasperfm_data', 'jasperfm_data', $data );
		wp_enqueue_script( 'jasperfm_data' );

		wp_register_style(
			'jasperfm-styles',
			'',
			$this->get_style_dependencies(),
			''
		);
		wp_enqueue_style( 'jasperfm-styles' );
	}
}
