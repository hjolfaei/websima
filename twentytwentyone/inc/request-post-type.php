<?php
function create_post_type_request()
{
    register_post_type('requests',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('Requests'),
                'singular_name' => __('Request')
            ), 'supports' => array(
            'title',
            'author',
            'custom-fields',
        ),
            'capabilities' => array(
                'create_posts' => false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
            ),
            'map_meta_cap' => true, // Set to `false`, if users are not allowed to edit/delete existing posts
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'requests'),
            'show_in_rest' => true,
            /*'taxonomies' => array( 'category' ),*/

        )
    );
}

// Hooking up our function to theme setup
add_action('init', 'create_post_type_request');