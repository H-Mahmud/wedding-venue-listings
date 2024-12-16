<?php
$page_id = wvl_get_venue_id();
$paged = (get_query_var('cpage')) ? absint(get_query_var('cpage')) : 1;
$comments_per_page = 5;

$args = array(
    'post_id' => $page_id,
    'status'  => 'approve',
    'parent'  => 0,
    'number'  => $comments_per_page,
    'offset'  => ($paged - 1) * $comments_per_page,
    'orderby' => 'comment_date',
    'order'   => 'DESC',
);

$comments = get_comments($args);

if ($comments) {
    echo '<div class="review-list mb-7">';
    foreach ($comments as $comment) {
?>

        <div class="message my-2">
            <?php do_action('wvl_notice', 'wvl_review_reply_form'); ?>
        </div>

        <div class="review-item flex gap-8 mb-6 mt-3" id="comment-<?php echo $comment->comment_ID; ?>">
            <div class="avatar w-20 h-20 max-w-20 rounded-lg border flex-1">
                <?php
                $local_avatar = get_user_meta($comment->user_id, 'simple_local_avatar', true);
                if ($local_avatar) {
                    echo wp_get_attachment_image($local_avatar, 'thumbnail', '', ['class' => 'rounded-lg h-full w-full object-cover']);
                } else {
                    echo get_avatar($comment->user_id, 112, '', __('Upload Avatar'), ['class' => 'rounded-lg h-full w-full object-cover']);
                }
                ?>
            </div>
            <div class="flex-1">
                <div class="content bg-gray-100 p-4 rounded-lg">
                    <div class="meta flex justify-between mb-2">
                        <div class="info"><span class="name font-medium"><?php echo $comment->comment_author; ?></span> -
                            <span class="date"><?php echo get_comment_date('F j, Y', $comment->comment_ID); ?></span>
                        </div>
                        <div class="rating">
                            <star-rating min="0" max="5" value="<?php echo get_comment_meta($comment->comment_ID, 'rating', true); ?>"></star-rating>
                        </div>
                    </div>
                    <h4 class="font-semibold"><?php echo get_comment_meta($comment->comment_ID, 'title', true); ?></h4>
                    <p>
                        <?php echo get_comment_text($comment); ?>
                    </p>
                    <a class="text-blue-700 open-modal-btn" data-target="#modal-<?php echo $comment->comment_ID; ?>" href="#comment-<?php echo $comment->comment_ID; ?>" class="reply-btn"><?php _e('Reply', 'wedding-venue-listings'); ?></a>
                </div>
                <?php
                $args_replies = array(
                    'post_id' => $page_id,
                    'status' => 'approve',
                    'parent' => $comment->comment_ID,
                );
                $replies = get_comments($args_replies);

                if ($replies && $replies[0]) {
                    wvl_review_reply_form($page_id, $comment->comment_ID, $replies[0]->comment_ID);
                } else {
                    wvl_review_reply_form($page_id, $comment->comment_ID);
                }


                if ($replies) {
                    foreach ($replies as $reply) { ?>
                        <div class="review-item flex gap-8 mt-6" id="comment-<?php echo $reply->comment_ID; ?>">
                            <div class="avatar w-20 h-20 max-w-20 rounded-lg border flex-1">
                                <?php
                                $local_avatar = get_user_meta($reply->user_id, 'simple_local_avatar', true);
                                if ($local_avatar) {
                                    echo wp_get_attachment_image($local_avatar, 'thumbnail', '', ['class' => 'rounded-lg h-full w-full object-cover']);
                                } else {
                                    echo get_avatar($reply->user_id, 112, '', __('Upload Avatar'), ['class' => 'rounded-lg h-full w-full object-cover']);
                                }
                                ?>
                            </div>
                            <div class="content flex-1 bg-gray-100 p-4 rounded-lg">
                                <div class="meta flex justify-between mb-2">
                                    <div class="info"><span class="name font-medium"><?php echo get_comment_author_link($reply->comment_ID); ?></span> -
                                        <span class="date"><?php echo get_comment_date('F j, Y', $reply->comment_ID); ?></span>
                                    </div>
                                </div>
                                <p><?php echo get_comment_text($reply); ?></p>

                                <a class="text-blue-700 open-modal-btn" data-target="#modal-<?php echo $comment->comment_ID; ?>" href="#comment-<?php echo $comment->comment_ID; ?>" class="reply-btn"><?php _e('Edit', 'wedding-venue-listings'); ?></a>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>

<?php
    }
    echo '</div>';

    $total_comments = get_comments(array(
        'post_id' => $page_id,
        'status'  => 'approve',
        'parent'  => 0,
        'count'   => true,
    ));

    $total_pages = ceil($total_comments / $comments_per_page);

    $current_page = (get_query_var('cpage')) ? absint(get_query_var('cpage')) : 1;
    custom_comments_pagination($total_pages, $current_page);
} else {
    echo '<p class="text-center my-8 text-2xl font-medium">No Reviews yet.</p>';
}
?>

</div>




<?php
$user_id = get_current_user_id();
$user_comments = get_comments([
    'user_id' => $user_id,
    'post_id' => get_the_ID(),
]);

$comment_text = '';
$comment_title = '';
$rating_amount = 1;
$comment_id = '';
if (!empty($user_comments)) {
    $comment_text = $user_comments[0]->comment_content;
    $comment_title = get_comment_meta($user_comments[0]->comment_ID, 'title', true);
    $rating_amount = get_comment_meta($user_comments[0]->comment_ID, 'rating', true);
    $comment_id = $user_comments[0]->comment_ID;
}
?>


<?php
function custom_comments_pagination($total_pages, $current_page)
{

    if ($total_pages > 1) {
        echo '<div class="text-center mb-8 wvl-comments-pagination">';
        echo '<ul class="inline-flex -space-x-px text-sm">';

        if ($current_page > 1) {
            echo '<li><a  class="page-links" href="' . wlv_get_review_dashboard_page_link($current_page - 1) . '" class="page-numbers arrow-prev"><i class="fa-solid fa-angles-left"></i></a></li>';
        } else {
            echo <<<HTML
             <li class="page-links"><i class="fa-solid fa-angles-left"></i></li>
            HTML;
        }

        if ($current_page > 3) {
            echo '<li><a class="page-links page-numbers" href="' . wlv_get_review_dashboard_page_link(1) . '"> ' . number_format_i18n(1) . '</a></li>';
            echo '<li class="page-dots">...</li>';
        }

        for ($i = max(1, $current_page - 1); $i <= min($current_page + 1, $total_pages); $i++) {
            if ($i === $current_page) {
                echo '<li><span class="page-links current">' . number_format_i18n($i) . '</span></li>';
            } else {
                echo '<li><a class="page-links" href="' . wlv_get_review_dashboard_page_link($i) . '">' . number_format_i18n($i) . '</a></li>';
            }
        }

        if ($current_page < $total_pages - 2) {
            echo '<li class="page-dots">...</li>';
            echo '<li><a class="page-links" href="' . wlv_get_review_dashboard_page_link($total_pages) . '">' . number_format_i18n($total_pages) . '</a></li>';
        }

        if ($current_page < $total_pages) {
            echo '<li><a class="page-links" href="' . wlv_get_review_dashboard_page_link($current_page + 1) . '" class="page-numbers arrow-prev"><i class="fa-solid fa-angles-right"></i></a></li>';
        } else {
            echo <<<HTML
             <li class="page-links"><i class="fa-solid fa-angles-right"></i></li>
            HTML;
        }
        echo '</ul>';
        echo '</div>';
    }
}


function wlv_get_review_dashboard_page_link($page_number = 1)
{
    $url = site_url('dashboard/reviews');
    if (isset($_GET) && count($_GET) > 0) {
        $new_query_params = $_GET;
        $new_query_params['cpage'] = $page_number;
        return add_query_arg($new_query_params, $url);
    } else {
        return add_query_arg('cpage', $page_number, $url);
    }
}

function wvl_review_reply_form($post_id, $parent_comment_id, $comment_id = '')
{
    $comment_text = '';
    if ($comment_id) {
        $comment_text = get_comment_text($comment_id);
    }
?>

    <div id="modal-<?php echo $parent_comment_id; ?>" class="wvl-modal" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-box" role="document">
            <div class="modal-inner">
                <div class="modal-header">
                    <h3 class="modal-title"><?php if ($comment_id) _e('Edit Reply', 'wedding-venue-listings');
                                            else _e('Add Reply', 'wedding-venue-listings'); ?></h3>
                    <button type="button" class="close-btn" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form method="post">
                    <div class="modal-content">
                        <?php wp_nonce_field('wvl_review_reply_nonce', 'wvl_review_reply_nonce'); ?>
                        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                        <input type="hidden" id="venue_id" name="venue_id" value="<?php echo $post_id; ?>">
                        <input type="hidden" id="parent_comment_id" name="parent_id" value="<?php echo $parent_comment_id; ?>">

                        <div class="wvl-field">
                            <textarea name="comment_content" placeholder="<?php _e('Your reply', 'wedding-venue-listings'); ?>"><?php echo $comment_text; ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="wvl-btn-secondary cancel-btn"><?php _e('Cancel', 'wedding-venue-listings'); ?></button>
                        <button type="submit" class="wvl-btn-primary submit-btn" name="submit_review_reply"><?php _e('Submit', 'wedding-venue-listings'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
}
