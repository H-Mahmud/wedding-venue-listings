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
