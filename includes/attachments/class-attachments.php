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
        self::includes();
        self::modify_attachments();
    }
    
    private function includes() {

		//Include ACF Fields
        //include_once JASPERFM_ACF_PATH . 'acf.php';
        
    }
    
    private function modify_attachments() {

        //add_filter( 'attachment_fields_to_edit', [__CLASS__, 'my_add_attachment_location_field'], 10, 2 );
        
        add_action( 'admin_enqueue_scripts', [__CLASS__, 'wpdocs_selectively_enqueue_admin_script'] );
    }

    function wpdocs_selectively_enqueue_admin_script( $hook ) {
        // if ( 'edit.php' != $hook ) {
        //     return;
        // }
        wp_enqueue_script( 'jasperfm-attachments', JasperFM::plugin_url() . '/assets/dist/attachments.bundle.js', array(), '1.0' );
    }
    
    function my_add_attachment_location_field( $form_fields, $post ) {
        //$field_value = get_post_meta( $post->ID, 'location', true );
        $mime_type = $post->post_mime_type;
        $form_fields["custom1"] = array(
            "label" => __("Custom Text Field"),
            "input" => "text", // this is default if "input" is omitted
            "value" => $mime_type
        );
        return $form_fields;
    }
}
Attachments::init();
