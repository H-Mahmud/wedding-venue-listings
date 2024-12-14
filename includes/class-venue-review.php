<?php
defined('ABSPATH') || exit;

/**
 * WVL_Venue_Review class
 */
class WVL_Venue_Review
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Venue_Review
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
        add_action('wvl_review_form', array($this, 'venue_review_form'));
        add_action('init', array($this, 'venue_review_handle'));
    }


    /**
     * Displays the venue review form.
     *
     * @action wvl_review_form
     *
     * @since 1.0.0
     */
    public function venue_review_form()
    {
        if (is_user_logged_in()) {
            include_once WVL_PLUGIN_DIR . 'template-parts/reviews/review-form.php';
        } else {
            echo '<p class="my-2">' . __('You must be logged in to leave a review.', 'wedding-venue-listings') . '</p>';
        }
    }


    /**
     * Handles the submission of a venue review.
     * 
     * Verifies a nonce and checks if the user is logged in and if the post exists.
     * If the request is valid, it inserts a comment and, if the rating and title are set, adds them as comment meta.
     * If a rating is set, it also updates the average rating of the post.
     * 
     * @since 1.0.0
     */
    public function venue_review_handle()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['wvl_venue_review_submit']) || !isset($_POST['venue_id']) || !get_post_status($_POST['venue_id'])) return;
        if (!wp_verify_nonce($_POST['wvl_venue_review_nonce'], 'wvl_venue_review_nonce')) return;
        if (post_password_required() || !is_user_logged_in())  return;

        $user_id = get_current_user_id();
        $post_id = $_POST['venue_id'];

        $comment_data = array(
            'comment_post_ID' => $post_id,
            'comment_content' => isset($_POST['comment']) ? sanitize_textarea_field($_POST['comment']) : '',
            'user_id' => $user_id,
        );

        if (empty($comment_data['comment_content'])) {
            wvl_add_notice(__('Please enter a review.', 'wedding-venue-listings'), 'error', 'wvl_review_form');
        } else {
            if (isset($_POST['comment_id']) && !empty($_POST['comment_id'])) {
                $comment_data['comment_ID'] = $_POST['comment_id'];
                wp_update_comment($comment_data);
                $comment_id = $_POST['comment_id'];
            } else {
                $comment_id = wp_insert_comment($comment_data);
            }

            if (isset($_POST['rating']) && !empty($_POST['rating'])) {
                $rating = sanitize_text_field($_POST['rating']);
                update_comment_meta($comment_id, 'rating', $rating);
                update_post_meta($post_id, 'average_rating', $this->calculate_average_rating($post_id));
            }

            if (isset($_POST['title']) && !empty($_POST['title'])) {
                $title = sanitize_text_field($_POST['title']);
                update_comment_meta($comment_id, 'title', $title);
            }
            wvl_add_notice(__('Review submitted successfully.', 'wedding-venue-listings'), 'success', 'wvl_review_form');
        }
    }


    public function calculate_average_rating($post_id)
    {
        if (empty($post_id) || !is_numeric($post_id)) {
            return 0;
        }

        $args = array(
            'post_id'     => $post_id,
            'meta_key'    => 'rating',
            'meta_value'  => '',
            'meta_compare' => '!=',
            'status'      => 'approve',
            'number'      => 0,
        );

        $comments = get_comments($args);

        $total_rating = 0;
        $rating_count = 0;

        foreach ($comments as $comment) {
            $rating = get_comment_meta($comment->comment_ID, 'rating', true);
            if (!empty($rating) && is_numeric($rating)) {
                $total_rating += (int)$rating;
                $rating_count++;
            }
        }

        if ($rating_count > 0) {
            $average_rating = $total_rating / $rating_count;
            return round($average_rating, 2);
        }

        return 0;
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Venue_Review The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

WVL_Venue_Review::get_instance();
