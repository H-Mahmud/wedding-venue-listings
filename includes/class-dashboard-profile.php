<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Profile
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Profile
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
        add_action('wp_ajax_upload_cover_photo', array($this, 'upload_cover_photo'));

        add_action('wp_ajax_submit_profile_info', array($this, 'handle_profile_info'));
        add_action('wp_ajax_nopriv_submit_profile_info', array($this, 'handle_profile_info'));
    }


    /**
     * Renders the Profile menu item in the Wedding Venue Listings dashboard menu.
     * 
     * The Profile menu item displays the user's profile information, including their name, email address, and profile picture.
     * 
     * @return void
     */
    public function render_wvl_dashboard_menu()
    {
        add_wvl_menu([
            'name'     => __('Venue Profile', 'wedding-venue-listings'),
            'slug'     => 'venue-profile',
            'icon'     => '<i class="fa-solid fa-user text-xl" style="color: #1f72b2;"></i>',
            'priority' => 20,
            'callback' => array($this, 'profile_page_cb'),
        ]);
    }


    /**
     * Callback function for the Profile menu item in the Wedding Venue Listings dashboard menu.
     *
     * Requires the profile.php template file in the template-parts/dashboard directory.
     *
     * @return void
     */
    public function profile_page_cb()
    {
        require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/profile.php';
    }




    public function handle_profile_info()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dashboard_nonce')) {
            wp_send_json_error(['message' => 'Invalid request.'], 400);
        }

        $first_name = sanitize_text_field($_POST['first_name'] ?? '');
        $last_name = sanitize_text_field($_POST['last_name'] ?? '');

        if (empty($first_name) || empty($last_name)) {
            wp_send_json_error(['message' => 'First name and last name are required.'], 400);
        }

        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            update_user_meta($user_id, 'first_name', $first_name);
            update_user_meta($user_id, 'last_name', $last_name);
            wp_send_json_success(['message' => 'Profile information updated successfully.']);
        } else {
            wp_send_json_error(['message' => 'You must be logged in to update your profile.'], 401);
        }
    }



    /**
     * Handles the AJAX request for uploading a cover photo for the current user's venue.
     *
     * @uses check_ajax_referer
     * @uses wp_handle_upload
     * @uses wp_insert_attachment
     * @uses wp_update_attachment_metadata
     * @uses wp_send_json_error
     * @uses wp_send_json_success
     *
     * @return void
     */
    public function upload_cover_photo()
    {
        check_ajax_referer('upload_image_nonce', 'security');
        if (empty($_FILES['file'])) {
            wp_send_json_error('No file uploaded.');
        }

        if (!is_user_logged_in()) {
            wp_send_json_error('You have no permission.');
        }

        $file = $_FILES['file'];
        $uploaded = wp_handle_upload($file, ['test_form' => false]);
        $parent_id = wvl_get_venue_id();

        if (isset($uploaded['error'])) {
            wp_send_json_error($uploaded['error']);
        }

        $attachment_id = wp_insert_attachment([
            'guid'           => $uploaded['url'],
            'post_mime_type' => $uploaded['type'],
            'post_title'     => sanitize_file_name($file['name']),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'post_parent'    => $parent_id,
        ], $uploaded['file']);

        if (is_wp_error($attachment_id) || !$attachment_id) {
            wp_send_json_error('Failed to create attachment.');
        }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attach_data = wp_generate_attachment_metadata($attachment_id, $uploaded['file']);
        wp_update_attachment_metadata($attachment_id, $attach_data);

        wp_send_json_success([
            'attachment_id' => $attachment_id,
            'url'           => $uploaded['url'],
            'parent_id'     => $parent_id,
        ]);
    }

    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Profile The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Dashboard_Profile::get_instance();
