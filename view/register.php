<form method="post">
    <p>
        <label for="username">Username</label>
        <input type="text" name="username" required>
    </p>
    <p>
        <label for="email">Email</label>
        <input type="email" name="email" required>
    </p>
    <p>
        <label for="password">Password</label>
        <input type="password" name="password" required>
    </p>
    <p>
        <input type="submit" name="register" value="Register">
    </p>
</form>
<?php
if (isset($_POST['register'])) {
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    $errors = register_new_user($username, $email);
    if (is_wp_error($errors)) {
        echo '<p class="error">' . $errors->get_error_message() . '</p>';
    } else {
        wp_set_password($password, $errors->ID);
        echo '<p class="success">Registration complete. You can now log in.</p>';
    }
}
