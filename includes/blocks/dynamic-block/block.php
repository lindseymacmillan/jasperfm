<?php 

function gutenberg_examples_05_dynamic_render_callback( $attributes, $content ) {
    $recent_posts = wp_get_recent_posts( array(
        'numberposts' => 1,
        'post_status' => 'publish',
    ) );
    if ( count( $recent_posts ) === 0 ) {
        return 'No posts';
    }
    $post = $recent_posts[ 0 ];
    $post_id = $post['ID'];
    return sprintf(
        '<a class="wp-block-my-plugin-latest-post" href="%1$s">%2$s</a>',
        esc_url( get_permalink( $post_id ) ),
        esc_html( get_the_title( $post_id ) )
    );
}
 
function gutenberg_examples_05_dynamic() {
    register_block_type( 'gutenberg-examples/example-05-dynamic', array(
        'editor_script' => 'jfm-editor-scripts',
        'render_callback' => 'gutenberg_examples_05_dynamic_render_callback'
    ) );
 
}

add_action( 'init', 'gutenberg_examples_05_dynamic' );