<form class="mt-14 profile-step-forms" id="profilePhotographsForm" data-step="4">
    <fieldset class="p-5 rounded-xl mb-8 border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Cover Photo', 'wedding-venue-listings'); ?></legend>

        <label for="upload_cover" class="cover-upload block text-center border border-gray-200 rounded-lg hover:border-dashed hover:border-blue-600 cursor-pointer">
            <p class="text-center my-10">
                Upload a Cover Photo <br>
                <span class="text-xs text-gray-400">JPG, PNG, GIF</span><br>
                <span class="text-blue-600">Browse</span>
            </p>
            <input type="file" name="upload_cover" id="upload_cover" class="hidden" accept="image/*">
        </label>
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
                <input type="file" name="upload_gallery" id="upload_gallery" class="hidden" accept="image/*">
            </label>
            <div>
                <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
            </div>
        </div>
    </fieldset>

    <fieldset class="p-5 rounded-xl  border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Videos', 'wedding-venue-listings'); ?></legend>

    </fieldset>
</form>
