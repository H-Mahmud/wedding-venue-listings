<?php
add_shortcode('wvl-listing', 'wvl_listing_shortcode');
function wvl_listing_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'ids' => [],
        'categories' => [],
        'featured' => false,
        'count' => 10
    ), $atts);

    $query = wvl_get_listing($atts);

    ob_start(); ?>
    <div class="wvl-listing-list">
        <?php
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post(); ?>

                <div class="listing-item" data-id="<?php the_ID(); ?>">
                    <a href="<?php the_permalink(); ?>">
                        <div class="thumbnail">
                            <?php the_post_thumbnail('full', array('class' => 'thumbnail-image')); ?>
                        </div>
                    </a>

                    <div class="content">
                        <h2 class="title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="location">
                            <i class="fa-solid fa-location-dot icon"></i>
                            <?php echo wvl_get_venue_address(get_the_ID()); ?>
                        </p>
                        <p class="description"><?php echo wvl_get_excerpt_content(get_the_ID(), 80); ?></p>
                        <div class="meta">
                            <span class="reviews">
                                <star-rating min="0" max="5" value="<?php echo wvl_get_venue_average_rating(get_the_ID()); ?>"></star-rating>
                                <span class="count">
                                    <?php wvl_venue_review_count(get_the_ID()); ?>
                                </span>
                            </span>
                        </div>
                        <div class="actions">
                            <a class="wvl-btn-primary" href="<?php the_permalink(); ?>"><?php _e('Request Pricing', 'wedding-venue-listings'); ?></a>
                        </div>
                    </div>
                </div>

        <?php
            }
        }
        wp_reset_postdata();
        ?>
    </div>

<?php
    return ob_get_clean();
}

// Get top listings

// listing by ids

// listing by filter ultimate, pro, free



function wvl_get_listing($array = array())
{
    $defaults = array(
        'ids' => [],
        'categories' => [],
        'featured' => false,
        'count' => 10
    );

    $args = wp_parse_args($array, $defaults);

    $query_args = array(
        'post_type' => 'venue',
        'post_status' => 'publish',
        'posts_per_page' => $args['count'],
        'post__in' => $args['ids'],
    );

    if ($args['featured']) {
        $query_args['orderby'] = 'post_mime_type';
        $query_args['order'] = 'ASC';
    }

    $query = new WP_Query($query_args);

    return $query;
}
