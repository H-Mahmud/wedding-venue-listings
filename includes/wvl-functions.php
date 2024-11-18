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
