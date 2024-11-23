<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto  lg:py-0">
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 ">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                <?php _e('Forgot Password', 'wedding-venue-listings'); ?>
            </h1>
            <form class="space-y-4 md:space-y-6" method="post">
                <?php wp_nonce_field('wvl_forgot_password_nonce', '_wvl_forgot_password_nonce'); ?>
                <div class="wvl-field">
                    <label for="user_login"><?php _e('Username or Email', 'wedding-venue-listings'); ?></label>
                    <input type="username" name="user_login" id="user_login" class="wvl-input" placeholder="john" value="<?php echo isset($_POST['user_login']) ? $_POST['user_login'] : ''; ?>" required="">
                </div>

                <?php if (isset($_SESSION['wvl_password_forgot_error'])) : ?>
                    <p class="error text-red-700"><?php echo $_SESSION['wvl_password_forgot_error']; ?></p>
                <?php
                    unset($_SESSION['wvl_password_forgot_error']);
                endif; ?>

                <?php if (isset($_SESSION['wvl_password_forgot_success'])) : ?>
                    <p class="error text-green-700"><?php echo $_SESSION['wvl_password_forgot_success']; ?></p>
                <?php
                    unset($_SESSION['wvl_password_forgot_success']);
                endif; ?>

                <button type="submit" name="forgot_password" class="w-full wvl-btn-primary"><?php _e('Send Reset Link', 'wedding-venue-listings'); ?></button>

        </div>
    </div>
</div>
