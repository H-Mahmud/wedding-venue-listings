<?php
defined('ABSPATH') || exit;

add_shortcode('wvl-user-profile', 'wvl_listings_user_profile_shortcode');
function wvl_listings_user_profile_shortcode()
{
    ob_start(); ?>
    <div class="user-profile">
        <?php if (is_user_logged_in()): ?>
            <a href="<?php echo site_url('dashboard'); ?>" class="wvl-user-profile-avatar block h-12 w-12">
                <?php
                $user_id = get_current_user_id();
                $local_avatar = get_user_meta($user_id, 'simple_local_avatar', true);
                if ($local_avatar) {
                    echo wp_get_attachment_image($local_avatar, 'thumbnail', '', ['class' => 'rounded-full h-full w-full object-cover userAvatarPreview']);
                } else {
                    echo get_avatar($user_id, 112, '', __('Upload Avatar'), ['class' => 'rounded-full h-full w-full object-cover userAvatarPreview']);
                }
                ?>

            </a>
        <?php else: ?>
            <div class="flex justify-end items-center gap-1">
                <i class="fa-regular fa-user"></i>
                <a href="<?php echo site_url('register'); ?>" class="btn-register">
                    <?php _e('Register', 'wedding-venue-listings'); ?>
                </a>
                <?php _e( ' / ', 'wedding-venue-listings' ); ?>
                <a href="<?php echo site_url('login'); ?>" class="btn-login">
                    <?php _e('Login', 'wedding-venue-listings'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <style>
        .user-profile, 
        .user-profile a {
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            line-height: 24px;
        }
    </style>
<?php
    return ob_get_clean();
}
