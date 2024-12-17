<div class=" mb-14">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2"><?php _e('Booking Availability', 'wedding-venue-listings'); ?></legend>

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
                <h3 class="modal-title"><?php _e('Contact Form', 'wedding-venue-listings'); ?></h3>
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
                        <textarea class="form-control" name="location" id="location"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="wvl-btn-secondary cancel-btn"><?php _e('Cancel', 'wedding-venue-listings'); ?></button>
                    <button type="submit" class="wvl-btn-primary submit-btn" name="wvl_contact_submit"><?php _e('Submit', 'wedding-venue-listings'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
