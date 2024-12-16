<?php
defined('ABSPATH') || exit();

function wvl_get_venue_id($user_id = null)
{
    if ($user_id) {
        $current_user_id = $user_id;
    } else if (is_user_logged_in()) {
        $current_user_id = get_current_user_id();
    } else {
        return false;
    }
    $args = [
        'post_type'      => 'venue',
        'author'         => $current_user_id,
        'post_status'    => 'any',
        'numberposts'    => 1,
        'fields'         => 'ids'
    ];

    $post_ids = get_posts($args);
    if (count($post_ids))
        return $post_ids[0];

    return false;
}

function custom_comments_display($page_id)
{
    include_once WVL_PLUGIN_DIR . 'template-parts/reviews/review-list.php';
}

// Usage: Call the function for the specific page (replace 42 with your page ID)

function save_comment_title_and_rating($comment_id)
{
    if (isset($_POST['rating']) && !empty($_POST['rating'])) {
        $rating = sanitize_text_field($_POST['rating']);
        add_comment_meta($comment_id, 'rating', $rating);
    }

    if (isset($_POST['title']) && !empty($_POST['title'])) {
        $title = sanitize_text_field($_POST['title']);
        add_comment_meta($comment_id, 'title', $title);
    }
}
add_action('comment_post', 'save_comment_title_and_rating');


function wlv_get_review_page_link($page_number = 1)
{
    $url = get_the_permalink();
    if (isset($_GET) && count($_GET) > 0) {
        $new_query_params = $_GET;
        $new_query_params['cpage'] = $page_number;
        return add_query_arg($new_query_params, $url);
    } else {
        return add_query_arg('cpage', $page_number, $url);
    }
}

/**
 * TODO: Make it functional
 */
function wvl_get_venue_address($venue_id)
{
    return get_post_meta($venue_id, 'address', true);
}


/**
 * Retrieves the average rating of a given venue.
 *
 * @param int $venue_id The venue ID.
 *
 * @return float The average rating of the venue.
 */
function wvl_get_venue_average_rating($venue_id)
{
    return get_post_meta(get_the_ID(), 'average_rating', true);
}

/**
 * Displays the number of reviews for a given venue.
 *
 * @since 1.0.0
 */
function wvl_venue_review_count()
{
    $comment_count = get_comment_count(get_the_ID());

    printf(
        _n(
            '(%s Review)',
            '(%s Reviews)',
            $comment_count['approved'],
            'wedding-venue-listings'
        ),
        number_format_i18n($comment_count['approved'])
    );
}

function wvl_count_reviews_without_reply($post_id)
{
    global $wpdb;

    $post_id = intval($post_id);
    $query = $wpdb->prepare(
        "
        SELECT COUNT(parent.comment_ID)
        FROM $wpdb->comments AS parent
        WHERE parent.comment_post_ID = %d
        AND parent.comment_approved = 1
        AND parent.comment_parent = 0
        AND NOT EXISTS (
            SELECT 1
            FROM $wpdb->comments AS child
            WHERE child.comment_parent = parent.comment_ID
            AND child.comment_approved = 1
        )
        ",
        $post_id
    );

    // Execute the query
    $count = $wpdb->get_var($query);

    return intval($count);
}


function wvL_insert_contact_data($data)
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'contact_form';
    $wpdb->insert(
        $table_name,
        [
            'user_id' => $data['user_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'city' => $data['city'],
            'message' => $data['message'],
        ],
        [
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s'
        ]
    );
}
