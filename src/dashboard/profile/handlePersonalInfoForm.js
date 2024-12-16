import { hideLoading, showLoading } from "./utils";

export default function handlePersonalInfoForm($) {
    const $form = $('form#profileInfoForm');
    const $profileFormError = $('.profile-form-error')

    if (!$form.get(0).checkValidity()) {
        $form.get(0).reportValidity();
        return false;
    }

    const firstName = $form.find('#firstName').val();
    const lastName = $form.find('#lastName').val();

    if (!firstName || !lastName) {
        $profileFormError.html("First Name, Last Name both fields are required.");
        return false;
    }

    showLoading();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: WVL_DATA.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'submit_profile_info',
                nonce: WVL_DATA.ajax_nonce,
                first_name: firstName,
                last_name: lastName
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
                hideLoading();
            }
        });
    });
}
