<?php
defined('ABSPATH') || exit;
/**
 * Class WVL_Subscription_Manage
 */
class WVL_Subscription_Manage
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
        add_action('wp', array($this,  'daily_cron_schedule'));
        add_action('wvl_vendor_status_daily_event', array($this, 'check_vendor_status'));
    }


    public function daily_cron_schedule()
    {
        if (! wp_next_scheduled('wvl_vendor_status_daily_event')) {
            wp_schedule_event(time(), 'daily', 'wvl_vendor_status_daily_event');
        }
    }


    public function check_vendor_status()
    {

        $venue_ids = get_posts([
            'post_type' => 'venue',
            'numberposts' => -1,
            'fields' => 'ids'
        ]);
        foreach ($venue_ids as $venue_id) {
            $author_id = get_post_field('post_author', $venue_id);
            $current_plan = wvl_current_plan($author_id);
            $mime_type = $current_plan;
            wp_update_post(array(
                'ID' => $venue_id,
                'post_mime_type' => $mime_type
            ));
        }
    }

    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Subscription_Manage The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Subscription_Manage::get_instance();


/**
 * Determines the current subscription plan for a user.
 *
 * This function retrieves all active subscriptions for a user and checks their status.
 * It returns the slug of the highest-level active subscription plan ('ultimate' or 'pro').
 * If no active subscriptions are found, it defaults to returning 'free'.
 *
 * @return string The slug of the current subscription plan ('ultimate', 'pro', or 'free').
 */

function wvl_current_plan($user_id = 0)
{
    if (!method_exists('\Indeed\Ihc\UserSubscriptions', 'getAllForUser'))  return 0;

    if (!$user_id) $user_id = get_current_user_id();

    $active_subscriptions = \Indeed\Ihc\UserSubscriptions::getAllForUser($user_id);
    if (!is_array($active_subscriptions) || count($active_subscriptions) == 0)  return 0;

    $slug = 0;

    foreach ($active_subscriptions as $subscription) {

        if ($subscription['status'] != 1)  continue;

        if ($subscription['level_slug'] == 'pro' || $subscription['level_slug'] == 'proyear') {
            $slug = 2;
        } elseif (($subscription['level_slug'] == 'standard' || $slug == 'standardyear') && ($subscription['level_slug'] != 'pro' || $subscription['level_slug'] != 'proyear')) {
            $slug = 1;
        }
    }

    return $slug;
}
