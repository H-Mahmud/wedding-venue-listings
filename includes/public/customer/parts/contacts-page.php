<script>
    jQuery(document).ready(function($) {
        $(".expand-row").on("click", function() {
            const target = $(this).data("target");
            $("#" + target).toggleClass("hidden");
            $(this).find(".arrow-icon").toggleClass("fa-chevron-down fa-chevron-up");
        });
    });
</script>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4"><?php _e('Contact List', 'wedding-venue-listings'); ?></h1>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">First Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Phone Number</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Expand</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <!-- Row 1 -->
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">1</td>
                    <td class="py-3 px-6 text-left">John</td>
                    <td class="py-3 px-6 text-left">john@example.com</td>
                    <td class="py-3 px-6 text-left">123-456-7890</td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Read</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <button class="expand-row" data-target="message-1">
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </button>
                    </td>
                </tr>
                <tr id="message-1" class="hidden">
                    <td colspan="6" class="py-3 px-6 bg-gray-50">
                        <strong>Message:</strong> Hello, this is John. I have a question about your services.
                    </td>
                </tr>

                <!-- Row 2 -->
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">2</td>
                    <td class="py-3 px-6 text-left">Jane</td>
                    <td class="py-3 px-6 text-left">jane@example.com</td>
                    <td class="py-3 px-6 text-left">987-654-3210</td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Unread</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <button class="expand-row" data-target="message-2">
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </button>
                    </td>
                </tr>
                <tr id="message-2" class="hidden">
                    <td colspan="6" class="py-3 px-6 bg-gray-50">
                        <strong>Message:</strong> Hi, this is Jane. I am interested in your product offerings.
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
<?php
/*
global $wpdb;

$page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
$contacts = cf_get_paginated_data($page);
$table_name = $wpdb->prefix . 'contact_form';
$per_page = 10;

$total_entries = $wpdb->get_var("SELECT COUNT(*) FROM " . $table_name);
$total_pages = ceil($total_entries / $per_page);

echo '<div class="wrap">';
echo '<h1>Contact Submissions</h1>';

echo '<table class="widefat fixed striped">';
echo '<thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>City</th><th>Date</th><th>Message</th></tr></thead>';
echo '<tbody>';

foreach ($contacts as $contact) {
    echo '<tr>';
    echo '<td>' . esc_html($contact['id']) . '</td>';
    echo '<td>' . esc_html($contact['first_name']) . '</td>';
    echo '<td>' . esc_html($contact['last_name']) . '</td>';
    echo '<td>' . esc_html($contact['email']) . '</td>';
    echo '<td>' . esc_html($contact['phone']) . '</td>';
    echo '<td>' . esc_html($contact['city']) . '</td>';
    echo '<td>' . esc_html($contact['submission_date']) . '</td>';
    echo '<td>' . esc_html($contact['message']) . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

echo '<div class="tablenav"><div class="tablenav-pages">';

for ($i = 1; $i <= $total_pages; $i++) {
    $current = ($i == $page) ? ' class="current"' : '';
    echo '<a href="?page=cf_contact_submissions&paged=' . $i . '"' . $current . '>' . $i . '</a> ';
}

echo '</div></div>';
echo '</div>';



function cf_get_paginated_data($page = 1)
{
    global $wpdb;

    $per_page = 10;
    $offset = ($page - 1) * $per_page;
    $table_name = $wpdb->prefix . 'contact_form';

    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name ORDER BY submission_date DESC LIMIT %d, %d",
            $offset,
            $per_page
        ),
        ARRAY_A
    );

    return $results;
}
*/
