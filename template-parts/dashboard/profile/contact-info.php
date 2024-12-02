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
            <label for="location"><?php _e('Location Support', 'wedding-venue-listings'); ?></label>
            <input type="text" name="location" id="location" value="<?php echo get_post_meta($venue_id, 'location', true); ?>" required>
        </div>
    </fieldset>
</form>
