<?php
defined('ABSPATH') || exit;
/**
 * WVL_Seller_Account class
 */
class WVL_Seller_Account
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Seller_Account
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
        add_shortcode('wvl-login', array($this, 'login_form_shortcode'));
        add_shortcode('wvl-register', array($this, 'register_form_shortcode'));
        add_shortcode('wvl-forgot-password', array($this, 'forgot_password_form_shortcode'));
        add_shortcode('wvl-reset-password', array($this, 'reset_password_form_shortcode'));
        add_shortcode('wvl-dashboard', array($this, 'dashboard_shortcode'));
    }




    public function login_form_shortcode()
    {

        ob_start();
        include_once WVl_PLUGIN_DIR . 'view/login.php';
        return ob_get_clean();
    }



    public function register_form_shortcode()
    {

        ob_start();
        include_once WVl_PLUGIN_DIR . 'view/register.php';
        return ob_get_clean();
    }



    public function forgot_password_form_shortcode()
    {

        ob_start();
        include_once WVl_PLUGIN_DIR . 'view/forgot-password.php';

        return ob_get_clean();
    }



    public function reset_password_form_shortcode()
    {

        // Get the key and login from URL parameters
        $reset_key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';
        $user_login = isset($_GET['login']) ? sanitize_text_field($_GET['login']) : '';

        if (!$reset_key || !$user_login) {
            return '<p class="error">Invalid password reset link.</p>';
        }

        // Verify the reset key and login
        $user = check_password_reset_key($reset_key, $user_login);
        if (is_wp_error($user)) {
            return '<p class="error">' . $user->get_error_message() . '</p>';
        }

        // Display the reset password form
        ob_start();
        include_once WVl_PLUGIN_DIR . 'view/reset-password.php';
        return ob_get_clean();
    }


    public function dashboard_shortcode()
    {

        ob_start();
        include_once WVl_PLUGIN_DIR . 'view/dashboard.php';
        return ob_get_clean();
    }



    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Seller_Account The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Seller_Account::get_instance();
// Login, Register, Forgot Password

// Category, location, bio, thumbnail, gallery, videos, and social media

// Manage booking availability through a calender.
