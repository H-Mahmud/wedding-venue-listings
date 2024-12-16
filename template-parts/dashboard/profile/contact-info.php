<form class="mt-14 profile-step-forms" id="profileContactForm" data-step="3">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Contact Information', 'wedding-venue-listings'); ?></legend>

        <div class="wvl-field-row">
            <div class="wvl-field">
                <label for="phone"><?php _e('Phone Number', 'wedding-venue-listings'); ?></label>
                <input type="number" name="phone" id="phone" value="<?php echo get_post_meta($venue_id, 'phone', true); ?>" required>
            </div>

            <div class="wvl-field">
                <label for="email"><?php _e('Email Address', 'wedding-venue-listings'); ?></label>
                <input type="text" name="email" id="email" value="<?php echo get_post_meta($venue_id, 'email', true); ?>" required>
            </div>
        </div>

        <div class="wvl-field">
            <label for="address"><?php _e('Full Address', 'wedding-venue-listings'); ?></label>
            <input type="text" name="address" id="address" value="<?php echo get_post_meta($venue_id, 'address', true); ?>" required>
        </div>
    </fieldset>

    <fieldset class="p-5 rounded-xl border-gray-200 mt-8">
        <legend class="mb-2 text-center"><?php _e('Other Information', 'wedding-venue-listings'); ?></legend>
        <?php
        if (wvl_current_plan() === 'free') {
        ?>
            <p class="text-center text-yellow-700"><?php _e('Below contact information won\'t show with free account.', 'wedding-venue-listings'); ?></p>
        <?php
        }
        $social_accounts = [
            'website' => [
                'label' => __('Website', 'wedding-venue-listings'),
                'placeholder' => 'https://www.yourwebsite.com',
                'icon' => 'globe',
                'value' => ''
            ],
            'facebook' => [
                'label' => __('Facebook', 'wedding-venue-listings'),
                'placeholder' => 'https://www.facebook.com/yourprofile',
                'icon' => 'facebook-f',
                'value' => ''
            ],
            'twitter' => [
                'label' => __('Twitter', 'wedding-venue-listings'),
                'placeholder' => 'https://www.twitter.com/yourprofile',
                'icon' => 'x-twitter',
                'value' => ''
            ],
            'instagram' => [

                'label' => __('Instagram', 'wedding-venue-listings'),
                'placeholder' => 'https://www.instagram.com/yourprofile',
                'icon' => 'instagram',
                'value' => ''
            ],
            'linkedin' => [
                'label' => __('LinkedIn', 'wedding-venue-listings'),
                'placeholder' => 'https://www.linkedin.com/in/yourprofile',
                'icon' => 'linkedin-in',
                'value' => ''
            ],
            'youtube' => [
                'label' => __('YouTube', 'wedding-venue-listings'),
                'placeholder' => 'https://www.youtube.com/@yourprofile',
                'icon' => 'square-youtube',
                'value' => ''
            ],
            'tiktok' => [
                'label' => __('TikTok', 'wedding-venue-listings'),
                'placeholder' => 'https://www.tiktok.com/@yourprofile',
                'icon' => 'tiktok',
                'value' => ''
            ],
        ];

        $get_social_links = get_post_meta($venue_id, 'social_links', true);
        if (!$get_social_links) {
            $get_social_links = [];
        }

        $social_fields = [];
        foreach ($social_accounts as $key => $value) {
            $account_value = isset($get_social_links[$key]) && $get_social_links[$key]['value'] ? $get_social_links[$key]['value'] : '';
            $social_fields[$key] = [
                'label' => $value['label'],
                'placeholder' => $value['placeholder'],
                'icon' => $value['icon'],
                'value' => $account_value
            ];
        }


        foreach ($social_fields as $key => $value) { ?>
            <div class="wvl-field">
                <label for="<?php echo $key; ?>"><?php echo $value['label']; ?></label>
                <input class="social-input" type="text" id="<?php echo $key; ?>" name="socials[<?php echo $key; ?>]" value="<?php echo $value['value']; ?>" placeholder="<?php echo $value['placeholder']; ?>">
            </div>
        <?php }
        ?>
    </fieldset>

</form>
