<form class="mt-14 profile-step-forms" id="profileServiceForm" data-step="1">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2 text-center"><?php _e('Service Information', 'wedding-venue-listings'); ?></legend>
        <div class="wvl-field">
            <label for="venue_name">
                Venue Name <br>
                <input type="text" name="venue_name" value="<?php echo $venue->post_title; ?>" id="venue_name">
            </label>
        </div>


        <div class="wvl-field-row mt-3">
            <div class="wvl-field">
                <label for="vendor_type">
                    Vendor Type <br>
                    <select name="vendor_type" id="vendor_type"></select>
                </label>
            </div>

            <div class="wvl-field">
                <label for="event_type">
                    Event Type <br>
                    <select name="event_type" id="event_type"></select>
                </label>
            </div>
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
                <label for="category">
                    Category <br>
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
                </label>
            </div>

            <div class="wvl-field">
                <label for="subcategory">
                    Subcategory <br>
                    <select name="subcategory" id="subcategory"></select>
                </label>
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
