<form class=" mb-14">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2">General Information</legend>
        <div class="wvl-field-row">
            <div class="wvl-field">
                <label for="fistName">First Name:</label>
                <input type="text" id="fistName" name="first_name" placeholder="John" required>
            </div>

            <div class="wvl-field">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="last_name" placeholder="Doe" required>
            </div>
        </div>
    </fieldset>
    <button type="submit" class="wvl-btn-primary">Save</button>
</form>

<form method="post">
    <?php wp_nonce_field('change_password', '_change_password'); ?>
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend><?php _e('Change Your Account Password', 'wedding-venue-listings'); ?></legend>

        <div class="wvl-field-row">
            <div class="wvl-field">
                <label for="newPassword"><?php _e('New Password', 'wedding-venue-listings'); ?></label>
                <input type="password" id="newPassword" name="new_password" required>
            </div>

            <div class="wvl-field">
                <label for="confirmPassword"><?php _e('Confirm Password', 'wedding-venue-listings'); ?></label>
                <input type="password" id="confirmPassword" name="confirm_password" required>
            </div>
        </div>
        <?php
        do_action('wvl_notice');
        ?>
    </fieldset>
    <button type="submit" name="wvl_change_password" class="wvl-btn-primary"><?php _e('Change Password', 'wedding-venue-listings'); ?></button>
</form
