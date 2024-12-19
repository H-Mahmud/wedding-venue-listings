<?php
get_header(); ?>
<div id="primary" class="listing-archive mt-4">
    <main id="main" class="site-container" role="main">
        <div class="wvl-sidebar">
            <?php load_template(WVL_PLUGIN_DIR . 'templates/parts/sidebar.php'); ?>
        </div>
        <div class="listing-content w-full">
            <?php
            $args = array(
                'post_type' => 'venue',
                'posts_per_page' => -1,
            );

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

            $args = [
                'dates' => $booking_dates,
                'category_ids' => $subcategories,
                'taxonomy_terms' => $locations,
                'search' => $search_query,
                'order_by_mime_type' => true,
                'paged' => 1,
                'posts_per_page' => 10,
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

                    ?>
                </div>
            <?php else:  ?>
                <p class="no-result"><?php _e('No vendor found', 'wedding-venue-listings'); ?></p>
            <?php endif; ?>

        </div>
    </main>
</div>
<?php get_footer(); ?>
