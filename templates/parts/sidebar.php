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
                $selected_category = 0;
                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $selected_category = intval($_GET['category']);
                }
                $categories = get_categories(array('hide_empty' => false));
                foreach ($categories as $category) {
                    if ($category->parent == 0) {
                        $checked = $selected_category == $category->term_id ? 'checked="checked"' : '';
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
        </div>


        <div class="filter subcategory" id="subcategoryFilter" method="get">
            <div class="header">
                <h3 class="title"><?php _e('Subcategory', 'wedding-venue-listings'); ?></h3>
                <i class="fa-solid fa-angle-up toggle-icon"></i>
            </div>
            <div class="content">
            </div>
        </div>

        <div class="filter wvl-field availability mb-4">
            <div class="header">
                <h3 class="title"><?php _e('Availability', 'wedding-venue-listings'); ?></h3>
                <i class="fa-solid fa-angle-up toggle-icon"></i>
            </div>
            <div class="content mt-6">
                <input class="!hidden" type="text" id="selected-dates" name="booking-date" value="<?php echo isset($_GET['booking-date']) ? $_GET['booking-date'] : ''; ?>" placeholder="<?php _e('Select a date', 'wedding-venue-listings'); ?>" readonly />
                <div class="wvl-calendar" id="booking-calendar"></div>
            </div>
        </div>
    </div>
    <button type="submit" class="wvl-btn-primary filter-btn"><?php _e('Filter', 'wedding-venue-listings'); ?></button>
</form>

<?php
$categories_by_parent = [];
foreach ($categories as $category) {
    $categories_by_parent[$category->parent][] = $category;
}
$categories_json = json_encode($categories_by_parent);

$selected_subcategories = [];
if (isset($_GET['subcategory']) && !empty($_GET['subcategory']) && is_array($_GET['subcategory'])) {
    $selected_subcategories = array_map('intval', $_GET['subcategory']);
}
?>

<script>
    const categoriesData = <?php echo $categories_json; ?>;

    jQuery(document).ready(function($) {

        const category = $('#categoryFilter input[name="category"]');
        const subcategory = $('#subcategoryFilter .content');

        subcategoryOptions(<?php echo json_encode($selected_category); ?>);

        // Event listener for category change
        category.on('change', function() {
            const selectedCategory = this.value;
            subcategory.empty();
            if (selectedCategory) {
                subcategoryOptions(selectedCategory);
            }
        });

        // Function to populate subcategories
        function subcategoryOptions(selectedCategory) {
            const subcategories = categoriesData[selectedCategory] || [];
            const selectedSubcategory = <?php echo json_encode($selected_subcategories); ?>;

            for (let i = 0; i < subcategories.length; i++) {
                const subcat = subcategories[i];
                const label = $('<label class="name">' + subcat.name + '</label>');
                const input = $('<input class="checkbox" type="checkbox" name="subcategory[]" value="' + subcat.term_id + '" />');
                if (selectedSubcategory && typeof selectedSubcategory === 'object' && selectedSubcategory.includes(subcat.term_id)) {
                    input.attr('checked', 'checked');
                }
                label.prepend(input);
                subcategory.append(label);
            }

        }
    });
</script>
