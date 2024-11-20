<?php
defined('ABSPATH') || exit;

/**
 * Adds a new menu item to the Wedding Venue Listings dashboard menu.
 *
 * @param array $args {
 *     Array of arguments for the menu item.
 *
 *     @type string $name     The name of the menu item.
 *     @type string $slug     The slug of the menu item, used in the URL.
 *     @type string $icon     Optional icon class for the menu item.
 *     @type int    $priority The priority of the menu item, lower numbers are displayed first.
 *     @type callable $callback The callback function to run when the menu item is clicked.
 * }
 *
 * @return void
 */
function add_wvl_menu($args)
{
    $defaults = [
        'name'     => '',
        'slug'     => '',
        'icon'     => '',
        'premium'  => false,
        'priority' => 10,
        'callback' => '',
    ];

    $args = wp_parse_args($args, $defaults);

    if (empty($args['name']) || empty($args['slug']) || empty($args['callback'])) {
        return;
    }

    global $wvl_menus;
    if (!isset($wvl_menus)) {
        $wvl_menus = [];
    }

    $wvl_menus[] = $args;
    usort($wvl_menus, function ($a, $b) {
        return $a['priority'] - $b['priority'];
    });
}


/**
 * Retrieves terms of a specified taxonomy.
 *
 * This function fetches terms for the given taxonomy and returns them
 * as an associative array where the keys are the term slugs and the 
 * values are the term names.
 *
 * @param string $taxonomy The taxonomy from which to retrieve terms.
 * @param bool $hide_empty Optional. Whether to hide terms not assigned to any posts. Default false.
 *
 * @return array Associative array of terms with slugs as keys and names as values.
 */
function get_wvl_terms_options($taxonomy, $hide_empty = false)
{
    $vendor_types_object = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => $hide_empty,
    ));

    $vendor_types = [];

    foreach ($vendor_types_object as $vendor_type) {

        $term = ['value' => $vendor_type->slug, 'label' => $vendor_type->name];
        $vendor_types[] = $term;
    };

    return $vendor_types;
}
