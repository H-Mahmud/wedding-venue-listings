<form class=" mt-14 profile-step-forms active" id="packageInfoForm" data-step="6">
    <h3 class="mb-2 font-semibold text-2xl text-center"><?php _e('Our Packages', 'wedding-venue-listings'); ?></h3>

    <?php
    echo do_shortcode('[elementor-template id="490"]');

    /*
    <div class="pricing-tables gap-3">
        <div class="pricing-card">
            <h5 class="heading"><?php _e('Free', 'wedding-venue-listings'); ?></h5>

            <ul role="list" class="list">
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Basic Profile Visibility</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Up to 1 service showcased in your portfolio</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">1 Supported Location</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Up to 5 photos & 1 Video</span>
                </li>
            </ul>
            <?php if (wvl_current_plan() == 0): ?>
                <div class="bg-white hover:bg-white !border text-center py-3 rounded-md w-full  text-gray-500 cursor-not-allowed"><?php _e('Current Plan', 'wedding-venue-listings'); ?></div>
            <?php else: ?>
                <a href="<?php echo site_url('subscription-plan'); ?>" class="wvl-btn-primary w-full"><?php _e('Learn More', 'wedding-venue-listings'); ?></a>
            <?php endif; ?>
        </div>

        <div class="pricing-card">
            <h5 class="heading"><?php _e('Pro', 'wedding-venue-listings'); ?></h5>

            <ul role="list" class="list">
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Enhanced Profile Visibility</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Unlimited services showcased in your portfolio</span>
                </li>

                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Appear in unlimited locations</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Unlimited Photos & Videos</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Visible Phone Number</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Social Media Links and more</span>
                </li>
                <?php /*
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">No competitor Ads on Profile</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Dashboard Analytics</span>
                </li>
            </ul>
            <?php if (wvl_current_plan() == 1): ?>
                <div class="bg-white hover:bg-white !border text-center py-3 rounded-md w-full  text-gray-500 cursor-not-allowed"><?php _e('Current Plan', 'wedding-venue-listings'); ?></div>
            <?php else: ?>
                <a href="<?php echo site_url('subscription-plan'); ?>" class="wvl-btn-primary w-full"><?php _e('Learn More', 'wedding-venue-listings'); ?></a>
            <?php endif; ?>
        </div>

        <div class="pricing-card">
            <h5 class="heading"><?php _e('Ultimate', 'wedding-venue-listings'); ?></h5>

            <ul role="list" class="list">
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Top Ranking</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Unlimited events/services showcased in your portfolio</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Appear in unlimited locations</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Unlimited Photos & Videos</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Visible Phone Number</span>
                </li>
                <li class="item">
                    <i class="fa-solid fa-circle-check icon"></i>
                    <span class="text">Social Media Links and more</span>
                </li>
            </ul>
            <?php if (wvl_current_plan() == 2): ?>
                <div class="bg-white hover:bg-white !border text-center py-3 rounded-md w-full  text-gray-500 cursor-not-allowed"><?php _e('Current Plan', 'wedding-venue-listings'); ?></div>
            <?php else: ?>
                <a href="<?php echo site_url('subscription-plan'); ?>" class="wvl-btn-primary w-full"><?php _e('Learn More', 'wedding-venue-listings'); ?></a>
            <?php endif; ?>
        </div>
    </div>
    */ ?>
</form>
