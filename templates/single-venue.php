<?php get_header(); ?>
<div id="primary" class="single-venue">
    <div class="cover-photo">
        <!-- <img src="http://koumparos.local/wp-content/uploads/2024/11/মির্জা-গালিব.png" alt=""> -->
    </div>
    <main id="main" class="site-main site-container" role="main">
        <?php
        while (have_posts()) {
            the_post(); ?>
            <div class="header">
                <div class="entry">
                    <?php the_title('<h1 class="title">', '</h1>'); ?>
                    <div class="meta">
                        <div class="location"></div>
                        <div class="reviews"></div>
                    </div>
                </div>
                <div class="links">
                    <ul class="social">
                        <li><a href="">Facebook</a></li>
                    </ul>
                    <button>Contact Now</button>
                </div>
            </div>

            <div class="wvl-content">
                <ul class="tabs">
                    <li><a href="">About Place</a></li>
                </ul>

                <div class="description"></div>

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
        <?php
        }; ?>
    </main>
</div>
<?php get_footer(); ?>
