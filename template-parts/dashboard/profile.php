<form method="post">
    <input type="hidden" name="action" value="venue-profile-update-action">
    <div class="wvl-cover-photo-field">
        <label for="uploadCoverPhoto">
            <div class="preview">
                <svg class="upload-icon" height="100" width="800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384.97 384.97" xml:space="preserve">
                    <path d="M372.939 264.641c-6.641 0-12.03 5.39-12.03 12.03v84.212H24.061v-84.212c0-6.641-5.39-12.03-12.03-12.03S0 270.031 0 276.671v96.242c0 6.641 5.39 12.03 12.03 12.03h360.909c6.641 0 12.03-5.39 12.03-12.03v-96.242c.001-6.652-5.389-12.03-12.03-12.03z" />
                    <path d="m117.067 103.507 63.46-62.558v235.71c0 6.641 5.438 12.03 12.151 12.03s12.151-5.39 12.151-12.03V40.95l63.46 62.558c4.74 4.704 12.439 4.704 17.179 0 4.74-4.704 4.752-12.319 0-17.011L201.268 3.5c-4.692-4.656-12.584-4.608-17.191 0L99.888 86.496a11.942 11.942 0 0 0 0 17.011c4.74 4.704 12.439 4.704 17.179 0z" />
                </svg>
            </div>
        </label>
        <div id="progressContainer" style="display:block; margin-top: 10px;">
            <div style="width: 100%; background-color: #f3f3f3; border-radius: 5px; overflow: hidden;">
                <div id="progressBar" style="width: 0; height: 20px; background-color: #4caf50;"></div>
            </div>
            <span id="progressText" style="display: block; text-align: center; margin-top: 5px;">0%</span>
        </div>
        <input type="file" name="cover_photo" id="uploadCoverPhoto" accept="image/*" id="cover_photo">

    </div>
    <div class="wvl-field">
        <label for="venue_name">
            Venue Name <br>
            <input type="text" name="venue_name" value="<?php echo get_the_title($post_id); ?>" id="venue_name">
        </label>
    </div>

    <div class="wvl-field">
        <label for="venue_type">
            Venue Type <br>
            <select name="venue_type" id="venue_type">
                <?php
                $venue_types = get_terms(array(
                    'taxonomy' => 'venue_type',
                    'hide_empty' => false,
                ));
                foreach ($venue_types as $venue_type) {
                    echo '<option name="' . $venue_type->slug . '">' . $venue_type->name . '</option>';
                };
                ?>
            </select>
        </label>
    </div>

    <div class="wvl-field">
        <label for="venue_service">
            Venue Service <br>
            <select name="venue_service" id="venue_service">
                <?php
                $venue_services = get_terms(array(
                    'taxonomy' => 'venue_service',
                    'hide_empty' => false,
                ));

                foreach ($venue_services as $venue_service) {
                    echo '<option name="' . $venue_service->slug . '">' . $venue_service->name . '</option>';
                }; ?>
            </select>
        </label>
    </div>

    <div class="wvl-field">
        <label for="venue_setting">Venue Settings
            <br>
            <select name="venue_setting" id="venue_setting">
        </label>
        <?php
        $venue_settings = get_terms(array(
            'taxonomy' => 'venue_setting',
            'hide_empty' => false,
        ));

        foreach ($venue_settings as $venue_setting) {
            echo '<option name="' . $venue_setting->slug . '">' . $venue_setting->name . '</option>';
        }; ?>
        </select>
    </div>

    <div class="wvl-field">
        <label for="phone">
            Phone <br>
            <input type="number" name="phone" id="phone">
        </label>
    </div>

    <div class="wvl-field">
        <label for="email">
            Email <br>
            <input type="text" name="email" id="email">
        </label>
    </div>

    <div class="wvl-field">
        <label for="description">
            Description
            <textarea name="description" id=""></textarea>
        </label>
    </div>

    <div class="wvl-field">
        <label for="location">
            Location <br>
            <input type="text" name="location" id="location">
        </label>
    </div>

    <button type="submit">Submit</button>
</form>
