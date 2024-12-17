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
        add_action('wp_ajax_wvl_collections', array($this, 'collect_view_impression_data'));
        add_action('wp_ajax_nopriv_wvl_collections', array($this, 'collect_view_impression_data'));

        add_action('wvl_vendor_contact_redirect_handle', array($this, 'collect_contact_redirect_data'));
    }


    /**
     * Collects view and impression data from the front-end.
     *
     * This function is triggered via an AJAX request and verifies the request
     * using a nonce. It processes the incoming data to extract venue lists, 
     * each encoded as a base64 string containing JSON objects of post IDs. 
     * 
     * For each post ID in the venue lists:
     *   - 'DATA_1' category is treated as 'impression' data.
     *   - 'DATA_2' category is treated as 'view' data.
     * 
     * The function inserts a daily analytics entry for each post ID using the
     * WVL_Analytic_Data_Storage::insert_daily method, along with the user's 
     * current IP address.
     *
     * @return void
     */
    public function collect_view_impression_data()
    {
        check_ajax_referer('wvl_analytics_nonce', 'nonce');
        if (!isset($_POST['data'])) return;

        if (isset($_POST['data']['DATA_1'])) {
            $data_1 = $_POST['data']['DATA_1'];
            foreach ($data_1 as $venue_list) {
                $venue_items = json_decode(base64_decode($venue_list));
                foreach ($venue_items as $id) {
                    WVL_Analytic_Data_Storage::insert_daily($id, 'impression', wvl_get_user_ip_address());
                }
            }
        }

        if (isset($_POST['data']['DATA_2'])) {
            $data_1 = $_POST['data']['DATA_2'];
            foreach ($data_1 as $venue_list) {
                $venue_items = json_decode(base64_decode($venue_list));
                foreach ($venue_items as $id) {
                    WVL_Analytic_Data_Storage::insert_daily($id, 'view', wvl_get_user_ip_address());
                }
            }
        }
        die();
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
