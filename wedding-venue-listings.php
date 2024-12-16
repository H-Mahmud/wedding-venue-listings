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

require_once WVL_PLUGIN_DIR . 'init.php';

defined('WVL_DEVELOPMENT') || define('WVL_DEVELOPMENT', true);

add_action('init', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}, 1);

// dependencies
require_once WVL_PLUGIN_DIR . 'classes/class-subscription-manage.php';
require_once WVL_PLUGIN_DIR . 'template-tags.php';
require_once WVL_PLUGIN_DIR . 'includes/wvl-functions.php';

require_once WVL_PLUGIN_DIR . 'classes/abstract-wvl-update-venue.php';
require_once WVL_PLUGIN_DIR . 'classes/abstract-wvl-get-venue.php';
require_once WVL_PLUGIN_DIR . 'classes/class-wvl-venue.php';

require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-home.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-profile.php';
// require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-contact.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-availability.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-analytics.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard-account.php';
require_once WVL_PLUGIN_DIR . 'includes/public/customer/dashboard-reviews.php';
require_once WVL_PLUGIN_DIR . 'includes/public/customer/dashboard-contacts.php';
require_once WVL_PLUGIN_DIR . 'includes/class-account-auth.php';
require_once WVL_PLUGIN_DIR . 'includes/class-dashboard.php';
require_once WVL_PLUGIN_DIR . 'includes/class-venue-admin.php';
require_once WVL_PLUGIN_DIR . 'includes/class-venue-review.php';
require_once WVL_PLUGIN_DIR . 'includes/class-listing.php';
require_once WVL_PLUGIN_DIR . 'shortcodes/venue-landing.php';
require_once WVL_PLUGIN_DIR . 'shortcodes/user-profile.php';

require_once WVL_PLUGIN_DIR . 'analytics/class-venue-analytics.php';

add_action('wvl_notice', function ($source) {
    if (isset($_SESSION['wvl_notice'])) {
        $notification = $_SESSION['wvl_notice'];

        if ($notification['source'] != $source) {
            return;
        }

        if ($_SESSION['wvl_notice']['type'] == 'success') {
            echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">' . $notification['message'] . '</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3"></span>
            </div>';
            unset($_SESSION['wvl_notice']);
        } else if ($_SESSION['wvl_notice']['type'] == 'error') {
            echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">' . $notification['message'] . '</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3"></span>
            </div>';
            unset($_SESSION['wvl_notice']);
        }
    }
});



add_action('wp_enqueue_scripts', 'wvl_enqueue_scripts', 20);
function wvl_enqueue_scripts()
{

    wp_enqueue_style('font-awesome-v6',  WVL_PLUGIN_URL . '/assets/lib/font-awesome/css/all.min.css', [], '6.7.1');

    wp_enqueue_script('air-datepicker', WVL_PLUGIN_URL . '/assets/lib/air-datepicker/datepicker.min.js');
    wp_enqueue_script('air-datepicker-en', WVL_PLUGIN_URL . '/assets/lib/air-datepicker/i18n/datepicker.en.min.js');
    wp_enqueue_style('air-datepicker',  WVL_PLUGIN_URL . '/assets/lib/air-datepicker/datepicker.min.css');

    wp_enqueue_script('lightgallery', WVL_PLUGIN_URL . '/assets/lib/lightgallery/js/lightgallery-all.min.js', array('jquery'), '1.10.0', true);
    wp_enqueue_style('lightgallery', WVL_PLUGIN_URL . '/assets/lib/lightgallery/css/lightgallery.min.css', array(), '1.10.0');




    if (defined('WVL_DEVELOPMENT') && WVL_DEVELOPMENT) {
        // $dev_server_url = 'http://localhost:3000';
        $dev_server_url = WVL_PLUGIN_URL . '/assets/dist';

        wp_enqueue_style('wvl-style', $dev_server_url . '/style.min.css', array(), time());

        wp_enqueue_script('wvl-main', $dev_server_url . '/main.bundle.js', array('jquery'), time(), true);

        if (is_page('dashboard')) {
            wp_enqueue_script('wvl-dashboard',  $dev_server_url . '/dashboard.bundle.js', array('jquery'), time(), true);
        }
    } else {
        wp_enqueue_style('wvl-style', WVL_PLUGIN_URL . '/assets/dist/style.min.css', array(), '1.0');

        wp_enqueue_script('wvl-main',  WVL_PLUGIN_URL . '/assets/dist/main.bundle.js', array('jquery'), time(), true);

        if (is_page('dashboard')) {
            wp_enqueue_script('wvl-dashboard', WVL_PLUGIN_URL . '/assets/dist/dashboard.bundle.min.js', array('jquery'), '1.0', true);
        }
    }



    // Environment Independent scripts
    if (is_page('dashboard')) {
        wp_enqueue_script('choices.js', WVL_PLUGIN_URL . '/assets/lib/choices.js/js/choices.min.js', array('jquery'), null, true);
        wp_enqueue_style('choices.js', WVL_PLUGIN_URL . '/assets/lib/choices.js/css/choices.min.css');
        wp_enqueue_script('fullcalendar', WVL_PLUGIN_URL . '/assets/lib/fullcalendar/index.global.min.js', [], '6.1.15', true);

        wp_enqueue_script('chart.js',  WVL_PLUGIN_URL . '/assets/lib/chart/chart.umd.js', [], '4.4.7', true);

        wp_enqueue_script('tinymce');
        wp_enqueue_script('wp-tinymce');


        $venue_id = wvl_get_venue_id();
        $venue_status = get_post_status($venue_id);
        $data = [
            'ajax_url'      => admin_url('admin-ajax.php'),
            'ajax_nonce'    => wp_create_nonce('dashboard_nonce'),
            'venue_status'  => $venue_status
        ];

        wp_localize_script('wvl-dashboard', 'WVL_DATA', $data);
    }



    // wp_enqueue_style('nepali-date-picker', WVL_PLUGIN_URL . '/assets/css/nepali-date-picker.css');
    // wp_enqueue_style('wvl-style', WVL_PLUGIN_URL . '/assets/css/wvl-style.css');

    // wp_enqueue_script('chart-js', WVL_PLUGIN_URL . '/assets/js/chart.js', array(), null, true);
    // wp_enqueue_script('nepali-date-picker', WVL_PLUGIN_URL . '/assets/js/nepali-date-picker.js', ['jquery'], false, true);
    // wp_enqueue_script('wvl-main', WVL_PLUGIN_URL . '/assets/js/wvl-main.js', array('jquery'), '1.0', true);




    // wp_localize_script('wvl-main', 'WVL_MAIN', [
    //     'ajax_url' => admin_url('admin-ajax.php'),
    // ]);
}
