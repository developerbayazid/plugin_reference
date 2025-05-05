<?php

namespace WeDevs;

class Rewrite_Rules {
    
    public function __construct() {
        add_action( 'init', [$this, 'init'] );
        add_filter( 'template_include', [$this, 'template_include'] );
    }

    public function init() {

        add_rewrite_rule( 
            'bayazid',
            'index.php?page_id=2053',
            'top'
        );

        add_rewrite_rule( 
            'my_custom_url/([a-z0-9-]+)[/]?$',
            'index.php?my_custom_url=$matches[1]',
            'top'
        );

        add_rewrite_tag( '%my_custom_url%', '([^&]+)' );

    }

    public function template_include( $template ) {

        if( get_query_var( 'my_custom_url' ) === strtolower( 'my-account' ) ) {
            return WD_PLUGIN_DIR_PATH . 'includes/templates/my-account-page.php';
        }

        return $template;
    }

}