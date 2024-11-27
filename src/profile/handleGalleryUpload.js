export default function handleGalleryUpload($) {
    $('#profilePhotographsForm #upload_gallery').on('change', function () {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                const gallery = document.createElement('div');
                // gallery.classList.add('gallery');

                // const deleteButton = document.createElement('div');
                // deleteButton.classList.add('delete');
                // gallery.appendChild(deleteButton);

                const img = document.createElement('img');
                img.classList.add('h-auto', 'max-w-full', 'rounded-lg');
                img.src = e.target.result;
                gallery.appendChild(img);

                // const desc = document.createElement('div');
                // desc.classList.add('desc');
                // desc.innerHTML = 'Add a description of the image here';
                // gallery.appendChild(desc);

                // jQuery('.galleries').prepend(gallery);
                $('.gallery-upload').after(gallery);
            };

            reader.readAsDataURL(file);
        }
    });
}
