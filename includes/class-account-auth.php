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
        add_action('template_redirect', array($this, 'restrict_logged_user'), 100);
        add_shortcode('wvl-login', array($this, 'login_form_shortcode'));
        add_shortcode('wvl-register', array($this, 'register_form_shortcode'));
        add_action('init', array($this, 'user_logging'));
        add_action('init', array($this, 'user_register'));
        add_action('init', array($this, 'user_password_forgot'));
        add_action('init', array($this, 'user_password_reset'));
        add_shortcode('wvl-forgot-password', array($this, 'forgot_password_form_shortcode'));
        add_shortcode('wvl-reset-password', array($this, 'reset_password_form_shortcode'));
        add_shortcode('wvl-dashboard', array($this, 'dashboard_shortcode'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }


    public function restrict_logged_user()
    {
        if (!is_user_logged_in() || is_admin()) return;
        if (is_page('register') || is_page('login') || is_page('forgot-password')) {
            wp_redirect(home_url());
            exit;
        }
    }


    public function login_form_shortcode()
    {

        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/login.php';
        return ob_get_clean();
    }


    public function user_logging()
    {
        if (!isset($_POST['_wvl_login_nonce']) || !wp_verify_nonce($_POST['_wvl_login_nonce'], 'wvl_login_nonce')) {
            return;
        }
        if (isset($_POST['login'])) {
            $is_remember = isset($_POST['remember']) ? true : false;
            $creds = array(
                'user_login'    => $_POST['username'],
                'user_password' => $_POST['password'],
                'remember'      => false
            );
            if ($is_remember) {
                $creds['remember'] = true;
            }

            $user = wp_signon($creds, false);
            if (is_wp_error($user)) {
                $_SESSION['wvl_login_error'] = $user->get_error_message();
            } else {
                wp_redirect(home_url());
                exit;
            }
        }
    }


    public function register_form_shortcode()
    {

        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/register.php';
        return ob_get_clean();
    }


    /**
     * Handles the user registration process.
     *
     * This function checks whether the `register` form was submitted, and if so,
     * it creates a new user, sets the user's password, and redirects the user
     * to the home page. If there is an error during the registration process,
     * it will be stored in the session and can be displayed to the user.
     */
    public function user_register()
    {
        if (!isset($_POST['_wvl_register_nonce']) || !wp_verify_nonce($_POST['_wvl_register_nonce'], 'wvl_register_nonce')) {
            return;
        }

        if (isset($_POST['register'])) {
            $username = sanitize_user($_POST['username']);
            $email = sanitize_email($_POST['email']);
            $password = sanitize_text_field($_POST['password']);

            $user = register_new_user($username, $email);

            if (is_wp_error($user)) {
                $_SESSION['wvl_register_error'] = $user->get_error_message();
            } else {
                wp_set_password($password, $user);

                wp_set_current_user($user);
                wp_set_auth_cookie($user);

                wp_redirect(home_url());
                exit;
            }
        }
    }


    public function forgot_password_form_shortcode()
    {

        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/forgot-password.php';

        return ob_get_clean();
    }

    public function user_password_forgot()
    {

        if (isset($_POST['forgot_password'])) {
            $user_login = sanitize_text_field($_POST['user_login']);
            $user = get_user_by('email', $user_login);

            if (!$user) {
                $user = get_user_by('login', $user_login);
            }

            if ($user) {
                $reset_key = get_password_reset_key($user);
                $reset_page_link = site_url('reset-password');
                $reset_link = add_query_arg(array('key' => $reset_key, 'login' => $user->user_login, 'action' => 'rp'), $reset_page_link);


                $to = $user->user_email;
                $subject = "Password Reset";
                $message = "Click the following link to reset your password: $reset_link";
                wp_mail($to, $subject, $message);

                $_SESSION['wvl_password_forgot_success'] = 'Check your email for the password reset link.';
            } else {
                $_SESSION['wvl_password_forgot_error'] = 'Invalid username or email.';
            }
        }
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

        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/reset-password.php';
        return ob_get_clean();
    }

    public function user_password_reset()
    {

        if (!isset($_POST['_wvl_reset_password_nonce']) || !wp_verify_nonce($_POST['_wvl_reset_password_nonce'], 'wvl_reset_password_nonce')) {
            return;
        }

        if (isset($_POST['register'])) {
            $username = sanitize_user($_POST['username']);
            $email = sanitize_email($_POST['email']);
            $password = sanitize_text_field($_POST['password']);

            $user = register_new_user($username, $email);

            if (is_wp_error($user)) {
                $_SESSION['wvl_register_error'] = $user->get_error_message();
            } else {
                wp_set_password($password, $user);

                wp_set_current_user($user);
                wp_set_auth_cookie($user);

                wp_redirect(home_url());
                exit;
            }
        }


        if (isset($_POST['reset_password'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password !== $confirm_password) {
                $_SESSION['wvl_reset_password_error'] = 'passwords do not match.';
            } elseif (empty($new_password) || strlen($new_password) < 6) {
                $_SESSION['wvl_reset_password_error'] = 'Password must be at least 6 characters.';
            } else {
                reset_password($user, $new_password);
                $_SESSION['wvl_reset_password_success'] = '<p class="success text-green-700">Your password has been reset successfully. <a href="' . site_url('login') . '">Log in</a>.</p>';
            }
        }
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
