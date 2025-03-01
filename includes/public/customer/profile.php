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

        add_action('wp_ajax_submit_profile_service_info', array($this, 'handle_profile_service_info'));
        add_action('wp_ajax_nopriv_submit_profile_service_info', array($this, 'handle_profile_service_info'));


        add_action('wp_ajax_submit_profile_contact_info', array($this, 'handle_profile_contact_info'));
        add_action('wp_ajax_nopriv_submit_profile_contact_info', array($this, 'handle_profile_contact_info'));

        add_action('wp_ajax_submit_profile_your_story', array($this, 'handle_profile_your_story'));
        add_action('wp_ajax_nopriv_submit_profile_your_story', array($this, 'handle_profile_your_story'));

        add_action('wp_ajax_wvl_upload_cover_photo', array($this, 'upload_cover_photo'));
        add_action('wp_ajax_nopriv_wvl_upload_cover_photo', array($this, 'upload_cover_photo'));

        add_action('wp_ajax_wvl_upload_gallery_photo', array($this, 'upload_gallery_photo'));
        add_action('wp_ajax_nopriv_wvl_upload_gallery_photo', array($this, 'upload_gallery_photo'));

        add_action('wp_ajax_wvl_remove_gallery_photo', array($this, 'remove_gallery_photo'));
        add_action('wp_ajax_nopriv_wvl_remove_gallery_photo', array($this, 'remove_gallery_photo'));

        add_action('wp_ajax_wvl_add_new_video', array($this, 'add_new_video'));
        add_action('wp_ajax_nopriv_wvl_add_new_video', array($this, 'add_new_video'));

        add_action('wp_ajax_wvl_remove_gallery_video', array($this, 'remove_gallery_video'));
        add_action('wp_ajax_nopriv_wvl_remove_gallery_video', array($this, 'remove_gallery_video'));

        add_action('wp_ajax_wvl_submit_venue_profile', array($this, 'submit_venue_profile'));
        add_action('wp_ajax_nopriv_wvl_submit_venue_profile', array($this, 'submit_venue_profile'));
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
            'capability' => 'manage_venue',
            'icon'     => '<i class="fa-solid fa-user text-xl" style="color: #916E37;"></i>',
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
        if (!wvl_get_venue_id()) {
            wp_insert_post(array(
                'post_title'    => 'Untitled Venue',
                'post_status'   => 'draft',
                'post_type'     => 'venue',
                'post_author'   => get_current_user_id()
            ));
        }

        require_once WVL_PLUGIN_DIR . '/includes/public/customer/parts/profile-page.php';
    }




    public function handle_profile_info()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dashboard_nonce')) {
            wp_send_json_error(['message' => 'Invalid request.']);
        }

        $first_name = sanitize_text_field($_POST['first_name'] ?? '');
        $last_name = sanitize_text_field($_POST['last_name'] ?? '');

        if (empty($first_name) || empty($last_name)) {
            wp_send_json_error(['message' => 'First name and last name are required.']);
        }

        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            update_user_meta($user_id, 'first_name', $first_name);
            update_user_meta($user_id, 'last_name', $last_name);
            wp_send_json_success(['message' => 'Profile information updated successfully.']);
        } else {
            wp_send_json_error(['message' => 'You must be logged in to update your profile.']);
        }
    }


    public function handle_profile_your_story()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dashboard_nonce')) {
            wp_send_json_error(['message' => 'Invalid request.']);
        }

        $your_story = wp_kses_post($_POST['your_story'] ?? '');

        if (empty($your_story)) {
            wp_send_json_error(['message' => 'Your Story field is required.']);
        }

        $venue_id = wvl_get_venue_id();
        if ($venue_id) {
            wp_update_post([
                'ID' => $venue_id,
                'post_content' => $your_story
            ]);
            wp_send_json_success(['message' => 'Profile information updated successfully.']);
        } else {
            wp_send_json_error(['message' => 'You must be logged in to update your profile.']);
        }
    }

    public function handle_profile_service_info()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dashboard_nonce')) {
            wp_send_json_error(['message' => 'Invalid request.']);
        }

        $venue_name = sanitize_text_field($_POST['venue_name'] ?? '');
        $category = sanitize_text_field($_POST['category'] ?? '');
        $sub_category = sanitize_text_field($_POST['sub_category'] ?? '');

        if (!isset($_POST['sub_category']) || !is_array($_POST['sub_category'])) {
            wp_send_json_error(['message' => 'Subcategory is required.']);
        }
        $sub_category = array_map('sanitize_text_field', $_POST['sub_category']);

        // Support Location
        if (!isset($_POST['support_location']) || !is_array($_POST['support_location'])) {
            wp_send_json_error(['message' => 'Support Location is required.']);
        }
        $support_location = array_map('sanitize_text_field', $_POST['support_location']);

        // if (!isset($_POST['vendor_type']) || !is_array($_POST['vendor_type'])) {
        //     wp_send_json_error(['message' => 'Vendor type is required.']);
        // }
        // $vendor_type = array_map('sanitize_text_field', $_POST['vendor_type']);


        // if (!isset($_POST['event_type']) || !is_array($_POST['event_type'])) {
        //     wp_send_json_error(['message' => 'Event type is required.']);
        // }
        // $event_type = array_map('sanitize_text_field', $_POST['event_type']);

        if (empty($venue_name) || empty($category)) {
            wp_send_json_error(['message' => 'All fields are required.']);
        }

        $venue_id = wvl_get_venue_id();
        if ($venue_id) {
            wp_update_post([
                'ID' => $venue_id,
                'post_title' => $venue_name,
            ]);


            // wp_set_post_terms($venue_id, $vendor_type, 'vendor_type', false);
            // wp_set_post_terms($venue_id, $event_type, 'event_type', false);

            // if (wvl_get_support_location_limit($venue_id) !== -1 && count($support_location) > 1) {
            //     wp_send_json_success(['message' => 'You are not allowed to add more then 1 support location with free account.']);
            // }
            wp_set_post_terms($venue_id, $support_location, 'support_location', false);

            $categories = $sub_category;
            $categories[] = $category;
            wp_set_post_terms($venue_id, $categories, 'category', false);

            wp_send_json_success(['message' => 'Profile information updated successfully.']);
        } else {
            wp_send_json_error(['message' => 'You must be logged in to update your profile.']);
        }
    }

    public function handle_profile_contact_info()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dashboard_nonce')) {
            wp_send_json_error(['message' => 'Invalid request.']);
        }

        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $email = sanitize_text_field($_POST['email'] ?? '');
        $address = sanitize_text_field($_POST['address'] ?? '');

        $social_links = [];
        if (isset($_POST['social_links']) && is_array($_POST['social_links'])) {
            foreach ($_POST['social_links'] as $key => $value) {
                $social_links[$key]['value'] = sanitize_text_field($value['value']);
            }
        }
        update_post_meta(wvl_get_venue_id(), 'social_links', $social_links);

        if (empty($phone) || empty($email) || empty($address)) {
            wp_send_json_error(['message' => 'All fields are required.']);
        }

        $venue_id = wvl_get_venue_id();
        if ($venue_id) {
            update_post_meta($venue_id, 'phone', $phone);
            update_post_meta($venue_id, 'email', $email);
            update_post_meta($venue_id, 'address', $address);
            wp_send_json_success(['message' => 'Profile information updated successfully.']);
        } else {
            wp_send_json_error(['message' => 'You must be logged in to update your profile.']);
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
        check_ajax_referer('dashboard_nonce', 'security');

        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => __('You must be logged in to upload an Cover Photo.', 'wedding-venue-listings')]);
        }


        if (!isset($_FILES['file']) || empty($_FILES['file']['tmp_name'])) {
            wp_send_json_error(['message' => __('No file uploaded.', 'wedding-venue-listings')]);
        }

        $file = $_FILES['file'];
        $upload = wp_handle_upload($file, ['test_form' => false]);
        if (!empty($upload['error'])) {
            wp_send_json_error(['message' => $upload['error']], 500);
        }


        $parent_id = wvl_get_venue_id();
        $user_id = get_current_user_id();

        $attachment_id = wp_insert_attachment([
            'guid'           => $upload['url'],
            'post_mime_type' => $upload['type'],
            'post_title'     => sanitize_file_name($file['name']),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'post_parent'    => $parent_id,
            'post_author'      => $user_id
        ], $upload['file']);

        if (is_wp_error($attachment_id) || !$attachment_id) {
            wp_send_json_error(['message' => 'Failed to save the cover photo in the media library.'], 500);
        }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));

        $current_thumbnail_id = get_post_thumbnail_id($parent_id);
        if ($current_thumbnail_id) {
            delete_post_thumbnail($parent_id);
            wp_delete_attachment($current_thumbnail_id, true);
        }

        set_post_thumbnail($parent_id, $attachment_id);

        wp_send_json_success(['message' => 'Cover uploaded successfully!']);
    }


    public function upload_gallery_photo()
    {
        check_ajax_referer('dashboard_nonce', 'security');

        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => __('You must be logged in to upload a Photo.', 'wedding-venue-listings')]);
        }

        if (!wvl_get_gallery_upload_limit(wvl_get_venue_id())) {
            wp_send_json_error(['message' => __('You have reached the maximum number of gallery images (5) allowed in your current plan. Please consider upgrading to a paid plan to upload unlimited images.', 'wedding-venue-listings')]);
        }


        if (!isset($_FILES['file']) || empty($_FILES['file']['tmp_name'])) {
            wp_send_json_error(['message' => __('No file uploaded.', 'wedding-venue-listings')]);
        }

        $file = $_FILES['file'];
        $upload = wp_handle_upload($file, ['test_form' => false]);
        if (!empty($upload['error'])) {
            wp_send_json_error(['message' => $upload['error']], 500);
        }


        $parent_id = wvl_get_venue_id();
        $user_id = get_current_user_id();

        $attachment_id = wp_insert_attachment([
            'guid'           => $upload['url'],
            'post_mime_type' => $upload['type'],
            'post_title'     => sanitize_file_name($file['name']),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'post_parent'    => $parent_id,
            'post_author'      => $user_id
        ], $upload['file']);

        if (is_wp_error($attachment_id) || !$attachment_id) {
            wp_send_json_error(['message' => 'Failed to save the photo in the media library.'], 500);
        }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));

        $post_gallery = get_post_meta($parent_id, 'venue_gallery', true);

        if (empty($post_gallery)) {
            $post_gallery = [];
        }

        $post_gallery[] = $attachment_id;

        update_post_meta($parent_id, 'venue_gallery', $post_gallery);

        wp_send_json_success(['message' => 'Image uploaded successfully!']);
    }

    public function remove_gallery_photo()
    {
        check_ajax_referer('dashboard_nonce', 'security');

        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => __('You must be logged to delete a Photo.', 'wedding-venue-listings')]);
        }

        if (!isset($_POST['attachment_id']) || empty($_POST['attachment_id'])) {
            wp_send_json_error(['message' => __('No attachment ID provided.', 'wedding-venue-listings')]);
        }

        $attachment_id = $_POST['attachment_id'];
        $parent_id = wvl_get_venue_id();

        $attachment = get_post($attachment_id);
        if (!$attachment || $attachment->post_parent !== $parent_id) {
            wp_send_json_error(['message' => __('Invalid attachment ID.', 'wedding-venue-listings')]);
        }

        $delete = wp_delete_attachment($attachment_id, true);

        if (is_wp_error($delete)) {
            wp_send_json_error(['message' => __('Failed to delete the attachment.', 'wedding-venue-listings')]);
        }

        $post_gallery = get_post_meta($parent_id, 'venue_gallery', true);

        if (empty($post_gallery)) {
            $post_gallery = [];
        }

        $post_gallery = array_diff($post_gallery, [$attachment_id]);

        update_post_meta($parent_id, 'venue_gallery', $post_gallery);

        wp_send_json_success(['message' => 'Image deleted successfully!']);
    }

    public function add_new_video()
    {
        check_ajax_referer('dashboard_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => __('You must be logged in to upload a Photo.', 'wedding-venue-listings')]);
        }

        if (wvl_current_plan() == 0) {
            wp_send_json_error(['message' => __('Your not allowed to upload videos. Please consider upgrading to a paid plan to add unlimited videos.', 'wedding-venue-listings')]);
        }


        if (!isset($_POST['video_url']) || empty($_POST['video_url'])) {
            wp_send_json_error(['message' => __('No video URL provided.', 'wedding-venue-listings')]);
        }

        $video = wvl_extract_video_id($_POST['video_url']);

        if (!$video || empty($video['platform']) || empty($video['video_id'])) {
            wp_send_json_error(['message' => __('Invalid video URL.', 'wedding-venue-listings')]);
        }

        $platform = $video['platform'];
        $id = $video['video_id'];

        $venue_id = wvl_get_venue_id();

        $video_gallery = get_post_meta($venue_id, 'venue_videos', true);

        if (empty($video_gallery)) {
            $video_gallery = [];
        }

        $image_url = '';
        $video_url = '';
        if ($platform == 'youtube') {
            $image_url = 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
            $video_url = 'https://www.youtube.com/watch?' . $id;
        } elseif ($platform == 'vimeo') {
            $image_url = 'https://vumbnail.com/' . $id . '.jpg';
            $video_url = 'https://vimeo.com/' . $id;
        } else {
            wp_send_json_error(['message' => __('Invalid video URL.', 'wedding-venue-listings')]);
        };


        $video_gallery[] = [
            'platform' => $platform,
            'id' => $id,
            'key' => uniqid()
        ];
        update_post_meta($venue_id, 'venue_videos', $video_gallery);

        wp_send_json_success([
            'url' => $video_url,
            'thumbnail' => $image_url,
            'platform' => $platform
        ]);
    }


    public function remove_gallery_video()
    {
        check_ajax_referer('dashboard_nonce', 'security');

        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => __('You must be logged to delete a Photo.', 'wedding-venue-listings')]);
        }

        if (!isset($_POST['key']) || empty($_POST['key'])) {
            wp_send_json_error(['message' => __('No video key provided.', 'wedding-venue-listings')]);
        }

        $key_id = $_POST['key'];
        $parent_id = wvl_get_venue_id();
        $video_gallery = get_post_meta($parent_id, 'venue_videos', true);

        if (empty($video_gallery)) {
            $video_gallery = [];
        }
        foreach ($video_gallery as $key => $video) {
            if ($video['key'] == $key_id) {
                unset($video_gallery[$key]);
            }
        }

        update_post_meta($parent_id, 'venue_videos', $video_gallery);
        wp_send_json_success(['message' => 'Video Removed successfully!']);
    }

    public function submit_venue_profile()
    {

        check_ajax_referer('dashboard_nonce', 'security');
        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => 'You must be logged in to update your profile.']);
        }
        $venue_id = wvl_get_venue_id();

        if (!$venue_id) {
            wp_send_json_error(['message' => 'You must be logged in to update your profile.']);
        }

        $venue_id = wvl_get_venue_id();
        $venue_status = get_post_status($venue_id);
        if ($venue_status !== 'publish') {
            wp_update_post([
                'ID' => $venue_id,
                'post_status' => 'publish'
            ]);
        }

        wp_send_json_success(['message' => __('Your application has been submitted.', 'wedding-venue-listings')]);
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


function wvl_extract_video_id($url)
{
    // YouTube URL regex
    $youtubePattern = '/(?:https?:\/\/(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+|(?:v|e(?:mbed)?)\/|.*?[?&]v=)([a-zA-Z0-9_-]+)))/';
    // Vimeo URL regex
    $vimeoPattern = '/(?:https?:\/\/(?:www\.)?vimeo\.com\/(?:[^\d]+)?(\d+))/';

    // Check if it's a YouTube URL
    if (preg_match($youtubePattern, $url, $matches)) {
        return ['platform' => 'youtube', 'video_id' => $matches[1]];
    }
    // Check if it's a Vimeo URL
    elseif (preg_match($vimeoPattern, $url, $matches)) {
        return ['platform' => 'vimeo', 'video_id' => $matches[1]];
    }

    // If no match found, return false
    return false;
}
