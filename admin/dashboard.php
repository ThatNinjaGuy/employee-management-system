<!-- : The script starts a session and checks if the usertype session variable is set. If not, it redirects the user to index.php and stops further execution. -->
<?php
    session_start();
    include('../includes/dbconn.php');
    
    if(empty($_SESSION['usertype'])) {   
        header('location:index.php');
        exit; // Add exit to stop further execution
    }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Panel - Employee </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    
</head>

<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                <a href="dashboard.php">
    <img src="../assets/images/icon/ar2.jpeg" alt="logo" style="width: 60px; height: auto;">
</a>

                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <?php
                        $page='dashboard';
                        include '../includes/admin-sidebar.php';
                    ?>
                </div>
            </div>
        </div>
       
        <div class="main-content">   
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        
                    </div>
                   
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>

                            
                            <?php include '../includes/admin-notification.php'?>

                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Admin Overview</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="dashboard.php">Home</a></li>
                                <li><span>Admin's Dashboard</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="../assets/images/admin.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">ADMIN <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- Key Metrics Section -->
                <div class="key-metrics mt-5 d-flex flex-wrap">
                    <div class="metric-card" style="flex: 1 1 300px; min-width: 300px; margin: 10px; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; border-radius: 8px;">
                        <div class="metric-content text-center" style="padding: 20px;">
                            <h2 style="font-size: 2.5rem; margin-bottom: 10px;"><?php include 'counters/dept-counter.php'?></h2>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <i class="fa fa-th-large" style="font-size: 1.2rem;"></i>
                                <span style="font-size: 1.1rem;">Available Sites</span>
                            </div>
                        </div>
                    </div>
                    <div class="metric-card" style="flex: 1 1 300px; min-width: 300px; margin: 10px; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; border-radius: 8px;">
                        <div class="metric-content text-center" style="padding: 20px;">
                            <h2 style="font-size: 2.5rem; margin-bottom: 10px;"><?php include 'counters/activeemp-counter.php'?> / <?php include 'counters/emp-counter.php'?></h2>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <i class="fa fa-users" style="font-size: 1.2rem;"></i>
                                <span style="font-size: 1.1rem;">Employee Status</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Key Metrics Section End -->
                <!-- Employee Summary Section -->
                <div class="employee-summary mt-5 mb-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="section-title">Employee Summary</h4>
                        <!-- Move icons for switching views next to the title -->
                        <div class="view-switcher">
                            <i class="fa fa-pie-chart view-icon fa-lg" id="chart-view-icon" title="Pie Chart View" style="margin-right: 5px; opacity: 0.6;"></i>
                            <i class="fa fa-table view-icon fa-lg" id="table-view-icon" title="Table View" style="opacity: 0.6;"></i>
                        </div>
                    </div>
                    <!-- Pie Chart View -->
                    <div id="chart-view">
                        <canvas id="employeeChart" style="width: 100%; height: 400px;"></canvas>
                    </div>
                    <div id="table-view" style="display: none; margin-top: 20px;">
                        <table class="table table-striped" style="border: 1px solid #dee2e6;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #dee2e6;">Designation</th>
                                    <th style="border: 1px solid #dee2e6;">Number of Employees</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT d.id, d.name, COUNT(e.id) AS employee_count 
                                        FROM tbldesignation d 
                                        LEFT JOIN tblemployees e ON d.id = e.designation 
                                        GROUP BY d.id, d.name
                                        ORDER BY employee_count DESC";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                // Determine top N designations to display individually
                                $topN = 5;
                                $topResults = array_slice($results, 0, $topN);
                                $otherResults = array_slice($results, $topN);

                                // Calculate "Others" count
                                $othersCount = array_reduce($otherResults, function($carry, $item) {
                                    return $carry + $item->employee_count;
                                }, 0);

                                // Prepare data for chart
                                $chartLabels = array_map(function($result) {
                                    return htmlentities($result->name);
                                }, $topResults);
                                $chartData = array_map(function($result) {
                                    return htmlentities($result->employee_count);
                                }, $topResults);
                                $chartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

                                // Add "Others" category if applicable
                                if ($othersCount > 0) {
                                    $chartLabels[] = 'Others';
                                    $chartData[] = $othersCount;
                                    $chartColors[] = '#CCCCCC'; // Default color for "Others"
                                }

                                foreach ($topResults as $result) {
                                    echo "<tr>
                                            <td style='border: 1px solid #dee2e6;'>" . htmlentities($result->name) . "</td>
                                            <td style='border: 1px solid #dee2e6;'>" . htmlentities($result->employee_count) . "</td>
                                          </tr>";
                                }

                                // Add Others row if there are additional designations
                                if ($othersCount > 0) {
                                    echo "<tr>
                                            <td style='border: 1px solid #dee2e6;'>Others</td>
                                            <td style='border: 1px solid #dee2e6;'>" . $othersCount . "</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                // JavaScript to toggle views
                document.getElementById('table-view-icon').addEventListener('click', function() {
                    document.getElementById('table-view').style.display = 'block';
                    document.getElementById('chart-view').style.display = 'none';
                });

                document.getElementById('chart-view-icon').addEventListener('click', function() {
                    document.getElementById('table-view').style.display = 'none';
                    document.getElementById('chart-view').style.display = 'block';
                    renderChart();
                });

                // Function to render the pie chart
                function renderChart() {
                    var ctx = document.getElementById('employeeChart').getContext('2d');
                    var chartData = {
                        labels: <?php echo json_encode($chartLabels); ?>.map((label, index) => {
                            return label + ' (' + <?php echo json_encode($chartData); ?>[index] + ')';
                        }),
                        datasets: [{
                            data: <?php echo json_encode($chartData); ?>,
                            backgroundColor: <?php echo json_encode($chartColors); ?>
                        }]
                    };

                    new Chart(ctx, {
                        type: 'pie',
                        data: chartData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                position: 'bottom'
                            },
                            layout: {
                                padding: {
                                    top: 20,
                                    bottom: 20
                                }
                            }
                        }
                    });
                }

                // Ensure the pie chart is rendered on page load
                document.addEventListener('DOMContentLoaded', function() {
                    renderChart();
                });
                </script>
            </div>
            <!-- Main Content Area End -->

            <?php include '../includes/footer.php' ?>
        </div>
        <!-- main content area end -->
    </div>

    <!-- Scripts -->
    <!-- jquery latest version -->
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>
    
    <!-- others plugins -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>

