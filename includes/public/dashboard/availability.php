<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Availability
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Availability
     * @access private
     */
    private static $_instance = null;

    /**
     * Private constructor to prevent instantiation from outside of the class.
     * 
     * @access private
     * @final
     */
    private final function __construct()
    {
        add_action('wvl_dashboard', array($this, 'render_wvl_dashboard_menu'));
        add_action('wp_ajax_wvl_booked_dates', array($this, 'booked_dates_handle'));
        add_action('wp_ajax_nopriv_booked_dates', array($this, 'booked_dates_handle'));
        add_action('wp_ajax_wvl_add_new_booking', array($this, 'add_new_booking_handle'));
        add_action('wp_ajax_nopriv_wvl_add_new_booking', array($this, 'add_new_booking_handle'));
    }


    /**
     * Renders the Availability menu item in the Wedding Venue Listings dashboard menu.
     *
     * The Availability menu item displays the venue's availability, including
     * their calendar of events. This menu item is available to all venues, regardless
     * of whether they have a premium subscription or not.
     *
     * @return void
     */
    public function render_wvl_dashboard_menu()
    {

        add_wvl_menu([
            'name'     => __('Availability', 'wedding-venue-listings'),
            'slug'     => 'availability',
            'capability' => 'manage_venue',
            'icon'     => '<i class="fa-solid fa-calendar-days text-xl" style="color: #1f72b2;"></i>',
            'premium'  => false,
            'priority' => 50,
            'callback' => array($this, 'availability_page_cb'),
        ]);
    }

    /**
     * The callback function for the Availability menu item in the Wedding Venue Listings dashboard menu.
     *
     * This function simply requires the template file for the Availability page and does not do any
     * further processing.
     *
     * @return void
     */
    public function availability_page_cb()
    {
        require_once WVL_PLUGIN_DIR . 'includes/public/dashboard/parts/availability-page.php';
    }

    /**
     * Handles the AJAX request to get the booked dates for a venue.
     *
     * This function is called when the venue owner requests the booked dates
     * for their venue from the front-end. It uses the `wvl_get_booked_date`
     * function to get the booked dates and then encodes the array of booked
     * dates as JSON and outputs it to the browser. The function then dies
     * to prevent any further processing.
     *
     * @since 1.0
     */
    public function booked_dates_handle()
    {
        check_ajax_referer('dashboard_nonce', 'nonce');
        if (!current_user_can('manage_venue')) return;

        $start_date = sanitize_text_field($_GET['start_date']);
        $end_date = sanitize_text_field($_GET['end_date']);
        $venue_id = wvl_get_venue_id();

        $booked_dates = wvl_get_booked_date($venue_id, $start_date, $end_date);
        wp_send_json($booked_dates);
    }

    public function add_new_booking_handle()
    {
        check_ajax_referer('dashboard_nonce', 'nonce');
        if (!current_user_can('manage_venue')) return;

        $title = sanitize_text_field($_POST['title']) ?: 'Untitled';
        $date = sanitize_text_field($_POST['date']) ?: wp_send_json_error(['message' => 'Date not set']);
        $location = sanitize_text_field($_POST['location']) ?: '';
        $venue_id = wvl_get_venue_id();

        if (wvl_insert_booking_date($venue_id, date('Y-m-d', strtotime($date)), $title, $location)) {
            wp_send_json(['title' => $title, 'location' => $location, 'date' => $date]);
        }
    }

    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Availability The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Dashboard_Availability::get_instance();
