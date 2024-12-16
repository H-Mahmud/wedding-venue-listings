import { hideLoading, showLoading } from "./utils";

export default function handleContactInfoForm($) {
    const $form = $('form#profileContactForm');
    const $profileFormError = $('.profile-form-error')

    if (!$form.get(0).checkValidity()) {
        $form.get(0).reportValidity();
        return false;
    }

    const phone = $form.find('#phone').val();
    const email = $form.find('#email').val();
    const address = $form.find('#address').val();

    let socialLinks = {};
    $(".social-input").each(function () {
        let id = $(this).attr("id")
        let value = $(this).val();
        socialLinks[id] = { value: value };
    });


    if (!phone || !email || !address) {
        $profileFormError.html("All fields are required.");
        return false;
    }

    const formData = {
        action: 'submit_profile_contact_info',
        nonce: WVL_DATA.ajax_nonce,
        phone: phone,
        email: email,
        address: address,
        social_links: socialLinks
    }

    showLoading();
    return new Promise((resolve, reject) => {
        jQuery.ajax({
            url: WVL_DATA.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: formData,
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
