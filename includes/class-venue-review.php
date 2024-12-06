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
