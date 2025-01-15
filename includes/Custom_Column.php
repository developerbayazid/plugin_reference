<?php

namespace WeDevs;

class Custom_Column {
    public function __construct() {
        add_filter( 'manage_post_posts_columns', array( $this, 'post_columns_callback' ) );
        add_action( 'manage_post_posts_custom_column', array( $this, 'post_custom_data_callback' ), 10, 2 );
        add_filter( 'manage_edit-post_sortable_columns', array( $this, 'post_column_sortable_callback' ) );
        add_filter( 'manage_course_contents_posts_columns', array( $this, 'course_content_columns_callback' ) );
        add_action( 'manage_course_contents_posts_custom_column', array( $this, 'course_contents_custom_data_callback' ), 10, 2 );
        add_filter( 'manage_edit-course_contents_sortable_columns', array( $this, 'course_content_column_sortable_callback' ) );
    }

    public function post_columns_callback( $columns ) {
        $new_columns = array();

        foreach ($columns as $key => $column) {
            if ( 'cb' == $key ) {
                $new_columns['id'] = 'ID';
            }
            $new_columns[$key] = $column;

            if ( 'title' == $key ) {
                $new_columns['tags'] = $column;
            }
        }


        return $new_columns;
    }

    public function course_content_columns_callback( $columns ) {
        $new_columns = array();

        foreach ($columns as $key => $column) {

            $new_columns[$key] = $column;

            if ( 'title' == $key ) {
                $new_columns['course'] = 'Course';
            }
        }

        return $new_columns;
    }

    public function post_custom_data_callback( $column, $post_id ) {
        if ( 'id' == $column ) {
            echo $post_id;
        }
    }

    public function course_contents_custom_data_callback( $column, $post_id ) {
        if ( 'course' == $column ) {
            $course_id = get_post_meta( $post_id, '_course_id', true );
            $post = get_post( $course_id );
            echo $post->post_title;
        }
    }

    public function post_column_sortable_callback( $column ) {
        $column['id'] = 'id';
        return $column;
    }

    public function course_content_column_sortable_callback( $column ) {
        $column['course'] = 'course';

        return $column;
    }
}
