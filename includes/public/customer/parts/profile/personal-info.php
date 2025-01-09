<form class=" mt-14 profile-step-forms active" id="profileInfoForm" data-step="0">
    <fieldset class="wvl-fieldset">
        <legend class="text-center"><?php _e('Personal Information', 'wedding-venue-listings'); ?></legend>
        <div class="wvl-field">
            <label for="firstName"><?php _e('First Name', 'wedding-venue-listings'); ?></label>
            <input type="text" id="firstName" name="first_name" placeholder="John" value="<?php echo get_user_meta($author_id, 'first_name', true); ?>" required>
        </div>

        <div class="wvl-field">
            <label for="lastName"><?php _e('Last Name', 'wedding-venue-listings'); ?></label>
            <input type="text" id="lastName" name="last_name" placeholder="Doe" value="<?php echo get_user_meta($author_id, 'last_name', true); ?>" required>
        </div>
    </fieldset>
</form>
