<?php
$venue_id = wvl_get_venue_id();
$author_id = get_current_user_id();
$venue = get_post($venue_id);
?>
<div class="wvl-profile-steps">
    <div class="steps">
        <div class="steps__step" data-step="0">
            <div class="steps__step-number">1</div>
            <div class="steps__step-name"><?php _e('Personal Info', 'wedding-venue-listings'); ?></div>
        </div>
        <div class="steps__connector"></div>
        <div class="steps__step" data-step="1">
            <div class="steps__step-number">2</div>
            <div class="steps__step-name"><?php _e('Service Info', 'wedding-venue-listings'); ?></div>
        </div>
        <div class="steps__connector"></div>
        <div class="steps__step" data-step="2">
            <div class="steps__step-number">3</div>
            <div class="steps__step-name"><?php _e('Contact Info', 'wedding-venue-listings'); ?></div>
        </div>
        <div class="steps__connector"></div>
        <div class="steps__step" data-step="3">
            <div class="steps__step-number">4</div>
            <div class="steps__step-name"><?php _e('Your Story', 'wedding-venue-listings'); ?></div>
        </div>
        <div class="steps__connector"></div>
        <div class="steps__step" data-step="4">
            <div class="steps__step-number">5</div>
            <div class="steps__step-name"> <?php _e('Gallery', 'wedding-venue-listings'); ?></div>
        </div>
        <div class="steps__connector"></div>
        <div class="steps__step" data-step="5">
            <div class="steps__step-number">6</div>
            <div class="steps__step-name"> <?php _e('Videos', 'wedding-venue-listings'); ?></div>
        </div>
        <div class="steps__connector"></div>
        <div class="steps__step" data-step="6">
            <div class="steps__step-number">7</div>
            <div class="steps__step-name"><?php _e('Package', 'wedding-venue-listings'); ?></div>
        </div>
    </div>

    <?php include_once WVL_PLUGIN_DIR . 'includes/public/customer/parts/profile/personal-info.php'; ?>
    <?php include_once WVL_PLUGIN_DIR . 'includes/public/customer/parts/profile/service-info.php'; ?>
    <?php include_once WVL_PLUGIN_DIR . 'includes/public/customer/parts/profile/contact-info.php'; ?>
    <?php include_once WVL_PLUGIN_DIR . 'includes/public/customer/parts/profile/your-story.php'; ?>
    <?php include_once WVL_PLUGIN_DIR . 'includes/public/customer/parts/profile/photographs.php'; ?>
    <?php include_once WVL_PLUGIN_DIR . 'includes/public/customer/parts/profile/videos.php'; ?>
    <?php include_once WVL_PLUGIN_DIR . 'includes/public/customer/parts/profile/package.php'; ?>

    <p class="text-red-700 profile-form-error pt-3"></p>
    <p class="text-green-700 profile-form-success pt-3"></p>

    <div class="btn-group">
        <button class="wvl-btn-primary" type="button" data-action="prev" disabled>Previous</button>
        <button class="wvl-btn-primary" id="profileFormNext" type="button" data-action="next">
            <svg aria-hidden="true" role="status" class="spinner hidden  w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
            </svg>
            <span class="next"><?php _e('Next', 'wedding-venue-listings'); ?></span>
            <span class="loading hidden"><?php _e('Loading...', 'wedding-venue-listings'); ?></span>
        </button>
    </div>
</div>
