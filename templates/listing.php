<?php
get_header(); ?>

<div id="primary" class="listing-archive">
    <main id="main" class="site-main site-container md:flex md:gap-10 md:justify-between items-start block" role="main">
        <div class="wvl-sidebar md:w-[310px] w-full">

            <form action="<?php echo site_url('listing'); ?>" class="mb-6">
                <div class="flex justify-between items-center border border-quaternary rounded-md p-1">
                    <input class="!bg-white !border-0" type="text" name="s" placeholder="Search for a venue" value="<?php echo get_query_var('location'); ?>">
                    <button type="button" class="search-icon"><i class="fa-solid fa-magnifying-glass p-3 rounded-lg inline-block bg-primary text-white"></i></button>
                </div>
            </form>

            <div class="wvl-widgets border-quaternary border px-5 py-6 rounded-md">

                <form class="filter vendor-types mb-5" id="vendorTypesFilter" method="get">
                    <h3 class="text-lg font-bold"><?php _e('vendor Types', 'wedding-venue-listings'); ?></h3>
                    <?php
                    $vendor_types = get_wvl_terms_options('vendor_type');
                    foreach ($vendor_types as $vendor_type) { ?>
                        <label class="my-2 inline-block cursor-pointer">
                            <input class="mr-2 w-4 h-4" type="checkbox" name="vendor-types[]" value="<?php echo $vendor_type['value']; ?>" />
                            <?php echo $vendor_type['label']; ?>
                        </label>
                        <br>
                    <?php
                    }; ?>
                </form>

                <form class="filter event-types mb-5" id="eventTypesFilter" method="get">
                    <h3 class="text-lg font-bold"><?php _e('Event Types', 'wedding-venue-listings'); ?></h3>
                    <?php
                    $event_types = get_wvl_terms_options('event_type');
                    foreach ($event_types as $event_type) { ?>

                        <label class="my-2 inline-block cursor-pointer">
                            <input class="mr-2 w-4 h-4" type="checkbox" name="event-types[]" value="<?php echo $event_type['value']; ?>" />
                            <?php echo $event_type['label']; ?>
                        </label>
                        <br>
                    <?php
                    }; ?>
                </form>

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

                    });
                </script>

            </div>
        </div>

        <div class="wvl-content w-full">
            <?php

            $args = array(
                'post_type' => 'venue',
                'posts_per_page' => -1,
            );
            $query = new WP_Query($args);

            if ($query->have_posts()):
            ?>
                <p class="total-result font-semibold text-2xl mb-8 mt-2"><span><?php echo $query->found_posts; ?></span> Search Result</p>
                <div class="wvl-list">
                    <?php
                    while ($query->have_posts()) :
                        $query->the_post(); ?>

                        <div class="wvl-list-item grid grid-cols-[320px_1fr] gap-8">
                            <div class="thumbnail h-full max-w-80">
                                <?php the_post_thumbnail('full', array('class' => 'w-full h-full block object-cover rounded-md'));
                                ?>

                            </div>
                            <div class="item-content flex-1">
                                <h2 class="item-title">
                                    <a class=" font-semibold text-2xl" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <p class="text-secondary py-2 text-sm">
                                    <i class="fa-solid fa-location-dot text-primary"></i>
                                    1901 Thornridge Cir. Shiloh, Hawaii 81063
                                </p>
                                <p class="text-secondary text-sm mt-1"><?php echo wvl_get_excerpt_content(get_the_ID()); ?></p>
                                <div class="meta flex mt-5 gap-4">
                                    <span class="inline-block text-secondary text-sm">Price Range: <b class="text-primary">$1000 - $5000</b></span>

                                    <span class="h-6 w-[1.5px] bg-quaternary inline-block"></span>

                                    <span class="inline-flex">
                                        <span class="stars inline-flex justify-start gap-1">
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                        </span>
                                        <span class="text-secondary text-sm">(1.8 k+ Reviews)</span>
                                    </span>
                                </div>
                                <div class="mt-4">
                                    <a class="wvl-btn-primary " href="<?php the_permalink(); ?>">Request a Pricing</a>
                                </div>
                        <?php
                    endwhile;
                else:
                    echo '<p>No Venues Found</p>';
                endif;
                wp_reset_postdata();
                        ?>
                            </div>
                        </div>
    </main>
</div>

<?php get_footer(); ?>
