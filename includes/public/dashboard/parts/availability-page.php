<div class="mb-14">
    <fieldset class="wvl-fieldset">
        <legend><?php _e('Booking Availability', 'wedding-venue-listings'); ?></legend>

        <div class="card">
            <div class="card-body p-0">
                <div id="booking-calendar"></div>
            </div>
        </div>

    </fieldset>
</div>

<div id="modal-add-booking" class="wvl-modal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-box" role="document">
        <div class="modal-inner">
            <div class="modal-header">
                <h3 class="modal-title"><?php _e('Add New Booking', 'wedding-venue-listings'); ?></h3>
                <button type="button" class="close-btn" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="post">
                <div class="modal-content">

                    <div class="wvl-field">
                        <label for="title"><?php _e('Event Title', 'wedding-venue-listings'); ?></label>
                        <input type="text" name="title" id="title">
                    </div>
                    <div class="wvl-field">
                        <label for="date"><?php _e('Event Date', 'wedding-venue-listings'); ?></label>
                        <input type='text' readonly name="date" id="date" autocomplete="off">
                    </div>
                    <div class="wvl-field">
                        <label for="location"><?php _e('Event Location', 'wedding-venue-listings'); ?></label>
                        <?php
                        $support_locations = get_terms(array(
                            'taxonomy' => 'support_location',
                            'hide_empty' => true,
                        ));

                        if (!empty($support_locations)) {
                            echo '<select class="form-control" name="location" id="location">';
                            echo '<option value="all">' . __('Select Location', 'wedding-venue-listings') . '</option>';
                            foreach ($support_locations as $location) {
                                echo <<<HTML
                                <option value="$location->name">$location->name</option>
                            HTML;
                            }
                            echo '</select>';
                        }
                        ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="wvl-btn-secondary cancel-btn"><?php _e('Cancel', 'wedding-venue-listings'); ?></button>
                    <button type="submit" class="wvl-btn-primary submit-btn"><?php _e('Submit', 'wedding-venue-listings'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="modal-show-booking-details" class="wvl-modal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-box" role="document">
        <div class="modal-inner">
            <div class="modal-header">
                <h3 class="modal-title"><?php _e('Booking Details', 'wedding-venue-listings'); ?></h3>
                <button type="button" class="close-btn" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="post">
                <input type="hidden" name="date" id="date">
                <div class="modal-content">
                    <h3 class="title text-2xl font-semibold" id="booking-title"></h3>
                    <p class="font-semibold text-gray-900">Date: <span class="text-gray-600 font-normal" id="booking-date"></span></p>
                    <p class="font-semibold text-gray-900">Location: <span class="text-gray-600 font-normal" id="booking-location"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="wvl-btn-secondary cancel-btn"><?php _e('Cancel', 'wedding-venue-listings'); ?></button>
                    <button type="submit" class="wvl-btn-primary submit-btn" name="wvl_booking_delete"><?php _e('Delete', 'wedding-venue-listings'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
