<?php
defined('ABSPATH') || exit;
class WVL_Analytical_Data_Collection
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Analytical_Data_Collection
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
        add_action('wvl_vendor_contact_redirect_handle', array($this, 'collect_contact_redirect_data'));
    }

    /**
     * Collects contact click redirect data
     *
     * This function is invoked on the 'wvl_vendor_contact_redirect_handle' action hook.
     * It stores data in the analytics table with the key 'contact_click', the venue_id
     * as the post_id, and the user's current IP address.
     *
     * @return void
     */
    public function  collect_contact_redirect_data()
    {
        if (!isset($_GET['post_id']) || empty($_GET['post_id'])) return;
        WVL_Analytic_Data_Storage::insert_daily(intval(sanitize_text_field($_GET['post_id'])), 'contact_click', wvl_get_user_ip_address());
    }

    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Analytical_Data_Collection The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

WVL_Analytical_Data_Collection::get_instance();
