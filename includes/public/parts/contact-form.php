<div id="modal-contact" class="wvl-modal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-box" role="document">
        <div class="modal-inner">
            <div class="modal-header">
                <h3 class="modal-title"><?php _e('Contact Form', 'wedding-venue-listings'); ?></h3>
                <button type="button" class="close-btn" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="post">
                <?php wp_nonce_field('wlv_contact_submission', 'wlv_contact_submission');
                $wvl_user_id = get_current_user_id();
                ?>
                <input type="hidden" name="venue_id" value="<?php the_ID(); ?>">
                <div class="modal-content">
                    <div class="wvl-field-row">
                        <div class="wvl-field">
                            <label for="first_name"><?php _e('Fist name', 'wedding-venue-listings'); ?></label>
                            <input type="text" name="first_name" id="first_name" value="<?php echo get_user_meta($wvl_user_id, 'first_name', true); ?>" placeholder="John" required />
                        </div>
                        <div class="wvl-field">
                            <label for="last_name"><?php _e('Last Name', 'wedding-venue-listings'); ?></label>
                            <input type="text" name="last_name" id="last_name" value="<?php echo get_user_meta($wvl_user_id, 'last_name', true); ?>" placeholder="Doe" required />
                        </div>
                    </div>

                    <div class="wvl-field">
                        <label for="email"><?php _e('Email', 'wedding-venue-listings'); ?></label>
                        <input type="email" name="email" id="email" value="<?php echo get_user_meta($wvl_user_id, 'email', true); ?>" placeholder="name@example.com" required />
                    </div>

                    <div class="wvl-field">
                        <label for="phone"><?php _e('Phone', 'wedding-venue-listings'); ?></label>
                        <input type="number" name="phone" id="phone" value="<?php echo get_user_meta($wvl_user_id, 'phone', true); ?>" placeholder="123-456-7890" required />
                    </div>

                    <div class="wvl-field">
                        <label for="city"><?php _e('City', 'wedding-venue-listings'); ?></label>
                        <input type="text" name="city" id="city" value="<?php echo get_user_meta($wvl_user_id, 'city', true); ?>" placeholder="New York" required />
                    </div>

                    <div class="wvl-field">
                        <label for="date"><?php _e('Date', 'wedding-venue-listings'); ?></label>
                        <input type="date" name="date" id="date" min="<?php echo date('Y-m-d', strtotime('+1 days')); ?>" placeholder="date" required />
                    </div>

                    <div class="wvl-field">
                        <label for="message"><?php _e('Message', 'wedding-venue-listings'); ?></label>
                        <textarea name="message" id="message"></textarea>
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
