<?php
get_header(); ?>
<div id="primary" class="listing-archive mt-4">
    <main id="main" class="site-container" role="main">
        <div class="wvl-sidebar">
            <?php load_template(WVL_PLUGIN_DIR . 'templates/parts/sidebar.php'); ?>
        </div>
        <div class="listing-content w-full">
            <?php
            $subcategories = [];
            if (isset($_GET['subcategory']) && !empty($_GET['subcategory']) && is_array($_GET['subcategory'])) {
                $subcategories = array_map('intval', $_GET['subcategory']);
            }

            $locations = [];
            if (isset($_GET['location']) && !empty($_GET['location']) && is_array($_GET['location'])) {
                $locations = array_map('intval', $_GET['location']);
            }


            $booking_dates = [];
            if (isset($_GET['booking-date']) && !empty($_GET['booking-date'])) {
                $dates = sanitize_text_field($_GET['booking-date']);
                $booking_dates = explode(',', $dates);
            }

            $search_query = '';
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search_query = sanitize_text_field($_GET['search']);
            }

            $current_page = 1;
            if (isset($_GET['lpage']) && !empty($_GET['lpage'])) {
                $current_page = intval($_GET['lpage']);
            }

            $per_page = 10;

            $args = [
                'dates' => $booking_dates,
                'category_ids' => $subcategories,
                'taxonomy_terms' => $locations,
                'search' => $search_query,
                'order_by_mime_type' => true,
                'paged' =>  $current_page,
                'posts_per_page' => $per_page,
            ];

            $venue_query = new WVL_Venue_Query($args);
            if ($venue_query->have_posts()) : ?>
                <p class="total-result"><span class="amount"><?php echo $venue_query->get_total_count(); ?></span> <?php _e('Vendor found', 'wedding-venue-listings'); ?></p>
                <div class="wvl-list">
                    <?php
                    $collection_data = [];
                    while ($venue_query->have_posts()) {
                        $post = $venue_query->the_post();

                        $collection_data[] = get_the_ID();
                        load_template(WVL_PLUGIN_DIR . 'templates/parts/listing-item.php', false);
                    }

                    WVL_Process_Analytics_Data::print('data_1', $collection_data);

                    wvl_pagination(
                        function ($page_number) {
                            $query = [];
                            $url = site_url('listing');
                            if (isset($_GET) && count($_GET) > 0) {
                                $query = $_GET;
                            }
                            $query['lpage'] = $page_number;
                            return add_query_arg($query, $url);
                        },
                        $venue_query->get_total_count() / $per_page,
                        $current_page
                    );
                    ?>
                </div>
            <?php else:  ?>
                <p class="no-result"><?php _e('No vendor found', 'wedding-venue-listings'); ?></p>
            <?php endif; ?>

        </div>
    </main>
</div>
<?php get_footer(); ?>
