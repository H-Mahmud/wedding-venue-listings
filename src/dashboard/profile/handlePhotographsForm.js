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

                console.log('loaded')
            };

            reader.readAsDataURL(file);
        }
    });

}
