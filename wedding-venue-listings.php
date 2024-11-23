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
defined('WVL_PLUGIN_FILE') || define('WVL_PLUGIN_FILE', __FILE__);
defined('WVL_PLUGIN_DIR') || define('WVL_PLUGIN_DIR', plugin_dir_path(__FILE__));
defined('WVL_PLUGIN_URL') || define('WVL_PLUGIN_URL', plugin_dir_url(__FILE__));

defined('WVL_DEVELOPMENT') || define('WVL_DEVELOPMENT', true);

add_action('init', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}, 1);

// dependencies
require_once WVL_PLUGIN_DIR . 'template-tags.php';
require_once WVL_PLUGIN_DIR . 'includes/wvl-functions.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-home.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-profile.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-contact.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-gallery.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-availability.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-analytics.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-account.php';
require_once WVL_PLUGIN_DIR . 'includes/class-account-auth.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard.php';
require_once WVL_PLUGIN_DIR . 'includes/class-venue.php';
require_once WVL_PLUGIN_DIR . 'includes/class-listing.php';
