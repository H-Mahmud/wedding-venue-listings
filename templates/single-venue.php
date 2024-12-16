<?php get_header(); ?>
<div id="primary" class="single-venue">
    <?php
    while (have_posts()) {
        the_post(); ?>
        <div class="cover-photo">
            <?php the_post_thumbnail('full', array('class' => '')); ?>
        </div>
        <main id="main" class="site-container" role="main">
            <div class="header">
                <div class="entry-header">
                    <?php the_title('<h1 class="title text-4xl font-bold">', '</h1>'); ?>
                    <div class="meta">
                        <div class="address">
                            <i class="fa-solid fa-location-dot icon"></i>
                            <?php echo wvl_get_venue_address(get_the_ID()); ?>
                        </div>
                        <span class="separator"></span>

                        <div class="reviews">
                            <star-rating min="0" max="5" value="<?php echo get_post_meta(get_the_ID(), 'average_rating', true); ?>"></star-rating>
                            <span class="count"> <?php wvl_venue_review_count(get_the_ID()); ?></span>
                        </div>
                    </div>
                </div>
                <div class="links">
                    <ul class="social">
                        <?php do_action('wvl_social_links'); ?>
                    </ul>
                    <button class="wvl-btn-primary open-modal-btn" id="contactFormOpen" data-target="#modal-contact"><?php _e('Contact Us', 'wedding-venue-listings'); ?></button>
                </div>
            </div>

            <div class="wvl-content">

                <div class="nav-tabs">
                    <a class="active" href="#overview">Overview</a>
                    <a href="#contact">Contact Info</a>
                    <a href="#photos">Photos</a>
                    <a href="#videos">Videos</a>
                    <a href="#locations">Supported Locations</a>
                    <a href="#reviews">Reviews</a>
                </div>

                <div class="description">
                    <?php the_content(); ?>
                </div>

                <div class="wvl-gallery">
                    <div class="entry mb-3 mt-6 flex justify-between items-center">
                        <h3 class="text-2xl font-semibold">Recent Events Gallery</h3>
                        <!-- <a id="view-all-btn" class="wvl-btn">
                            View All
                        </a> -->
                    </div>

                    <style type="text/css">
                        .demo-gallery>ul {
                            margin-bottom: 0;
                        }

                        .demo-gallery>ul>li {
                            float: left;
                            margin-bottom: 15px;
                            margin-right: 20px;
                            width: 200px;
                        }

                        .demo-gallery>ul>li a {
                            border: 3px solid #FFF;
                            border-radius: 3px;
                            display: block;
                            overflow: hidden;
                            position: relative;
                            float: left;
                        }

                        .demo-gallery>ul>li a>img {
                            -webkit-transition: -webkit-transform 0.15s ease 0s;
                            -moz-transition: -moz-transform 0.15s ease 0s;
                            -o-transition: -o-transform 0.15s ease 0s;
                            transition: transform 0.15s ease 0s;
                            -webkit-transform: scale3d(1, 1, 1);
                            transform: scale3d(1, 1, 1);
                            height: 100%;
                            width: 100%;
                        }

                        .demo-gallery>ul>li a:hover>img {
                            -webkit-transform: scale3d(1.1, 1.1, 1.1);
                            transform: scale3d(1.1, 1.1, 1.1);
                        }

                        .demo-gallery>ul>li a:hover .demo-gallery-poster>img {
                            opacity: 1;
                        }

                        .demo-gallery>ul>li a .demo-gallery-poster {
                            background-color: rgba(0, 0, 0, 0.1);
                            bottom: 0;
                            left: 0;
                            position: absolute;
                            right: 0;
                            top: 0;
                            -webkit-transition: background-color 0.15s ease 0s;
                            -o-transition: background-color 0.15s ease 0s;
                            transition: background-color 0.15s ease 0s;
                        }

                        .demo-gallery>ul>li a .demo-gallery-poster>img {
                            left: 50%;
                            margin-left: -10px;
                            margin-top: -10px;
                            opacity: 0;
                            position: absolute;
                            top: 50%;
                            -webkit-transition: opacity 0.3s ease 0s;
                            -o-transition: opacity 0.3s ease 0s;
                            transition: opacity 0.3s ease 0s;
                        }

                        .demo-gallery>ul>li a:hover .demo-gallery-poster {
                            background-color: rgba(0, 0, 0, 0.5);
                        }

                        .demo-gallery .justified-gallery>a>img {
                            -webkit-transition: -webkit-transform 0.15s ease 0s;
                            -moz-transition: -moz-transform 0.15s ease 0s;
                            -o-transition: -o-transform 0.15s ease 0s;
                            transition: transform 0.15s ease 0s;
                            -webkit-transform: scale3d(1, 1, 1);
                            transform: scale3d(1, 1, 1);
                            height: 100%;
                            width: 100%;
                        }

                        .demo-gallery .justified-gallery>a:hover>img {
                            -webkit-transform: scale3d(1.1, 1.1, 1.1);
                            transform: scale3d(1.1, 1.1, 1.1);
                        }

                        .demo-gallery .justified-gallery>a:hover .demo-gallery-poster>img {
                            opacity: 1;
                        }

                        .demo-gallery .justified-gallery>a .demo-gallery-poster {
                            background-color: rgba(0, 0, 0, 0.1);
                            bottom: 0;
                            left: 0;
                            position: absolute;
                            right: 0;
                            top: 0;
                            -webkit-transition: background-color 0.15s ease 0s;
                            -o-transition: background-color 0.15s ease 0s;
                            transition: background-color 0.15s ease 0s;
                        }

                        .demo-gallery .justified-gallery>a .demo-gallery-poster>img {
                            left: 50%;
                            margin-left: -10px;
                            margin-top: -10px;
                            opacity: 0;
                            position: absolute;
                            top: 50%;
                            -webkit-transition: opacity 0.3s ease 0s;
                            -o-transition: opacity 0.3s ease 0s;
                            transition: opacity 0.3s ease 0s;
                        }

                        .demo-gallery .justified-gallery>a:hover .demo-gallery-poster {
                            background-color: rgba(0, 0, 0, 0.5);
                        }

                        .demo-gallery .video .demo-gallery-poster img {
                            height: 48px;
                            margin-left: -24px;
                            margin-top: -24px;
                            opacity: 0.8;
                            width: 48px;
                        }

                        .demo-gallery.dark>ul>li a {
                            border: 3px solid #04070a;
                        }

                        .home .demo-gallery {
                            padding-bottom: 80px;
                        }
                    </style>

                    <div id="recent-gallery" class="demo-gallery grid grid-cols-2 md:grid-cols-4 gap-4">

                        <?php
                        $gallery_images = get_post_meta(get_the_ID(), 'venue_gallery', true);
                        if ($gallery_images && count($gallery_images) > 0) :
                            foreach ($gallery_images as $image) :
                                $image_url = wp_get_attachment_url($image);
                        ?>
                                <a href="<?php echo esc_url($image_url); ?>" class="lightgallery-item">
                                    <?php echo wp_get_attachment_image($image, 'medium', false, ['class' => 'max-h-full h-full w-full object-cover max-w-full rounded-lg']); ?>
                                </a>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            const lightGalleryInstance = $('#recent-gallery').lightGallery({
                                download: false
                            });
                        });
                    </script>
                </div>

                <div class="wvl-reviews mt-20">
                    <div class="mb-3">

                        <div class=" mb-3 mt-6 flex justify-between items-center">
                            <h3 class="text-2xl font-semibold"><?php _e('Reviews', 'wedding-venue-listings'); ?></h3>
                            <?php
                            if (is_user_logged_in()) {
                                $user_id = get_current_user_id();
                                $user_comments = get_comments([
                                    'user_id' => $user_id,
                                    'post_id' => get_the_ID(),
                                    // 'status'  => 'approve', // Only approved comments
                                ]);

                                if (!empty($user_comments)) {
                                    $review_text = __('Edit Your Review', 'wedding-venue-listings');
                                } else {
                                    $review_text = __('Write a Review', 'wedding-venue-listings');
                                }

                            ?>
                                <span class="wvl-btn" data-component-type="wlval-modal-trigger" data-target-modal="#review-modal">
                                    <?php echo $review_text ?>
                                </span>
                            <?php } ?>
                        </div>
                    </div>

                    <?php
                    do_action('wvl_review_form');
                    do_action('wvl_notice', 'wvl_review_form');
                    custom_comments_display(get_the_ID()); ?>
                </div>
            </div>
        </main>
        <?php do_action('wvl_related_venue', get_the_ID()); ?>

        <?php do_action('wvl_single_venue_after', get_the_ID()); ?>

        <script>
            jQuery(document).ready(function($) {
                $('#contactFormOpen').on('click', function() {
                    $('#contact-modal').addClass('flex');
                    $('#contact-modal').removeClass('hidden');

                })
                $('.close-contact-btn').click(function() {
                    $('#contact-modal').addClass('hidden');
                    $('#contact-modal').removeClass('flex');
                });

                $(window).click(function(event) {
                    if ($(event.target).is('#contact-modal .modal-content')) {
                        $('#contact-modal').addClass('hidden');
                        $('#contact-modal').removeClass('flex');
                    }
                });
            })
        </script>
    <?php
    }; ?>

</div>
<?php get_footer(); ?>
