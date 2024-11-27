

<?php /*
<style>
    div.gallery {
        margin: 5px;
        border: 1px solid #ccc;
        float: left;
        width: 180px;
        position: relative;
        z-index: 1;
    }

    div.gallery:hover {
        border: 1px solid #777;
    }

    div.gallery img {
        width: 100%;
        height: auto;
    }

    div.desc {
        padding: 15px;
        text-align: center;
    }

    .delete {
        position: absolute;
        top: 4px;
        right: 4px;
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="800" height="800" viewBox="0 0 41.336 41.336" xml:space="preserve"><path d="M36.335 5.668h-8.167V1.5a1.5 1.5 0 0 0-1.5-1.5h-12a1.5 1.5 0 0 0-1.5 1.5v4.168H5.001a2 2 0 0 0 0 4h2.001v29.168a2.5 2.5 0 0 0 2.5 2.5h22.332a2.5 2.5 0 0 0 2.5-2.5V9.668h2.001a2 2 0 0 0 0-4zM14.168 35.67a1.5 1.5 0 0 1-3 0v-21a1.5 1.5 0 0 1 3 0v21zm8 0a1.5 1.5 0 0 1-3 0v-21a1.5 1.5 0 0 1 3 0v21zm3-30.002h-9V3h9v2.668zm5 30.002a1.5 1.5 0 0 1-3 0v-21a1.5 1.5 0 0 1 3 0v21z"/></svg>');
        background-repeat: no-repeat;
        width: 20px;
        height: 20px;
        z-index: 99;
        background-size: contain;
        cursor: pointer;
    }

    .upload-gallery {
        border: 3px solid #f2f2f2;
        margin-bottom: 1rem;
        border-radius: 2px;
        padding: 3rem;
    }

    .upload-gallery #upload_gallery {
        display: none;
    }
</style>

<div class="upload-gallery">
    <label for="upload_gallery">
        <svg class="upload-icon" height="100" width="800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384.97 384.97" xml:space="preserve">
            <path d="M372.939 264.641c-6.641 0-12.03 5.39-12.03 12.03v84.212H24.061v-84.212c0-6.641-5.39-12.03-12.03-12.03S0 270.031 0 276.671v96.242c0 6.641 5.39 12.03 12.03 12.03h360.909c6.641 0 12.03-5.39 12.03-12.03v-96.242c.001-6.652-5.389-12.03-12.03-12.03z" />
            <path d="m117.067 103.507 63.46-62.558v235.71c0 6.641 5.438 12.03 12.151 12.03s12.151-5.39 12.151-12.03V40.95l63.46 62.558c4.74 4.704 12.439 4.704 17.179 0 4.74-4.704 4.752-12.319 0-17.011L201.268 3.5c-4.692-4.656-12.584-4.608-17.191 0L99.888 86.496a11.942 11.942 0 0 0 0 17.011c4.74 4.704 12.439 4.704 17.179 0z" />
        </svg>
    </label>
    <input type="file" name="upload_gallery" id="upload_gallery">
</div>


<script>
    jQuery('.upload-gallery #upload_gallery').on('change', function() {

        console.log('changed')
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const gallery = document.createElement('div');
                gallery.classList.add('gallery');

                const deleteButton = document.createElement('div');
                deleteButton.classList.add('delete');
                gallery.appendChild(deleteButton);

                const img = document.createElement('img');
                img.src = e.target.result;
                gallery.appendChild(img);

                const desc = document.createElement('div');
                desc.classList.add('desc');
                desc.innerHTML = 'Add a description of the image here';
                gallery.appendChild(desc);

                jQuery('.galleries').prepend(gallery);
            };

            reader.readAsDataURL(file);
        }
    });
</script>
*/
