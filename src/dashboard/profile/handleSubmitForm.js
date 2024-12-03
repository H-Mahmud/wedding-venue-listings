import { hideProfileNextSpinner, showProfileNextSpinner } from "./utils";

export default function handleSubmitForm($) {

    if (WVL_DATA.venue_status === 'publish') {
        $('.profile-form-success').html('Your profile has been updated.');
        return true;
    }

    showProfileNextSpinner();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: WVL_DATA.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'wvl_submit_venue_profile',
                security: WVL_DATA.ajax_nonce,
            },
            success: function (response) {
                if (response.success) {
                    $('.profile-form-success').html(response.data.message);
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
