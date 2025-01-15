<?php

namespace WeDevs;

class Custom_Post {
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'manage_note_posts_columns', array( $this, 'post_column_callback' ) );
        add_action( 'manage_note_posts_custom_column', array( $this, 'post_custom_column_callback' ), 10, 2 );
        add_filter( 'manage_edit-note_sortable_columns', array( $this, 'post_column_sortable' ) );
    }

    public function init () {
        register_post_type( 'note', array(
            'labels'            => array(
                'name'          => __( 'Notes', 'weDevs' ),
                'singular_name' => __( 'Note', 'weDevs' ),
                'add_new_item'  => __( 'Add New Note', 'weDevs' ),
                'edit_item'     => __( 'Edit New Note', 'weDevs' ),
                'view_item'     => __( 'View New Note', 'weDevs' ),
                'search_items'  => __( 'Search Notes', 'weDevs' ),
            ),
            'public'             => true,
            'hierarchical'       => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            // 'show_in_rest'       => true,
            'capability_type'    => 'post',
            'supports'           => array( 'title', 'editor', 'page-attributes' ),
            'rewrite'            => array( 'slug' => 'we_cpt_book' ),
            'query_var'          => true,
            'has_archive'        => true,
        ) );

        register_taxonomy( 'note_category', 'note', array(
            'public'       => true,
            'hierarchical' => true,
            'rewrite'      => array( 'slug' => 'notes/category' ),
        ) );
    }

    public function post_column_callback( $column ) {
        
        $new_column = array();
        
        foreach ($column as $key => $value) {
            if ( 'date' == $key ) {
                $new_column['note_category'] = 'Categories';
            }
            $new_column[$key] = $value;
        }

        return $new_column;
    }
    public function post_custom_column_callback( $column, $post_id ) {
        if ( 'note_category' == $column ) {
            $cat = get_the_terms( $post_id, 'note_category' );
            $cat_item = array_map( function( $cat ) {
                return $cat->name;
            }, $cat );
            echo implode( ', ', $cat_item );
        }
    }

    public function post_column_sortable( $column ) {
        $column['note_category'] = 'category';
        return $column;
    }
}