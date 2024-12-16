<?php
add_action('wvl_related_venue', 'wvl_add_related_venue');
function wvl_add_related_venue()
{
    if (wvl_current_plan() !== 'free') return;
    global $post;

    $categories = wp_get_post_categories($post->ID);
    if (!empty($categories)) {
        $args = [
            'category__in'   => $categories,
            'post__not_in'   => [$post->ID],
            'posts_per_page' => 6,
            'orderby'        => 'rand',
            'post_type'     => 'venue'
        ];

        $related_posts = new WP_Query($args);

        if ($related_posts->have_posts()) {

?>
            <div class="site-container related-venue mt-6">
                <h3 class="text-2xl font-semibold"><?php _e('Related Venue', 'wedding-venue-listings'); ?></h3>
                <div class="related-items-wrapper">
                    <?php
                    while ($related_posts->have_posts()) {
                        $related_posts->the_post(); ?>

                        <div class="listing-item" data-id="<?php the_ID(); ?>">
                            <div class="thumbnail">
                                <?php the_post_thumbnail('full', array('class' => 'thumbnail-image')); ?>
                            </div>
                            <div class="content">
                                <h2 class="title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <p class="location">
                                    <i class="fa-solid fa-location-dot icon"></i>
                                    <?php echo wvl_get_venue_address(get_the_ID()); ?>
                                </p>
                                <div class="meta">
                                    <span class="reviews">
                                        <star-rating min="0" max="5" value="<?php echo wvl_get_venue_average_rating(get_the_ID()); ?>"></star-rating>
                                        <span class="count">
                                            <?php wvl_venue_review_count(get_the_ID()); ?>
                                        </span>
                                    </span>
                                </div>
                                <p class="description"><?php echo wvl_get_excerpt_content(get_the_ID()); ?></p>
                                <div class="actions">
                                    <a class="wvl-btn-primary" href="<?php the_permalink(); ?>"><?php _e('Request a Pricing', 'wedding-venue-listings'); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>

<?php
            // Reset post data to avoid conflicts with the main query
            wp_reset_postdata();
        }
    }
}