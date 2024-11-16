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
        add_action('init', array($this, 'create_venue_type_taxonomy'), 0);
        add_action('init', array($this, 'create_venue_service_taxonomy'), 0);
        add_action('init', array($this, 'create_venue_setting_taxonomy'), 0);

        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
    }

    /**
     * Registers the 'venue' post type.
     *
     * @since 0.1.0
     */
    public function register_venue_post_type()
    {
        $labels = array(
            'name'                  => _x('Venues', 'Post type general name', 'wedding-venue-listings'),
            'singular_name'         => _x('Venue', 'Post type singular name', 'wedding-venue-listings'),
            'menu_name'             => _x('Venues', 'Admin Menu text', 'wedding-venue-listings'),
            'name_admin_bar'        => _x('Venue', 'Add New on Toolbar', 'wedding-venue-listings'),
            'add_new'               => __('Add New', 'wedding-venue-listings'),
            'add_new_item'          => __('Add New Venue', 'wedding-venue-listings'),
            'new_item'              => __('New Venue', 'wedding-venue-listings'),
            'edit_item'             => __('Edit Venue', 'wedding-venue-listings'),
            'view_item'             => __('View Venue', 'wedding-venue-listings'),
            'all_items'             => __('All Venues', 'wedding-venue-listings'),
            'search_items'          => __('Search Venues', 'wedding-venue-listings'),
            'parent_item_colon'     => __('Parent Venues:', 'wedding-venue-listings'),
            'not_found'             => __('No venues found.', 'wedding-venue-listings'),
            'not_found_in_trash'    => __('No venues found in Trash.', 'wedding-venue-listings'),
            'featured_image'        => _x('Venue Cover Image', 'Overrides the “Featured Image” phrase for this post type.', 'wedding-venue-listings'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase.', 'wedding-venue-listings'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase.', 'wedding-venue-listings'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase.', 'wedding-venue-listings'),
            'archives'              => _x('Venue archives', 'The post type archive label', 'wedding-venue-listings'),
            'insert_into_item'      => _x('Insert into venue', 'Overrides the “Insert into post” phrase.', 'wedding-venue-listings'),
            'uploaded_to_this_item' => _x('Uploaded to this venue', 'Overrides the “Uploaded to this post” phrase.', 'wedding-venue-listings'),
            'filter_items_list'     => _x('Filter venues list', 'Screen reader text for the filter links', 'wedding-venue-listings'),
            'items_list_navigation' => _x('Venues list navigation', 'Screen reader text for pagination', 'wedding-venue-listings'),
            'items_list'            => _x('Venues list', 'Screen reader text for the items list', 'wedding-venue-listings'),
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
     * Registers the 'venue_type' taxonomy for the 'venue' post type.
     *
     * @since 0.1.0
     */
    public  function create_venue_type_taxonomy()
    {
        $labels = array(
            'name'              => _x('Venue Types', 'taxonomy general name', 'wedding-venue-listings'),
            'singular_name'     => _x('Venue Type', 'taxonomy singular name', 'wedding-venue-listings'),
            'search_items'      => __('Search Venue Types', 'wedding-venue-listings'),
            'all_items'         => __('All Venue Types', 'wedding-venue-listings'),
            'parent_item'       => null, // Remove parent item to disable hierarchy
            'parent_item_colon' => null,
            'edit_item'         => __('Edit Venue Type', 'wedding-venue-listings'),
            'update_item'       => __('Update Venue Type', 'wedding-venue-listings'),
            'add_new_item'      => __('Add New Venue Type', 'wedding-venue-listings'),
            'new_item_name'     => __('New Venue Type Name', 'wedding-venue-listings'),
            'menu_name'         => __('Venue Types', 'wedding-venue-listings'),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'venue-type'),
        );
        register_taxonomy('venue_type', array('venue'), $args);
    }

    /**
     * Registers the 'venue_service' taxonomy for the 'venue' post type.
     *
     * @since 0.1.0
     */
    public function create_venue_service_taxonomy()
    {
        $labels = array(
            'name'              => _x('Venue Services', 'taxonomy general name', 'wedding-venue-listings'),
            'singular_name'     => _x('Venue Service', 'taxonomy singular name', 'wedding-venue-listings'),
            'search_items'      => __('Search Venue Services', 'wedding-venue-listings'),
            'all_items'         => __('All Venue Services', 'wedding-venue-listings'),
            'parent_item'       => null, // Remove parent item to disable hierarchy
            'parent_item_colon' => null,
            'edit_item'         => __('Edit Venue Service', 'wedding-venue-listings'),
            'update_item'       => __('Update Venue Service', 'wedding-venue-listings'),
            'add_new_item'      => __('Add New Venue Service', 'wedding-venue-listings'),
            'new_item_name'     => __('New Venue Service Name', 'wedding-venue-listings'),
            'menu_name'         => __('Venue Services', 'wedding-venue-listings'),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'venue-type'),
        );
        register_taxonomy('venue_service', array('venue'), $args);
    }

    /**
     * Registers the 'venue_setting' taxonomy for the 'venue' post type.
     *
     * @since 0.1.0
     */
    public function create_venue_setting_taxonomy()
    {
        $labels = array(
            'name'              => _x('Venue Settings', 'taxonomy general name', 'wedding-venue-listings'),
            'singular_name'     => _x('Venue Setting', 'taxonomy singular name', 'wedding-venue-listings'),
            'search_items'      => __('Search Venue Settings', 'wedding-venue-listings'),
            'all_items'         => __('All Venue Settings', 'wedding-venue-listings'),
            'parent_item'       => null, // Remove parent item to disable hierarchy
            'parent_item_colon' => null,
            'edit_item'         => __('Edit Venue Setting', 'wedding-venue-listings'),
            'update_item'       => __('Update Venue Setting', 'wedding-venue-listings'),
            'add_new_item'      => __('Add New Venue Setting', 'wedding-venue-listings'),
            'new_item_name'     => __('New Venue Setting Name', 'wedding-venue-listings'),
            'menu_name'         => __('Venue Settings', 'wedding-venue-listings'),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'venue-type'),
        );
        register_taxonomy('venue_setting', array('venue'), $args);
    }

    public function admin_scripts()
    {
        if (is_admin()) {
            wp_enqueue_script('wvl-admin', WVL_PLUGIN_URL . '/assets/admin/wvl-admin.js', [], '1.0', true);
            wp_enqueue_style('wvl-admin', WVL_PLUGIN_URL . '/assets/admin/wvl-admin.css', [], '1.0');
        }
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


function remove_post_and_venue_admin_menu()
{
    // Remove "Posts"
    remove_menu_page('edit.php');

    // Remove "Venue" (custom post type)
    remove_menu_page('edit.php?post_type=venue');
}
// add_action('admin_menu', 'remove_post_and_venue_admin_menu', 999);
