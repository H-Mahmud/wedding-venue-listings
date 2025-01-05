<div class="listing-item" data-id="<?php the_ID(); ?>">
    <a href="<?php echo the_permalink(get_the_ID()); ?>">
        <div class="thumbnail">
            <?php the_post_thumbnail('full', array('class' => 'thumbnail-image')); ?>
        </div>
    </a>
    <div class="content">
        <h2 class="title">
            <a href="<?php echo the_permalink(get_the_ID()); ?>"><?php the_title(); ?></a>
        </h2>
        <p class="location">
            <i class="fa-solid fa-location-dot icon"></i>
            <?php echo wvl_get_venue_address(get_the_ID()); ?>
        </p>
        <p class="description"><?php echo wvl_get_excerpt_content(get_the_ID()); ?></p>
        <div class="meta">
            <span class="reviews">
                <star-rating min="0" max="5" value="<?php echo wvl_get_venue_average_rating(get_the_ID()); ?>"></star-rating>
                <span class="count">
                    <?php wvl_venue_review_count(get_the_ID()); ?>
                </span>
            </span>
        </div>
        <div class="actions">
            <a class="wvl-btn-primary" href="<?php the_permalink(get_the_ID()); ?>"><?php _e('Request a Pricing', 'wedding-venue-listings'); ?></a>
        </div>
    </div>
</div>
