<form method="post">
    <div class="wvl-cover-photo-field">
        <label for="cover_photo">
            Cover Photo
            <input type="file" name="cover_photo" id="cover_photo">
        </label>
    </div>
    <div class="wvl-field">
        <label for="venue_name">
            Venue Name <br>
            <input type="text" name="venue_name" value="<?php echo get_the_title($post_id); ?>" id="venue_name">
        </label>
    </div>

    <div class="wvl-field">
        <label for="location">
            Location <br>
            <input type="text" name="location" id="location">
        </label>
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

    <button type="submit">Submit</button>
</form>
