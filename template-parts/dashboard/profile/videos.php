<form class="mt-14 profile-step-forms" id="profilVideosForm" data-step="4">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Videos', 'wedding-venue-listings'); ?></legend>

        <div id="video-form-container">
            <form id="video-form" method="post">
                <div class="form-item wvl-field-row">
                    <div class="wvl-field w-48">
                        <select name="video_type[]" class="video-type">
                            <option value="youtube">YouTube</option>
                            <option value="motion">Dailymotion</option>
                            <option value="vimeo">Vimeo</option>
                        </select>
                    </div>
                    <div class="wvl-field">
                        <input type="text" name="video_url[]" class="video-url" placeholder="Enter video URL">
                    </div>
                    <button type="button" class="remove-item" style="display:none">-</button>
                </div>
                <!-- <button type="button" id="add-item">+</button> -->
                <!-- <button type="submit" id="submit-form">Submit</button> -->
            </form>
        </div>
    </fieldset>
</form>


<!-- HTML for the Form -->

<?php
/*
        <script>
            jQuery(document).ready(function($) {
                // Add new item
                $('#add-item').on('click', function() {
                    const newItem = `
      <div class="form-item">
        <select name="video_type[]" class="video-type">
          <option value="youtube">YouTube</option>
          <option value="motion">Dailymotion</option>
          <option value="vimeo">Vimeo</option>
        </select>
        <input type="text" name="video_url[]" class="video-url" placeholder="Enter video URL">
        <button type="button" class="remove-item">-</button>
      </div>`;
                    $('#video-form').find('#add-item').before(newItem);
                });

                // Remove an item
                $(document).on('click', '.remove-item', function() {
                    $(this).closest('.form-item').remove();
                });

                // Handle form submission
                $('#video-form').on('submit', function(e) {
                    e.preventDefault();

                    const formData = $(this).serialize();

                    $.ajax({
                        url: ajaxurl, // Provided by WordPress
                        type: 'POST',
                        data: {
                            action: 'save_video_data',
                            form_data: formData,
                        },
                        success: function(response) {
                            alert('Data submitted successfully!');
                        },
                        error: function() {
                            alert('An error occurred while submitting the data.');
                        },
                    });
                });
            });
        </script>

        <!-- PHP: Add this to your plugin or theme's functions.php -->
        <?php
        add_action('wp_ajax_save_video_data', 'save_video_data_callback');
        add_action('wp_ajax_nopriv_save_video_data', 'save_video_data_callback');

        function save_video_data_callback()
        {
            if (isset($_POST['form_data'])) {
                parse_str($_POST['form_data'], $data);

                // Process the data as needed, e.g., save it to the database
                $video_data = $data['video_type'];
                $video_urls = $data['video_url'];

                foreach ($video_data as $key => $type) {
                    $url = sanitize_text_field($video_urls[$key]);
                    $type = sanitize_text_field($type);

                    // Example: Insert into custom table (adjust table name and columns accordingly)
                    global $wpdb;
                    $wpdb->insert(
                        $wpdb->prefix . 'videos',
                        [
                            'type' => $type,
                            'url' => $url,
                        ],
                        ['%s', '%s']
                    );
                }

                wp_send_json_success('Data saved successfully.');
            } else {
                wp_send_json_error('Invalid data.');
            }
        }
            */
?>
