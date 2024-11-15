jQuery(document).ready(function ($) {
    $('#imageUpload').on('change', function () {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result).show();
            };

            reader.readAsDataURL(file);
        }
    });

    // Handle form submission with progress
    $('#uploadForm').on('submit', function (e) {
        e.preventDefault();

        var fileInput = $('#imageUpload')[0].files[0];
        if (!fileInput) {
            alert('Please select an image to upload.');
            return;
        }

        var formData = new FormData();
        formData.append('file', fileInput);
        formData.append('action', 'upload_image'); // WP action
        formData.append('security', ajax_object.ajax_nonce); // Nonce for security

        $.ajax({
            url: ajax_object.ajax_url, // Provided by WordPress
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        $('#progressBar').css('width', percentComplete + '%');
                        $('#progressText').text(Math.round(percentComplete) + '%');
                    }
                });
                return xhr;
            },
            beforeSend: function () {
                $('#progressContainer').show();
                $('#progressBar').css('width', '0%');
                $('#progressText').text('0%');
            },
            success: function (response) {
                if (response.success) {
                    alert('Image uploaded successfully!');
                } else {
                    alert(response.data || 'Error uploading image.');
                }
            },
            error: function () {
                alert('An error occurred while uploading the image.');
            },
            complete: function () {
                $('#progressContainer').hide();
            }
        });
    });
});
