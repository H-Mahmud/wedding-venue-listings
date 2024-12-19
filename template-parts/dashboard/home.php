<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?php _e('Dashboard', 'wedding-venue-listings'); ?></h1>
</header>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (!current_user_can('vendor')) : ?>
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-bold text-gray-700 mb-2"><?php _e('Account Manage', 'wedding-venue-listings'); ?></h2>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600"><?php _e('Manage your plan, packages', 'wedding-venue-listings'); ?></p>
                    <!-- <p class="text-gray-600">Expires: <span class="font-semibold">2024-12-31</span></p> -->
                </div>
            </div>
            <a href="<?php echo site_url('my-account'); ?>" class="wvl-btn-primary">
                <?php _e('Manage', 'wedding-venue-listings'); ?>
            </a>
        </div>
    <?php endif; ?>

    <?php
    /*
    <!-- Subscription Management Widget -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-bold text-gray-700 mb-2">Manage Subscription</h2>
        <p class="text-gray-600 mb-4">Update your subscription details and manage your plan preferences.</p>
        <a href="/subscription-management" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Go to Subscription Management
        </a>
    </div>
 
    <!-- Example of Another Widget -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-bold text-gray-700 mb-2">Usage Statistics</h2>
        <p class="text-gray-600">Coming soon...</p>
    </div>
    */ ?>
</div>
</div>
