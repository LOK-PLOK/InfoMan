<?php
    session_start();
    ob_start();
    require '../php/templates.php';
    require '../views/StatisticsViews.php';

    html_start('statistics.css');

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

    echo '<script>console.log("Quarterly Data: ", ' . json_encode($quarterlyData) . ')</script>'; // Output: 'Quarterly Data: [Object, Object, Object, ...]'

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

    echo '<script>console.log("Current Quarter: ' . json_encode($currentQuarter) . '")</script>'; // Output: 'Current Quarter: 1'
    echo '<script>console.log("Previous Quarter: ' . json_encode($previousQuarter) . '")</script>'; // Output: 'Previous Quarter: 4'
    echo '<script>console.log("Current Year: ",' . json_encode($currentYear) . ')</script>'; // Output: 'Current Year: 2022'
    echo '<script>console.log("Previous Year: ",' . json_encode($previousYear) . ')</script>'; // Output: 'Previous Year: 2021'
    
    // Filter $quarterlyData to find the matching entry for the current quarter
    $currentQuarterString = 'Q' . $currentQuarter;
    echo '<script>console.log("Current Quarter String: ", ' . json_encode($currentQuarterString) . ')</script>'; // Output: 'Current Quarter String: Q1'
    $currentQuarterData = array_values(array_filter($quarterlyData, function($entry) use ($currentQuarter, $currentYear) {
        return $entry['quarter'] === $currentQuarter && $entry['year'] === $currentYear;
    }));

    // Extract the total_payments from the current quarter's matching entry
    $totalPaymentsCurrentQuarter = !empty($currentQuarterData) ? $currentQuarterData['total_payments'] : 0;

    // Filter $quarterlyData to find the matching entry for the previous quarter
    $previousQuarterString = 'Q' . $previousQuarter;
    echo '<script>console.log("Previous Quarter String: ", ' . json_encode($previousQuarterString) . ')</script>'; // Output: 'Previous Quarter String: Q4'
    $previousQuarterData = array_values(array_filter($quarterlyData, function($entry) use ($previousQuarter, $previousYear) {
        return $entry['quarter'] === $previousQuarter && $entry['year'] === $previousYear;
    }));

    echo '<script>console.log("Previous Quarter Data: ", ' . json_encode($previousQuarterData) . ')</script>'; // Output: 'Previous Quarter Data: [Object]
    echo '<script>console.log("Current Quarter Data: ", ' . json_encode($currentQuarterData) . ')</script>'; // Output: 'Current Quarter Data: [Object]

    // Extract the total_payments from the previous quarter's matching entry
    $totalPaymentsPreviousQuarter = !empty($previousQuarterData) ? $previousQuarterData['total_payments'] : 0;

    // Output the results'
    echo '<script>console.log("Current Quarter Payments: ' . json_encode($totalPaymentsCurrentQuarter) . '")</script>';
    echo '<script>console.log("Previous Quarter Payments: ' . json_encode($totalPaymentsPreviousQuarter) . '")</script>';


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
                <!-- Gross Revenue -->
                <div class="w-100 my-2 py-4 px-3 shadow" style="background-color: #EDF6F7; border-radius: 16px">
                    <div>
                        <span style="font-size: 0.9rem">Gross Revenue</span>
                    </div>
                    <div>
                        <span class="page-header" style="font-size: 1.8rem">Php 1,000,000.00</span>
                    </div>
                    <div>
                        <span style="font-size: 0.9rem">8% from March</span>
                    </div>
                </div>
                <!-- Current Number of Tenants -->
                <div class="w-100 my-2 py-4 px-3 shadow" style="background-color: #EDF6F7; border-radius: 16px">
                    <?php
                        $currentTenants = StatisticsController::total_current_residents();

                        if ($lastMonthOccupancy == 0) {
                            // Decide how to handle this case. Example: set to 100% if currentTenants > 0, or 0 if no change.
                            $occPercentChange = $currentTenants * 100;
                        } else {
                            $occPercentChange = ($currentTenants - $lastMonthOccupancy) / $lastMonthOccupancy * 100;
                        }

                        $occPercentChange = number_format($occPercentChange, 2);

                        if ($occPercentChange > 0) {
                            $color = 'green';
                            $occPercentChange = $occPercentChange;
                        } else {
                            $color = 'red';
                            $occPercentChange = $occPercentChange * -1;
                        }
                    ?>
                    <div>
                        <span style="font-size: 0.9rem">Current number of tenants</span>
                    </div>
                    <div>
                        <span class="page-header" style="font-size: 1.8rem"><?php echo $currentTenants ?> tenants</span>
                    </div>
                    <div>
                        <span style="font-size: 0.9rem; color: <?php echo $color ?>;">%<?php echo $occPercentChange . ' from ' . $lastMonth ?> </span>
                    </div>
                </div>

                <!-- <div class="w-100 my-2 py-4 px-3 shadow" style="background-color: #EDF6F7; border-radius: 16px">
                    <div>
                        <span style="font-size: 0.7rem">Occupied Rooms</span>
                    </div>
                    <div>
                        <span class="page-header" style="font-size: 1.8rem">5 rooms</span>
                    </div>
                    <div>
                        <span style="font-size: 0.7rem">18% from March</span>
                    </div>
                </div> -->
            </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<!-- In Progress -->
<script>
    const ctx1 = document.getElementById('occupancyChart');
    const ctx2 = document.getElementById('revenueChart');

    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const quarterlyData = <?php echo json_encode($quarterlyData); ?>;
    const yearlyData = <?php echo json_encode($yearlyData); ?>;

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

</script> 

<?php
    html_end(); 
    ob_end_flush();
?>