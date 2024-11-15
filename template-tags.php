<?php
defined('ABSPATH') || exit();

function wvl_get_venue_id()
{
    $current_user_id = get_current_user_id();
    $args = [
        'post_type'      => 'venue',
        'author'         => $current_user_id,
        'post_status'    => 'any',
        'numberposts'    => 1,
        'fields'         => 'ids'
    ];

    $post_ids = get_posts($args);
    if (count($post_ids))
        return $post_ids[0];

    return false;
}
