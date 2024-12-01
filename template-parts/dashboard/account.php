<?php $wvl_user_id = get_current_user_id(); ?>

<form class=" mb-14" method="post">
    <?php wp_nonce_field('update_account', '_update_account'); ?>
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2"><?php _e('Account Information', 'wedding-venue-listings'); ?></legend>


        <label for="user_avatar" class="cursor-pointer h-28 w-28 mb-2 inline-block relative group text-center">
            <?php
            $local_avatar = get_user_meta($wvl_user_id, 'simple_local_avatar', true);
            if ($local_avatar) {
                echo wp_get_attachment_image($local_avatar, 'thumbnail', '', ['class' => 'rounded-full h-full w-full object-cover userAvatarPreview']);
            } else {
                echo get_avatar($wvl_user_id, 112, '', __('Upload Avatar'), ['class' => 'rounded-full h-full w-full object-cover userAvatarPreview']);
            }
            ?>
            <input type="file" class="hidden" id="user_avatar" accept="image/*">

            <span
                class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-full">
                <span
                    class="text-white text-sm px-4 py-2transition">
                    <?php _e('Upload Avatar', 'wedding-venue-listings'); ?>
                </span>
            </span>
        </label>
        <div class="show-upload-notice"></div>
        <script>
            jQuery(document).ready(function($) {
                $('#user_avatar').on('change', function() {
                    var file = this.files[0];
                    if (!file) return

                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.userAvatarPreview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);

                    var formData = new FormData();
                    formData.append('file', file);
                    formData.append('action', 'wvl_upload_avatar');
                    formData.append('security', '<?php echo wp_create_nonce('wvl_upload_avatar'); ?>');

                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('.show-upload-notice').html('<p class="text-green-500">' + response.data.message + '</p>');
                        },
                        error: function(response) {
                            if (response.responseJSON) {
                                $('.show-upload-notice').html('<p class="text-red-500">' + response.responseJSON.data.message + '</p>');
                            } else {
                                $('.show-upload-notice').html('<p class="text-red-500">' + response.responseText + '</p>');
                            }
                        }
                    });
                });
            });
        </script>

        <div class="wvl-field-row">
            <div class="wvl-field">
                <label for="fistName"><?php _e('First Name', 'wedding-venue-listings'); ?></label>
                <input type="text" id="fistName" name="first_name" value="<?php echo get_user_meta($wvl_user_id, 'first_name', true); ?>" placeholder="John" required>
            </div>

            <div class="wvl-field">
                <label for="lastName"><?php _e('Last Name', 'wedding-venue-listings'); ?></label>
                <input type="text" id="lastName" name="last_name" value="<?php echo get_user_meta($wvl_user_id, 'last_name', true); ?>" placeholder="Doe" required>
            </div>
        </div>
        <?php do_action('wvl_notice', 'wvl_update_account'); ?>
    </fieldset>
    <button type="submit" name="wvl_account_info" class="wvl-btn-primary"><?php _e('Save Changes', 'wedding-venue-listings'); ?></button>
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
