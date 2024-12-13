<?php
defined('ABSPATH') || exit;
add_shortcode('wvl-landing', 'wvl_venue_landing');
function wvl_venue_landing()
{
    ob_start();
?>
    <style>
        body {
            background-color: gray;
        }
    </style>
    <div class="flex flex-col items-center justify-center px-28 py-32 mx-auto lg:py-0">
        <h2 class="flex items-center mb-6 text-6xl font-bold text-primary">
            <?php _e('Weddings With Koumparos', 'wedding-venue-listings'); ?>
        </h2>
        <p class="text-center"><?php _e('Lorem ipsum dolor sit amet consectetur. Tortor ac sem diam convallis. Mauris ullamcorper', 'wedding-venue-listings'); ?></p>

        <form action="" class="w-full">
            <div class="wvl-field-row mb-0">
                <div class="wvl-field">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location">
                </div>
                <div class="wvl-field">
                    <label for="category">Category</label>
                    <select name="category" id="category">
                        <option value="all">All</option>
                        <option value="wedding">Wedding</option>
                        <option value="reception">Reception</option>
                    </select>
                </div>
            </div>
            <button class="wvl-btn-primary w-full m-0"><?php _e('Search', 'wedding-venue-listings'); ?></button>
        </form>
    </div>
<?php
    return ob_get_clean();
}
