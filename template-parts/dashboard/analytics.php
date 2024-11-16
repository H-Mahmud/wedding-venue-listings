<div>
    <button class="time-frame-btn" data-timeframe="last_week">Last Week</button>
    <button class="time-frame-btn" data-timeframe="last_14_days">Last 14 Days</button>
    <button class="time-frame-btn" data-timeframe="last_month">Last Month</button>
    <button class="time-frame-btn" data-timeframe="last_2_months">Last 2 Months</button>
    <button class="time-frame-btn" data-timeframe="last_3_months">Last 3 Months</button>
</div>
<canvas id="myLineChart" width="800" height="400"></canvas>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('myLineChart').getContext('2d');

        chartData = {
            'impressions': {
                'last_week': [50, 60, 70, 90, 100, 110, 120],
                'last_14_days': [40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160, 170],
                'last_month': [300, 320, 340, 360],
                'last_2_months': [600, 650, 700, 750],
                'last_3_months': [900, 950, 1000, 1050]
            },
            'clicks': {
                'last_week': [10, 20, 30, 40, 50, 60, 70],
                'last_14_days': [8, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75],
                'last_month': [100, 110, 120, 130],
                'last_2_months': [200, 210, 220, 230],
                'last_3_months': [300, 310, 320, 330]
            }
        }

        const data = chartData; // This comes from wp_localize_script
        const labels = {
            last_week: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            last_14_days: Array.from({
                length: 14
            }, (_, i) => `Day ${i + 1}`),
            last_month: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            last_2_months: ['Month 1', 'Month 2'],
            last_3_months: ['Month 1', 'Month 2', 'Month 3']
        };

        const timeFrames = ['last_week', 'last_14_days', 'last_month', 'last_2_months', 'last_3_months'];

        let activeTimeFrame = 'last_week';

        function renderChart(timeFrame) {
            if (myLineChart && typeof myLineChart.destroy === 'function') {
                console.log('Destroying existing chart instance:', myLineChart);
                myLineChart.destroy();
            }

            // Create a new chart instance
            myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels[timeFrame],
                    datasets: [{
                            label: 'Impressions',
                            data: data.impressions[timeFrame],
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 0, 255, 0.1)',
                            fill: true
                        },
                        {
                            label: 'Clicks',
                            data: data.clicks[timeFrame],
                            borderColor: 'green',
                            backgroundColor: 'rgba(0, 255, 0, 0.1)',
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: `Performance for ${timeFrame.replace('_', ' ')}`
                        }
                    }
                }
            });
        }

        // Render initial chart
        renderChart(activeTimeFrame);

        // Add event listeners for changing time frames
        document.querySelectorAll('.time-frame-btn').forEach(button => {
            button.addEventListener('click', function() {
                activeTimeFrame = this.dataset.timeframe;
                renderChart(activeTimeFrame);
            });
        });
    });
</script>
