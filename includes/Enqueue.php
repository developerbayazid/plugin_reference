<?php

namespace WeDevs;

class Enqueue {
    public function __construct(){
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
    }

    public function admin_enqueue_scripts( $screen ) {

        $pages = array( 'options-writing.php', 'options-general.php' );

        if ( in_array( $screen, $pages ) ) {
            $main_path = WD_PLUGIN_DIR_PATH . 'assets/admin/js/main.js';
            wp_enqueue_script( 'weDevs-admin-main-js', WD_PLUGIN_URL . 'assets/admin/js/main.js', array(), filemtime( $main_path ), array( 'in_footer' => true ) );

            $main_css_path = WD_PLUGIN_DIR_PATH . 'assets/admin/css/main.css';
            wp_enqueue_style( 'weDevs-admin-main-css', WD_PLUGIN_URL . 'assets/admin/css/main.css', array(), filemtime( $main_css_path ) );
        }
    }

    public function wp_enqueue_scripts() {
        $shortcode_path = WD_PLUGIN_DIR_PATH . 'assets/frontend/shortcode/shortcode.css';
        wp_register_style( 'shortcode-css', WD_PLUGIN_URL . 'assets/frontend/shortcode/shortcode.css', array(), filemtime( $shortcode_path ) );
    }
}