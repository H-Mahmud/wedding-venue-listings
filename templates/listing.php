<?php
get_header(); ?>

<div id="primary" class="listing-archive">
    <main id="main" class="site-main site-container md:flex md:gap-8 md:justify-between items-start block" role="main">
        <div class="wvl-sidebar md:w-[310px] w-full">

            <form action="<?php echo site_url('listing'); ?>" class="mb-6">
                <div class="flex justify-between items-center border border-quaternary rounded-md p-1">
                    <input class="!bg-white !border-0" type="text" name="s" placeholder="Search for a venue" value="<?php echo get_query_var('location'); ?>">
                    <button type="button" class="search-icon"><i class="fa-solid fa-magnifying-glass p-3 rounded-lg inline-block bg-primary text-white"></i></button>
                </div>
            </form>

            <div class="wvl-widgets border-quaternary border px-5 py-6 rounded-md">

                <div class="filter vendor-types">
                    <h3>vendor Types</h3>
                    <?php
                    $vendor_types = get_wvl_terms_options('vendor_type');
                    foreach ($vendor_types as $vendor_type) { ?>
                        <label>
                            <input type="checkbox" name="vendor-types[]" value="<?php echo $vendor_type['value']; ?>" />
                            <?php echo $vendor_type['label']; ?>
                        </label>
                        <br>
                    <?php
                    }; ?>
                </div>

                <div class="filter event-types">
                    <h3>Event Types</h3>
                    <?php
                    $event_types = get_wvl_terms_options('event_type');
                    foreach ($event_types as $event_type) { ?>

                        <label>
                            <input type="checkbox" name="event_types[]" value="<?php echo $event_type['value']; ?>" />
                            <?php echo $event_type['label']; ?>
                        </label>
                        <br>
                    <?php
                    }; ?>
                </div>

                <div class="filter wvl-field availability">
                    <h3>Availability</h3>
                    <input type="date">
                </div>

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
                <p class="total-result"><?php echo $query->found_posts; ?> Venues Found</p>
                <div class="wvl-list">
                    <?php
                    while ($query->have_posts()) :
                        $query->the_post(); ?>

                        <div class="wvl-list-item">
                            <div class="thumbnail">
                                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Venue Image">
                            </div>
                            <div class="item-content">
                                <h2 class="item-title text-4xl">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div>
                                    <i class="fa-solid fa-location-dot"></i>
                                    1901 Thornridge Cir. Shiloh, Hawaii 81063
                                </div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a </p>
                                <div class="meta">
                                    <span>Price Range: <b>$1000 - $5000</b></span>
                                    <span>
                                        <span class="stars">
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                        </span>
                                        <span class="amount">(1.8 k+ Reviews)</span>
                                    </span>
                                </div>
                                <a href="<?php the_permalink(); ?>"><button>Request a Pricing</button></a>
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
