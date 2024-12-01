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
        add_action('init', array($this, 'register_roles_vendor_customer'));
        add_action('admin_init', array($this, 'redirect_vendor_and_customer_from_dashboard'));
        add_action('after_setup_theme', array($this, 'remove_admin_bar_for_vendor_and_customer'));


        add_action('init', array($this, 'user_logging'));
        add_action('init', array($this, 'user_register'), 10);
        add_action('init', array($this, 'vendor_user_register'), 10);
        add_action('init', array($this, 'user_password_forgot'));
        add_action('init', array($this, 'user_password_reset'), 10);

        add_shortcode('wvl-login', array($this, 'login_form_shortcode'));
        add_shortcode('wvl-register', array($this, 'register_form_shortcode'));
        add_shortcode('wvl-vendor-register', array($this, 'vendor_register_form_shortcode'));
        add_shortcode('wvl-forgot-password', array($this, 'forgot_password_form_shortcode'));
        add_shortcode('wvl-reset-password', array($this, 'reset_password_form_shortcode'));
        add_shortcode('wvl-dashboard', array($this, 'dashboard_shortcode'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }


    /**
     * Redirects logged-in users away from specific pages.
     * 
     * This function checks if a user is logged in and not an admin. If they
     * attempt to access the 'register', 'login', or 'forgot-password' pages,
     * they are redirected to the home page.
     */
    public function restrict_logged_user()
    {
        if (!is_user_logged_in() || is_admin()) return;
        if (is_page('register') || is_page('login') || is_page('forgot-password')) {
            wp_redirect(home_url());
            exit;
        }
    }


    /**
     * Registers 'vendor' and 'customer' roles.
     *
     * 'vendor' and 'customer' roles are created with limited capabilities.
     * They are only able to read posts and cannot edit, delete, publish, or upload files.
     *
     * @since 1.0.0
     */
    public function register_roles_vendor_customer()
    {
        add_role(
            'vendor',
            'Vendor',
            array(
                'read'              => true,
                'edit_posts'        => false,
                'delete_posts'      => false,
                'publish_posts'     => false,
                'upload_files'      => false,
            )
        );

        add_role(
            'customer',
            'Customer',
            array(
                'read'              => true,
                'edit_posts'        => false,
                'delete_posts'      => false,
                'publish_posts'     => false,
                'upload_files'      => false,
            )
        );
    }


    /**
     * Redirects 'vendor' and 'customer' roles from the admin dashboard to the homepage.
     *
     * This function checks if the current user is in the admin panel and not performing an AJAX request.
     * If the user has the 'vendor' or 'customer' role, it redirects them to the homepage.
     *
     * @since 1.0.0
     */
    public function redirect_vendor_and_customer_from_dashboard()
    {
        if (is_admin() && !defined('DOING_AJAX') && (current_user_can('vendor') || current_user_can('customer'))) {
            wp_redirect(home_url());
            exit;
        }
    }


    /**
     * Hides the admin bar for users with the 'vendor' or 'customer' roles.
     *
     * This function checks if the current user is in the 'vendor' or 'customer' role and
     * hides the admin bar if true.
     *
     * @since 1.0.0
     */
    public function remove_admin_bar_for_vendor_and_customer()
    {
        if (current_user_can('vendor') || current_user_can('customer')) {
            show_admin_bar(false);
        }
    }

    /**
     * Login form shortcode
     *
     * This function will include the login.php template file which contains
     * the HTML for the login form. The function will return the contents of the
     * file as a string.
     *
     * @return string The login form HTML
     */
    public function login_form_shortcode()
    {

        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/login.php';
        return ob_get_clean();
    }


    /**
     * Handles the login form submission.
     *
     * Checks if the current user is logged in and if the login form nonce is valid.
     * If the login form has been submitted, it will verify the user credentials and
     * log the user in if they are valid. If the login is successful, the user is redirected
     * to the home page. If the login fails, an error message is set in the session.
     *
     * @return void
     */
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


    /**
     * Generates the registration form HTML.
     *
     * This function will include the register.php template file which contains
     * the HTML for the registration form. The function will return the contents
     * of the file as a string.
     *
     * @return string The registration form HTML
     */
    public function register_form_shortcode()
    {
        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/register.php';
        return ob_get_clean();
    }


    /**
     * Generates the vendor registration form HTML.
     *
     * This function will include the vendor-register.php template file
     * which contains the HTML for the vendor registration form.
     * The function will return the contents of the file as a string.
     *
     * @return string The vendor registration form HTML.
     */
    public function vendor_register_form_shortcode()
    {
        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/vendor-register.php';
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

            $user_id = wp_create_user($username, $password, $email);

            if (is_wp_error($user_id)) {
                $_SESSION['wvl_register_error'] = $user_id->get_error_message();
            } else {
                $u = new WP_User($user_id);
                $u->set_role('customer');

                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);

                wp_redirect(home_url());
                exit;
            }
        }
    }


    public function vendor_user_register()
    {
        if (!isset($_POST['_wvl_register_nonce']) || !wp_verify_nonce($_POST['_wvl_register_nonce'], 'wvl_register_nonce')) {
            return;
        }

        if (isset($_POST['register'])) {
            $username = sanitize_user($_POST['username']);
            $email = sanitize_email($_POST['email']);
            $password = sanitize_text_field($_POST['password']);

            $user_id = wp_create_user($username, $password, $email);

            if (is_wp_error($user_id)) {
                $_SESSION['wvl_register_error'] = $user_id->get_error_message();
            } else {
                $$u = new WP_User($user_id);
                $u->set_role('vendor');

                wp_insert_post(array(
                    'post_title'    => sanitize_text_field($_POST['venue_name']),
                    'post_content'  => '',
                    'post_status'   => 'draft',
                    'post_type'     => 'venue',
                    'post_author'   => $user_id
                ));

                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);

                wp_redirect(home_url());
                exit;
            }
        }
    }


    /**
     * Generates the forgot password form HTML.
     *
     * This function includes the forgot-password.php template file,
     * which contains the HTML for the forgot password form. The function
     * returns the contents of the file as a string.
     *
     * @return string The forgot password form HTML.
     */
    public function forgot_password_form_shortcode()
    {
        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/forgot-password.php';

        return ob_get_clean();
    }


    /**
     * Handles the password forgot process.
     *
     * This function checks whether the `forgot_password` form was submitted, and if so,
     * it generates a password reset key for the user, sends the user an email with
     * a link to reset their password, and redirects the user to the login page.
     * If there is an error during the forgot password process, it will be stored in the
     * session and can be displayed to the user.
     */
    public function user_password_forgot()
    {
        if (!isset($_POST['_wvl_forgot_password_nonce']) || !wp_verify_nonce($_POST['_wvl_forgot_password_nonce'], 'wvl_forgot_password_nonce')) {
            return;
        }

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


    /**
     * Generates the password reset form HTML.
     *
     * This function verifies the password reset link in the URL, and if it is valid,
     * it includes the reset-password.php template file which contains the HTML for
     * the password reset form. The function returns the contents of the file as a
     * string. If the password reset link is invalid, it returns an error message as
     * a string.
     *
     * @return string The password reset form HTML.
     */
    public function reset_password_form_shortcode()
    {
        $reset_key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';
        $user_login = isset($_GET['login']) ? sanitize_text_field($_GET['login']) : '';

        if (!$reset_key || !$user_login) {
            return '<p class="error">Invalid password reset link.</p>';
        }

        $user = check_password_reset_key($reset_key, $user_login);
        if (is_wp_error($user)) {
            return '<p class="error">' . $user->get_error_message() . '</p>';
        }

        ob_start();
        include_once WVL_PLUGIN_DIR . 'shortcodes/reset-password.php';
        return ob_get_clean();
    }

    /**
     * Handles the password reset process.
     *
     * This function verifies the password reset link in the URL, and if it is valid,
     * it checks whether the `reset_password` form was submitted, and if so, it validates
     * the new and confirm passwords, and if they are valid, it resets the user's password
     * and redirects the user to the home page. If there is an error during the password
     * reset process, it will be stored in the session and can be displayed to the user.
     */
    public function user_password_reset()
    {

        if (
            !isset($_POST['_wvl_reset_password_nonce']) ||
            !wp_verify_nonce($_POST['_wvl_reset_password_nonce'], 'wvl_reset_password_nonce')
        ) return;

        $new_password = sanitize_text_field($_POST['new_password']);
        $confirm_password = sanitize_text_field($_POST['confirm_password']);

        $key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';
        $login = isset($_GET['login']) ? sanitize_text_field($_GET['login']) : '';

        $user = check_password_reset_key($key, $login);
        if (is_wp_error($user)) {
            $_SESSION['wvl_reset_password_error'] = 'Invalid or expired reset link.';
            wp_redirect(home_url('/reset-password'));
            exit;
        }

        if ($new_password !== $confirm_password) {
            $_SESSION['wvl_reset_password_error'] = 'Passwords do not match.';
        } elseif (empty($new_password) || strlen($new_password) < 6) {
            $_SESSION['wvl_reset_password_error'] = 'Password must be at least 6 characters.';
        } elseif (!is_wp_error($user)) {
            reset_password($user, $new_password);
            // $_SESSION['wvl_reset_password_success'] = '<p class="success text-green-700">Your password has been reset successfully. <a href="' . site_url('login') . '">Log in</a>.</p>';
            wp_redirect(home_url());
            exit;
        }
    }


    public function enqueue_scripts()
    {
        // wp_enqueue_style('nepali-date-picker', WVL_PLUGIN_URL . '/assets/css/nepali-date-picker.css');
        // wp_enqueue_style('wvl-style', WVL_PLUGIN_URL . '/assets/css/wvl-style.css');

        wp_enqueue_script('chart-js', WVL_PLUGIN_URL . '/assets/js/chart.js', array(), null, true);
        wp_enqueue_script('nepali-date-picker', WVL_PLUGIN_URL . '/assets/js/nepali-date-picker.js', ['jquery'], false, true);
        // wp_enqueue_script('wvl-main', WVL_PLUGIN_URL . '/assets/js/wvl-main.js', array('jquery'), '1.0', true);

        // Fontawesom Todo: move to separate file

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
