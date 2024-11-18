jQuery(document).ready(function ($) {

    /**
     * Cover Photo upload event handler
     */
    $('#uploadCoverPhoto').on('change', function () {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#coverPhoto').attr('src', e.target.result);
                uploadCoverPhoto();
            };
            reader.readAsDataURL(file);
        }
    });

    function uploadCoverPhoto() {

        var fileInput = $('#uploadCoverPhoto')[0].files[0];
        if (!fileInput) {
            alert('Image upload failed, please try again.');
            return;
        }

        var formData = new FormData();
        formData.append('file', fileInput);
        formData.append('action', 'upload_cover_photo');
        formData.append('security', WVL_DATA.ajax_nonce);

        $.ajax({
            url: WVL_DATA.ajax_url, // Provided by WordPress
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    // if (e.lengthComputable) {
                    //     var percentComplete = (e.loaded / e.total) * 100;
                    //     $('#progressBar').css('width', percentComplete + '%');
                    //     $('#progressText').text(Math.round(percentComplete) + '%');
                    // }

                    $('.cover-photo-spinner').show();
                });
                return xhr;
            },
            // beforeSend: function () {
            //     $('#progressContainer').show();
            //     $('#progressBar').css('width', '0%');
            //     $('#progressText').text('0%');
            // },
            success: function (response) {
                if (response.success) {
                    // alert('Image uploaded successfully!');
                    $('.cover-photo-spinner').hide();
                    $('input[name="cover_photo_hash"]').val(response.data.attachment_id);
                } else {
                    alert(response.data || 'Error uploading image.');
                }
            },
            error: function () {
                alert('An error occurred while uploading the image.');
                $('.cover-photo-spinner').hide();
            },
            complete: function () {
                // $('#progressContainer').hide();
                $('.cover-photo-spinner').hide();
            }
        });
    }
})
