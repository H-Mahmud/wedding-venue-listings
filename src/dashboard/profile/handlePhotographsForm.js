import { showLoading, hideLoading } from "./utils";

export default function handlePhotographsForm($) {
  handleCoverPhotoUpload($);
  handleGalleryUpload($);

  removeGalleryImage($);
}

function handleCoverPhotoUpload($) {
  $("#upload_cover").on("change", function () {
    var file = this.files[0];
    if (file) {
      showLoading();
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#upload_cover_label").css(
          "background-image",
          "url('" + e.target.result + "')",
        );
      };

      reader.readAsDataURL(file);

      var formData = new FormData();
      formData.append("file", file);
      formData.append("action", "wvl_upload_cover_photo");
      formData.append("security", WVL_DATA.ajax_nonce);

      $.ajax({
        url: WVL_DATA.ajax_url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $(".cover-upload-notice").html(
            '<p class="text-green-500">' + response.data.message + "</p>",
          );
        },
        error: function (response) {
          if (response.responseJSON) {
            $(".cover-upload-notice").html(
              '<p class="text-red-500">' +
                response.responseJSON.data.message +
                "</p>",
            );
          } else {
            $(".cover-upload-notice").html(
              '<p class="text-red-500">' + response.responseText + "</p>",
            );
          }
        },
        complete: function () {
          hideLoading();
        },
      });
    }
  });
}

function handleGalleryUpload($) {
  $("#upload_gallery").on("change", function () {
    var file = this.files;
    if (file && file.length > 0) {
      // if(!parseInt(WVL_DATA.WVL_AVAILABLE_GALLERY_UPLOAD)) {
      //     $('.gallery-upload-notice').html('<p class="text-red-500">You have reached the maximum number of gallery images (5) allowed in your current package. Please consider upgrading to a higher package to upload more images.</p>');
      //     return;
      // }

      let uploadLimit = parseInt(WVL_DATA.WVL_AVAILABLE_GALLERY_UPLOAD);
      for (var i = 0; i < file.length; i++) {
        // if(!uploadLimit) {
        //     $('.gallery-upload-notice').html('<p class="text-red-500">You have reached the maximum number of gallery images 5 allowed in your current package. Please consider upgrading to a higher package to upload more images.</p>');
        //     break;
        // }

        uploadLimit--;

        var reader = new FileReader();

        reader.onload = function (e) {
          $(".gallery-upload").after(
            '<div class="relative group"><img src="' +
              e.target.result +
              '" alt="Gallery Image" class="h-auto max-w-full rounded-lg"></div>',
          );
        };
        reader.readAsDataURL(file[i]);

        handleGalleryImageUpload(file[i], $);
      }
    }
  });
}

function handleGalleryImageUpload(file, $) {
  showLoading();
  var formData = new FormData();
  formData.append("file", file);
  formData.append("action", "wvl_upload_gallery_photo");
  formData.append("security", WVL_DATA.ajax_nonce);

  $.ajax({
    url: WVL_DATA.ajax_url,
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,

    success: function (response) {
      $(".gallery-upload-notice").html(
        '<p class="text-green-500">' + response.data.message + "</p>",
      );
    },
    error: function (response) {
      if (response.responseJSON) {
        $(".gallery-upload-notice").html(
          '<p class="text-red-500">' +
            response.responseJSON.data.message +
            "</p>",
        );
      } else {
        $(".gallery-upload-notice").html(
          '<p class="text-red-500">' + response.responseText + "</p>",
        );
      }
    },
    complete: function () {
      hideLoading();
    },
  });
}

function removeGalleryImage($) {
  $(".remove-gallery-image").on("click", function (e) {
    e.preventDefault();
    if (confirm("Are you sure you want to remove this image?")) {
      $.ajax({
        url: WVL_DATA.ajax_url,
        type: "POST",
        data: {
          action: "wvl_remove_gallery_photo",
          security: WVL_DATA.ajax_nonce,
          attachment_id: $(this).data("attachment-id"),
        },
        success: function (response) {
          if (response.success) {
            $(e.target).closest(".gallery-image").remove();
          } else {
            alert(response.data.message);
          }
        },
        error: function (response) {
          if (response.responseJSON) {
            alert(response.responseJSON.data.message);
          } else {
            alert(response.responseText);
          }
        },
      });
    }
  });
}

function uploadCoverPhoto() {
  var fileInput = $("#uploadCoverPhoto")[0].files[0];
  if (!fileInput) {
    alert("Image upload failed, please try again.");
    return;
  }

  var formData = new FormData();
  formData.append("file", fileInput);
  formData.append("action", "upload_cover_photo");
  formData.append("security", WVL_DATA.ajax_nonce);

  $.ajax({
    url: WVL_DATA.ajax_url, // Provided by WordPress
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    xhr: function () {
      var xhr = new XMLHttpRequest();
      xhr.upload.addEventListener("progress", function (e) {
        // if (e.lengthComputable) {
        //     var percentComplete = (e.loaded / e.total) * 100;
        //     $('#progressBar').css('width', percentComplete + '%');
        //     $('#progressText').text(Math.round(percentComplete) + '%');
        // }

        $(".cover-photo-spinner").show();
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
        $(".cover-photo-spinner").hide();
        $('input[name="cover_photo_hash"]').val(response.data.attachment_id);
      } else {
        alert(response.data || "Error uploading image.");
      }
    },
    error: function () {
      alert("An error occurred while uploading the image.");
      $(".cover-photo-spinner").hide();
    },
    complete: function () {
      // $('#progressContainer').hide();
      $(".cover-photo-spinner").hide();
    },
  });
}
