<?php
get_header(); ?>

<div id="primary" class="listing-archive">
    <main id="main" class="site-main site-container md:flex md:gap-10 md:justify-between items-start block" role="main">
        <div class="wvl-sidebar md:w-[310px] w-full">
            <?php load_template(WVL_PLUGIN_DIR . 'templates/parts/sidebar.php'); ?>
        </div>

        <div class="listing-content w-full">
            <?php
            $args = array(
                'post_type' => 'venue',
                'posts_per_page' => -1,
            );

            if (isset($_GET['subcategory']) && !empty($_GET['subcategory']) && is_array($_GET['subcategory'])) {
                $subcategories = array_map('intval', $_GET['subcategory']);
                $args['category__in'] = $subcategories;
            }

            $query = new WP_Query($args);
            if ($query->have_posts()):
            ?>
                <p class="total-result"><span class="amount"><?php echo $query->found_posts; ?></span> <?php _e('Vendor found', 'wedding-venue-listings'); ?></p>
                <div class="wvl-list">
                <?php
                while ($query->have_posts()) :
                    $query->the_post();
                    load_template(WVL_PLUGIN_DIR . 'templates/parts/listing-item.php', false);
                endwhile;
            else:
                echo '<p>No Venues Found</p>';
            endif;
            wp_reset_postdata();
                ?>
                </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>
