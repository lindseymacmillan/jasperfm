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
class Attachments {

	public function init() {
        add_action( 'wp_enqueue_media', [__CLASS__, 'modify_media_library'] );
    }
    
    public function modify_media_library() {
        add_action( 'admin_print_footer_scripts', [__CLASS__, 'override_two_column_template'], 11 );
        add_action( 'admin_print_footer_scripts', [__CLASS__, 'override_attachment_details_template'], 11 );
    }

    public function override_two_column_template() {
		include_once JASPERFM_ABSPATH . 'includes/attachments/two-column-template.php';
    }

    public function override_attachment_details_template() {
		include_once JASPERFM_ABSPATH . 'includes/attachments/attachment-details-template.php';
    }

}   
Attachments::init();
