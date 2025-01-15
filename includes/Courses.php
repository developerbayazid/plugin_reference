<?php

namespace WeDevs;

class Courses {
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
        add_filter( 'the_content', array( $this, 'course_the_content' ) );
        add_filter( 'the_content', array( $this, 'course_topic_content' ) );
        $this->codestar_init();
    }

    public function init() {
        register_post_type( 'courses', array(
            'labels'            => array(
                'name'          => __( 'Courses', 'weDevs' ),
                'singular_name' => __( 'Course', 'weDevs' ),
                'add_new_item'  => __( 'Add New Course', 'weDevs' ),
                'edit_item'     => __( 'Edit New Course', 'weDevs' ),
                'view_item'     => __( 'View New Course', 'weDevs' ),
                'search_items'  => __( 'Search Courses', 'weDevs' ),
            ),
            'public'             => true,
            'hierarchical'       => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'capability_type'    => 'post',
            'supports'           => array( 'title', 'editor' ),
            'query_var'          => true,
            'has_archive'        => true,
        ) );

        register_post_type( 'course_contents', array(
            'labels'            => array(
                'name'          => __( 'Course Contents', 'weDevs' ),
                'singular_name' => __( 'Course Content', 'weDevs' ),
                'add_new_item'  => __( 'Add New Course Content', 'weDevs' ),
                'edit_item'     => __( 'Edit New Course Content', 'weDevs' ),
                'view_item'     => __( 'View New Course Content', 'weDevs' ),
                'search_items'  => __( 'Search Courses Content', 'weDevs' ),
            ),
            'public'             => true,
            'hierarchical'       => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'capability_type'    => 'post',
            'supports'           => array( 'title', 'editor' ),
            'query_var'          => true,
            'has_archive'        => true,
        ) );
    }

    public function codestar_init() {
        // Control core classes for avoid errors
        if( class_exists( 'CSF' ) ) {

            //
            // Set a unique slug-like ID
            $prefix = 'courses_metabox';

            $courses_query = get_posts( array(
                'post_type'      => 'courses',
                'posts_per_page' => -1,
            ) );
            $course_options = array();

            foreach ($courses_query as $course) {
                $course_options[$course->ID] = $course->post_title;
            }
        
            //
            // Create a metabox
            \CSF::createMetabox( $prefix, array(
                'title'     => 'Select Course',
                'post_type' => 'course_contents',
                'data_type' => 'unserialize'
            ) );
            //
            // Create a section
            \CSF::createSection( $prefix, array(
                'title'  => 'Course List',
                'fields' => array(
            
                    array(
                        'id'          => '_course_id',
                        'type'        => 'select',
                        'title'       => 'Select with courses',
                        'placeholder' => 'Select a course',
                        'options'     => $course_options,
                    ),
                )
            ) );

        }
  
    }

    public function course_the_content( $contents ) {
        
        global $post;

        if ( $post->post_type !== 'courses' ) {
            return $contents;
        }

        $course_topic = get_posts( array(
            'post_type'      => 'course_contents',
            'posts_per_page' => -1,
            'meta_key'       => '_course_id',
            'meta_value'     => $post->ID,
        ) );

        ob_start();
        ?>
        <ul>
            <?php foreach( $course_topic as $course ): ?>
                <li>
                    <a href="<?php the_permalink( $course->ID ); ?>"><?php echo $course->post_title; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        $contents .= ob_get_clean();

        return $contents;
    }

    public function course_topic_content( $contents ) {

        global $post;

        if ( $post->post_type !== 'course_contents' ) {
            return $contents;
        }

        $course_id = get_post_meta( $post->ID, '_course_id', true );

        $course = get_post( $course_id );

        $contents .= '<p>Course Name: <a href="'.get_the_permalink( $course ).'">'.$course->post_title.'</a></p>';

        return $contents;
    }
}