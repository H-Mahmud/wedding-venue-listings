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
        add_action('init', array($this, 'dashboard_rewrite_rules'));
        add_filter('query_vars', array($this, 'dashboard_query_vars'));
    }


    public function dashboard_page_template($page_template)
    {
        if (is_page('dashboard')) {
            $page_template = WVL_PLUGIN_DIR . '/templates/dashboard.php';
        }
        return $page_template;
    }



    /**
     * Adds custom rewrite rules for the dashboard subpages.
     *
     * This function registers a rewrite rule to handle URLs of the form
     * 'dashboard/{subpage}', mapping them to the 'dashboard' page with the
     * 'subpage' query variable set to the specified subpage value.
     *
     * The rewrite rule is added to the top of the rules list, ensuring that
     * it takes precedence over other rules.
     */
    public function dashboard_rewrite_rules()
    {
        add_rewrite_rule('^dashboard/([^/]*)/?', 'index.php?pagename=dashboard&subpage=$matches[1]', 'top');
    }


    /**
     * Add 'subpage' as a query variable.
     *
     * The 'subpage' query variable is used to identify the sub-page of the
     * Dashboard page. For example, 'dashboard/profile' will use 'profile' as
     * the value of 'subpage'.
     *
     * @param array $vars The list of query variables.
     *
     * @return array The updated list of query variables.
     */
    public function dashboard_query_vars($vars)
    {
        $vars[] = 'subpage';
        return $vars;
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
