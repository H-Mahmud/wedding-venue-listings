<div class="dashboard-wrapper">
    <div class="dashboard-sidebar">
        <ul>
            <li>
                <a href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
            </li>
            <li>
                <a href="<?php echo site_url('dashboard/profile'); ?>">Profile</a>
            </li>
            <li>
                <a href="<?php echo site_url('dashboard/gallery'); ?>">Gallery</a>
            </li>
            <li>
                <a href="<?php echo site_url('dashboard/availability'); ?>">Availability</a>
            </li>
            <li>
                <a href="<?php echo site_url('dashboard/account'); ?>">Account</a>
            </li>
            <li>
                <a href="<?php echo site_url('logout'); ?>">Logout</a>
            </li>
        </ul>
    </div>
    <div class="dashboard-content">
        <?php
        $subpage = get_query_var('subpage');

        if ($subpage) {
            switch ($subpage) {
                case 'profile':
                    require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/profile.php';
                    break;

                case 'gallery':
                    require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/gallery.php';
                    break;

                case 'availability':
                    require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/availability.php';
                    break;

                case 'account':
                    require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/account.php';
                    break;

                default:
                    require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/dashboard.php';
                    break;
            }
        } else {
            require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/dashboard.php';
        } ?>
    </div>
</div>
