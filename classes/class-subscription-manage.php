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

function wvl_current_plan()
{
    return 'ultimate';
};
