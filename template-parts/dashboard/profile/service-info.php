<form class="mt-14 profile-step-forms" id="profileServiceForm" data-step="2">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Service Information', 'wedding-venue-listings'); ?></legend>
        <div class="wvl-field">
            <label for="venue_name"><?php _e('Venue Name', 'wedding-venue-listings'); ?></label>
            <input type="text" name="venue_name" value="<?php echo $venue->post_title; ?>" id="venue_name" required>
        </div>

        <div class="wvl-field-row mt-3 wvl-tags">
            <div class="wvl-field">
                <label for="vendor_type"> <?php _e('Vendor Types', 'wedding-venue-listings'); ?></label>
                <select name="vendor_type" id="vendor_type" multiple></select>
            </div>

            <div class="wvl-field">
                <label for="event_type"> <?php _e('Event Types', 'wedding-venue-listings'); ?></label>
                <select name="event_type" id="event_type" multiple></select>
            </div>

            <?php

            // Get current venue selected vendor_types
            $selected_vendor_types = get_the_terms($venue_id, 'vendor_type');
            $selected_vendor_slugs = [];
            foreach ($selected_vendor_types as $vendor_type) {
                $selected_vendor_slugs[] = $vendor_type->slug;
            }

            // Get all vendor and event types
            $vendor_types_object = get_terms(array(
                'taxonomy' => 'vendor_type',
                'hide_empty' => false,
            ));

            $vendor_types = [];
            foreach ($vendor_types_object as $vendor_type) {
                $term = ['value' => $vendor_type->slug, 'label' => $vendor_type->name];
                if (in_array($vendor_type->slug, $selected_vendor_slugs)) {
                    $term['selected'] = true;
                }
                $vendor_types[] = $term;
            };

            // Get current venue selected event_types
            $selected_event_types = get_the_terms($venue_id, 'event_type');
            $selected_event_slugs = [];
            foreach ($selected_event_types as $event_type) {
                $selected_event_slugs[] = $event_type->slug;
            }

            // Get all vendor and event types
            $event_types_object = get_terms(array(
                'taxonomy' => 'event_type',
                'hide_empty' => false,
            ));

            $event_types = [];
            foreach ($event_types_object as $event_type) {
                $term = ['value' => $event_type->slug, 'label' => $event_type->name];
                if (in_array($event_type->slug, $selected_event_slugs)) {
                    $term['selected'] = true;
                }
                $event_types[] = $term;
            };
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const vendorChoices = new Choices("#vendor_type", {
                        removeItemButton: true,
                        maxItemCount: <?php echo wvl_get_terms_limit('vendor_type'); ?>,
                        choices: <?php echo json_encode($vendor_types); ?>,
                        searchResultLimit: 10,
                        searchEnabled: true,
                        maxItemText: (maxItemCount) => {
                            return `Only ${maxItemCount} vendor types can be added with free plan`;
                        },
                    });
                    const eventChoices = new Choices("#event_type", {
                        removeItemButton: true,
                        maxItemCount: <?php echo wvl_get_terms_limit('vendor_type'); ?>,
                        choices: <?php echo json_encode($event_types); ?>,
                        searchResultLimit: 10,
                        searchEnabled: true,
                        maxItemText: (maxItemCount) => {
                            return `Only ${maxItemCount} Event types can be added with free plan`;
                        },
                    });
                });
            </script>
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
                <select name="subcategory" id="subcategory"></select>
            </div>
        </div>
    </fieldset>
</form>

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

            const selectedSubcategory = <?php echo $subcategory; ?>;

            if (subcategories) {
                subcategories.forEach(category => {
                    if (selectedSubcategory && selectedSubcategory === category.term_id) {
                        subcategory.append(`<option value="${category.term_id}" selected="selected">${category.name}</option>`);
                    } else {
                        subcategory.append(`<option value="${category.term_id}">${category.name}</option>`);
                    }
                });
            }
        }
    })
</script>
