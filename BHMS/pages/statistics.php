<?php   
    session_start();
    ob_start();
    require '../php/templates.php';
    require '../views/StatisticsViews.php';

    if($_SESSION['sessionType'] !== 'admin'){
        header('Location: dashboard.php?AccessError=unauthorizedPageAttempt');    
        exit();
    }

    $more_links = '<script src="https://cdn.jsdelivr.net/npm/progressbar.js@1.0.0/dist/progressbar.min.js"></script>';

    html_start('statistics.css', $more_links);

    // Sidebar
    require '../php/navbar.php';

    // Hamburger Sidebar
    StatisticsViews::burger_sidebar();  

    // Fetch data from the database
    $monthlyData = StatisticsController::fetchDataMonthly();

    // Assuming $monthlyData is fetched and structured as described

    // Step 1: Determine last month's year and month
    $lastMonthTimestamp = strtotime("-1 month");
    $lastMonth = date("F", $lastMonthTimestamp); // "F" format gives the full textual representation of a month
    $lastYear = date("Y", $lastMonthTimestamp);

    // Step 2: Filter $monthlyData to find the matching entry
    $lastMonthData = array_filter($monthlyData, function($entry) use ($lastMonth, $lastYear) {
        return $entry['month'] === $lastMonth && $entry['year'] === $lastYear;
    });

    // Step 3: Extract the total_occupancy from the matching entry
    // Assuming there's only one entry per month, so taking the first match
    $lastMonthOccupancy = !empty($lastMonthData) ? reset($lastMonthData)['total_occupancy'] : 0;

    $quarterlyData = StatisticsController::fetchDataQuarterly();

    // Existing code to fetch quarterly data
    $quarterlyData = StatisticsController::fetchDataQuarterly();


    // Determine last month's year and month
    $lastMonthTimestamp = strtotime("-1 month");
    $lastMonth = date("F", $lastMonthTimestamp); // Full textual representation of a month, such as January or March
    $lastYear = date("Y", $lastMonthTimestamp); // Numeric representation of a year, 4 digits
    
    // Determine the current quarter and year
    $currentMonth = date("n"); // Current month as a number (1-12)
    $currentYear = date("Y"); // Current year
    
    // Calculate the previous quarter and year
    if ($currentMonth >= 1 && $currentMonth <= 3) {
        $currentQuarter = 1;
        $previousQuarter = 4;
        $previousYear = $currentYear - 1;
    } else if ($currentMonth >= 4 && $currentMonth <= 6) {
        $currentQuarter = 2;
        $previousQuarter = 1;
        $previousYear = $currentYear;
    } else if ($currentMonth >= 7 && $currentMonth <= 9) {
        $currentQuarter = 3;
        $previousQuarter = 2;
        $previousYear = $currentYear;
    } else {
        $currentQuarter = 4;
        $previousQuarter = 3;
        $previousYear = $currentYear;
    }
    
    // Filter $quarterlyData to find the matching entry for the current quarter
    $currentQuarterString = 'Q' . $currentQuarter;
    $currentQuarterData = array_values(array_filter($quarterlyData, function($entry) use ($currentQuarterString, $currentYear) {
        return $entry['quarter'] === $currentQuarterString && $entry['year'] === $currentYear;
    }));

    // Extract the total_payments from the current quarter's matching entry
    $totalPaymentsCurrentQuarter = !empty($currentQuarterData) ? $currentQuarterData[0]['total_payments'] : 0;

    // Filter $quarterlyData to find the matching entry for the previous quarter
    $previousQuarterString = 'Q' . $previousQuarter;
    $previousQuarterData = array_values(array_filter($quarterlyData, function($entry) use ($previousQuarterString, $previousYear) {
        return $entry['quarter'] === $previousQuarterString && $entry['year'] === $previousYear;
    }));

    // Extract the total_payments from the previous quarter's matching entry
    $totalPaymentsPreviousQuarter = !empty($previousQuarterData) ? $previousQuarterData[0]['total_payments'] : 0;


    // Assuming $yearlyData is fetched and structured as described
    $yearlyData = StatisticsController::fetchDataYearly();


?>

<div class="container-fluid">
    <div>
        <div>
            <span class="page-header">Statistics</span><br>
            <span class="page-sub-header">Boarding House's financial and operational statistics.</span>
        </div>
    </div>

    <div class="row mx-4 pt-3">
        <div class="col-sm-8 p-0">
            <!-- Occupancy Rate -->
            <div class="p-3 my-3 w-100 shadow position-relative rounded">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="page-header" style="font-size: 1.8rem">Occupancy Rate</span>
                    <select id="occupancyFilterBtn" class="form-select form-select-sm w-25 shadow" style="height: 40px; color: white; background-color: #344799">
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="occupancyChart"></canvas>
                </div>
            </div>
            <!-- Revenue Rate -->
            <div class="p-3 my-3 w-100 shadow position-relative rounded">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="page-header" style="font-size: 1.8rem">Revenue and Expenses</span>
                    <select id="revenueFilterBtn" class="form-select form-select-sm w-25 shadow" style="height: 40px; color: white; background-color: #344799">
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center col-sm-4 px-5 py-4" >
                <span class="page-header" style="font-size: 1.5rem">Performance Overview</span>
                <?php
                    // Assuming $totalPaymentsCurrentQuarter and $totalPaymentsPreviousQuarter are calculated
                    $revenueChange = $totalPaymentsCurrentQuarter - $totalPaymentsPreviousQuarter;
                    $revenueChangePercent = $totalPaymentsPreviousQuarter === 0 ? 0 : $revenueChange / $totalPaymentsPreviousQuarter * 100;
                    $revenueChangePercent = number_format($revenueChangePercent, 2);

                    if ($revenueChange > 0) {
                        $revenueIcon = 'up.png';
                        $color = '#00BA00';
                        $revenueChange = $revenueChange;
                    } else {
                        $revenueIcon = 'down.png';
                        $color = '#FF0000';
                        $revenueChange = $revenueChange * -1;
                    }
                ?>
                <!-- Gross Revenue -->
                <div class="w-100 my-2 py-4 px-3 shadow" style="background-color: #EDF6F7; border-radius: 16px">
                    <div>
                        <span style="font-size: 0.9rem">Gross Revenue (<?php echo "Q" . $currentQuarter . " - " . $currentYear ?>)</span>
                    </div>
                    <div>
                        <span class="page-header" style="font-size: 1.8rem">Php <?php echo $totalPaymentsCurrentQuarter ?></span>
                    </div>
                    <div>
                        <span style="font-size: 0.9rem; color: <?php echo $color ?>;"><img src="/images/icons/Statistics/<?php echo $revenueIcon ?>" style="width: 18px"> %<?php echo $revenueChangePercent . ' from Q' . $previousQuarter . ' - ' . $previousYear?></span>
                    </div>
                </div>
                <!-- Current Number of Tenants -->
                <div class="w-100 my-2 py-4 px-3 shadow" style="background-color: #EDF6F7; border-radius: 16px">
                    <?php
                        $currentTenants = StatisticsController::total_current_residents();

                        if ($lastMonthOccupancy == 0) {
                            // Decide how to handle this case. Example: set to 100% if currentTenants > 0, or 0 if no change.
                            $occPercentChange = $currentTenants > 0 ? 100 : 0;
                        } else {
                            $occPercentChange = ($currentTenants - $lastMonthOccupancy) / $lastMonthOccupancy * 100;
                        }

                        $occPercentChange = number_format($occPercentChange, 2);

                        if ($occPercentChange > 0) {
                            $tenantRateIcon = 'up.png';
                            $color = '#00BA00';
                            $occPercentChange = $occPercentChange;
                        } else {
                            $tenantRateIcon = 'down.png';
                            $color = '#FF0000';
                            $occPercentChange = $occPercentChange * -1;
                        }
                    ?>
                    <div>
                        <span style="font-size: 0.9rem">Monthly Occupancy Goal (<?php echo date('F') ?>)</span>
                    </div>
                    <div>
                        <div id="progress-container">
                            <span id="progress-value"></span>
                        </div>
                    </div>
                    <div>
                        <span style="font-size: 0.9rem; color: <?php echo $color ?>;"><img src="/images/icons/Statistics/<?php echo $tenantRateIcon ?>" style="width: 18px"> %<?php echo $occPercentChange . ' from ' . $lastMonth ?> </span>
                    </div>
                </div>
            </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    const ctx1 = document.getElementById('occupancyChart');
    const ctx2 = document.getElementById('revenueChart');

    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const quarterlyData = <?php echo json_encode($quarterlyData); ?>;
    const yearlyData = <?php echo json_encode($yearlyData); ?>;

    const container = document.getElementById('container');

    Chart.register(ChartDataLabels);

    // Filter buttons
    const occupancyFilterBtn = document.getElementById('occupancyFilterBtn');
    const revenueFilterBtn = document.getElementById('revenueFilterBtn');

    document.addEventListener('DOMContentLoaded', () => {
        updateChartData(occupancyChart, monthlyData, 'month');
        updateChartData(revenueChart, monthlyData, 'month');
    });

    // Filtered data
    occupancyFilterBtn.addEventListener('change', () => {
        const value = occupancyFilterBtn.value;
        switch(value) {
            case 'monthly':
                updateChartData(occupancyChart, monthlyData, 'month');
                break;
            case 'quarterly':
                updateChartData(occupancyChart, quarterlyData, 'quarter');
                break;
            case 'yearly':
                updateChartData(occupancyChart, yearlyData, 'year');
                break;
        }
    });

    // Revenue Filter - Assuming similar logic applies
    revenueFilterBtn.addEventListener('change', () => {
        const value = revenueFilterBtn.value;
        // Adjust according to how revenue data should be filtered and displayed
        // This is just an example based on the occupancy filter logic
        switch(value) {
            case 'monthly':
                updateChartData(revenueChart, monthlyData, 'month');
                break;
            case 'quarterly':
                updateChartData(revenueChart, quarterlyData, 'quarter');
                break;
            case 'yearly':
                updateChartData(revenueChart, yearlyData, 'year');
                break;
        }
    });

    // Revenue Filter - Assuming similar logic applies
    revenueFilterBtn.addEventListener('change', () => {
        const value = revenueFilterBtn.value;
        // Adjust according to how revenue data should be filtered and displayed
        // This is just an example based on the occupancy filter logic
        switch(value) {
            case 'monthly':
                updateChartData(revenueChart, monthlyData, 'month');
                break;
            case 'quarterly':
                updateChartData(revenueChart, quarterlyData, 'quarter');
                break;
            case 'yearly':
                updateChartData(revenueChart, yearlyData, 'year');
                break;
        }
    });

    function updateChartData(chart, data, labelType) {
        chart.data.labels = data.map(data => {
            if (labelType === 'month') {
                return `${data.month.slice(0, 3)} ${data.year}`;
            } else if (labelType === 'quarter') {
                return `${data.quarter} ${data.year}`;
            } else {
                return data[labelType];
            }
        });

        // Adjust according to how empty rooms data should be displayed
        if(chart === occupancyChart) {
            chart.data.datasets[0].data = data.map(data => data.total_occupancy);
            chart.data.datasets[1].data = data.map(data => data.empty_rooms); // Assuming second dataset is always relevant
        } else if (chart === revenueChart) {
            chart.data.datasets[0].data = data.map(data => data.total_payments);
            chart.data.datasets[1].data = data.map(data => data.total_maintenance_cost); // Assuming second dataset is always relevant
        }
        chart.update();
    }
    
    const occupancyChart = new Chart(ctx1, {
        type: 'line',
        data: {
            // labels: data.map(data => `${data.month.slice(0, 3)} ${data.year}`),
            datasets: [
                {
                    label: 'Occupancy Rate',
                    // data: data.map(data => data.total_occupancy),
                    borderWidth: 1,
                    borderColor: 'rgb(75, 192, 192)', // Example color
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Example background color
                    cubicInterpolationMode: 'monotone',
                    pointRadius: 2,
                },
                {
                    label: 'Empty Rooms',
                    // data: data.map(data => data.empty_rooms),
                    borderWidth: 1,
                    borderColor: 'rgb(255, 99, 132)', // Example color
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Example background color
                    type: 'line',
                    cubicInterpolationMode: 'monotone',
                    pointRadius: 2,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 11
                        },
                        autoSkip: true,
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom', // Moves the legend to the bottom
                    align: 'start' // Aligns the legend to the left
                },
                datalabels: {
                    display: false
                }
            }
        }
    });

    const revenueChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            datasets: [
                {
                    label: 'Revenue',
                    borderWidth: 1,
                    borderColor: 'rgb(75, 192, 192)', // Example color
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Example background color
                },
                {
                    label: 'Expenses',
                    borderWidth: 1,
                    borderColor: 'rgb(255, 99, 132)', // Example color
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Example background color
                    type: 'bar'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 11
                        },
                        autoSkip: true,
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                },
            },
            plugins: {
                legend: {
                    position: 'bottom', // Moves the legend to the bottom
                    align: 'start' // Aligns the legend to the left
                },
                datalabels: {
                    anchor: 'end',
                    align: function(context) {
                        const chart = context.chart;
                        const datasetIndex = context.datasetIndex;
                        const dataIndex = context.dataIndex;
                        const value = chart.data.datasets[datasetIndex].data[dataIndex];
                        const scale = chart.scales.y; // Assuming 'y' is your vertical scale ID
                        const yPos = scale.getPixelForValue(value);

                        // Check if the label's position is too close to the top of the chart
                        if (yPos < (scale.top + 20)) { // 20 pixels from the top as a threshold
                            return 'start'; // Align labels to the start (bottom) of the bars
                        }
                        return 'end'; // Default alignment to the end (top) of the bars
                    },
                    font: {
                        size: 9,
                    },
                    formatter: function (value, context) {
                        if (value > 0) {
                            return '₱' + (value / 1000).toFixed(1) + 'K'; // Format as needed for positive values
                        } else {
                            return null; // Don't display a label for values that are 0 or less
                        }
                    }
                }
            }
        }
    });

    
    document.addEventListener('DOMContentLoaded', function() {
        var container = document.getElementById('progress-container');
        if (!container) {
            console.error('Container not found');
            return;
        }

        var max = 35;
        var value = <?php echo json_encode($currentTenants) ?>; // Example value, you can set this dynamically
        
        var bar = new ProgressBar.Circle(container, {
            color: '#1199E6',
            trailColor: '#eee',
            trailWidth: 15,
            duration: 1400,
            easing: 'bounce',
            strokeWidth: 15,
            from: {color: '#1199E6', a:0},
            to: {color: '#1199E6', a:1},
            // Set default step function for all animate calls
            step: function(state, circle) {
                circle.path.setAttribute('stroke', state.color);
                circle.path.setAttribute('stroke-linecap', 'round'); // Makes the stroke ends rounded
                circle.path.setAttribute('stroke-linejoin', 'round'); // Makes the stroke joins rounded
            }
        });
        
        var progressValue = document.getElementById('progress-value');
        if (!progressValue) {
            console.error('Progress value span not found');
            return;
        }
        
        progressValue.textContent = `${value}/${max}`;

        var progress = value / max;
        bar.animate(progress); // Number from 0.0 to 1.0
    });

</script> 

<?php
    html_end(); 
    ob_end_flush();
?>