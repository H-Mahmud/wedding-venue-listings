<?php $post_id = wvl_get_venue_id(); ?>
<form method="post">
    <input type="hidden" name="action" value="venue-profile-update-action">

    <div class="flex gap-8">
        <label for="uploadCoverPhoto" class="avatar block relative cursor-pointer">

            <img id="coverPhoto" class="w-auto h-32 rounded-md ring-2" src="http://koumparos.local/wp-content/uploads/2024/11/মির্জা-গালিব.png" alt="">

            <div class="delete absolute w-full h-full transition-opacity top-0 left-0 bg-black text-white font-semibold opacity-0 hover:opacity-50 flex items-center justify-center">Upload</div>

            <div class="cover-photo-spinner hidden">
                <div class=" absolute  top-0 left-0 h-full w-full flex items-center justify-center" role="status">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <input class="hidden" type="file" name="cover_photo" value="" id="uploadCoverPhoto" accept="image/*">
            <input type="hidden" name="cover_photo_hash" value="">
        </label>

        <div class="wvl-field">
            <label for="venue_name">
                Venue Name <br>
                <input type="text" name="venue_name" value="<?php echo get_the_title($post_id); ?>" id="venue_name">
            </label>
        </div>
    </div>

    <div class="wvl-field-row mt-3">
        <div class="wvl-field">
            <label for="vendor_type">
                Vendor Type <br>
                <select name="vendor_type" id="vendor_type"></select>
            </label>
        </div>

        <div class="wvl-field">
            <label for="event_type">
                Event Type <br>
                <select name="event_type" id="event_type"></select>
            </label>
        </div>
    </div>

    <div class="wvl-field-row">
        <div class="wvl-field">
            <label for="phone">
                Phone <br>
                <input type="number" name="phone" id="phone">
            </label>
        </div>

        <div class="wvl-field">
            <label for="email">
                Email <br>
                <input type="text" name="email" id="email">
            </label>
        </div>

    </div>

    <div class="wvl-field">
        <label for="description">
            Description
            <textarea name="description" rows="6" id=""></textarea>
        </label>
    </div>

    <div class="wvl-field">
        <label for="location">
            Location <br>
            <input type="text" name="location" id="location">
        </label>
    </div>

    <button type="submit" class="wvl-btn-primary">Submit</button>
</form>
