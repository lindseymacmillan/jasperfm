<?php
/**
 * Plugin Name: JasperFM
 * Description: An advanced boilerplate for building React-enabled Wordpress plugins.
 * Version: 1.0.0
 * Author: Henry holtgeerts
 * Author URI: https://henryholtgeerts.com
 * License: GPL2
 * Text Domain: jasperfm
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || exit;

// Define JASPERFM_PLUGIN_FILE.
if ( ! defined( 'JASPERFM_PLUGIN_FILE' ) ) {
	define( 'JASPERFM_PLUGIN_FILE', __FILE__ );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jasperfm-activator.php
 */
function activate_jasperfm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jasperfm-activator.php';
	JasperFM_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jasperfm-deactivator.php
 */
function deactivate_jasperfm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jasperfm-deactivator.php';
	JasperFM_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jasperfm' );
register_deactivation_hook( __FILE__, 'deactivate_jasperfm' );

// Include the main JasperFM class.
if ( ! class_exists( 'JasperFM' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-jasperfm.php';
}
