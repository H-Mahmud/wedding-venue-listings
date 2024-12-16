<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Contacts
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Contacts
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
        add_action('wvl_menu_badge', array($this, 'add_new_contact_count_badge'));
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Contacts The singleton instance.
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
            'name'     => 'Contacts',
            'slug'     => 'contacts',
            'capability' => 'manage_account',
            'icon'     => '<i class="fa-solid fa-address-card text-xl" style="color: #1f72b2;"></i>',
            'premium'  => false,
            'priority' => 30,
            'callback' => array($this, 'contacts_page_cb'),
        ]);
    }


    /**
     * The callback function for the Contacts menu item in the Wedding Venue Listings dashboard menu.
     *
     * This function simply requires the template file for the Contacts page and does not do any
     * further processing.
     *
     * @return void
     */
    public function contacts_page_cb()
    {
        require_once WVL_PLUGIN_DIR . '/includes/public/customer/parts/contacts-page.php';
    }


    /**
     * Adds a badge to the Contacts menu item in the Wedding Venue Listings dashboard menu if there are any new contacts.
     *
     * @param string $slug The slug of the current menu item.
     * 
     * @return void
     */
    public function add_new_contact_count_badge($slug)
    {
        if ($slug == 'contacts') {
            $count = wvl_get_contact_count();
            echo '<span class="inline-block ml-2 bg-amber-100 text-amber-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">' . $count . '</span>';
        }
    }
}
WVL_Dashboard_Contacts::get_instance();
