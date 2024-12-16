<?php
defined('ABSPATH') || exit;
add_shortcode('wvl-landing', 'wvl_venue_landing');
function wvl_venue_landing()
{
    ob_start();
?>
    <div class="flex flex-col items-center justify-center !p-4 !py-6 sm:!px-28 sm:!py-32 mx-auto lg:py-0 bg-white rounded-3xl">
        <h2 class="flex items-center mb-6 text-4xl sm:!text-6xl text-center !font-bold text-primary">
            <?php _e('Weddings With Koumparos', 'wedding-venue-listings'); ?>
        </h2>
        <p class="text-center"><?php _e('Lorem ipsum dolor sit amet consectetur. Tortor ac sem diam convallis. Mauris ullamcorper', 'wedding-venue-listings'); ?></p>

        <form method="get" action="<?php echo site_url('listing'); ?>" class="w-full">
            <div class="flex-col md:flex-row flex justify-between gap-3 mb-5">
                <div class="w-full">
                    <input class="!h-14 !bg-tertiary rounded-lg w-full" type="text" name="location" id="location" placeholder="<?php _e('Location', 'wedding-venue-listings'); ?>">
                </div>

                <?php
                $categories = get_categories(array('hide_empty' => false));
                $categories_by_parent = [];
                foreach ($categories as $category) {
                    $categories_by_parent[$category->parent][] = $category;
                }

                ?>

                <div class="w-full">
                    <select class="!h-14 bg-tertiary !px-5 rounded-lg w-full" name="category" id="category">
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
                    <select class="!h-14 bg-tertiary !px-5 rounded-lg w-full" name="subcategory" id="subcategory">
                        <option value="all"><?php _e('Select Subcategory'); ?></option>
                    </select>
                </div>

                <?php /*
                <label for="booking-date" class="flex relative items-center justify-center cursor-pointer rounded-lg !min-w-14 bg-tertiary !h-14 ring-1 ring-slate-300">
                    <i class="fa-solid fa-calendar-days text-xl text-primary"></i>
                    <input type="text" class="datetimepicker absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" name="booking-date" readonly autocomplete="false" id="booking-date" placeholder="<?php _e('Date', 'wedding-venue-listings'); ?>">
                </label>
                */
                ?>
            </div>
            <button class="wvl-btn-primary w-full !h-14 m-0"><?php _e('Search', 'wedding-venue-listings'); ?></button>

            <p class="mt-6 text-center">Lorem ipsum dolor sit amet consectetur. Tortor ac sem diam convallis. <br> Mauris ullamcorper</p>

        </form>
    </div>
    <script>
        jQuery(document).ready(function($) {
            <?php /*
            $('.datetimepicker').datepicker({
                timepicker: false,
                language: 'en',
                range: false,
                multipleDates: false,
                minDate: new Date(new Date().setDate(new Date().getDate() + 1))
            });
 */ ?>
            const category = $('#category');
            const subcategory = $('#subcategory');

            category.on('change', function() {
                const selectedCategory = this.value;

                if (selectedCategory) {
                    loadSubCategory(selectedCategory);
                } else {
                    subcategory.empty();
                }

            })


            function loadSubCategory(selectedCategory) {
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'get_sub_category_list',
                        _nonce: '<?php echo wp_create_nonce('sub-category-list'); ?>',
                        category: selectedCategory
                    },
                    success: function(response) {
                        if (response) {
                            subcategory.empty();
                            subcategory.html(response);
                        }
                    }

                })
            }
        })
    </script>
<?php
    return ob_get_clean();
}

add_action('wp_ajax_get_sub_category_list', 'wvl_handle_sub_category_list_request');
add_action('wp_ajax_nopriv_get_sub_category_list', 'wvl_handle_sub_category_list_request');
function wvl_handle_sub_category_list_request()
{
    check_ajax_referer('sub-category-list', '_nonce');
    $category = $_POST['category'];
    $subcategories = get_categories(array('parent' => $category, 'hide_empty' => false));

    $list = '<option value="all">' . __('Select Subcategory', 'wedding-venue-listings') . '</option>';
    foreach ($subcategories as $subcategory) {
        $list .= <<<HTML
            <option value="$subcategory->term_id">$subcategory->name</option>
        HTML;
    }
    echo $list;
    wp_die();
}
