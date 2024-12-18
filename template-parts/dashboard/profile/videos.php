<form class="mt-14 profile-step-forms" id="profileVideosForm" data-step="6">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Videos', 'wedding-venue-listings'); ?></legend>

        <div id="video-form" class="relative">
            <?php if (wvl_current_plan() == 'free'): ?>

                <!-- <div class=" absolute inset-0 flex items-center justify-center z-500">
                    <h1 class="text-orange-600 font-semibold text-3xl p-4 backdrop-blur-sm"><?php _e('Upgrade to unlock this feature', 'wedding-venue-listings'); ?></h1>
                </div>
                <div class=" deemed absolute inset-0 flex items-center justify-center bg-black opacity-30 rounded-lg">
                </div> -->
            <?php endif;  ?>
            <div class="video-gallery grid grid-cols-2 md:grid-cols-3 gap-4">
                <label for="upload_gallery" data-target="#modal-add-video" class="open-modal-btn flex justify-center items-center flex-col gap-3 border border-gray-200 rounded-lg hover:border-dashed hover:border-blue-600 cursor-pointer">
                    <i class="fa-regular fa-video  text-gray-600 text-4xl"></i>
                    <p class="text-center text-xl font-semibold">
                        <?php _e(' Add New Video', 'wedding-venue-listings'); ?>
                    </p>
                    <input type="file" name="upload_gallery" id="upload_gallery" class="hidden" multiple accept="image/*">
                </label>
                <?php
                $video_gallery = get_post_meta($venue_id, 'venue_videos', true);
                if (!empty($video_gallery) && is_array($video_gallery)) {

                    foreach ($video_gallery as $key => $video) {
                        if ($video['platform'] == 'youtube') {
                ?>
                            <a class="relative" href="https://www.youtube.com/watch?v=<?php echo $video['id']; ?>">
                                <span class="remove-video inline-block cursor-pointer absolute bg-black opacity-60 hover:opacity-100 rounded-lg  m-2" data-video-id="<?php echo $key; ?>"><i class="fa-regular fa-trash-can text-2xl text-white p-3 inline-block"></i></span>

                                <img class="h-auto max-w-full rounded-lg" src="https://img.youtube.com/vi/<?php echo $video['id']; ?>/hqdefault.jpg" alt="YouTube Video" />
                            </a>
                        <?php
                        }
                        if ($video['platform'] == 'vimeo') { ?>
                            <a class="relative" href="https://vimeo.com/<?php echo $video['id']; ?>" data-key="<?php echo $video['id']; ?>">
                                <span class="remove-video inline-block cursor-pointer absolute bg-black opacity-60 hover:opacity-100 rounded-lg  m-2" data-attachment-id="<?php echo $key; ?>"><i class="fa-regular fa-trash-can text-2xl text-white p-3 inline-block"></i></span>

                                <img class="h-auto max-w-full rounded-lg" src="https://vumbnail.com/<?php echo $video['id']; ?>.jpg" alt="Vimeo Video" />
                            </a>
                <?php
                        }
                    }
                }
                ?>
            </div>
    </fieldset>
</form>

<div id="modal-add-video" class="wvl-modal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-box" role="document">
        <div class="modal-inner min-w-[520px]">
            <div class="modal-header">
                <h3 class="modal-title"><?php _e('Add New Video', 'wedding-venue-listings'); ?></h3>
                <button type="button" class="close-btn" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="post">
                <div class="modal-content">
                    <div class="wvl-field-row">
                        <div class="wvl-field w-32">
                            <label for="platform"><?php _e('Platform', 'wedding-venue-listings'); ?></label>
                            <select name="platform" id="platform">
                                <option value="youtube">YouTube</option>
                                <option value="vimeo">Vimeo</option>
                            </select>
                        </div>
                        <div class="wvl-field">
                            <label for="video_url"><?php _e('Video URL', 'wedding-venue-listings'); ?></label>
                            <input required type="text" name="video_url" id="video_url">
                        </div>
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
