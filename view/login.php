    <form method="post">
        <p>
            <label for="username">Username or Email</label>
            <input type="text" name="username" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </p>
        <p>
            <input type="submit" name="login" value="Login">
        </p>
    </form>
    <?php
    if (isset($_POST['login'])) {
        $creds = array(
            'user_login'    => $_POST['username'],
            'user_password' => $_POST['password'],
            'remember'      => true
        );
        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            echo '<p class="error">' . $user->get_error_message() . '</p>';
        } else {
            wp_redirect(home_url());
            exit;
        }
    }
