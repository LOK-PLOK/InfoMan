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
            <div><span class="page-header" style="font-size: 2rem">Occupancy Rate</span></div>
            <div class="p-3 w-100 shadow position-relative rounded" style="height:35vh; width:100vw; background-color: #EDF6F7; border">
                <canvas id="occupancyChart"></canvas>
            </div>
            <div><span class="page-header" style="font-size: 2rem">Revenue</span></div>
            <div class="p-3 w-100 shadow position-relative rounded" style="height:35vh; width:100vw; background-color: #EDF6F7; border">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="col-sm-4 p-0" >
            <span class="page-header" style="font-size: 2rem">Gross Revenue</span><br>
        </div>
    </div>
</div>

<?php
    // Getting data from the database
    $data = StatisticsController::fetch_all_data();
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    const occupancyChart = document.getElementById('occupancyChart');
    const revenueChart = document.getElementById('revenueChart');
    const chartData = <?php echo $data; ?>;

    const labels = chartData.map(item => item.month_year);
    const data1 = chartData.map(item => item.CountTenants);
    const data2 = chartData.map(item => item.CountEmptyRooms);
    const data3 = chartData.map(item => item.TotalPaymentAmount);

    // Filtered Chart
    const filtered = new Chart(occupancyChart, {
        type: 'bar',
        data: {
        labels: labels,
        datasets: [
            {
                label: 'Occupied',
                data: data1,
                borderWidth: 1,
                borderColor: 'rgb(75, 192, 192)', // Example color
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Example background color
            },
            {
                label: 'Empty',
                data: data2,
                borderWidth: 1,
                borderColor: 'rgb(255, 99, 132)', // Example color
                backgroundColor: 'rgba(255, 99, 132, 0.2)', // Example background color
                type: 'line'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: true
                },
                beginAtZero: true,
                ticks: {
                    font:  {
                        size: 9
                    }
                }
            },
            y: {
                grid: {
                    display: false
                },
                beginAtZero: true,
                ticks: {
                    font:  {
                        size: 9
                    }
                }
            }
        },
        plugins: {
            legend: {
                position: 'bottom', // Moves the legend to the bottom
                align: 'start' // Aligns the legend to the left
            }
        }
        }
    });

    // Revenue Chart
    const finance = new Chart(revenueChart, {
        type: 'line',
        data: {
        labels: labels,
        display: false,
        datasets: [
            {
                label: 'Gross Revenue/mon',
                data: data3,
                borderWidth: 1,
                borderColor: 'rgb(54, 162, 235)', // Example color
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Example background color
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: true
                },
                beginAtZero: true,
                ticks: {
                    font:  {
                        size: 9
                    }
                }
            },
            y: {
                grid: {
                    display: false
                },
                beginAtZero: true,
                ticks: {
                    font:  {
                        size: 9
                    }
                }
            }
        },
        plugins: {
            legend: {
                position: 'bottom', // Moves the legend to the bottom
                align: 'start' // Aligns the legend to the left
            }
        }
        }
    });


</script>

<?php
    html_end(); 
    ob_end_flush();
?>