<?php
defined('ABSPATH') || exit;
/**
 * WVL_Account_Auth class
 */
class WVL_Account_Auth
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Account_Auth
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

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }




    public function login_form_shortcode()
    {

        ob_start();
        include_once WVL_PLUGIN_DIR . 'view/login.php';
        return ob_get_clean();
    }



    public function register_form_shortcode()
    {

        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/register.php';
        return ob_get_clean();
    }



    public function forgot_password_form_shortcode()
    {

        ob_start();
        include_once WVL_PLUGIN_DIR . 'view/forgot-password.php';

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
        include_once WVL_PLUGIN_DIR . 'view/reset-password.php';
        return ob_get_clean();
    }


    public function dashboard_shortcode()
    {

        ob_start();
        include_once WVL_PLUGIN_DIR . 'view/dashboard.php';
        return ob_get_clean();
    }



    public function enqueue_scripts()
    {
        // wp_enqueue_style('nepali-date-picker', WVL_PLUGIN_URL . '/assets/css/nepali-date-picker.css');
        // wp_enqueue_style('wvl-style', WVL_PLUGIN_URL . '/assets/css/wvl-style.css');

        wp_enqueue_script('chart-js', WVL_PLUGIN_URL . '/assets/js/chart.js', array(), null, true);
        wp_enqueue_script('nepali-date-picker', WVL_PLUGIN_URL . '/assets/js/nepali-date-picker.js', ['jquery'], false, true);
        // wp_enqueue_script('wvl-main', WVL_PLUGIN_URL . '/assets/js/wvl-main.js', array('jquery'), '1.0', true);

        // Fontawesom Todo: move to separate file
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', [], '5.15.3');

        wp_localize_script('wvl-main', 'ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('upload_image_nonce')
        ]);
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Account_Auth The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Account_Auth::get_instance();
