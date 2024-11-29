<form class="mt-14 profile-step-forms" id="profileContactForm" data-step="2">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Contact Information', 'wedding-venue-listings'); ?></legend>

        <div class="wvl-field-row">
            <div class="wvl-field">
                <label for="phone">
                    Phone <br>
                    <input type="number" name="phone" id="phone" value="<?php echo get_post_meta($venue_id, 'phone', true); ?>" required>
                </label>
            </div>

            <div class="wvl-field">
                <label for="email">
                    Email <br>
                    <input type="text" name="email" id="email" value="<?php echo get_post_meta($venue_id, 'email', true); ?>" required>
                </label>
            </div>

        </div>

        <div class="wvl-field">
            <label for="location">
                Location <br>
                <input type="text" name="location" id="location" value="<?php echo get_post_meta($venue_id, 'location', true); ?>" required>
            </label>
        </div>
    </fieldset>
</form>
