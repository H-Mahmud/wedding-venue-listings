<form class=" mt-14 profile-step-forms active" id="profileInfoForm" data-step="1">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Personal Information', 'wedding-venue-listings'); ?></legend>
        <div class="wvl-field">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="first_name" placeholder="John" value="<?php echo get_user_meta($author_id, 'first_name', true); ?>" required>
        </div>

        <div class="wvl-field">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="last_name" placeholder="Doe" value="<?php echo get_user_meta($author_id, 'last_name', true); ?>" required>
        </div>
    </fieldset>
</form>
