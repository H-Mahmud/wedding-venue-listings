<div class="listing-item" data-id="<?php the_ID(); ?>">
    <div class="thumbnail">
        <?php the_post_thumbnail('full', array('class' => 'w-full h-full block object-cover rounded-md'));
        ?>

    </div>
    <div class="content">
        <h2 class="title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <p class="location">
            <i class="fa-solid fa-location-dot icon"></i>
            1901 Thornridge Cir. Shiloh, Hawaii 81063
        </p>
        <p class="description"><?php echo wvl_get_excerpt_content(get_the_ID()); ?></p>
        <div class="meta">
            <span class="reviews">
                <star-rating min="0" max="5" value="<?php echo get_post_meta(get_the_ID(), 'average_rating', true); ?>"></star-rating>
                <span class="count">
                    <?php
                    $comment_count = get_comment_count(get_the_ID());
                    printf(_n('(%s Review)', '(%s Reviews)', $comment_count['approved'], 'wedding-venue-listings'), $comment_count['approved']);
                    ?>
                </span>
            </span>
        </div>
        <div class="actions">
            <a class="wvl-btn-primary " href="<?php the_permalink(); ?>"><?php _e('Request a Pricing', 'wedding-venue-listings'); ?></a>
        </div>
    </div>
</div>
