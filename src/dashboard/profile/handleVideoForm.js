export default function handleVideoForm($) {
  $("#modal-add-video form").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: WVL_DATA.ajax_url,
      type: "POST",
      data:
        jQuery(this).serialize() +
        "&action=wvl_add_new_video" +
        "&nonce=" +
        WVL_DATA.ajax_nonce,
      success: function (response) {
        if (response.success) {
          $video = `<a class="relative" href="${response.data.url}" data-fancybox="gallery" data-caption="${response.data.platform} Video">
                    <img class="h-auto max-w-full rounded-lg" src="${response.data.thumbnail}" alt="${response.data.platform} Video" />
                </a>`;

          $(".video-gallery").append($video);

          $("#modal-add-video").fadeOut();
          $("#modal-add-video form")[0].reset();
        } else {
          alert(response.data.message);
        }
      },
      error: function () {
        alert("Error while adding the event.");
      },
    });
  });
}
