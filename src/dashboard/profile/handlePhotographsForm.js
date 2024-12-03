export default function handlePhotographsForm($) {
    handleCoverPhotoUpload($);
}

function handleCoverPhotoUpload($) {
    $('#upload_cover').on('change', function () {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#upload_cover_label').css("background-image", "url('" + e.target.result + "')");
            };

            reader.readAsDataURL(file);

            var formData = new FormData();
            formData.append('file', file);
            formData.append('action', 'wvl_upload_cover_photo');
            formData.append('security', WVL_DATA.ajax_nonce);

            $.ajax({
                url: WVL_DATA.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('.cover-upload-notice').html('<p class="text-green-500">' + response.data.message + '</p>');
                },
                error: function (response) {
                    if (response.responseJSON) {
                        $('.cover-upload-notice').html('<p class="text-red-500">' + response.responseJSON.data.message + '</p>');
                    } else {
                        $('.cover-upload-notice').html('<p class="text-red-500">' + response.responseText + '</p>');
                    }
                }
            });


        }
    });

}
