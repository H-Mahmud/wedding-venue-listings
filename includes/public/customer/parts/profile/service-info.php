<form class="mt-14 profile-step-forms" id="profileServiceForm" data-step="1">
    <fieldset class="wvl-fieldset">
        <legend class="text-center"><?php _e('Service Information', 'wedding-venue-listings'); ?></legend>
        <div class="wvl-field">
            <label for="venue_name"><?php _e('Venue Name', 'wedding-venue-listings'); ?></label>
            <input type="text" name="venue_name" value="<?php echo $venue->post_title; ?>" id="venue_name" required>
        </div>
        <?php
        $categories = get_categories(array('hide_empty' => false));
        $categories_by_parent = [];
        foreach ($categories as $category) {
            $categories_by_parent[$category->parent][] = $category;
        }
        $categories_json = json_encode($categories_by_parent);

        // Current Venue category and subcategory ids
        $categories = get_the_category($venue_id);
        $category = 0;
        $subcategory = 0;
        if (!empty($categories)) {
            foreach ($categories as $cat) {
                if ($cat->parent == 0) {
                    $category = $cat->term_id;
                } else {
                    $subcategory = $cat->term_id;
                }
            }
        }
        ?>
        <div class="wvl-field-row mt-3">
            <div class="wvl-field">
                <label for="category"><?php _e('Category', 'wedding-venue-listings'); ?></label>

                <select name="category" id="category">
                    <option value="">Select a category</option>
                    <?php if (!empty($categories_by_parent[0])) :
                        foreach ($categories_by_parent[0] as $parent) :
                            if ($parent->term_id == $category) {
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
                <?php if (wvl_current_plan() == 0) { ?>

                    <p class="text-orange-600 mt-0"><?php _e('Upgrade your plan to add unlimited subcategories', 'wedding-venue-listings'); ?></p>
                <?php

                } ?>
            </div>
        </div>

        <div class="wvl-field md:w-1/2">
            <label for="support_location"><?php _e('Support Location', 'wedding-venue-listings'); ?></label>
            <select name="support_location" class="wvl-tags" multiple id="support_location"></select>
            <?php if (wvl_current_plan()  == 0) { ?>
                <p class="text-orange-600 mt-0"><?php _e('Upgrade your plan to add unlimited Supported locations', 'wedding-venue-listings'); ?></p>
            <?php } ?>
        </div>
    </fieldset>
</form>

<?php
$selected_locations = get_the_terms($venue_id, 'support_location');
$selected_location_slugs = [];
if ($selected_locations) {
    foreach ($selected_locations as $location) {
        $selected_location_slugs[] = $location->slug;
    }
}


$taxonomy = 'support_location';
$post_type = 'venue';
$formatted_terms = [];
$all_terms = get_terms([
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
]);

if (!is_wp_error($all_terms)) {
    foreach ($all_terms as $term) {
        $location_term = [
            'label' => $term->name,
            'value' => $term->slug,
        ];

        if (in_array($term->slug, $selected_location_slugs)) {
            $location_term['selected'] = true;
        }
        $formatted_terms[] = $location_term;
    }
}

?>
<script>
    const categoriesData = <?php echo $categories_json; ?>;

    const locationChoicesList = <?php echo json_encode($formatted_terms); ?>;
    const locationChoices = new Choices("#support_location", {
        removeItemButton: true,
        maxItemCount: <?php echo wvl_get_support_location_limit(wvl_get_venue_id()); ?>,
        choices: locationChoicesList,
        searchResultLimit: 15,
        searchEnabled: true,
        maxItemText: (maxItemCount) => {
            return `Only ${maxItemCount} Supported location can be added in the free plan`;
        },
    });

    var subCategoryChoices;

    jQuery(document).ready(function($) {

        const category = $('#category');
        const subcategory = $('#subcategory');

        // Initialize subcategory options on page load
        subcategoryOptions(<?php echo json_encode($category); ?>);

        // Event listener for category change
        category.on('change', function() {
            const selectedCategory = this.value;

            if (subCategoryChoices) {
                subCategoryChoices.destroy();
                subcategory.empty();
            }

            if (selectedCategory) {
                subcategoryOptions(selectedCategory);
            }
        });

        // Function to populate subcategories
        function subcategoryOptions(selectedCategory) {
            const subcategories = categoriesData[selectedCategory] || [];
            const selectedSubcategory = <?php echo json_encode($subcategory); ?>;

            const choicesList = subcategories.map(subcat => ({
                value: subcat.term_id,
                label: subcat.name,
                selected: selectedSubcategory && selectedSubcategory === subcat.term_id,
            }));

            // Clear subcategory DOM element to ensure no leftover options
            subcategory.empty();

            // Reinitialize Choices with new subcategory options
            subCategoryChoices = new Choices("#subcategory", {
                removeItemButton: true,
                maxItemCount: <?php echo wvl_get_terms_limit('subcategory'); ?>,
                choices: choicesList,
                searchResultLimit: 10,
                searchEnabled: true,
                maxItemText: (maxItemCount) => {
                    return `Only ${maxItemCount} subcategory can be added in the free plan`;
                },
            });
        }
    });
</script>
