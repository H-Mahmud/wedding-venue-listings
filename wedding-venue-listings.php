<?php
/*
 * Plugin Name:       Wedding Venue Listings
 * Plugin URI:        https://github.com/H-Mahmud/wedding-venue-listings
 * Description:       A versatile plugin for wedding venue listings, enabling owners to create detailed profiles with media and booking info. Visitors can search, filter by category and location, view ratings, and leave reviews.
 * Version:           1.0
 * Requires at least: 6.6
 * Requires PHP:      7.2
 * Author:            Mahmudul Hasan
 * Author URI:        https://imahmud.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wedding-venue-listings
 * Domain Path:       /languages
 */
defined('ABSPATH') || exit;

// Define plugin constants
defined('WVl_PLUGIN_FILE') || define('WVl_PLUGIN_FILE', __FILE__);
defined('WVl_PLUGIN_DIR') || define('WVl_PLUGIN_DIR', plugin_dir_path(__FILE__));
defined('WVl_PLUGIN_URL') || define('WVl_PLUGIN_URL', plugin_dir_url(__FILE__));

// dependencies
require_once WVl_PLUGIN_DIR . 'includes/class-account.php';
