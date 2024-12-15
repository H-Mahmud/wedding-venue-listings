<?php get_header(); ?>
<div id="primary" class="single-venue bg-white">
    <?php
    while (have_posts()) {
        the_post(); ?>
        <div class="cover-photo w-full max-h-[520px] overflow-hidden md:min-h-80">
            <?php the_post_thumbnail('full', array('class' => 'w-full h-auto block object-cover')); ?>
        </div>
        <main id="main" class="site-main site-container pt-4" role="main">
            <div class="header md:flex justify-between items-center">
                <div class="entry-header">
                    <?php the_title('<h1 class="title text-4xl font-bold">', '</h1>'); ?>
                    <style>
                        .meta star-rating {
                            --font-size: 18px;
                        }
                    </style>
                    <div class="meta flex-col md:flex-row flex mt-2 gap-4 text-secondary py-2 text-sm">
                        <span class="block">
                            <i class="fa-solid fa-location-dot text-primary"></i>
                            <?php echo wvl_get_venue_location(get_the_ID()); ?>
                        </span>
                        <span class="h-6 w-[1.5px] bg-quaternary hidden md:inline-block"></span>

                        <span class="block">
                            <star-rating min="0" max="5" value="<?php echo get_post_meta(get_the_ID(), 'average_rating', true); ?>"></star-rating>
                            <span class="amount">
                                <?php
                                $comment_count = get_comment_count(get_the_ID());
                                printf(_n('(%s Review)', '(%s Reviews)', $comment_count['approved'], 'wedding-venue-listings'), $comment_count['approved']);
                                ?>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="links flex justify-end items-center flex-wrap">
                    <ul class="social flex justify-end flex-wrap items-center gap-3 m-0 mr-6">
                        <?php do_action('wvl_social_links'); ?>
                    </ul>
                    <button class="wvl-btn-primary" id="contactFormOpen"><?php _e('Contact Us', 'wedding-venue-listings'); ?></button>
                </div>
            </div>

            <div class="wvl-content">

                <div class="description pb-10 pt-6 text-gray-500">
                    <div class="the-btn">
                        <a href="">Overview</a>
                        <a href="">Contact Info</a>
                        <a href="">Photos</a>
                        <a href="">Videos</a>
                        <a href="">Supported Locations</a>
                        <a href="">Reviews</a>
                    </div>
                    <style>
                        .the-btn {
                            display: flex;
                            justify-content: start;
                            gap: 20px;
                            margin-bottom: 20px;
                        }

                        .the-btn a {
                            padding: 10px 20px;
                            border: 1px solid #ccc;
                            border-radius: 5px;
                            text-decoration: none;
                            color: #333;
                            font-weight: bold;
                            display: inline-block;
                        }
                    </style>
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


        <div id="contact-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="bg-black opacity-65 fixed inset-0 z-40"></div>
            <div class="modal-content relative p-4 w-full max-w-lg max-h-ful z-50">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            <span class="text-sm block font-normal"><?php the_title(); ?></span>
                            <span class="text-lg block font-semibold"><?php _e('Message Vendor', 'wedding-venue-listings'); ?></span>
                        </h3>
                        <button type="button" class="close-contact-btn end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center " data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" action="#">
                            <div class="wvl-field-row">
                                <div class="wvl-field">
                                    <label for="fist_name"><?php _e('Fist name', 'wedding-venue-listings'); ?></label>
                                    <input type="text" name="fist_name" id="fist_name" class="" placeholder="John" required />
                                </div>
                                <div class="wvl-field">
                                    <label for="last_name"><?php _e('Last Name', 'wedding-venue-listings'); ?></label>
                                    <input type="text" name="last_name" id="last_name" class="" placeholder="Doe" required />
                                </div>
                            </div>

                            <div class="wvl-field">
                                <label for="email"><?php _e('Email', 'wedding-venue-listings'); ?></label>
                                <input type="email" name="email" id="email" class="" placeholder="name@example.com" required />
                            </div>

                            <div class="wvl-field">
                                <label for="phone"><?php _e('Phone', 'wedding-venue-listings'); ?></label>
                                <input type="number" name="phone" id="phone" class="" placeholder="123-456-7890" required />
                            </div>

                            <div class="wvl-field">
                                <label for="city"><?php _e('City', 'wedding-venue-listings'); ?></label>
                                <input type="text" name="city" id="city" class="" placeholder="New York" required />
                            </div>

                            <div class="wvl-field">
                                <label for="date"><?php _e('Date', 'wedding-venue-listings'); ?></label>
                                <input type="text" name="date" id="date" class="" placeholder="New York" required />
                            </div>

                            <div class="wvl-field">
                                <label for="message"><?php _e('Message', 'wedding-venue-listings'); ?></label>
                                <textarea name="message" id="message"></textarea>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="wvl-btn-primary"><?php _e('Send', 'wedding-venue-listings'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
