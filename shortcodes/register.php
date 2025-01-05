<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto  lg:py-0">
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 ">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-lg font-semibold leading-tight tracking-tight text-gray-900 ">
                <?php _e('Create a customer account or want to become a', 'wedding-venue-listings'); ?> <a href="<?php echo esc_url(site_url('vendor-register')); ?>" class="text-[#916E37] hover:text-[#916E37] hover:underline"><?php _e('Professional?', 'wedding-venue-listings'); ?></a>
            </h1>
            <form class="space-y-4 md:space-y-6" method="post">
                <?php wp_nonce_field('wvl_register_nonce', '_wvl_register_nonce'); ?>
                <div class="wvl-field">
                    <label for="username"><?php _e('Username', 'wedding-venue-listings'); ?></label>
                    <input type="username" name="username" id="username" class="wvl-input" placeholder="john" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required="">
                </div>
                <div class="wvl-field">
                    <label for="email"><?php _e('Email', 'wedding-venue-listings'); ?></label>
                    <input type="email" name="email" id="email" class="wvl-input" placeholder="john@example.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required="">
                </div>
                <div class="wvl-field">
                    <label for="password"><?php _e('Password', 'wedding-venue-listings'); ?></label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="wvl-input" required="">
                </div>

                <?php if (isset($_SESSION['wvl_register_error'])) : ?>
                    <p class="error text-red-700"><?php echo $_SESSION['wvl_register_error']; ?></p>
                <?php
                    unset($_SESSION['wvl_register_error']);
                endif; ?>

                <button type="submit" name="register" class="w-full wvl-btn-primary"><?php _e('Register', 'wedding-venue-listings'); ?></button>
                <p class="text-sm font-light text-gray-500">
                    <?php _e('Already have an account?', 'wedding-venue-listings'); ?> <a href="<?php echo site_url('login'); ?>" class="font-medium text-primary-600 hover:underline dark:text-primary-500"><?php _e('Login here', 'wedding-venue-listings'); ?></a>
                </p>

                <?php echo do_shortcode('[TheChamp-Login title="Register with your Social Account"]'); ?>

            </form>
        </div>
    </div>
</div>
