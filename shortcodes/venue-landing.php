<?php
defined('ABSPATH') || exit;
add_shortcode('wvl-landing', 'wvl_venue_landing');
function wvl_venue_landing()
{
    ob_start();
?>
    <style>
    </style>
    <div class="flex flex-col items-center justify-center !px-28 !py-32 mx-auto lg:py-0 bg-white rounded-3xl">
        <h2 class="flex items-center mb-6 !text-6xl !font-bold text-primary">
            <?php _e('Weddings With Koumparos', 'wedding-venue-listings'); ?>
        </h2>
        <p class="text-center"><?php _e('Lorem ipsum dolor sit amet consectetur. Tortor ac sem diam convallis. Mauris ullamcorper', 'wedding-venue-listings'); ?></p>

        <form method="get" action="<?php echo site_url('listing'); ?>" class="w-full">
            <div class="flex justify-between gap-3 mb-5">
                <div class="w-full">
                    <input class="!h-14 !bg-tertiary rounded-lg" type="text" name="location" id="location" placeholder="<?php _e('Location', 'wedding-venue-listings'); ?>">
                </div>

                <?php
                $categories = get_categories(array('hide_empty' => false));
                $categories_by_parent = [];
                foreach ($categories as $category) {
                    $categories_by_parent[$category->parent][] = $category;
                }
                $categories_json = json_encode($categories_by_parent);

                ?>

                <div class="w-full">
                    <select class="!h-14 bg-tertiary !px-5 rounded-lg" name="category" id="category">
                        <option value="all"><?php _e('Select Category'); ?></option>
                        <?php if (!empty($categories_by_parent[0])) :
                            foreach ($categories_by_parent[0] as $parent) :
                                echo <<<HTML
                                    <option value="$parent->term_id">$parent->name</option>
                                HTML;
                            endforeach;
                        endif; ?>
                    </select>
                </div>
                <div class="w-full">
                    <select class="!h-14 bg-tertiary !px-5 rounded-lg" name="subcategory" id="subcategory">
                        <option value="all"><?php _e('Select Subcategory'); ?></option>
                    </select>
                </div>

                <label for="booking-date" class="flex relative items-center justify-center cursor-pointer rounded-lg !min-w-14 bg-tertiary !h-14 ring-1 ring-slate-300">
                    <i class="fa-solid fa-calendar-days text-xl text-primary"></i>
                    <input type="text" class="datetimepicker absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" name="booking-date" id="booking-date" placeholder="<?php _e('Date', 'wedding-venue-listings'); ?>">
                </label>
            </div>
            <button class="wvl-btn-primary w-full !h-14 m-0"><?php _e('Search', 'wedding-venue-listings'); ?></button>

            <p class="mt-6 text-center">Lorem ipsum dolor sit amet consectetur. Tortor ac sem diam convallis. <br> Mauris ullamcorper</p>
            <script>
                jQuery('.datetimepicker').datepicker({
                    timepicker: false,
                    language: 'en',
                    range: false,
                    multipleDates: false,
                    minDate: new Date(new Date().setDate(new Date().getDate() + 1))
                });
            </script>

            <script>
                const categoriesData = <?php echo $categories_json; ?>;
                jQuery(document).ready(function($) {


                    const category = $('#category');
                    const subcategory = $('#subcategory');

                    category.on('change', function() {
                        const selectedCategory = this.value;

                        if (selectedCategory) {
                            subcategoryOptions(selectedCategory);
                        } else {
                            subcategory.empty();
                        }

                    })
                    subcategoryOptions(<?php echo $category; ?>);

                    function subcategoryOptions(selectedCategory) {
                        const subcategories = categoriesData[selectedCategory];
                        subcategory.empty();

                        if (subcategories) {
                            subcategories.forEach(category => {
                                subcategory.append(`<option value="${category.term_id}">${category.name}</option>`);
                            });
                        }
                    }
                })
            </script>

        </form>
    </div>
<?php
    return ob_get_clean();
}
