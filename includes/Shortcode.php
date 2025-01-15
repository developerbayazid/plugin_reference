<?php

namespace WeDevs;

class Shortcode {
    public function __construct(){
        add_shortcode( 'foobar', array( $this, 'foobar_callback' ) );
        add_shortcode( 'columns', array( $this, 'columns' ) );
        add_shortcode( 'column', array( $this, 'column' ) );
    }

    public function foobar_callback( $atts ) {
        wp_enqueue_style( 'shortcode-css' );

        $args = shortcode_atts( [
            'title' => __( 'this is title', 'weDevs' ),
            'id'    => 0,
            'color' => __( 'red', 'weDevs' )
        ], $atts );

        if ( !$args['id'] ) {
            return 'Id is required';
        }
        ob_start();
        require WD_PLUGIN_DIR_PATH . 'includes/templates/foobar-shortcode.php';

        return ob_get_clean();
    }

    public function columns ( $atts, $content = '' ) {
        ob_start();
        echo '<div class="columns-wrapper">';
        echo do_shortcode( $content );
        echo '</div>';
        return ob_get_clean();
    }

    public function column ( $atts, $content = '' ) {
        wp_enqueue_style( 'shortcode-css' );
        ob_start();
        echo '<div class="column">';
        echo $content;
        echo '</div>';
        return ob_get_clean();
    }
}