<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Analytics
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Analytics
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
        add_action('wvl_menu_badge', array($this, 'add_premium_badge'));
    }

    /**
     * Renders the Analytics menu item in the Wedding Venue Listings dashboard menu.
     *
     * The Analytics menu item is available to venues with a premium subscription
     * and displays the analytics of the venue. It includes an icon and is set with
     * a priority of 60.
     *
     * @return void
     */
    public function render_wvl_dashboard_menu()
    {

        add_wvl_menu([
            'name'     => 'Analytics',
            'slug'     => 'analytics',
            'capability' => 'manage_venue',
            'icon'     => '<i class="fa-solid fa-chart-simple text-xl" style="color: #1f72b2;"></i>',
            'premium'  => true,
            'priority' => 60,
            'callback' => array($this, 'analytics_page_cb'),

        ]);
    }




    /**
     * Callback function for the Analytics menu item in the Wedding Venue Listings dashboard menu.
     *
     * Requires the analytics.php template file in the template-parts/dashboard directory.
     *
     * @return void
     */
    public function analytics_page_cb()
    {
        require_once WVL_PLUGIN_DIR . '/includes/public/dashboard/parts/analytics-page.php';
    }


    public function add_premium_badge($slug)
    {
        if ($slug == 'analytics') {
            echo '<span class="inline-block ml-2 bg-amber-100 text-amber-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">' . __('Premium', 'wedding-venue-listings') . '</span>';
        }
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Analytics The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Dashboard_Analytics::get_instance();
