<?php
get_header(); ?>

<div id="primary" class="listings">
    <main id="main" class="site-main site-container" role="main">
        <div class="wvl-sidebar">
            <form action="<?php echo site_url('listing'); ?>">
                <div class="wvl-search-form">
                    <input type="text" name="listing" placeholder="Search for a venue" value="<?php echo get_search_query(); ?>">
                    <input type="submit" value="Search">
                </div>

            </form>
            <div class="wlv-filter">
                <div class="venue-types">
                    <h3>Venue Types</h3>
                    <?php
                    $venue_types = get_terms(array(
                        'taxonomy' => 'venue_type',
                        'hide_empty' => false,
                    ));

                    foreach ($venue_types as $venue_type) { ?>

                        <label>
                            <input type="checkbox" name="venue_type[]" value="<?php echo $venue_type->slug; ?>" aria-invalid="false" />
                            <?php echo $venue_type->name; ?>
                        </label>
                        <br>
                    <?php
                    }; ?>
                </div>

                <div class="venue-services">
                    <h3>Venue Services</h3>
                    <?php
                    $venue_services = get_terms(array(
                        'taxonomy' => 'venue_service',
                        'hide_empty' => false,
                    ));

                    foreach ($venue_services as $venue_service) { ?>

                        <label>
                            <input type="checkbox" name="venue_service[]" value="<?php echo $venue_service->slug; ?>" aria-invalid="false" />
                            <?php echo $venue_service->name; ?>
                        </label>
                        <br>
                    <?php
                    }; ?>
                </div>

                <div class="venue-setting">
                    <h3>Venue Settings</h3>
                    <?php
                    $venue_settings = get_terms(array(
                        'taxonomy' => 'venue_setting',
                        'hide_empty' => false,
                    ));

                    foreach ($venue_settings as $venue_setting) { ?>

                        <label>
                            <input type="checkbox" name="venue_setting[]" value="<?php echo $venue_setting->slug; ?>" aria-invalid="false" />
                            <?php echo $venue_setting->name; ?>
                        </label>
                        <br>
                    <?php
                    }; ?>
                </div>

                <div class="availability">
                    <h3>Availability</h3>
                    <input type="date">
                </div>
            </div>
        </div>

        <div class="wvl-content">
            <?php

            $args = array(
                'post_type' => 'venue',
                'posts_per_page' => -1,
            );
            $query = new WP_Query($args);
            ?>

            <p class="total-result"><?php echo $query->found_posts; ?> Results</p>
            <div class="wvl-list">
                <?php
                while ($query->have_posts()) {
                    $query->the_post(); ?>

                    <div class="wvl-list-item">
                        <div class="thumbnail">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Venue Image">
                        </div>
                        <div class="wvl-list-item-content">
                            <h3 class="wvl-list-item-title">
                                <a href="<?php the_permalink(); ?>">Wedding place name goes here</a>
                            </h3>
                            <p>
                                <span>Location Icon</span>
                                1901 Thornridge Cir. Shiloh, Hawaii 81063
                            </p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a </p>
                            <div class="meta">
                                <p>Price Range: $1000 - $5000</p>
                                <p>Rating: 4.7</p>
                            </div>
                            <button>Request a Pricing</button>
                        <?php
                    }
                        ?>
                        </div>
                    </div>
    </main>
</div>

<?php get_footer(); ?>
