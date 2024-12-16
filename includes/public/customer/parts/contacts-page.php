<script>
    jQuery(document).ready(function($) {
        $(".expand-row").on("click", function() {
            const target = $(this).data("target");
            $("#" + target).toggleClass("hidden");
            $(this).find(".arrow-icon").toggleClass("fa-chevron-down fa-chevron-up");
        });
    });
</script>

<?php
global $wpdb;

$page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
$contacts = wvl_get_contact_data($page);
$table_name = $wpdb->prefix . 'contact_form';
$per_page = 10;

$total_entries = $wpdb->get_var("SELECT COUNT(*) FROM " . $table_name);
$total_pages = ceil($total_entries / $per_page);

?>
<div class="container mx-auto dashboard-contacts">
    <h1 class="text-2xl font-bold mb-4"><?php _e('Contact List', 'wedding-venue-listings'); ?></h1>
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left"><?php _e('First Name', 'wedding-venue-listings'); ?></th>
                    <th class="py-3 px-6 text-left"><?php _e('Last Name', 'wedding-venue-listings'); ?></th>
                    <th class="py-3 px-6 text-left"><?php _e('Phone Number', 'wedding-venue-listings'); ?></th>
                    <th class="py-3 px-6 text-left"><?php _e('Submitted Date', 'wedding-venue-listings'); ?></th>
                    <?php /*<th class="py-3 px-6 text-center"><?php _e('Status', 'wedding-venue-listings'); ?></th> */ ?>
                    <th class="py-3 px-6 text-center">Expand</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php
                foreach ($contacts as $contact) {
                ?>

                    <tr class="border-b border-gray-200 hover:bg-gray-100 contact-item" id="contact-<?php esc_html_e($contact['id']); ?>">
                        <td class="py-3 px-6 text-left"><?php esc_html_e($contact['first_name']); ?></td>
                        <td class="py-3 px-6 text-left"><?php esc_html_e($contact['last_name']); ?></td>
                        <td class="py-3 px-6 text-left"><?php esc_html_e($contact['phone']); ?></td>
                        <td class="py-3 px-6 text-left"><?php esc_html_e($contact['submission_date']); ?></td>

                        <?php /* <td class="py-3 px-6 text-center">
                            <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Read</span>
                        </td> */ ?>
                        <td class="py-3 px-6 text-center">
                            <button class="expand-row" data-target="message-<?php esc_html_e($contact['id']); ?>">
                                <i class="fas fa-chevron-down arrow-icon"></i>
                            </button>
                        </td>
                    </tr>
                    <tr id="message-<?php esc_html_e($contact['id']); ?>" class="hidden">
                        <td colspan="6" class="py-3 px-6 bg-gray-50">
                            <ul class="contact-detail">
                                <li><strong><?php _e('Name', 'wedding-venue-listings'); ?>: </strong><?php esc_html_e($contact['first_name']); ?> <?php esc_html_e($contact['last_name']); ?></li>
                                <li><strong><?php _e('Phone', 'wedding-venue-listings'); ?>: </strong><?php esc_html_e($contact['phone']); ?></li>
                                <li><strong><?php _e('Email', 'wedding-venue-listings'); ?>: </strong><?php esc_html_e($contact['email']); ?></li>
                                <li><strong><?php _e('City', 'wedding-venue-listings'); ?>: </strong><?php esc_html_e($contact['city']); ?></li>
                                <li><strong><?php _e('Booking Date', 'wedding-venue-listings'); ?>: </strong><?php echo date('F j, Y', strtotime($contact['booking_date'])); ?></li>
                                <li><strong><?php _e('Message', 'wedding-venue-listings'); ?>: </strong> <?php esc_html_e($contact['message']); ?></li>
                            </ul>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php

// echo '<div class="tablenav"><div class="tablenav-pages">';

// $url = site_url('dashboard/contacts');
// for ($i = 1; $i <= $total_pages; $i++) {
//     $current = ($i == $page) ? ' class="current"' : '';
//     echo '<a href="' . $url . '?&paged=' . $i . '"' . $current . '>' . $i . '</a> ';
// }

// echo '</div>';
// echo '</div>';



function wvl_get_contact_data($page = 1)
{
    global $wpdb;

    $per_page = 10;
    $offset = ($page - 1) * $per_page;
    $table_name = $wpdb->prefix . 'contact_form';
    $venue_id = wvl_get_venue_id();

    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE venue_id = %d ORDER BY submission_date DESC LIMIT %d, %d",
            $venue_id,
            $offset,
            $per_page
        ),
        ARRAY_A
    );

    return $results;
}
