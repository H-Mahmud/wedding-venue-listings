<form method="post">
    <p>
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" required>
    </p>
    <p>
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" required>
    </p>
    <p>
        <input type="submit" name="reset_password" value="Reset Password">
    </p>
</form>
<?php

// Process form submission
if (isset($_POST['reset_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo '<p class="error">Passwords do not match.</p>';
    } elseif (empty($new_password) || strlen($new_password) < 6) {
        echo '<p class="error">Password must be at least 6 characters.</p>';
    } else {
        // Update the user's password and redirect to login page
        reset_password($user, $new_password);
        echo '<p class="success">Your password has been reset successfully. <a href="' . wp_login_url() . '">Log in</a>.</p>';
    }
}
