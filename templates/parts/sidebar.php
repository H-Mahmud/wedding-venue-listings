<script>
    /** TODO: Refactor */
    jQuery(document).ready(function($) {
        $('.listing-archive .filter .header .toggle-icon').on('click', function() {
            $(this).toggleClass('fa-angle-up');
            $(this).toggleClass('fa-angle-down');
            $(this).closest('.filter').find('.content').slideToggle();
        })


        // $('#categoryFilter input[name="category"]').on('change', function() {
        //     $('#categoryFilter').submit();
        // });
        // $('#subcategoryFilter input[name="subcategory[]"]').on('change', function() {
        //     const params = new URLSearchParams(window.location.search);
        //     params.delete('subcategory[]');
        //     $('input[name="subcategory[]"]:checked').each(function() {
        //         params.append('subcategory[]', $(this).val());
        //     });
        //     const newUrl = `${window.location.pathname}?${params.toString()}`;
        //     window.history.replaceState({}, '', newUrl);
        //     window.location.href = newUrl;
        // });
        // const params = new URLSearchParams(window.location.search);
        // $('#subcategoryFilter input[name="subcategory[]"]').each(function() {
        //     if (params.getAll('subcategory[]').includes($(this).val())) {
        //         $(this).prop('checked', true);
        //     }
        // });


    })
</script>
<form action="<?php echo site_url('listing'); ?>">
    <div class="search-container">
        <input class="search-input" type="text" name="search" placeholder="<?php _e('Search for a vendor', 'wedding-venue-listings'); ?>" value="<?php echo get_query_var('search'); ?>">
        <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass icon"></i></button>
    </div>


    <div class="filter-container mt-6">

        <div class="filter support-location" id="locationFilter" method="get">
            <div class="header">
                <h3 class="title"><?php _e('Support Location', 'wedding-venue-listings'); ?></h3>
                <i class="fa-solid fa-angle-up toggle-icon"></i>
            </div>
            <div class="content">
                <?php

                $selected_locations = [];
                if (isset($_GET['location']) && !empty($_GET['location']) && is_array($_GET['location'])) {
                    $selected_locations = array_map('intval', $_GET['location']);
                }
                $support_locations = get_terms(array(
                    'taxonomy' => 'support_location',
                    'hide_empty' => true,
                ));
                foreach ($support_locations as $location) {
                    $checked = '';
                    if (in_array($location->term_id, $selected_locations)) {
                        $checked = 'checked';
                    }
                    echo <<<HTML
                        <label class="name" for="location-$location->term_id">
                            <input class="checkbox" id="location-$location->term_id" type="checkbox" name="location[]" value="$location->term_id" $checked />
                            $location->name
                        </label>
                    HTML;
                };
                ?>
            </div>
        </div>

        <div class="filter category" id="categoryFilter" method="get">
            <div class="header">
                <h3 class="title"><?php _e('Category', 'wedding-venue-listings'); ?></h3>
                <i class="fa-solid fa-angle-up toggle-icon"></i>
            </div>
            <div class="content">
                <?php
                $categories = get_categories(array('hide_empty' => false));
                foreach ($categories as $category) {
                    if ($category->parent == 0) {
                        $checked = isset($_GET['category']) && $_GET['category'] == $category->term_id ? 'checked="checked"' : '';
                        echo <<<HTML
                        <label class="name">
                            <input class="radio" type="radio" name="category" value="$category->term_id" $checked />
                            $category->name
                        </label>
                    HTML;
                    }
                };
                ?>
            </div>


            <?php
            if (isset($_GET['category']) && !empty($_GET['category']) && is_numeric($_GET['category'])):
                $parent_id = $_GET['category'];
                $args = [
                    'parent'     => $parent_id,
                    'hide_empty' => false,
                    'taxonomy'   => 'category',
                ];
            ?>
                <div class="filter subcategory" id="subcategoryFilter" method="get">
                    <div class="header">
                        <h3 class="title"><?php _e('Subcategory', 'wedding-venue-listings'); ?></h3>
                        <i class="fa-solid fa-angle-up toggle-icon"></i>
                    </div>
                    <div class="content">
                        <?php
                        $subcategories = get_terms($args);
                        $selected_subcategories = [];
                        if (isset($_GET['subcategory']) && !empty($_GET['subcategory']) && is_array($_GET['subcategory'])) {
                            $selected_subcategories = $_GET['subcategory'];
                        }
                        foreach ($subcategories as $subcategory) {
                            $checked = in_array($subcategory->term_id, $selected_subcategories) ? 'checked="checked"' : '';
                            echo <<<HTML
                        <label class="name">
                            <input class="checkbox" type="checkbox" name="subcategory[]" value="$subcategory->term_id" $checked />
                            $subcategory->name
                        </label>
                    HTML;
                        };
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- TODO: Refactor -->
            <div class="filter wvl-field availability mb-4">
                <div class="header">
                    <h3 class="title"><?php _e('Availability', 'wedding-venue-listings'); ?></h3>
                    <i class="fa-solid fa-angle-up toggle-icon"></i>
                </div>

                <div class="content wvl-calendar">
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

        <button type="submit" class="wvl-btn-primary filter-btn"><?php _e('Filter', 'wedding-venue-listings'); ?></button>
    </div>
</form>

<?php
$categories = get_categories(array('hide_empty' => false));
$categories_by_parent = [];
foreach ($categories as $category) {
    $categories_by_parent[$category->parent][] = $category;
}
$categories_json = json_encode($categories_by_parent);

?>
<div class="wvl-field-row mt-3">
    <div class="wvl-field">
        <label for="category"><?php _e('Category', 'wedding-venue-listings'); ?></label>

        <select name="category" id="category">
            <option value="">Select a category</option>
            <?php if (!empty($categories_by_parent[0])) :
                foreach ($categories_by_parent[0] as $parent) :
                    if (true) {
                        echo <<<HTML
                                    <option value="$parent->term_id" selected="selected">
                                        $parent->name
                                    </option>
                                HTML;
                    } else {
                        echo <<<HTML
                                    <option value="$parent->term_id">
                                        $parent->name
                                    </option>
                                HTML;
                    }

                endforeach;
            endif; ?>
        </select>
    </div>

    <div class="wvl-field">
        <label for="subcategory"><?php _e('Subcategory', 'wedding-venue-listings'); ?></label>
        <select name="subcategory" class="wvl-tags" multiple id="subcategory"></select>
    </div>
</div>



<script>
    const categoriesData = <?php echo $categories_json; ?>;

    jQuery(document).ready(function($) {

        const category = $('#category');
        const subcategory = $('#subcategory');

        // Initialize subcategory options on page load
        subcategoryOptions(<?php echo json_encode($category); ?>);

        // Event listener for category change
        category.on('change', function() {
            const selectedCategory = this.value;

            if (selectedCategory) {
                subcategoryOptions(selectedCategory);
            }
        });

        // Function to populate subcategories
        function subcategoryOptions(selectedCategory) {
            const subcategories = categoriesData[selectedCategory] || [];
            const selectedSubcategory = <?php echo json_encode($subcategory); ?>;

            for (let i = 0; i < subcategories.length; i++) {
                const subcat = subcategories[i];
                const option = $('<option></option>').val(subcat.term_id).text(subcat.name);
                if (selectedSubcategory && selectedSubcategory === subcat.term_id) {
                    option.attr('selected', 'selected');
                }
                subcategory.append(option);
            }

        }
    });
</script>
