<form class=" mb-14">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2">General Information</legend>
        <div class="wvl-field-row">
            <div class="wvl-field">
                <label for="fistName">First Name:</label>
                <input type="text" id="fistName" name="first_name" placeholder="John" required>
            </div>

            <div class="wvl-field">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="last_name" placeholder="Doe" required>
            </div>
        </div>
    </fieldset>
    <button type="submit" class="wvl-btn-primary">Save</button>
</form>

<form>
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend>Password Reset</legend>

        <div class="wvl-field-row">
            <div class="wvl-field">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="new_password" required>
            </div>

            <div class="wvl-field">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirm_password" required>
            </div>
        </div>
    </fieldset>
    <button type="submit" class="wvl-btn-primary">Submit</button>
</form
