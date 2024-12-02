<?php get_header(); ?>
<div id="primary" class="single-venue bg-white">
    <?php
    while (have_posts()) {
        the_post(); ?>
        <div class="cover-photo w-full max-h-[520px] overflow-hidden min-h-80">
            <?php the_post_thumbnail('full', array('class' => 'w-full h-auto block object-cover')); ?>
        </div>
        <main id="main" class="site-main site-container pt-4" role="main">
            <div class="header">
                <div class="entry">
                    <?php the_title('<h1 class="title text-4xl font-bold">', '</h1>'); ?>
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
                </div>
                <div class="links">
                    <ul class="social">
                        <li><a href=""><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href=""><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a href=""><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href=""><i class="fa-brands fa-square-youtube"></i></a></li>
                        <li><a href=""><i class="fa-brands fa-linkedin-in"></i></a></li>
                    </ul>
                    <button class="wvl-btn-primary" id="contactFormOpen">Contact Now</button>
                </div>
            </div>

            <div class="wvl-content">
                <h3 class="text-lg font-semibold mt-2"><?php _e('Our Story', 'wedding-venue-listings'); ?></h3>

                <div class="description pb-10 pt-6 text-gray-500">
                    <?php the_content(); ?>
                </div>

                <div class="wvl-gallery">
                    <div class="entry mb-3 mt-6 flex justify-between items-center">
                        <h3 class="text-2xl font-semibold">Recent Events Gallery</h3>
                        <a class="wvl-btn">
                            View All
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-6.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg" alt="">
                        </div>
                    </div>

                </div>

                <div class="wvl-reviews mt-9">
                    <div class="entry mb-3">

                        <div class="entry mb-3 mt-6 flex justify-between items-center">
                            <h3 class="text-2xl font-semibold"><?php _e('Reviews', 'wedding-venue-listings'); ?></h3>
                            <a class="wvl-btn">
                                <?php _e('Write a Review', 'wedding-venue-listings'); ?>
                            </a>
                        </div>
                    </div>

                    <div class="review-list mb-7">
                        <div class="review-item flex gap-8">
                            <div class="avatar w-20 h-20 max-w-20 rounded-lg border flex-1"></div>
                            <div class="content flex-1 bg-gray-100 p-4 rounded-lg">
                                <div class="meta flex justify-between mb-2">
                                    <div class="info"><span class="name font-medium">John Doe</span> -
                                        <span class="date"><?php the_date('F j, Y'); ?></span>
                                    </div>
                                    <div class="rating">
                                        <span class="stars">
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                        </span>
                                    </div>
                                </div>
                                <h4 class="font-semibold">Best speaker I’ve ever used!</h4>
                                <p>
                                    I’ve been using this speaker for a few months now, and I’m absolutely in love with it. The sound quality is amazing, and the battery life is incredible. I can easily get 20 hours of use on a single charge, which is more than enough for a day at the beach or a weekend trip.
                                    The MEGABOOM 3 is also very durable. I’ve dropped it a few times, and it’s never been damaged. It’s also waterproof, so I can take it to the pool, beach, while I take a shower without having to worry about it getting wet.</p>

                            </div>
                        </div>

                    </div>

                    <div class="text-center mb-8">
                        <ul class="inline-flex -space-x-px text-sm">
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 ">Previous</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">1</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">2</a>
                            </li>
                            <li>
                                <a href="#" aria-current="page" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">4</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">5</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 ">Next</a>
                            </li>
                        </ul>
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
