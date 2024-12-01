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
        add_action('init', array($this, 'change_account_password'));
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
            'capability' => 'manage_account',
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


    public function change_account_password()
    {
        if (isset($_POST['wvl_change_password'])) {
            if (!isset($_POST['_change_password']) || !wp_verify_nonce($_POST['_change_password'], 'change_password')) {
                return;
            }
            if (!current_user_can('manage_account')) {
                $_SESSION['wvl_change_password_error'] = __('You do not have permission to change your account password.', 'wedding-venue-listings');
                wp_safe_redirect(site_url('dashboard/account/'));
                exit;
            }

            $new_password = sanitize_text_field($_POST['new_password']);
            $confirm_password = sanitize_text_field($_POST['confirm_password']);

            if ($new_password === $confirm_password) {
                $user_id = get_current_user_id();
                wp_set_password($new_password, $user_id);
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);
                wvl_add_notice(__('Password changed successfully.', 'wedding-venue-listings'), 'success');
                wp_safe_redirect(site_url('dashboard/account/'));
                exit;
            } else {
                wvl_add_notice(__('Passwords do not match.', 'wedding-venue-listings'), 'error');
                wp_safe_redirect(site_url('dashboard/account/'));
                exit;
            }
        }
    }
}
WVL_Dashboard_Account::get_instance();
