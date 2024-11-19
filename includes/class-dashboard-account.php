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
            'icon'     => '<svg fill="#74C0FC" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9.6 3.32a3.86 3.86 0 1 0 3.86 3.85A3.85 3.85 0 0 0 9.6 3.32M16.35 11a.26.26 0 0 0-.25.21l-.18 1.27a4.63 4.63 0 0 0-.82.45l-1.2-.48a.3.3 0 0 0-.3.13l-1 1.66a.24.24 0 0 0 .06.31l1 .79a3.94 3.94 0 0 0 0 1l-1 .79a.23.23 0 0 0-.06.3l1 1.67c.06.13.19.13.3.13l1.2-.49a3.85 3.85 0 0 0 .82.46l.18 1.27a.24.24 0 0 0 .25.2h1.93a.24.24 0 0 0 .23-.2l.18-1.27a5 5 0 0 0 .81-.46l1.19.49c.12 0 .25 0 .32-.13l1-1.67a.23.23 0 0 0-.06-.3l-1-.79a4 4 0 0 0 0-.49 2.67 2.67 0 0 0 0-.48l1-.79a.25.25 0 0 0 .06-.31l-1-1.66c-.06-.13-.19-.13-.31-.13l-1.2.52a4.07 4.07 0 0 0-.82-.45l-.18-1.27a.23.23 0 0 0-.22-.21h-1.82M9.71 13C5.45 13 2 14.7 2 16.83v1.92h9.33a6.65 6.65 0 0 1 0-5.69A13.56 13.56 0 0 0 9.71 13m7.6 1.43a1.45 1.45 0 1 1 0 2.89 1.45 1.45 0 0 1 0-2.89Z"/></svg>',
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
