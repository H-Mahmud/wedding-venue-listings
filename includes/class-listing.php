<?php
defined('ABSPATH') || exit;

/**
 * WVL_Listing class
 */
class WVL_Listing
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Listing
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
        add_filter('page_template', array($this, 'listing_page_template'));
    }


    public function listing_page_template($page_template)
    {
        if (is_page('listing')) {
            $page_template = WVL_PLUGIN_DIR . '/templates/listing.php';
        }
        return $page_template;
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Listing The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

WVL_Listing::get_instance();
