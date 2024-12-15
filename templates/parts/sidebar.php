<form action="<?php echo site_url('listing'); ?>" class="mb-6">
    <div class="flex justify-between items-center border border-quaternary rounded-md p-1">
        <input class="!bg-white !border-0" type="text" name="s" placeholder="Search for a venue" value="<?php echo get_query_var('location'); ?>">
        <button type="submit" class="search-icon"><i class="fa-solid fa-magnifying-glass p-3 rounded-lg inline-block bg-primary text-white"></i></button>
    </div>
</form>

<div class="wvl-widgets border-quaternary border px-5 py-6 rounded-md">
    <form class="filter category mb-5" id="categoryFilter" method="get">
        <h3 class="text-lg font-bold"><?php _e('Category', 'wedding-venue-listings'); ?></h3>
        <?php
        $categories = get_categories(array('hide_empty' => false));
        foreach ($categories as $category) {
            if ($category->parent == 0) {
                $selected = isset($_GET['category']) && $_GET['category'] == $category->term_id ? 'checked="checked"' : '';
                echo <<<HTML
                                <label class="my-2 inline-block cursor-pointer">
                                    <input class="mr-2 w-4 h-4"type="radio" name="category" value="$category->term_id" $selected />
                                    $category->name
                                </label>
                                <br>
                            HTML;
            }
        }; ?>
    </form>
    <?php
    if (isset($_GET['category']) && !empty($_GET['category']) && is_numeric($_GET['category'])):
        $parent_id = $_GET['category'];
        $args = [
            'parent'     => $parent_id,
            'hide_empty' => false,
            'taxonomy'   => 'category',
        ];
    ?>
        <form class="filter subcategory mb-5" id="subcategoryFilter" method="get">
            <h3 class="text-lg font-bold"><?php _e('Sub Category', 'wedding-venue-listings'); ?></h3>
            <?php
            $subcategories = get_terms($args);
            $selected_subcategories = [];
            if (isset($_GET['subcategory']) && !empty($_GET['subcategory']) && is_array($_GET['subcategory'])) {
                $selected_subcategories = $_GET['subcategory'];
            }
            foreach ($subcategories as $subcategory) {
                $checked = in_array($subcategory->term_id, $selected_subcategories) ? 'checked="checked"' : '';
                echo <<<HTML
                        <label class="my-2 inline-block cursor-pointer">
                            <input class="mr-2 w-4 h-4" type="checkbox" name="subcategory[]" value="$subcategory->term_id" $checked />
                            $subcategory->name
                        </label>
                        <br>
                    HTML;
            }; ?>
        </form>
    <?php endif; ?>

    <div class="filter wvl-field availability mb-4">
        <h3 class="text-lg font-bold">Availability</h3>

        <div class="wvl-calendar">
            <div class="calendar-header">
                <button id="prev-month">&lt;</button>
                <span id="month-year"></span>
                <button id="next-month">&gt;</button>
            </div>
            <div class="calendar-body">
                <div class="calendar-days">
                    <span>S</span>
                    <span>M</span>
                    <span>T</span>
                    <span>W</span>
                    <span>T</span>
                    <span>F</span>
                    <span>S</span>
                </div>
                <div class="calendar-dates" id="calendar-dates">
                </div>
            </div>
        </div>
    </div>
</div>
