import { hideLoading, showLoading } from "./utils";

export default function handleServiceInfoForm($) {
    const $form = $('form#profileServiceForm');
    const $profileFormError = $('.profile-form-error')

    if (!$form.get(0).checkValidity()) {
        $form.get(0).reportValidity();
        return false;
    }

    const $venueName = $form.find('#venue_name').val();
    // const $vendorType = $form.find('#vendor_type').val();
    // const $eventType = $form.find('#event_type').val();
    const $category = $form.find('#category').val();
    const $subCategory = $form.find('#subcategory').val();


    const formData = {
        action: 'submit_profile_service_info',
        nonce: WVL_DATA.ajax_nonce,
        venue_name: $venueName,
        // vendor_type: $vendorType,
        // event_type: $eventType,
        category: $category,
        sub_category: $subCategory
    }

    console.log(formData);
    if (!$venueName || !$category || !$subCategory) {
        $profileFormError.html("All fields are required.");
        return false;
    }

    showLoading();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: WVL_DATA.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function (response) {
                if (response.success) {
                    $profileFormError.html("");
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
