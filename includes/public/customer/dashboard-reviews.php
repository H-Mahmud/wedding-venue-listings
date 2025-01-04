<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Reviews
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Reviews
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
        add_action('init', array($this, 'reviews_reply_handle'));
        add_action('wvl_menu_badge', array($this, 'add_review_count_badge'));
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Reviews The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function render_wvl_dashboard_menu()
    {

        add_wvl_menu([
            'name'     => 'Reviews',
            'slug'     => 'reviews',
            'capability' => 'manage_venue',
            'icon'     => '<i class="fa-solid fa-star-half-stroke text-xl" style="color: #916E37;"></i>',
            'premium'  => false,
            'priority' => 30,
            'callback' => array($this, 'reviews_page_cb'),
        ]);
    }


    /**
     * The callback function for the Availability menu item in the Wedding Venue Listings dashboard menu.
     *
     * This function simply requires the template file for the Availability page and does not do any
     * further processing.
     *
     * @return void
     */
    public function reviews_page_cb()
    {
        require_once WVL_PLUGIN_DIR . '/includes/public/customer/parts/reviews-page.php';
    }


    public function reviews_reply_handle()
    {


        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['submit_review_reply']) || !isset($_POST['venue_id'])) return;
        if (!wp_verify_nonce($_POST['wvl_review_reply_nonce'], 'wvl_review_reply_nonce')) return;
        if (!is_user_logged_in())  return;



        $user_id = get_current_user_id();
        $post_id = intval($_POST['venue_id']);
        $parent_id = intval($_POST['parent_id']);
        $comment_content = sanitize_text_field($_POST['comment_content']);

        $comment_data = array(
            'comment_post_ID' => $post_id,
            'comment_parent' => $parent_id,
            'comment_content' => $comment_content,
            'user_id' => $user_id,
            'comment_approved' => 1,
        );

        if (empty($comment_data['comment_content'])) {
            wvl_add_notice(__('Please enter the reply message.', 'wedding-venue-listings'), 'error', 'wvl_review_reply_form');
        } else {
            if (isset($_POST['comment_id']) && !empty($_POST['comment_id'])) {
                $comment_data['comment_ID'] = $_POST['comment_id'];
                wp_update_comment($comment_data);
                $comment_id = $_POST['comment_id'];
            } else {
                $comment_id = wp_insert_comment($comment_data);
            }

            wvl_add_notice(__('Reply submitted successfully.', 'wedding-venue-listings'), 'success', 'wvl_review_reply_form');
        }
    }


    public function add_review_count_badge($slug)
    {
        if ($slug == 'reviews') {
            $count = wvl_count_reviews_without_reply(wvl_get_venue_id());
            echo '<span class="inline-block ml-2 bg-amber-100 text-amber-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">' . $count . '</span>';
        }
    }
}
WVL_Dashboard_Reviews::get_instance();
