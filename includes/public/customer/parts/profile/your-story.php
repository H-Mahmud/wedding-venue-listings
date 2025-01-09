<form class="mt-14 profile-step-forms" id="profileYourStoryForm" data-step="3">
    <fieldset class="wvl-fieldset">
        <legend class="text-center"><?php _e('Your Story', 'wedding-venue-listings'); ?></legend>
        <div class="wvl-field">
            <textarea name="your_story" rows="8" id="yourStory" required><?php echo $venue->post_content; ?></textarea>
        </div>
    </fieldset>
</form>
