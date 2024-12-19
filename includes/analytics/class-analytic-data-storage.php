<?php
defined('ABSPATH') || exit;
/**
 * WVL_Analytic_Data_Storage class
 */
class WVL_Analytic_Data_Storage
{
    /**
     * Inserts a daily analytics entry into the database.
     *
     * @param int $venue_id The post ID of the venue.
     * @param string $event_type The type of event to log.
     * @param string $ip_address The IP address of the user.
     *
     * @return void
     */
    public static function insert_daily($venue_id, $event_type, $ip_address)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'venue_daily_analytics';
        $wpdb->insert($table_name, array(
            'venue_id' => $venue_id,
            'event_type' => $event_type,
            'ip_address' => $ip_address
        ));
    }

    /**
     * Inserts an analytics entry into the database
     *
     * @param int $venue_id The post ID of the venue
     * @param string $event_type The type of event to log, one of impression, view, unique_view, contact_click, lead
     * @param int $count The number of times the event has occurred
     *
     * @return void
     */
    public static function insert($venue_id, $event_type, $count = 0)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'venue_analytics';
        $wpdb->insert($table_name, array(
            'venue_id' => $venue_id,
            'event_type' => $event_type,
            'count' => $count
        ));
    }

    /**
     * Retrieves the total count of analytics entries for a given venue ID and event type between a given date range.
     *
     * @param int $venue_id The post ID of the venue
     * @param string $event_type The type of event to log, one of impression, view, unique_view, contact_click, lead
     * @param string $start_date The start date of the range in Y-m-d format
     * @param string $end_date The end date of the range in Y-m-d format
     *
     * @return int The total count of analytics entries
     */
    public static function get_count_by($venue_id, $event_type, $start_date, $end_date)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'venue_analytics';
        $result =  $wpdb->get_var($wpdb->prepare("SELECT SUM(count) FROM $table_name WHERE venue_id = %d AND event_type = %s AND created_at BETWEEN %s AND %s", $venue_id, $event_type, $start_date, $end_date));

        return $result ? $result : 0;
    }

    public static function get_data_by_date($venue_id, $event_type, $date)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'venue_analytics';

        $result =  $wpdb->get_var($wpdb->prepare(
            "SELECT count
             FROM $table_name
             WHERE venue_id = %d AND event_type = %s AND DATE(created_at) = %s ",
            $venue_id,
            $event_type,
            $date
        ));
        return $result ? $result : 0;
    }


    /**
     * Retrieves the count of daily analytics entries for a given venue ID and event type
     *
     * @param int $venue_id The post ID of the venue
     * @param string $event_type The type of event to log, one of impression, view, unique_view, contact_click, lead
     *
     * @return int The count of daily analytics entries
     */
    public static function get_daily_data_count($venue_id, $event_type)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'venue_daily_analytics';
        return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE venue_id = %d AND event_type = %s", $venue_id, $event_type));
    }


    /**
     * Retrieves the count of unique daily analytics entries for a given venue ID and event type.
     *
     * This function counts the distinct IP addresses associated with the specified
     * venue ID and event type, providing a measure of unique interactions.
     *
     * @param int $venue_id The post ID of the venue.
     * @param string $event_type The type of event to log, one of impression, view, unique_view, contact_click, lead.
     *
     * @return int The count of unique daily analytics entries.
     */

    public static function get_daily_data_unique_count($venue_id, $event_type)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'venue_daily_analytics';
        return $wpdb->get_var($wpdb->prepare("SELECT COUNT(DISTINCT ip_address) FROM $table_name WHERE venue_id = %d AND event_type = %s", $venue_id, $event_type));
    }

    /**
     * Deletes daily analytics entries for a given venue ID and event type.
     *
     * @param int $venue_id The post ID of the venue.
     * @param string $event_type The type of event to log, one of impression, view, unique_view, contact_click, lead.
     *
     * @return void
     */
    public static function delete_daily_data($venue_id, $event_type)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'venue_daily_analytics';
        $wpdb->delete($table_name, array('venue_id' => $venue_id, 'event_type' => $event_type));
    }
}
