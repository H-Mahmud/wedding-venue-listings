<?php
defined('ABSPATH') || exit;

register_activation_hook(WVL_PLUGIN_FILE, 'wvl_plugin_activate');
function wvl_plugin_activate()
{
    wvl_create_venue_analytics_table();
    wvl_create_venue_daily_analytics_table();
    wvl_create_contact_database_table();
    wvl_create_venue_bookings_database_table();
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

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            venue_id BIGINT(20) NOT NULL,
            event_type VARCHAR(50) NOT NULL,
            count BIGINT(20) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX (venue_id, event_type, created_at)
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Creates the table for storing venue daily analytics
 *
 * This function creates the table if it does not already exist.
 *
 * @since 1.0.0
 */
function wvl_create_venue_daily_analytics_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'venue_daily_analytics';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            venue_id BIGINT(20) NOT NULL,
            event_type VARCHAR(50) NOT NULL,
            ip_address VARCHAR(50) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX (venue_id, event_type, created_at)
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Creates the table for storing contact form data
 *
 * This function creates the table if it does not already exist.
 *
 * @since 1.0.0
 */
function wvl_create_contact_database_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT(20) UNSIGNED NOT NULL,
        venue_id BIGINT(20) UNSIGNED NOT NULL,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        city VARCHAR(255) NOT NULL,
        booking_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        submission_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        message TEXT NOT NULL,
        status VARCHAR(50) NOT NULL DEFAULT 'new',
        INDEX email_index (email),
        INDEX submission_date_index (submission_date)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}


function wvl_create_venue_bookings_database_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'venue_bookings';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    venue_id BIGINT UNSIGNED NOT NULL,
    location_name VARCHAR(255) NOT NULL,
    booked_date DATE NOT NULL,
    UNIQUE KEY venue_date (venue_id, booked_date),
    INDEX (booked_date)
) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
