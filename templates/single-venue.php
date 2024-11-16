<?php get_header(); ?>
<div id="primary" class="single-venue">
    <?php
    while (have_posts()) {
        the_post(); ?>
        <div class="cover-photo">
            <?php the_post_thumbnail('full'); ?>
        </div>
        <main id="main" class="site-main site-container" role="main">

            <div class="header">
                <div class="entry">
                    <?php the_title('<h1 class="title">', '</h1>'); ?>
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
                    <button>Contact Now</button>
                </div>
            </div>

            <div class="wvl-content">
                <ul class="tabs">
                    <li class="tab-link active"><a href="">About The Place</a></li>
                </ul>

                <p class="description">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </p>

                <div class="wvl-gallery">
                    <div class="entry">
                        <h3>Recent Events Gallery</h3>
                        <a class="view-all">
                            View All
                        </a>
                    </div>
                    <div class="gallery-card"></div>
                </div>

                <div class="wvl-reviews">
                    <div class="entry">
                        <h3>Reviews</h3>
                        <a class="view-all">
                            View All
                        </a>
                    </div>
                    <div class="review-card"></div>

                    <div class="review-pagination"></div>
                </div>

            </div>

        </main>
    <?php
    }; ?>
</div>
<?php get_footer(); ?>
