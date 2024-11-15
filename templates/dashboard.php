<?php get_header(); ?>

<div id="primary" class="dashboard">
    <main id="main" class="site-main site-container" role="main">
        <?php if (is_user_logged_in()): ?>
            <?php

            $current_user_id = get_current_user_id();
            $args = [
                'post_type'      => 'venue',
                'author'         => $current_user_id,
                'post_status'    => 'any',
                'numberposts'    => 1,
                'fields'         => 'ids'
            ];

            $post_ids = get_posts($args);
            if (!count($post_ids) || (get_post_status($post_ids[0]) !== 'publish')):
                require_once WVL_PLUGIN_DIR . 'template-parts/venue-application.php';
            else:
                require_once WVL_PLUGIN_DIR . 'template-parts/dashboard-content.php';
            endif;
            ?>
        <?php else: ?>
            <h1><?php _e('You have no permission to access the page', 'wedding-venue-listings'); ?></h1>
        <?php endif; ?>
    </main>
</div>
<?php get_footer(); ?>
