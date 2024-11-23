<?php
if (isset($_POST['register'])) {
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    $errors = register_new_user($username, $email);
}
?>


<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto  lg:py-0">
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 ">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Create an account
            </h1>
            <form class="space-y-4 md:space-y-6" method="post">
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

                <?php if (isset($errors) && is_wp_error($errors)) : ?>
                    <p class="error text-red-700"><?php echo $errors->get_error_message(); ?></p>
                <?php endif; ?>

                <button type="submit" name="register" class="w-full wvl-btn-primary"><?php _e('Register', 'wedding-venue-listings'); ?></button>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    <?php _e('Already have an account?', 'wedding-venue-listings'); ?> <a href="<?php echo site_url('login'); ?>" class="font-medium text-primary-600 hover:underline dark:text-primary-500"><?php _e('Login here', 'wedding-venue-listings'); ?></a>
                </p>
            </form>
        </div>
    </div>
</div>
