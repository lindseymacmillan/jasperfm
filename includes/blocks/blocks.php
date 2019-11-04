<?php
 
//Include Dynamic Block
include_once JASPERFM_ABSPATH . '/includes/blocks/dynamic-block/block.php';

//Include Audio Block
include_once JASPERFM_ABSPATH . '/includes/blocks/audio-block/block.php';

function register_editor_script() {
    wp_register_script(
        'jfm-editor-scripts',
        plugins_url( '/', JASPERFM_PLUGIN_FILE ) . 'assets/js/dist/editor.bundle.js',        
        array( 'wp-blocks', 'wp-element', 'wp-data', 'wp-dom-ready', 'wp-edit-post' )
    );
}

add_action( 'init', 'register_editor_script' );
 