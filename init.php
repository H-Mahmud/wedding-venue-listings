<?php
defined('ABSPATH') || exit;

register_activation_hook(WVL_PLUGIN_FILE, 'wvl_plugin_activate');
function wvl_plugin_activate()
{
    wvl_create_venue_analytics_table();
}

/**
 * Creates the table for storing venue analytics
 *
 * This function creates the table if it does not already exist.
 *
 * @since 1.0.0
 */
function wvl_create_venue_analytics_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'venue_analytics';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            venue_id BIGINT(20) NOT NULL,
            event_type VARCHAR(50) NOT NULL,
            user_id BIGINT(20) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            INDEX (venue_id, event_type, created_at)
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
