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
    return $wpdb->insert(
        $table_name,
        [
            'user_id' => $data['user_id'],
            'venue_id' => $data['venue_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'city' => $data['city'],
            'message' => $data['message'],
            'booking_date' => $data['date']
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

function wvl_get_contact_count()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form';
    if ($venue_id = wvl_get_venue_id()) {
        $count = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE venue_id = %d",
                $venue_id
            )
        );
    } else {
        $current_user_id = get_current_user_id();
        $count = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE user_id = %d",
                $current_user_id
            )
        );
    }
    return intval($count);
}


/**
 * Retrieves the IP address of the current user.
 *
 * @return string The IP address of the current user.
 */
function wvl_get_user_ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $ip = explode(',', $ip);
        $ip = trim($ip[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}



/**
 * Inserts a booking date for a given venue.
 *
 * @param int $venue_id The ID of the venue to book.
 * @param string $date The date of the booking in the format 'Y-m-d'.
 * @param string $title The title of the event.
 * @param string $location The location of the event.
 *
 * @return bool Whether the booking date was inserted successfully.
 */
function wvl_insert_booking_date($venue_id, $date, $title = '', $location = '')
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'venue_bookings';
    return $wpdb->insert(
        $table_name,
        [
            'venue_id'    => $venue_id,
            'booked_date' => $date,
            'title'       => $title,
            'location'    => $location,
        ],
        ['%d', '%s', '%s', '%s']
    );
}


function wvl_get_booked_dates($venue_id, $start_date, $end_date)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'venue_bookings';
    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT title, location, booked_date as date FROM $table_name WHERE venue_id = %d AND booked_date BETWEEN %s AND %s",
            $venue_id,
            $start_date,
            $end_date
        )
    );
}


function wvl_delete_booked_date($venue_id, $date)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'venue_bookings';
    return $wpdb->delete($table_name, ['venue_id' => $venue_id, 'booked_date' => $date]);
}

function wvl_is_booked_date($venue_id, $date)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'venue_bookings';
    return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE venue_id = %d AND booked_date = %s", $venue_id, $date));
}


class WVL_Venue_Query
{
    private $args;
    private $results;
    private $current_post = -1;
    private $total_count;

    public function __construct($args = [])
    {
        $default_args = [
            'dates' => [],
            'category_ids' => [],
            'taxonomy_terms' => [],
            'order_by_mime_type' => false,
            'paged' => 1,
            'posts_per_page' => 10,
        ];
        $this->args = wp_parse_args($args, $default_args);
        $this->query();
    }

    private function query()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'venue_bookings';
        $post_type = 'venue';

        $join_taxonomy = '';
        $where_conditions = ["p.post_type = %s", "p.post_status = 'publish'"];
        $query_params = [$post_type];

        // Handle dates
        if (!empty($this->args['dates'])) {
            $sanitized_dates = array_map('sanitize_text_field', $this->args['dates']);
            $date_placeholders = "'" . implode("','", $sanitized_dates) . "'";
            $where_conditions[] = "p.ID NOT IN (
                SELECT venue_id
                FROM {$table_name}
                WHERE booked_date IN ($date_placeholders)
            )";
        }

        // Handle categories
        if (!empty($this->args['category_ids'])) {
            $sanitized_category_ids = array_map('intval', $this->args['category_ids']);
            $category_placeholders = implode(',', $sanitized_category_ids);
            $join_taxonomy .= "
                INNER JOIN {$wpdb->term_relationships} tr1 ON p.ID = tr1.object_id
                INNER JOIN {$wpdb->term_taxonomy} tt1 ON tr1.term_taxonomy_id = tt1.term_taxonomy_id";
            $where_conditions[] = "tt1.taxonomy = 'category' AND tt1.term_id IN ($category_placeholders)";
        }

        // Handle custom taxonomy
        if (!empty($this->args['taxonomy_terms'])) {
            $sanitized_taxonomy_terms = array_map('sanitize_text_field', $this->args['taxonomy_terms']);
            $taxonomy_placeholders = "'" . implode("','", $sanitized_taxonomy_terms) . "'";
            $join_taxonomy .= "
                INNER JOIN {$wpdb->term_relationships} tr2 ON p.ID = tr2.object_id
                INNER JOIN {$wpdb->term_taxonomy} tt2 ON tr2.term_taxonomy_id = tt2.term_taxonomy_id";
            $where_conditions[] = "tt2.taxonomy = 'support_location' AND tt2.term_id IN ($taxonomy_placeholders)";
        }

        // Build ORDER BY clause
        $order_by_clause = $this->args['order_by_mime_type'] ? "ORDER BY p.post_mime_type ASC" : "ORDER BY p.post_date DESC";

        // Combine WHERE conditions
        $where_clause = implode(' AND ', $where_conditions);

        // Pagination
        $offset = ($this->args['paged'] - 1) * $this->args['posts_per_page'];
        $limit_clause = "LIMIT %d OFFSET %d";

        // Query for total count
        $count_query = "
            SELECT COUNT(DISTINCT p.ID)
            FROM {$wpdb->posts} p
            $join_taxonomy
            WHERE $where_clause
        ";
        $this->total_count = $wpdb->get_var($wpdb->prepare($count_query, $query_params));

        // Main query
        $query = "
            SELECT DISTINCT p.ID, p.post_title, p.post_mime_type
            FROM {$wpdb->posts} p
            $join_taxonomy
            WHERE $where_clause
            $order_by_clause
            $limit_clause
        ";

        $query_params[] = intval($this->args['posts_per_page']);
        $query_params[] = intval($offset);
        $prepared_query = $wpdb->prepare($query, ...$query_params); // Unpack $query_params
        $this->results = $wpdb->get_results($prepared_query);
    }


    public function have_posts()
    {
        return $this->current_post + 1 < count($this->results);
    }

    public function the_post()
    {
        $this->current_post++;
        return $this->results[$this->current_post] ?? null;
    }

    public function get_total_count()
    {
        return $this->total_count;
    }

    public function rewind_posts()
    {
        $this->current_post = -1;
    }
}
