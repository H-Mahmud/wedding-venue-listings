<script>
    /** TODO: Refactor */
    jQuery(document).ready(function($) {
        $('.listing-archive .filter .header .toggle-icon').on('click', function() {
            $(this).toggleClass('fa-angle-up');
            $(this).toggleClass('fa-angle-down');
            $(this).closest('.filter').find('.content').slideToggle();
        })


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


    })
</script>
<form action="<?php echo site_url('listing'); ?>" class="mb-6">
    <div class="search-container">
        <input class="search-input" type="text" name="s-vendor" placeholder="<?php _e('Search for a vendor', 'wedding-venue-listings'); ?>" value="<?php echo get_query_var('s-vendor'); ?>">
        <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass icon"></i></button>
    </div>
</form>

<div class="filter-container">
    <form class="filter category" id="categoryFilter" method="get">
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
        <form class="filter subcategory" id="subcategoryFilter" method="get">
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
        </form>
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
