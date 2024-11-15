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
        add_filter('template_include', array($this, 'venue_single_template'));
    }


    /**
     * Modifies the page template for the 'listing' page.
     *
     * @param string $page_template The path to the page template.
     * @return string The modified path to the page template if on the 'listing' page.
     */
    public function listing_page_template($page_template)
    {
        if (is_page('listing')) {
            $page_template = WVL_PLUGIN_DIR . '/templates/listing.php';
        }
        return $page_template;
    }


    /**
     * Modifies the single template for the 'venue' post type.
     *
     * @param string $template The path to the single template.
     * @return string The modified path to the single template if on the 'venue' post type.
     */
    public function venue_single_template($template)
    {
        if (is_singular('venue')) {
            $plugin_template = WVL_PLUGIN_DIR . '/templates/single-venue.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }
        return $template;
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
