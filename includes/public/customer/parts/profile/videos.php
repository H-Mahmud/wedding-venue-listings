<form class="mt-14 profile-step-forms" id="profileVideosForm" data-step="5">
    <fieldset class="wvl-fieldset">
        <legend class="text-center"><?php _e('Videos', 'wedding-venue-listings'); ?></legend>

        <div id="video-form" class="relative">
            <div class="video-gallery grid grid-cols-2 md:grid-cols-3 gap-4">
                <?php if (wvl_current_plan() == 0): ?>
                    <label onclick="alert('<?php _e('Upgrade your plan to add videos', 'wedding-venue-listings'); ?>')" class=" p-3 sm:py-8 flex justify-center items-center flex-col gap-3 border border-gray-200 rounded-lg hover:border-dashed hover:border-blue-600 cursor-pointer">
                        <i class="fa-solid fa-video  text-gray-600 text-2xl sm:text-4xl"></i>
                        <p class="text-center text-xs sm:text-xl sm:font-semibold text-gray-600">
                            <?php _e(' Add New Video', 'wedding-venue-listings'); ?>
                        </p>
                        <div class="text-center">
                            <span class="inline-block ml-2 bg-amber-100 text-amber-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded"><?php _e('Premium', 'wedding-venue-listings'); ?></span>
                        </div>
                    </label>
                <?php else: ?>
                    <label for="upload_gallery" data-target="#modal-add-video" class="open-modal-btn py-8 flex justify-center items-center flex-col gap-3 border border-gray-200 rounded-lg hover:border-dashed hover:border-blue-600 cursor-pointer">
                        <i class="fa-solid fa-video  text-gray-600 text-2xl sm:text-4xl"></i>
                        <p class="text-center text-xs sm:text-xl sm:font-semibold text-gray-600">
                            <?php _e(' Add New Video', 'wedding-venue-listings'); ?>
                        </p>
                        <div class="text-center">
                            <span class="inline-block ml-2 bg-amber-100 text-amber-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded"><?php _e('Premium', 'wedding-venue-listings'); ?></span>
                        </div>
                        <input type="file" name="upload_gallery" id="upload_gallery" class="hidden" multiple accept="image/*">
                    </label>
                <?php endif;  ?>

                <?php
                $video_gallery = get_post_meta($venue_id, 'venue_videos', true);
                if (!empty($video_gallery) && is_array($video_gallery)) {

                    foreach ($video_gallery as $video) {
                        if ($video['platform'] == 'youtube') {
                ?>
                            <a class="relative" href="https://www.youtube.com/watch?v=<?php echo $video['id']; ?>">
                                <span data-key="<?php echo $video['key']; ?>" class="remove-gallery-video inline-block cursor-pointer absolute bg-[#916E37] opacity-60 hover:opacity-100 rounded-lg  m-2"><i class="fa-regular fa-trash-can text-sm sm:text-2xl text-white p-1 sm:p-3 inline-block"></i></span>

                                <img class="h-auto max-w-full rounded-lg" src="https://img.youtube.com/vi/<?php echo $video['id']; ?>/hqdefault.jpg" alt="YouTube Video" />
                            </a>
                        <?php
                        }
                        if ($video['platform'] == 'vimeo') { ?>
                            <a class="relative" href="https://vimeo.com/<?php echo $video['id']; ?>">
                                <span data-key="<?php echo $video['key']; ?>" class="remove-gallery-video inline-block cursor-pointer absolute bg-[#916E37] opacity-60 hover:opacity-100 rounded-lg  m-2"><i class="fa-regular fa-trash-can text-sm sm:text-2xl text-white p-1 sm:p-3 inline-block"></i></span>

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
        <div class="modal-inner md:min-w-[520px]">
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
