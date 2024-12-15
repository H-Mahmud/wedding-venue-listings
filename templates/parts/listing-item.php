<div class="venue-item wvl-list-item block sm:grid grid-cols-[320px_1fr] gap-8 mb-5" data-id="<?php the_ID(); ?>">
    <div class="thumbnail h-full w-full sm:max md:max-w-80">
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
            <?php /*
                                    <span class="inline-block text-secondary text-sm">Price Range: <b class="text-primary">$1000 - $5000</b></span> 

                                    <span class="h-6 w-[1.5px] bg-quaternary inline-block"></span>
*/ ?>
            <span class="inline-flex items-center">
                <style>
                    .meta star-rating {
                        --font-size: 18px;
                    }
                </style>
                <star-rating min="0" max="5" value="<?php echo get_post_meta(get_the_ID(), 'average_rating', true); ?>"></star-rating>
                <span class="text-secondary text-sm">
                    <?php
                    $comment_count = get_comment_count(get_the_ID());
                    printf(_n('(%s Review)', '(%s Reviews)', $comment_count['approved'], 'wedding-venue-listings'), $comment_count['approved']);
                    ?>
                </span>
            </span>
        </div>
        <div class="mt-4">
            <a class="wvl-btn-primary " href="<?php the_permalink(); ?>">Request a Pricing</a>
        </div>
    </div>
</div>
