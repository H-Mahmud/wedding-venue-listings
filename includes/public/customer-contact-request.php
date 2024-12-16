<?php
defined('ABSPATH') || exit;

/**
 * Class WVL_Customer_Contact_Request
 */
class WVL_Customer_Contact_Request
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Customer_Contact_Request
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
        add_action('wvl_single_venue_after', array($this, 'contact_form'));
        add_action('init', array($this, 'contact_submit'));
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Customer_Contact_Request The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    /**
     * Prints the contact form HTML.
     *
     * @since 1.0.0
     */
    public function contact_form()
    {
        require_once WVL_PLUGIN_DIR . '/includes/public/parts/contact-form.php';
    }

    public function contact_submit()
    {
        if (!is_user_logged_in()) return;
        if (!isset($_POST['wlv_contact_submission']) || !isset($_POST['wlv_contact_submission'])) return;
        if (!wp_verify_nonce($_POST['wlv_contact_submission'], 'wlv_contact_submission')) return;

        if (!isset($_POST['venue_id']) || empty($_POST['venue_id'])) wp_die('Invalid request vendor not found.');

        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
        $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
        $user_id = get_current_user_id();
        $vendor_id = $_POST['venue_id'];

        $data = [
            'user_id' => $user_id,
            'venue_id' => $vendor_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'city' => $city,
            'message' => $message,
            'date' => $date
        ];

        $insert_contact = wvL_insert_contact_data($data);
        if (!is_wp_error($insert_contact)) {
            wp_redirect(site_url('/dashboard/contacts?#contact-' . $insert_contact));
        }
    }
}

WVL_Customer_Contact_Request::get_instance();
