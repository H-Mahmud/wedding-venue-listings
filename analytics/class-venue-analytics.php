<?php
defined('ABSPATH') || exit;
/**
 * Venue Analytics class
 */
class WVL_Venue_Analytics
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Venue_Analytics
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
    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Venue_Analytics The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

WVL_Venue_Analytics::get_instance();
