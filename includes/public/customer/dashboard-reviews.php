<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Reviews
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Reviews
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
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Reviews The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function render_wvl_dashboard_menu()
    {

        add_wvl_menu([
            'name'     => 'Reviews',
            'slug'     => 'reviews',
            'capability' => 'manage_venue',
            'icon'     => '<i class="fa-solid fa-star-half-stroke text-xl" style="color: #1f72b2;"></i>',
            'premium'  => false,
            'priority' => 30,
            'callback' => array($this, 'reviews_page_cb'),
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
    public function reviews_page_cb()
    {
        require_once WVL_PLUGIN_DIR . '/includes/public/customer/parts/reviews-page.php';
    }
}
WVL_Dashboard_Reviews::get_instance();
