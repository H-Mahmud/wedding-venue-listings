<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto  lg:py-0">
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 ">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                <?php _e('Change Password', 'wedding-venue-listings'); ?>
            </h1>
            <form class="space-y-4 md:space-y-6" method="post">
                <?php wp_nonce_field('wvl_reset_password_nonce', '_wvl_reset_password_nonce'); ?>
                <div class="wvl-field">
                    <label for="new_password"><?php _e('New Password', 'wedding-venue-listings'); ?></label>
                    <input type="password" name="new_password" id="new_password" placeholder="••••••••" class="wvl-input" required="">
                </div>

                <div class="wvl-field">
                    <label for="confirm_password"><?php _e('Confirm Password', 'wedding-venue-listings'); ?></label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" class="wvl-input" required="">
                </div>

                <?php if (isset($_SESSION['wvl_reset_password_error'])) : ?>
                    <p class="error text-red-700"><?php echo $_SESSION['wvl_reset_password_error']; ?></p>
                <?php
                    unset($_SESSION['wvl_reset_password_error']);
                endif; ?>

                <?php if (isset($_SESSION['wvl_reset_password_success'])) : ?>
                    <p class="error text-green-700"><?php echo $_SESSION['wvl_reset_password_success']; ?></p>
                <?php
                    unset($_SESSION['wvl_reset_password_success']);
                endif; ?>

                <button type="submit" name="reset_password" class="w-full wvl-btn-primary"><?php _e('Reset Password', 'wedding-venue-listings'); ?></button>
            </form>
        </div>
    </div>
</div>
