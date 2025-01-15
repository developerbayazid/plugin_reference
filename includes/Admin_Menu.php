<?php

namespace WeDevs;

class Admin_Menu {
    public function __construct(){
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function admin_menu() {
        add_menu_page( __( 'Query Post', 'weDevs' ), __( 'Query Post', 'weDevs' ), 'administrator', 'wd_query_post', array( $this, 'admin_menu_callback' ), 'dashicons-admin-tools', 20 );
    }

    public function admin_menu_callback() {

        $terms = get_terms( array( 'taxonomy' => 'category' ) );

        $filter_cat = isset( $_GET['filter_cat'] ) ? $_GET['filter_cat'] : 0;

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 10,
        );

        if ( ! empty( $filter_cat ) ) {
            $args['cat'] = $filter_cat;
        }

        $posts = get_posts( $args );

        include WD_PLUGIN_DIR_PATH . 'includes/templates/query-post.php';
    }
}