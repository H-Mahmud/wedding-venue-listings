<?php
$user_id = get_current_user_id();
$user_comments = get_comments([
    'user_id' => $user_id,
    'post_id' => get_the_ID(),
    // 'status'  => 'approve', // Only approved comments
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

<div id="review-modal" data-component-type="wvl-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="bg-black opacity-65 fixed inset-0 z-40"></div>
    <div class="modal-content relative p-4 w-full max-w-lg max-h-ful z-50">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    <span class="text-lg block font-semibold"><?php _e('Leave a Review', 'wedding-venue-listings'); ?></span>
                </h3>
                <span class="close-btn end-2.5 cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center ">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </span>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" id="review-form" method="post">
                    <?php if (!empty($comment_id)) : ?>
                        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                    <?php endif; ?>
                    <div class="wvl-field">
                        <star-rating min="0" max="5" value="<?php echo $rating_amount; ?>" name="rating" editable="true"></star-rating>
                        <input type="hidden" name="rating" id="rating" class="hidden">
                        <script>
                            jQuery(document).ready(function($) {
                                var rating = $('#review-modal star-rating').on('change', (e) => {
                                    $('#review-modal #rating').val(e.detail.value);
                                })
                            })
                        </script>
                    </div>
                    <div class="wvl-field">
                        <label for="title"><?php _e('Title', 'wedding-venue-listings'); ?></label>
                        <input type="text" value="<?php echo $comment_title; ?>" name="title" id="title" placeholder="<?php _e('Give your review a title', 'wedding-venue-listings'); ?>" required />
                    </div>

                    <div class="wvl-field">
                        <label for="description"><?php _e('Description', 'wedding-venue-listings'); ?></label>
                        <textarea name="comment" id="description" placeholder="<?php _e('Share your experience with this vendor', 'wedding-venue-listings'); ?>"><?php echo $comment_text; ?></textarea>
                    </div>
                    <input type="hidden" name="venue_id" value="<?php echo get_the_ID(); ?>" />
                    <?php wp_nonce_field('wvl_venue_review_nonce', 'wvl_venue_review_nonce'); ?>
                    <div class="text-right">
                        <button type="submit" name="wvl_venue_review_submit" class="wvl-btn-primary"><?php _e('Submit', 'wedding-venue-listings'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
