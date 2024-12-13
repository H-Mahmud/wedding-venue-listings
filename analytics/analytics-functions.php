<?php
defined('ABSPATH') || exit;


/**
 * Insert an analytics entry into the database
 *
 * @param int $venue_id The post ID of the venue
 * @param string $event_type The type of event to log, one of impression, view, unique_view, contact_click, lead
 * @param int $count The number of times the event has occurred
 *
 * @return void
 */
function wvl_insert_analytics($venue_id, $event_type = 'impression', $count = 0)
{
    $event_types = ['impression', 'view', 'unique_view', 'contact_click', 'lead'];
    if (!in_array($event_type, $event_types)) {
        return;
    }
    global $wpdb;
    $table_name = $wpdb->prefix . 'venue_analytics';
    $wpdb->insert($table_name, array(
        'venue_id' => $venue_id,
        'event_type' => 'view',
        'count' => 1
    ));
}
