<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto  lg:py-0">
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 ">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-lg font-semibold leading-tight tracking-tight text-gray-900">
                <?php _e('Sign in to your account', 'wedding-venue-listings'); ?>
            </h1>
            <form class="space-y-4 md:space-y-6" method="post">
                <?php wp_nonce_field('wvl_login_nonce', '_wvl_login_nonce'); ?>
                <div class="wvl-field">
                    <label for="username"><?php _e('Username or Email', 'wedding-venue-listings'); ?></label>
                    <input type="username" name="username" id="username" class="wvl-input" placeholder="john" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required="">
                </div>
                <div class="wvl-field">
                    <label for="password"><?php _e('Password', 'wedding-venue-listings'); ?></label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="wvl-input" required="">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500"><?php _e('Remember me', 'wedding-venue-listings'); ?></label>
                        </div>
                    </div>
                    <a href="<?php echo site_url('forgot-password'); ?>" class="text-sm font-medium text-primary-600 hover:underline"><?php _e('Forgot password?', 'wedding-venue-listings'); ?></a>
                </div>

                <?php if (isset($_SESSION['wvl_login_error'])) : ?>
                    <p class="error text-red-700"><?php echo $_SESSION['wvl_login_error']; ?></p>
                <?php
                    unset($_SESSION['wvl_login_error']);
                endif; ?>

                <button type="submit" name="login" class="w-full wvl-btn-primary"><?php _e('Sign In', 'wedding-venue-listings'); ?></button>
                <p class="text-sm font-light text-gray-500 ">
                    <?php _e('Don’t have an account yet?', 'wedding-venue-listings'); ?> <a href="<?php echo site_url('register'); ?>" class="font-medium text-primary-600 hover:underline"><?php _e('Sign up', 'wedding-venue-listings'); ?></a>
                </p>
            </form>
        </div>
    </div>
</div>
