import { hideProfileNextSpinner, showProfileNextSpinner } from "./utils";

export default function handleYourStoryForm($) {
    const $form = $('form#profileYourStoryForm');
    const $profileFormError = $('.profile-form-error')

    if (!$form.get(0).checkValidity()) {
        $form.get(0).reportValidity();
        return false;
    }

    // const yourStory = $form.find('#yourStory').val();
    const yourStory = tinymce.get('yourStory').getContent();

    if (!yourStory) {
        $profileFormError.html("Your Story field is required.");
        return false;
    }

    showProfileNextSpinner();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: WVL_DATA.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'submit_profile_your_story',
                nonce: WVL_DATA.ajax_nonce,
                your_story: yourStory,
            },
            success: function (response) {
                if (response.success) {
                    resolve(true);
                } else {
                    $profileFormError.html(response.data.message || "An error occurred.");
                    resolve(false);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                $profileFormError.html("Something went wrong. Please try again later.");
                resolve(false);
            },
            complete: function (data) {
                hideProfileNextSpinner();
            }
        });
    });
}
