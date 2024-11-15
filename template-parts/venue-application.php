<h1 class="center">Application</h1>
<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <label for="venue_name">
        Venue Name
        <input type="text" name="venue_name" value="<?php echo get_the_title($post_id); ?>" id="venue_name">
    </label>

    <label for="location">
        Location
        <input type="text" name="location" id="location">
    </label>

    <label for="social">
        Social
        <input type="text" name="social">
    </label>
    <label for="phone">
        Phone
        <input type="phone" name="phone" id="phone">
    </label>

    <label for="email">
        Email
        <input type="text" name="email" id="email">
    </label>

    * Type, Services, Settings

    <label for="description">
        Description
        <textarea name="description" id=""></textarea>
    </label>
    <label for="cover_photo">
        Cover Photo
        <input type="file" name="cover_photo" id="cover_photo">
    </label>
    <label for="gallery">
        Gallery
        <input type="file" name="gallery" multiple id="gallery">
    </label>
    <button type="submit">Submit</button>
</form>
