<form class="mt-14 profile-step-forms" id="profilePhotographsForm" data-step="5">
    <fieldset class="p-5 rounded-xl mb-8 border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Cover Photo', 'wedding-venue-listings'); ?></legend>
        <?php
        $post_thumbnail_id = get_post_thumbnail_id($venue->ID);
        $background_styles = '';
        if ($post_thumbnail_id) {
            $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
            $background_styles = "background-image: url('$post_thumbnail_url'); background-size: cover";
        }
        ?>
        <label for="upload_cover" id="upload_cover_label" style="<?php echo $background_styles; ?>" class="cover-upload block text-center border  border-gray-200 rounded-lg hover:border-dashed hover:border-blue-600 cursor-pointer min-h-60 justify-center items-center">

            <span class="cursor-pointer px-3 py-2 font-semibold text-white bg-[#1f72b2] rounded-lg border border-dashed border-gray-200">Upload Cover Photo</span>
            <input type="file" name="upload_cover" id="upload_cover" class="hidden" accept="image/*">
        </label>
        <div class="cover-upload-notice mt-2"></div>
    </fieldset>


    <fieldset class="p-5 rounded-xl mb-8 border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Gallery', 'wedding-venue-listings'); ?></legend>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <label for="upload_gallery" class="gallery-upload flex justify-center items-center flex-col gap-3 border border-gray-200 rounded-lg hover:border-dashed hover:border-blue-600 cursor-pointer">
                <i class="fa-regular fa-image  text-gray-600 text-4xl"></i>
                <p class="text-center">
                    Upload a Photo <br>
                    <span class="text-xs text-gray-400">JPG, PNG, GIF</span><br>
                    <span class="text-blue-600">Browse</span>
                </p>
                <input type="file" name="upload_gallery" id="upload_gallery" class="hidden" multiple accept="image/*">
            </label>

            <?php
            $gallery = get_post_meta($venue->ID, 'venue_gallery', true);
            if ($gallery) :
                foreach ($gallery as $image) :
            ?>
                    <div class="relative gallery-image">
                        <span class="remove-gallery-image inline-block cursor-pointer absolute bg-black opacity-60 hover:opacity-100 rounded-lg  m-2" data-attachment-id="<?php echo $image; ?>"><i class="fa-regular fa-trash-can text-2xl text-white p-3 inline-block"></i></span>
                        <?php echo wp_get_attachment_image($image, 'medium', false, ['class' => 'h-auto max-w-full rounded-lg']); ?>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
        <div class="gallery-upload-notice mt-2"></div>

    </fieldset>

    <fieldset class="p-5 rounded-xl  border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Videos', 'wedding-venue-listings'); ?></legend>


        <!-- HTML for the Form -->
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
    </fieldset>
</form>
