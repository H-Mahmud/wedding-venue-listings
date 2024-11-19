
<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Home
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Home
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
    }


    public function render_wvl_dashboard_menu()
    {

        add_wvl_menu([
            'name'     => 'Dashboard',
            'slug'     => 'home',
            'icon'     => '<i class="fa-solid fa-house text-xl" style="color: #1f72b2;"></i>',
            'premium'  => false,
            'priority' => 10,
            'callback' => array($this, 'dashboard_home_page_cb'),

        ]);
    }


    public function dashboard_home_page_cb()
    {
        require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/home.php';
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Home The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Dashboard_Home::get_instance();
