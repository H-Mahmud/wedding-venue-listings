<form class="mt-14 profile-step-forms" id="profilePhotographsForm" data-step="4">
    <fieldset class="wvl-fieldset">
        <legend class="text-center"><?php _e('Cover Photo', 'wedding-venue-listings'); ?></legend>
        <?php
        $post_thumbnail_id = get_post_thumbnail_id($venue->ID);
        $background_styles = '';
        if ($post_thumbnail_id) {
            $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
            $background_styles = "background-image: url('$post_thumbnail_url'); background-size: cover";
        }
        ?>
        <label for="upload_cover" id="upload_cover_label" style="<?php echo $background_styles; ?>" class="cover-upload block text-center border  border-gray-200 rounded-lg hover:border-dashed hover:border-[#916E37] cursor-pointer h-32 md:min-h-60 justify-center items-center">

            <span class="cursor-pointer p-1 md:px-3 md:py-2 font-semibold text-white bg-[#916E37] rounded-lg border border-dashed border-gray-200 text-xs md:text-lg"><?php _e('Upload Cover Photo', 'wedding-venue-listings'); ?></span>
            <input type="file" name="upload_cover" id="upload_cover" class="hidden" accept="image/*">
        </label>
        <div class="cover-upload-notice mt-2"></div>
    </fieldset>


    <fieldset class="wvl-fieldset mt-5">
        <legend class="text-center"><?php _e('Gallery', 'wedding-venue-listings'); ?></legend>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <label for="upload_gallery" class="gallery-upload flex justify-center items-center flex-col gap-3 p-1 border border-gray-200 rounded-lg hover:border-dashed hover:border-[#916E37] cursor-pointer">
                <i class="fa-regular fa-image  text-gray-600 text-2xl sm:text-4xl"></i>
                <p class="text-center text-xs sm:text-lg">
                    <?php _e('Upload a Photo', 'wedding-venue-listings'); ?> <br>
                    <span class="text-xs text-gray-400">JPG, PNG, GIF</span><br>
                    <span class="text-[#916E37]"><?php _e('Browse', 'wedding-venue-listings'); ?></span>
                </p>
                <input type="file" name="upload_gallery" id="upload_gallery" class="hidden" multiple accept="image/*">
            </label>

            <?php
            $gallery = get_post_meta($venue->ID, 'venue_gallery', true);
            if ($gallery) :
                foreach ($gallery as $image) :
            ?>
                    <div class="relative gallery-image">
                        <span class="remove-gallery-image inline-block cursor-pointer absolute bg-[#916E37] opacity-60 hover:opacity-100 rounded-lg  m-2" data-attachment-id="<?php echo $image; ?>"><i class="fa-regular fa-trash-can text-sm sm:text-2xl text-white p-1 sm:p-3 inline-block"></i></span>
                        <?php echo wp_get_attachment_image($image, 'medium', false, ['class' => 'h-auto max-w-full rounded-lg']); ?>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
        <div class="gallery-upload-notice mt-2"></div>

    </fieldset>
</form>
