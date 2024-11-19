
<?php
defined('ABSPATH') || exit;

class WVL_Dashboard_Gallery
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard_Gallery
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


    /**
     * Renders the Gallery menu item in the Wedding Venue Listings dashboard menu.
     *
     * The Gallery menu item is available to venues with a premium subscription and
     * displays the gallery of the venue. It uses an Envira icon and is set with
     * a priority of 40.
     *
     * @return void
     */
    public function render_wvl_dashboard_menu()
    {
        add_wvl_menu([
            'name'     => 'Gallery',
            'slug'     => 'gallery',
            'icon'     => '<i class="fa-brands fa-envira text-xl" style="color: #1f72b2;"></i>',
            'premium'  => false,
            'priority' => 40,
            'callback' => array($this, 'gallery_page_cb'),
        ]);
    }


    /**
     * Callback function for the Gallery menu item in the Wedding Venue Listings dashboard menu.
     *
     * Requires the gallery.php template file in the template-parts/dashboard directory.
     *
     * @return void
     */
    public function gallery_page_cb()
    {
        require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/gallery.php';
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard_Gallery The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Dashboard_Gallery::get_instance();
