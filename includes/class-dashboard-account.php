<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Account
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Account
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
     * Renders the Account menu item in the Wedding Venue Listings dashboard menu.
     *
     * The Account menu item displays the venue's account information, including their name, email address, and profile picture.
     *
     * @return void
     */
    public function render_wvl_dashboard_menu()
    {
        add_wvl_menu([
            'name'     => 'Account',
            'slug'     => 'account',
            'icon'     => '<i class="fa-solid fa-circle-info text-xl" style="color: #1f72b2;"></i>',
            'priority' => 80,
            'callback' => array($this, 'account_page_cb'),
        ]);
    }



    /**
     * Callback function for the Account menu item in the Wedding Venue Listings dashboard menu.
     *
     * Requires the account.php template file in the template-parts/dashboard directory.
     *
     * @return void
     */
    public function account_page_cb()
    {
        require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/account.php';
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Account The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Dashboard_Account::get_instance();
