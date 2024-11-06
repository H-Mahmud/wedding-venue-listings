<form method="post">
    <p>
        <label for="user_login">Username or Email</label>
        <input type="text" name="user_login" required>
    </p>
    <p>
        <input type="submit" name="forgot_password" value="Reset Password">
    </p>
</form>
<?php
if (isset($_POST['forgot_password'])) {
    $user_login = sanitize_text_field($_POST['user_login']);
    $user = get_user_by('email', $user_login);

    if (!$user) {
        $user = get_user_by('login', $user_login);
    }

    if ($user) {
        $reset_key = get_password_reset_key($user);
        $reset_link = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login), 'login');

        // Send email with reset link
        $to = $user->user_email;
        $subject = "Password Reset";
        $message = "Click the following link to reset your password: $reset_link";
        wp_mail($to, $subject, $message);

        echo '<p class="success">Check your email for the password reset link.</p>';
    } else {
        echo '<p class="error">Invalid username or email.</p>';
    }
}
