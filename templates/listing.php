<?php
get_header(); ?>
<div id="primary" class="listing-archive mt-4">
    <main id="main" class="site-container" role="main">
        <script>
            jQuery(document).ready(function($) {
                $("#openSidebarBtn").click(function() {
                    // $("#mobileSidebar").css("width", "100%");
                    $("#mobileSidebar").css("transform", "translateX(0%)");
                    console.log('cliced')
                });

                // Close the sidebar
                $("#closeSidebarBtn").click(function() {
                    // $("#mobileSidebar").css("width", "0");
                    $("#mobileSidebar").css("transform", "translateX(-100%)");
                });
            });
        </script>
        <style>
            @media (max-width: 767px) {
                #mobileSidebar {
                    height: 100%;
                    /* width: 0; */
                    transform: translateX(-100%);
                    position: fixed;
                    top: 0;
                    left: 0;
                    z-index: 99;
                    background-color: #FFF;
                    overflow-y: auto;
                    transition: 0.5s;
                    padding-top: 20px;
                    padding-left: 12px;
                    padding-right: 12px;
                }
            }
        </style>

        <div class="wvl-sidebar  " id="mobileSidebar">
            <p class="text-right md:hidden block"> <i id="closeSidebarBtn" class="close inline-block p-2 cursor-pointer text-2xl fa-solid fa-times"></i></p>
            <?php load_template(WVL_PLUGIN_DIR . 'templates/parts/sidebar.php', false); ?>
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
            ?>
            <div class="listing-entry flex justify-between items-center">
                <p class="total-result"><span class="amount"><?php echo $venue_query->get_total_count(); ?></span> <?php _e('Professionals Found', 'wedding-venue-listings'); ?></p>
                <span id="openSidebarBtn" class="listing-filter  md:hidden block border px-3 py-2 rounded-md text-sm text-gray-900"><?php _e('Filter', 'wedding-venue-listings'); ?></span>
            </div>

            <?php
            if ($venue_query->have_posts()) : ?>
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
                <p class="no-result"><?php _e('No Professional Found', 'wedding-venue-listings'); ?></p>
            <?php endif; ?>

        </div>
    </main>
</div>
<?php get_footer(); ?>
