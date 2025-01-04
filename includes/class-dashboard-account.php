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
        add_action('init', array($this, 'update_account_info'));

        add_action('wp_ajax_wvl_upload_avatar', array($this, 'handle_avatar_upload'));
        add_action('wp_ajax_nopriv_wvl_upload_avatar', array($this, 'handle_avatar_upload'));
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
            'icon'     => '<i class="fa-solid fa-circle-info text-xl" style="color: #916E37;"></i>',
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
     * Handles the account password change request for the current user.
     *
     * This function checks if the password change form has been submitted, verifies the nonce,
     * and ensures the current user has the required capability to change the account password.
     * If the new password and confirmation password match, it updates the user's password and
     * sets the appropriate authentication cookies. Success or error notices are added based on
     * the outcome, and the user is redirected to the account page.
     *
     * @return void
     */
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

    /**
     * Updates the user's account information, including their first name and last name.
     *
     * Requires the user to have the manage_account capability.
     *
     * @return void
     */
    public function update_account_info()
    {
        if (isset($_POST['wvl_account_info'])) {
            if (!isset($_POST['_update_account']) || !wp_verify_nonce($_POST['_update_account'], 'update_account')) {
                return;
            }
            if (!current_user_can('manage_account')) {
                wvl_add_notice(__('You do not have permission to update your account information.', 'wedding-venue-listings'), 'error', 'wvl_update_account');
                wp_safe_redirect(site_url('dashboard/account/'));
                exit;
            }
            $user_id = get_current_user_id();
            $first_name = sanitize_text_field($_POST['first_name']);
            $last_name = sanitize_text_field($_POST['last_name']);

            if (empty($first_name) || empty($last_name)) {
                wvl_add_notice(__('First name and last name are required.', 'wedding-venue-listings'), 'error', 'wvl_update_account');
                wp_safe_redirect(site_url('dashboard/account/'));
                exit;
            }

            update_user_meta($user_id, 'first_name', $first_name);
            update_user_meta($user_id, 'last_name', $last_name);

            wvl_add_notice(__('Account information updated successfully.', 'wedding-venue-listings'), 'success', 'wvl_update_account');
            wp_safe_redirect(site_url('dashboard/account/'));
            exit;
        }
    }

    /**
     * Handles the avatar upload via AJAX.
     *
     * This function checks if the user is logged in, if the security nonce is valid, and if a file has been uploaded.
     * It then handles the upload of the avatar via the WordPress built-in functions wp_handle_upload and wp_insert_attachment.
     * Finally, it updates the user meta with the new avatar ID and sends a JSON response back to the client.
     *
     * @return void
     */
    public function handle_avatar_upload()
    {
        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => __('You must be logged in to upload an avatar.', 'wedding-venue-listings')]);
        }

        if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'wvl_upload_avatar')) {
            wp_send_json_error(['message' => __('Invalid security token.', 'wedding-venue-listings')]);
        }

        if (!isset($_FILES['file']) || empty($_FILES['file']['tmp_name'])) {
            wp_send_json_error(['message' => __('No file uploaded.', 'wedding-venue-listings')]);
        }

        $file = $_FILES['file'];
        $upload = wp_handle_upload($file, ['test_form' => false]);
        if (!empty($upload['error'])) {
            wp_send_json_error(['message' => $upload['error']], 500);
        }

        $user_id = get_current_user_id();
        $attachment = [
            'post_mime_type' => $upload['type'],
            'post_title'     => sanitize_file_name($file['name']),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ];

        $attachment_id = wp_insert_attachment($attachment, $upload['file']);
        if (is_wp_error($attachment_id) || !$attachment_id) {
            wp_send_json_error(['message' => 'Failed to save the avatar in the media library.'], 500);
        }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));

        $current_avatar_id = get_user_meta($user_id, 'simple_local_avatar', true);
        if ($current_avatar_id) {
            wp_delete_attachment($current_avatar_id, true);
        }

        update_user_meta($user_id, 'simple_local_avatar', $attachment_id);

        // wp_send_json_success(['message' => 'Avatar updated successfully.', 'attachment_id' => $attachment_id]);

        wp_send_json_success(['message' => 'Avatar uploaded successfully!']);
    }
}
WVL_Dashboard_Account::get_instance();
