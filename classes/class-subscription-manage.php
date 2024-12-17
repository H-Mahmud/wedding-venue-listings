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
    private final function __construct() {}

    public function currentPlan()
    {
        $user_id = get_current_user_id();
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
    if (!method_exists('\Indeed\Ihc\UserSubscriptions', 'getAllForUser'))  return 'free';

    if (!$user_id) $user_id = get_current_user_id();

    $active_subscriptions = \Indeed\Ihc\UserSubscriptions::getAllForUser($user_id);
    if (!is_array($active_subscriptions) || count($active_subscriptions) == 0)  return 'free';

    $slug = 'free';

    foreach ($active_subscriptions as $subscription) {

        if ($subscription['status'] != 1)  continue;

        if ($subscription['level_slug'] == 'ultimate') {
            $slug = $subscription['level_slug'];
        } elseif ($subscription['level_slug'] == 'pro' && $slug !== 'ultimate') {
            $slug = $subscription['level_slug'];
        }
    }

    return $slug;
}
