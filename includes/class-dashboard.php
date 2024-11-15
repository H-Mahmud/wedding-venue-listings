<?php
defined('ABSPATH') || exit;
/**
 * WVL_Dashboard class
 */
class WVL_Dashboard
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard
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
        add_filter('page_template', array($this, 'dashboard_page_template'));
    }


    public function dashboard_page_template($page_template)
    {
        if (is_page('dashboard')) {
            $page_template = WVL_PLUGIN_DIR . '/templates/dashboard.php';
        }
        return $page_template;
    }

    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Dashboard::get_instance();
