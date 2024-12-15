<form action="<?php echo site_url('listing'); ?>" class="mb-6">
    <div class="flex justify-between items-center border border-quaternary rounded-md p-1">
        <input class="!bg-white !border-0" type="text" name="s" placeholder="Search for a venue" value="<?php echo get_query_var('location'); ?>">
        <button type="button" class="search-icon"><i class="fa-solid fa-magnifying-glass p-3 rounded-lg inline-block bg-primary text-white"></i></button>
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
            foreach ($subcategories as $subcategory) {
                echo <<<HTML
                        <label class="my-2 inline-block cursor-pointer">
                            <input class="mr-2 w-4 h-4" type="checkbox" name="subcategory[]" value="$subcategory->term_id" />
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

    <script>
        jQuery(document).ready(function($) {

            $('#categoryFilter input[name="category"]').on('change', function() {
                $('#categoryFilter').submit();
            });

            $('#subcategoryFilter input[name="subcategory[]"]').on('change', function() {
                const params = new URLSearchParams(window.location.search);
                params.delete('subcategory[]');

                $('input[name="subcategory[]"]:checked').each(function() {
                    params.append('subcategory[]', $(this).val());
                });
                const newUrl = `${window.location.pathname}?${params.toString()}`;
                window.history.replaceState({}, '', newUrl);
                window.location.href = newUrl;
            });

            const params = new URLSearchParams(window.location.search);
            $('#subcategoryFilter input[name="subcategory[]"]').each(function() {
                if (params.getAll('subcategory[]').includes($(this).val())) {
                    $(this).prop('checked', true);
                }
            });

            // const params = new URLSearchParams(window.location.search);
            // $('#categoryFilter input[name="category"]').each(function() {
            //     if (params.getAll('category').includes($(this).val())) {
            //         $(this).prop('checked', true);
            //     }
            // });

            <?php
            /*
                        // vendor types
                        $('#vendorTypesFilter input[name="vendor-types[]"]').on('change', function() {
                            const params = new URLSearchParams(window.location.search);
                            params.delete('vendor-types[]');

                            $('input[name="vendor-types[]"]:checked').each(function() {
                                params.append('vendor-types[]', $(this).val());
                            });
                            const newUrl = `${window.location.pathname}?${params.toString()}`;
                            window.history.replaceState({}, '', newUrl);
                            window.location.href = newUrl;
                        });

                        const params = new URLSearchParams(window.location.search);
                        $('#vendorTypesFilter input[name="vendor-types[]"]').each(function() {
                            if (params.getAll('vendor-types[]').includes($(this).val())) {
                                $(this).prop('checked', true);
                            }
                        });


                        // event types
                        $('#eventTypesFilter input[name="event-types[]"]').on('change', function() {
                            const params = new URLSearchParams(window.location.search);
                            params.delete('event-types[]');

                            $('input[name="event-types[]"]:checked').each(function() {
                                params.append('event-types[]', $(this).val());
                            });
                            const newUrl = `${window.location.pathname}?${params.toString()}`;
                            window.history.replaceState({}, '', newUrl);
                            window.location.href = newUrl;
                        });

                        $('#eventTypesFilter input[name="event-types[]"]').each(function() {
                            if (params.getAll('event-types[]').includes($(this).val())) {
                                $(this).prop('checked', true);
                            }
                        });

                        */
            ?>
        });
    </script>

</div>
