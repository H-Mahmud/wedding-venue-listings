<?php
$user_id = get_current_user_id();
$user_comments = get_comments([
    'user_id'    => $user_id,
    'post_id'    => get_the_ID(),
    'number'     => 1,
    'parent'  => 0,
    'orderby'    => 'comment_ID',
    'order'      => 'DESC',
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
<div id="modal-review-form" class="wvl-modal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-box" role="document">
        <div class="modal-inner md:min-w-[420px]">
            <div class="modal-header">
                <h3 class="modal-title">
                    <?php
                    if (!empty($comment_id)) {
                        _e('Edit Review', 'wedding-venue-listings');
                    } else {
                        _e('Leave a Review', 'wedding-venue-listings');
                    }
                    ?>
                </h3>
                <button type="button" class="close-btn" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="post">
                <div class="modal-content">
                    <?php if (!empty($comment_id)) : ?>
                        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                    <?php endif; ?>
                    <div class="wvl-field text-center">
                        <star-rating min="0" max="5" value="<?php echo $rating_amount; ?>" name="rating" editable="true"></star-rating>
                        <input type="hidden" name="rating" id="rating" class="hidden">
                        <script>
                            jQuery(document).ready(function($) {
                                var rating = $('#modal-review-form star-rating').on('change', (e) => {
                                    $('#modal-review-form #rating').val(e.detail.value);
                                })
                            })
                        </script>
                    </div>
                    <div class="wvl-field mt-2">
                        <label for="title"><?php _e('Title', 'wedding-venue-listings'); ?></label>
                        <input type="text" value="<?php echo $comment_title; ?>" name="title" id="title" placeholder="<?php _e('Give your review a title', 'wedding-venue-listings'); ?>" required />
                    </div>

                    <div class="wvl-field mt-2">
                        <label for="description"><?php _e('Description', 'wedding-venue-listings'); ?></label>
                        <textarea name="comment" id="description" placeholder="<?php _e('Share your experience with this vendor', 'wedding-venue-listings'); ?>"><?php echo $comment_text; ?></textarea>
                    </div>
                    <input type="hidden" name="venue_id" value="<?php echo get_the_ID(); ?>" />
                    <?php wp_nonce_field('wvl_venue_review_nonce', 'wvl_venue_review_nonce'); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="wvl-btn-secondary cancel-btn"><?php _e('Cancel', 'wedding-venue-listings'); ?></button>
                    <button type="submit" class="wvl-btn-primary submit-btn" name="wvl_venue_review_submit"><?php _e('Submit', 'wedding-venue-listings'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
