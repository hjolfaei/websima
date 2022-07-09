<?php
/**
 * Removes the "Trash" link on the individual post's "actions" row on the posts
 * edit page.
 */
add_filter( 'post_row_actions', 'remove_row_actions_post', 10, 2 );
function remove_row_actions_post( $actions, $post ) {
    if( $post->post_type === 'requests' ) {
        unset( $actions['clone'] );
        unset( $actions['trash'] );
    }
    return $actions;
}

add_action('wp_trash_post', 'restrict_post_deletion');
function restrict_post_deletion($post_id) {
    if( get_post_type($post_id) === 'requests' ) {
        wp_die('The post you were trying to delete is protected.');
    }
}

/**
 * Removes the "Delete" link on the individual term's "actions" row on the terms
 * edit page.
 */
add_filter( 'tag_row_actions', 'remove_row_actions_term', 10, 2 );
function remove_row_actions_term( $actions, $term ) {
    if ( 'types' === $term->taxonomy ) {
        unset( $actions['delete'] );
    }
    return $actions;
}

add_action( 'pre_delete_term', 'restrict_taxonomy_deletion', 10, 2 );
function restrict_taxonomy_deletion( $term, $taxonomy ) {
    if ( 'types' === $taxonomy ) {
        wp_die( 'The taxonomy you were trying to delete is protected.' );
    }
}

add_action( 'admin_head', function () {
    $current_screen = get_current_screen();

    // Hides the "Move to Trash" link on the post edit page.
    if ( 'post' === $current_screen->base &&
        'requests' === $current_screen->post_type ) :
        ?>
        <style>#delete-action { display: none; }</style>
    <?php
    endif;

    // Hides the "Delete" link on the term edit page.
    if ( 'term' === $current_screen->base &&
        'types' === $current_screen->taxonomy ) :
        ?>
        <style>#delete-link { display: none; }</style>
    <?php
    endif;
} );