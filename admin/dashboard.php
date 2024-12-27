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
                <div class="key-metrics mt-5 d-flex justify-content-between">
                    <div class="metric-card">
                        <div class="metric-icon"><i class="fa fa-users"></i></div>
                        <div class="metric-content">
                            <h4>Total Employees</h4>
                            <span><?php include 'counters/emp-counter.php'?></span>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon"><i class="fa fa-th-large"></i></div>
                        <div class="metric-content">
                            <h4>Active Employees</h4>
                            <span><?php include 'counters/activeemp-counter.php'?></span>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon"><i class="fa fa-th-large"></i></div>
                        <div class="metric-content">
                            <h4>Inactive Employees</h4>
                            <span><?php include 'counters/inactiveemp-counter.php'?></span>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon"><i class="fa fa-th-large"></i></div>
                        <div class="metric-content">
                            <h4>Available Sites</h4>
                            <span><?php include 'counters/dept-counter.php'?></span>
                        </div>
                    </div>
                </div>
                <!-- Key Metrics Section End -->
                <!-- Employee Summary Section -->
                <div class="employee-summary mt-5 mb-5">
                    <h4 class="section-title">Employee Summary</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>Number of Employees</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT d.id, d.name, COUNT(e.id) AS employee_count 
                                    FROM tbldesignation d 
                                    LEFT JOIN tblemployees e ON d.id = e.designation 
                                    GROUP BY d.id, d.name";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                            foreach ($results as $result) {
                                echo "<tr>
                                        <td>" . htmlentities($result->name) . "</td>
                                        <td>" . htmlentities($result->employee_count) . "</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Employee Summary Section End -->
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
</body>

</html>

