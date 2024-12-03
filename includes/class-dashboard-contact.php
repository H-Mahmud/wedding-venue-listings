<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Contact
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Contact
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
     * Renders the Contact Info menu item in the Wedding Venue Listings dashboard menu.
     *
     * The Contact Info menu item displays the venue's contact information, including
     * their email address and phone number. This menu item is only available to
     * venues with a premium subscription.
     *
     * @return void
     */
    public function render_wvl_dashboard_menu()
    {
        add_wvl_menu([
            'name'     => 'Contact Info',
            'slug'     => 'contact-info',
            'capability' => 'manage_venue',
            'icon'     => '<i class="fa-solid fa-address-card text-xl" style="color: #1f72b2;"></i>',
            'premium'  => true,
            'priority' => 30,
            'callback' => array($this, 'contact_info_page_cb'),
        ]);
    }



    /**
     * Callback function for the Contact Info menu item in the Wedding Venue Listings dashboard menu.
     *
     * Requires the contact-info.php template file in the template-parts/dashboard directory.
     *
     * @return void
     */
    public function contact_info_page_cb()
    {
        require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/contact-info.php';
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Contact The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Dashboard_Contact::get_instance();
