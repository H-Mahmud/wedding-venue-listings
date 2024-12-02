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
    $args = array(
        'post_id' => $page_id, // The ID of the page you want to fetch comments for
        'status' => 'approve', // Only approved comments
        'parent' => 0, // Only top-level comments (no replies)
        'number' => 10, // Number of comments per page
    );

    // Fetch the comments
    $comments = get_comments($args);

    if ($comments) {
        echo '<ul class="comment-list">';
        foreach ($comments as $comment) {
            echo '<li id="comment-' . $comment->comment_ID . '" class="comment-item">';
            echo '<div class="comment-author">' . get_comment_author_link($comment) . '</div>';
            echo '<h3 class="title text-2xl">' . get_comment_meta($comment->comment_ID, 'title', true) . '</h3>';
            echo '<star-rating min="0" max="5" value="' . get_comment_meta($comment->comment_ID, 'rating', true) . '"></star-rating>';
            echo '<div class="comment-content">' . get_comment_text($comment) . '</div>';

            // Get and display replies (single depth)
            $args_replies = array(
                'post_id' => $page_id,
                'status' => 'approve',
                'parent' => $comment->comment_ID, // Get replies to this comment
            );
            $replies = get_comments($args_replies);

            if ($replies) {
                echo '<ul class="reply-list">';
                foreach ($replies as $reply) {
                    echo '<li id="comment-' . $reply->comment_ID . '" class="reply-item">';
                    echo '<div class="comment-author">' . get_comment_author_link($reply) . '</div>';
                    echo '<div class="comment-content">' . get_comment_text($reply) . '</div>';
                    echo '</li>';
                }
                echo '</ul>';
            }

            echo '</li>';
        }
        echo '</ul>';

        // Pagination for comments
        echo '<div class="comment-pagination">';
        paginate_comments_links(array(
            'type' => 'list', // This will generate a list of pagination links
            'prev_text' => '&laquo; Previous',
            'next_text' => 'Next &raquo;',
            'total' => ceil(count($comments) / 10), // Total pages
            'current' => 1, // Start at the first page
        ));
        echo '</div>';
    } else {
        echo '<p>No comments yet.</p>';
    }
}

// Usage: Call the function for the specific page (replace 42 with your page ID)


// Custom Comment Form for Logged-In Users
function custom_comment_form()
{
    if (is_user_logged_in()) {
        include_once WVL_PLUGIN_DIR . 'template-parts/reviews/review-form.php';
    } else {
        echo '<p>You must be logged in to leave a comment.</p>';
    }
}

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
