<?php
defined('ABSPATH') || exit;

/**
 * WVL_Venue class
 */
class WVL_Venue
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Venue
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
        add_action('init', array($this, 'register_venue_post_type'));
    }



    public function register_venue_post_type()
    {
        $labels = array(
            'name'                  => _x('Venues', 'Post type general name', 'textdomain'),
            'singular_name'         => _x('Venue', 'Post type singular name', 'textdomain'),
            'menu_name'             => _x('Venues', 'Admin Menu text', 'textdomain'),
            'name_admin_bar'        => _x('Venue', 'Add New on Toolbar', 'textdomain'),
            'add_new'               => __('Add New', 'textdomain'),
            'add_new_item'          => __('Add New Venue', 'textdomain'),
            'new_item'              => __('New Venue', 'textdomain'),
            'edit_item'             => __('Edit Venue', 'textdomain'),
            'view_item'             => __('View Venue', 'textdomain'),
            'all_items'             => __('All Venues', 'textdomain'),
            'search_items'          => __('Search Venues', 'textdomain'),
            'parent_item_colon'     => __('Parent Venues:', 'textdomain'),
            'not_found'             => __('No venues found.', 'textdomain'),
            'not_found_in_trash'    => __('No venues found in Trash.', 'textdomain'),
            'featured_image'        => _x('Venue Cover Image', 'Overrides the “Featured Image” phrase for this post type.', 'textdomain'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase.', 'textdomain'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase.', 'textdomain'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase.', 'textdomain'),
            'archives'              => _x('Venue archives', 'The post type archive label', 'textdomain'),
            'insert_into_item'      => _x('Insert into venue', 'Overrides the “Insert into post” phrase.', 'textdomain'),
            'uploaded_to_this_item' => _x('Uploaded to this venue', 'Overrides the “Uploaded to this post” phrase.', 'textdomain'),
            'filter_items_list'     => _x('Filter venues list', 'Screen reader text for the filter links', 'textdomain'),
            'items_list_navigation' => _x('Venues list navigation', 'Screen reader text for pagination', 'textdomain'),
            'items_list'            => _x('Venues list', 'Screen reader text for the items list', 'textdomain'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'venue'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-location',
            'supports'           => array('title', 'thumbnail', 'excerpt', 'comments'),
            'show_in_rest'       => true,
            'taxonomies'         => array('category'),
        );

        register_post_type('venue', $args);
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Venue The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

WVL_Venue::get_instance();
