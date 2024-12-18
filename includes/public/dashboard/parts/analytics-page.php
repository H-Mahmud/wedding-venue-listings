<form id="filterForm" method="post">
    <div class="flex max-w-md gap-2 items-center">
        <div class="wvl-field">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" max="">
        </div>
        <div class="wvl-field">
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate" max="">
        </div>

        <button type="submit" class="wvl-btn-primary">Filter</button>
    </div>
</form>


<?php

$defaultStartDate = (new DateTime())->modify('-15 days')->format('Y-m-d');
$defaultEndDate = (new DateTime())->format('Y-m-d');

$startDate = $_POST['startDate'] ?? $defaultStartDate;
$endDate = $_POST['endDate'] ?? $defaultEndDate;
$impression_count = WVL_Analytic_Data_Storage::get_count_by(wvl_get_venue_id(), 'impression', $startDate, $endDate);
$profile_view_count = WVL_Analytic_Data_Storage::get_count_by(wvl_get_venue_id(), 'view', $startDate, $endDate);
$unique_view_count = WVL_Analytic_Data_Storage::get_count_by(wvl_get_venue_id(), 'unique_view', $startDate, $endDate);
$contact_click_count = WVL_Analytic_Data_Storage::get_count_by(wvl_get_venue_id(), 'contact_click', $startDate, $endDate);
$lead_count = WVL_Analytic_Data_Storage::get_count_by(wvl_get_venue_id(), 'lead', $startDate, $endDate);
?>

<div class="analytics-summary mt">
    <div class="card impression bg-[#4BC0C0]">
        <span><?php _e('Impressions', 'wedding-venue-listings'); ?></span>
        <h3><?php echo number_format_i18n($impression_count); ?></h3>
    </div>
    <div class="card profile-view bg-[#FF6384]">
        <span><?php _e('Views', 'wedding-venue-listings'); ?></span>
        <h3><?php echo number_format_i18n($profile_view_count); ?></h3>
    </div>
    <div class="card profile-view-unique bg-[#36A2EB]">
        <span><?php _e('Unique Views', 'wedding-venue-listings'); ?></span>
        <h3><?php echo number_format_i18n($unique_view_count); ?></h3>
    </div>
    <div class="card contact-view bg-[#efb526]">
        <span><?php _e('Contact Clicks', 'wedding-venue-listings'); ?></span>
        <h3><?php echo number_format_i18n($contact_click_count); ?></h3>
    </div>
    <div class="card lead bg-[#9966FF]">
        <span><?php _e('Leads', 'wedding-venue-listings'); ?></span>
        <h3><?php echo number_format_i18n($lead_count); ?></h3>
    </div>
</div>



<canvas id="myChart" width="400" height="200" class="mt-8"></canvas>

<?php
function generateDummyData($startDate, $endDate)
{
    $period = new DatePeriod(
        new DateTime($startDate),
        new DateInterval('P1D'),
        (new DateTime($endDate))->modify('+1 day')
    );

    $data = [
        'labels' => [],
        'impressions' => [],
        'profileViews' => [],
        'uniqueProfileViews' => [],
        'contactInfoClicks' => [],
        'leads' => []
    ];

    foreach ($period as $date) {
        $data['labels'][] = $date->format('Y-m-d');
        $data['impressions'][] = rand(100, 500);
        $data['profileViews'][] = rand(50, 200);
        $data['uniqueProfileViews'][] = rand(20, 100);
        $data['contactInfoClicks'][] = rand(10, 50);
        $data['leads'][] = rand(5, 20);
    }

    return $data;
}


$chartData = generateDummyData($startDate, $endDate);
?>

<script>
    jQuery(document).ready(function($) {
        const chartData = <?php echo json_encode($chartData); ?>;

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                        label: 'Impressions',
                        data: chartData.impressions,
                        borderColor: '#4BC0C0',
                        fill: false
                    },
                    {
                        label: 'Profile View',
                        data: chartData.profileViews,
                        borderColor: '#FF6384',
                        fill: false
                    },
                    {
                        label: 'Unique Profile View',
                        data: chartData.uniqueProfileViews,
                        borderColor: '#36A2EB',
                        fill: false
                    },
                    {
                        label: 'Contact Click',
                        data: chartData.contactInfoClicks,
                        borderColor: '#efb526',
                        fill: false
                    },
                    {
                        label: 'Leads',
                        data: chartData.leads,
                        borderColor: '#9966FF',
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });

        // Set default dates in the date inputs
        const today = new Date();
        const maxDate = today.toISOString().split('T')[0];
        const defaultStartDate = new Date();
        defaultStartDate.setDate(today.getDate() - 30);

        $('#startDate').val('<?php echo $startDate; ?>');
        $('#endDate').val('<?php echo $endDate; ?>');
        $('#startDate').attr('max', maxDate);
        $('#endDate').attr('max', maxDate);
    })
</script>
