<form>
    <fieldset>
        <legend>General Information</legend>
        <label for="fistName">First Name:</label><br>
        <input type="text" id="fistName" name="first_name" placeholder="John" required>
        <br><br>
        <label for="lastName">Last Name:</label><br>
        <input type="text" id="lastName" name="last_name" placeholder="Doe" required>
    </fieldset>

    <fieldset>
        <legend>Password Reset</legend>
        <label for="newPassword">New Password:</label><br>
        <input type="password" id="newPassword" name="new_password" required>
        <br><br>

        <label for="confirmPassword">Email Address:</label><br>
        <input type="password" id="confirmPassword" name="confirm_password" required>
    </fieldset>
    <button type="submit">Submit</button>
</form>
