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
                    <button class="wvl-btn-primary">Contact Now</button>
                </div>
            </div>

            <div class="wvl-content">
                <ul class="tabs">
                    <li class="tab-link active"><a href="">About The Place</a></li>
                </ul>

                <p class="description py-10 text-gray-500">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </p>

                <div class="wvl-gallery">
                    <div class="entry mb-3 mt-6 flex justify-between items-center">
                        <h3 class="text-2xl font-semibold">Recent Events Gallery</h3>
                        <a class="view-all font-medium">
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
                        <h3 class="text-2xl font-semibold">Review</h3>
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
    <?php
    }; ?>
</div>
<?php get_footer(); ?>
