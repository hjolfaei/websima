<?php
function custom_confirmed_post_status()
{
    register_post_status('confirmed', array(
        'label' => _x('Confirmed', 'requests'),
        'public' => false,
        'post_type' => array('requests'),
        'exclude_from_search' => true,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'show_in_inline_dropdown' => true,
        'show_in_metabox_dropdown' => true,
        'label_count' => _n_noop('Confirmed <span class="count">(%s)</span>', 'Confirmed <span class="count">(%s)</span>'),

    ));
}

add_action('init', 'custom_confirmed_post_status');


function custom_rejected_post_status()
{
    register_post_status('rejected', array(
        'label' => _x('Rejected', 'requests'),
        'public' => false,
        'post_type' => array('requests'),
        'exclude_from_search' => true,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'show_in_inline_dropdown' => true,
        'show_in_metabox_dropdown' => true,
        'label_count' => _n_noop('Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>'),
    ));
}

add_action('init', 'custom_rejected_post_status');

add_action('admin_footer-post.php', 'jc_append_post_status_list');
function jc_append_post_status_list()
{
    global $post;
    $complete = '';
    $label = '';
    if ($post->post_type == 'requests') {
        if ($post->post_status == 'confirmed') {
            $complete = ' selected=\"selected\"';
            $label = '<span id=\"post-status-display\"> Confirmed</span>';
        }
        if ($post->post_status == 'rejected') {
            $complete = ' selected=\"selected\"';
            $label = '<span id=\"post-status-display\"> Rejected</span>';
        }
        echo '
      <script>
      jQuery(document).ready(function($){
           $("select#post_status").append("<option value=\"confirmed\" ' . $complete . '>Confirmed</option>");
           $(".misc-pub-section label").append("' . $label . '");
           $("select#post_status").append("<option value=\"rejected\" ' . $complete . '>Rejected</option>");
           $(".misc-pub-section label").append("' . $label . '");
      });
      </script>
      ';
    }

}

add_filter('display_post_states', function ($statuses) {
    global $post;

    if ($post->post_type == 'requests') {
        if ($post->post_status == 'rejected') {
            return array('Rejected');
        }
        if ($post->post_status == 'confirmed') {
            return array('Confirmed');
        }
    }
    return $statuses;
});