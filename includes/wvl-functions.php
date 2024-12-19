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
        'capability' => '',
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

/**
 * Adds a notice to the session for displaying later.
 *
 * This function stores a notice message with a specified type
 * in the session, which can be rendered on the frontend using
 * the 'wvl_notice' action hook.
 *
 * @param string $message The message to be displayed in the notice.
 * @param string $type    Optional. The type of the notice. Either 'success' or 'error'. Default 'success'.
 */
function wvl_add_notice($message, $type = 'success', $source = '')
{
    $_SESSION['wvl_notice'] = [
        'message' => $message,
        'type' => $type,
        'source' => $source
    ];
}


function wvl_get_excerpt_content($post_id, $length = 180)
{
    // Get the post content
    $content = get_post_field('post_content', $post_id);

    $content = strip_tags(strip_shortcodes($content));

    if (strlen($content) > $length) {
        $content = substr($content, 0, $length) . '...';
    }

    return $content;
}

function wvl_get_venue_location($venue_id)
{
    return '1901 Thornridge Cir. Shiloh, Hawaii 81063';
}


add_action('wvl_social_links', function () {
    $post = get_post();
    if (wvl_current_plan($post->post_author) == 'free') return;

    $social_accounts = [
        'website' => [
            'label' => __('Website', 'wedding-venue-listings'),
            'placeholder' => 'https://www.yourwebsite.com',
            'icon' => 'fa-solid fa-globe',
            'value' => ''
        ],
        'facebook' => [
            'label' => __('Facebook', 'wedding-venue-listings'),
            'placeholder' => 'https://www.facebook.com/yourprofile',
            'icon' => 'fa-brands fa-facebook-f',
            'value' => ''
        ],
        'twitter' => [
            'label' => __('Twitter', 'wedding-venue-listings'),
            'placeholder' => 'https://www.twitter.com/yourprofile',
            'icon' => 'fa-brands fa-x-twitter',
            'value' => ''
        ],
        'instagram' => [

            'label' => __('Instagram', 'wedding-venue-listings'),
            'placeholder' => 'https://www.instagram.com/yourprofile',
            'icon' => 'fa-brands fa-instagram',
            'value' => ''
        ],
        'linkedin' => [
            'label' => __('LinkedIn', 'wedding-venue-listings'),
            'placeholder' => 'https://www.linkedin.com/in/yourprofile',
            'icon' => 'fa-brands fa-linkedin-in',
            'value' => ''
        ],
        'youtube' => [
            'label' => __('YouTube', 'wedding-venue-listings'),
            'placeholder' => 'https://www.youtube.com/@yourprofile',
            'icon' => 'fa-brands fa-square-youtube',
            'value' => ''
        ],
        'tiktok' => [
            'label' => __('TikTok', 'wedding-venue-listings'),
            'placeholder' => 'https://www.tiktok.com/@yourprofile',
            'icon' => 'fa-brands fa-tiktok',
            'value' => ''
        ],
    ];

    $get_social_links = get_post_meta(get_the_ID(), 'social_links', true);
    if (!$get_social_links) {
        $get_social_links = [];
    }

    $social_fields = [];
    foreach ($social_accounts as $key => $value) {
        $account_value = isset($get_social_links[$key]) && $get_social_links[$key]['value'] ? $get_social_links[$key]['value'] : '';
        if (!$account_value) continue;

        $social_fields[$key] = [
            'label' => $value['label'],
            'placeholder' => $value['placeholder'],
            'icon' => $value['icon'],
            'value' => $account_value
        ];
    }

    foreach ($social_fields as $key => $value) {

        $link = apply_filters('wvl_contact_link', $value['value'], $key);
?>
        <li>
            <a class="rounded-full w-11 h-11 flex justify-center items-center no-underline bg-[#F1F1F1]" href="<?php echo $link; ?>" target="_blank">
                <i class="<?php echo $value['icon']; ?>"></i>
            </a>
        </li>
<?php
    }
});



function add_verified_badge_to_venue_title($title, $post_id)
{
    $get_author_id = get_post_field('post_author', $post_id);
    if (is_admin() || get_post_type($post_id) !== 'venue' || wvl_current_plan($get_author_id) != 'ultimate') {
        return $title;
    }

    return $title . wvl_get_verified_badge();
}
add_filter('the_title', 'add_verified_badge_to_venue_title', 10, 2);


function wvl_get_verified_badge($size = 'medium')
{

    return '<span class="verified-badge ' . $size . '">
    <i class="fa-solid fa-certificate bg "></i>
    <i class="fa-solid fa-check mark"></i>
 </span>';
}
