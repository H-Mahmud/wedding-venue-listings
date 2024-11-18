<h1 class="center">Application</h1>
<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <label for="venue_name">
        Venue Name <br>
        <input type="text" name="venue_name" value="<?php echo get_the_title($post_id); ?>" id="venue_name">
    </label>
    <br><br>
    <label for="location">
        Location <br>
        <input type="text" name="location" id="location">
    </label>
    <br><br>

    <label for="social">
        Social <br>
        <input type="text" name="social">
    </label>
    <br><br>

    <label for="phone">
        Phone <br>
        <input type="phone" name="phone" id="phone">
    </label>
    <br><br>

    <label for="email">
        Email <br>
        <input type="text" name="email" id="email">
    </label>
    <br> <br>
    * Type, Services, Settings

    <label for="description">
        Description <br>
        <textarea name="description" id=""></textarea>
    </label>
    <br> <br>

    <label for="cover_photo">
        Cover Photo <br>
        <input type="file" name="cover_photo" id="cover_photo">
    </label>

    <br> <br>
    <label for="gallery">
        Gallery <br>
        <input type="file" name="gallery" multiple id="gallery">
    </label> <br><br>
    <button type="submit">Submit</button>
</form>
