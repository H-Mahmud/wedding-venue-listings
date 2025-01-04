<form class="mt-14 profile-step-forms" id="profilePhotographsForm" data-step="4">
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
</form>
