<!-- : The script starts a session and checks if the usertype session variable is set. If not, it redirects the user to index.php and stops further execution. -->
<?php
    session_start();
    // error_reporting(E_ALL);
    error_reporting(0);
    include('../includes/dbconn.php');
    
    if(empty($_SESSION['usertype'])) {   
        header('location:index.php');
        exit; // Ensure exit is present to stop further execution
    }

    // Query to count available sites
    $siteCountQuery = "SELECT COUNT(*) as count FROM tblsite";
    $siteCountResult = $dbh->query($siteCountQuery)->fetch(PDO::FETCH_OBJ);
    $siteCount = $siteCountResult->count;

    // Query to count active and total employees
    $activeEmpCountQuery = "SELECT COUNT(*) as count FROM tblemployees WHERE status = 1";
    $activeEmpCountResult = $dbh->query($activeEmpCountQuery)->fetch(PDO::FETCH_OBJ);
    $activeEmpCount = $activeEmpCountResult->count;

    $empCountQuery = "SELECT COUNT(*) as count FROM tblemployees";
    $empCountResult = $dbh->query($empCountQuery)->fetch(PDO::FETCH_OBJ);
    $empCount = $empCountResult->count;

    // Query to count available groups
    $groupCountQuery = "SELECT COUNT(*) as count FROM tblgroup";
    $groupCountResult = $dbh->query($groupCountQuery)->fetch(PDO::FETCH_OBJ);
    $groupCount = $groupCountResult->count;

    // Query to count available suppliers
    $supplierCountQuery = "SELECT COUNT(*) as count FROM tblsupplier";
    $supplierCountResult = $dbh->query($supplierCountQuery)->fetch(PDO::FETCH_OBJ);
    $supplierCount = $supplierCountResult->count;

    // Query to get employee count per supplier
    $supplierEmpCountQuery = "SELECT s.name, COUNT(e.id) AS employee_count 
                              FROM tblsupplier s 
                              LEFT JOIN tblemployees e ON s.id = e.supplier_id 
                              GROUP BY s.name
                              ORDER BY employee_count DESC";
    $supplierQuery = $dbh->prepare($supplierEmpCountQuery);
    $supplierQuery->execute();
    $supplierResults = $supplierQuery->fetchAll(PDO::FETCH_OBJ);

    // Prepare data for supplier chart
    $supplierChartLabels = array_map(function($result) {
        return htmlentities($result->name);
    }, $supplierResults);
    $supplierChartData = array_map(function($result) {
        return htmlentities($result->employee_count);
    }, $supplierResults);
    $supplierChartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FFCD56'];

    // Updated query to get employee count per designation with names
    $designationCountQuery = "SELECT d.name as designation, 
                                 COUNT(e.id) as count 
                          FROM tbldesignation d
                          LEFT JOIN tblemployees e ON e.Designation = d.id
                          GROUP BY d.id, d.name";
    $designationQuery = $dbh->prepare($designationCountQuery);
    $designationQuery->execute();
    $designationResults = $designationQuery->fetchAll(PDO::FETCH_OBJ);

    // Prepare data for designation chart
    $designationChartLabels = array_map(function($result) {
        return htmlentities($result->designation);
    }, $designationResults);
    $designationChartData = array_map(function($result) {
        return $result->count;
    }, $designationResults);

    // Ensure these variables are defined
    $chartLabels = []; // Initialize with an empty array
    $chartData = []; // Initialize with an empty array
    $chartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FFCD56'];
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
    .chart-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-top: 20px;
    }

    .chart-item {
        flex: 1;
        margin: 10px;
        box-sizing: border-box;
        width: 45%;
        max-width: 100%;
        position: relative;
        background-color: #f0f8ff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: transform 0.3s ease;
        padding: 20px;
    }

    .chart-item:hover {
        transform: translateY(-5px);
    }

    .chart-item .section-title {
        text-align: center;
        padding-bottom: 10px;
        font-size: 1.2rem;
    }

    .legend-container {
        position: absolute;
        bottom: -50px;
        width: 100%;
        text-align: center;
    }

    @media (max-width: 1200px) {
        .chart-item {
            flex: 1 1 100%;
        }
    }

    .key-metrics .metric-card {
        flex: 1 1 200px;
        min-width: 200px;
        margin: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f0f8ff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .key-metrics .metric-card:hover {
        transform: translateY(-5px);
    }

    /* Add media query for smaller screens */
    @media (max-width: 768px) {
        .metric-content {
            padding: 10px; /* Reduce padding for smaller screens */
        }
    }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
        <div class="main-content">   
            <?php
                $pageTitle = "Admin Overview";
                $homeLink = "dashboard.php";
                $breadcrumb = "Admin Dashboard";
                $homeText = "Home";
                include '../includes/header.php';
            ?>
            
            <div class="main-content-inner">
                <!-- Key Metrics Section -->
                <div class="key-metrics mt-5 d-flex flex-wrap">
                    <div class="metric-card" style="flex: 1 1 200px; min-width: 200px; margin: 10px; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; border-radius: 8px;"
                         onclick="navigateTo('supplier')">
                        <div class="metric-content text-center" style="padding: 20px;">
                            <h2 style="font-size: 2.5rem; margin-bottom: 10px;"><?php echo $supplierCount; ?></h2>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <i class="fa fa-truck" style="font-size: 1.2rem;"></i>
                                <span style="font-size: 1.1rem;">Suppliers</span>
                            </div>
                        </div>
                    </div>
                    <div class="metric-card" style="flex: 1 1 200px; min-width: 200px; margin: 10px; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; border-radius: 8px;"
                         onclick="navigateTo('group')">
                        <div class="metric-content text-center" style="padding: 20px;">
                            <h2 style="font-size: 2.5rem; margin-bottom: 10px;"><?php echo $groupCount; ?></h2>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <i class="fa fa-object-group" style="font-size: 1.2rem;"></i>
                                <span style="font-size: 1.1rem;">Groups</span>
                            </div>
                        </div>
                    </div>
                    <div class="metric-card" style="flex: 1 1 200px; min-width: 200px; margin: 10px; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; border-radius: 8px;"
                         onclick="navigateTo('employee')">
                        <div class="metric-content text-center" style="padding: 20px;">
                            <h2 style="font-size: 2.5rem; margin-bottom: 10px;"><?php echo $activeEmpCount; ?> / <?php echo $empCount; ?></h2>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <i class="fa fa-users" style="font-size: 1.2rem;"></i>
                                <span style="font-size: 1.1rem;">Employees</span>
                            </div>
                        </div>
                    </div>
                    <div class="metric-card" style="flex: 1 1 200px; min-width: 200px; margin: 10px; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; border-radius: 8px;"
                         onclick="navigateTo('site')">
                        <div class="metric-content text-center" style="padding: 20px;">
                            <h2 style="font-size: 2.5rem; margin-bottom: 10px;"><?php echo $siteCount; ?></h2>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <i class="fa fa-th-large" style="font-size: 1.2rem;"></i>
                                <span style="font-size: 1.1rem;">Sites</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add the Generate Payroll button here -->
                <div class="text-center my-4">
                    <button onclick="navigateTo('payroll')" style="font-size: 1.1rem; padding: 10px 20px; border: none; border-radius: 5px; background-color: #4CAF50; color: white; cursor: pointer;">
                        Generate Payroll
                    </button>
                </div>

                <div class="chart-container d-flex justify-content-between">
                    <div class="chart-item" style="flex: 1; margin-right: 10px;">
                        <h4 class="section-title">Employee Roles</h4>
                        <canvas id="employeeRoleChart" style="width: 100%; height: 400px;"></canvas>
                    </div>
                    <div class="chart-item" style="flex: 1;">
                        <h4 class="section-title">Employee Count per Supplier</h4>
                        <canvas id="supplierEmployeeChart" style="width: 100%; height: 400px;"></canvas>
                    </div>
                </div>
                
                <script>
                function renderEmployeeRoleChart() {
                    var ctx = document.getElementById('employeeRoleChart').getContext('2d');
                    if (!ctx) {
                        console.error('Canvas element for Employee Role Chart not found');
                        return;
                    }
                    var chartData = {
                        labels: <?php echo json_encode($designationChartLabels); ?>.map((label, index) => {
                            return label + ' (' + <?php echo json_encode($designationChartData); ?>[index] + ')';
                        }),
                        datasets: [{
                            data: <?php echo json_encode($designationChartData); ?>,
                            backgroundColor: <?php echo json_encode($chartColors); ?>
                        }]
                    };

                    new Chart(ctx, {
                        type: 'pie',
                        data: chartData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 10
                                    }
                                }
                            },
                            layout: {
                                padding: {
                                    top: 20,
                                    bottom: 50
                                }
                            }
                        }
                    });
                }

                function renderSupplierChart() {
                    var ctx = document.getElementById('supplierEmployeeChart').getContext('2d');
                    if (!ctx) {
                        console.error('Canvas element for Supplier Chart not found');
                        return;
                    }
                    var supplierChartData = {
                        labels: <?php echo json_encode($supplierChartLabels); ?>.map((label, index) => {
                            return label + ' (' + <?php echo json_encode($supplierChartData); ?>[index] + ')';
                        }),
                        datasets: [{
                            data: <?php echo json_encode($supplierChartData); ?>,
                            backgroundColor: <?php echo json_encode($supplierChartColors); ?>
                        }]
                    };

                    new Chart(ctx, {
                        type: 'pie',
                        data: supplierChartData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 10
                                    }
                                }
                            },
                            layout: {
                                padding: {
                                    top: 20,
                                    bottom: 50
                                }
                            }
                        }
                    });
                }

                document.addEventListener('DOMContentLoaded', function() {
                    renderEmployeeRoleChart();
                    renderSupplierChart();
                });

                function navigateTo(section) {
                    <?php if ($_SESSION['usertype'] === 'Admin') { ?>
                        const adminSections = {
                            'supplier': 'supplier.php',
                            'group': 'group.php',
                            'employee': 'employees.php',
                            'site': 'site.php',
                            'payroll': 'payroll.php',
                            'manage-admin': 'manage-admin.php'
                        };
                        window.location.href = adminSections[section];
                    <?php } elseif ($_SESSION['usertype'] === 'supervisor') { ?>
                        const supervisorSections = {
                            'supplier': 'supplier.php',
                            'group': 'group.php',
                            'employee': 'employees.php',
                            'site': 'site.php',
                            'payroll': 'payroll.php',
                            'manage-admin': 'manage-admin.php'
                        };
                        if (supervisorSections[section]) {
                            window.location.href = supervisorSections[section];
                        }
                    <?php } elseif ($_SESSION['usertype'] === 'default') { ?>
                        const defaultSections = {
                            'supplier': 'supplier.php',
                            'group': 'group.php',
                            'employee': 'employees.php',
                            'site': 'site.php'
                        };
                        if (defaultSections[section]) {
                            window.location.href = defaultSections[section];
                        }
                    <?php } ?>
                }
                </script>
            </div>

            <?php include '../includes/footer.php' ?>
        </div>
    </div>
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <script src="assets/js/line-chart.js"></script>
    <script src="assets/js/pie-chart.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>

