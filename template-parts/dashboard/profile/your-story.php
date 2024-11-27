<form class="mt-14 profile-step-forms" id="profileYourStoryForm" data-step="3">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Your Story', 'wedding-venue-listings'); ?></legend>
        <div class="wvl-field">
            <textarea name="your_story" rows="8" id="yourStory" required><?php echo $venue->post_content; ?></textarea>
        </div>
    </fieldset>
</form>
