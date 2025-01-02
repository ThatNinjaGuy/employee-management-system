<?php
    session_start();
    error_reporting(0);
    include('../includes/dbconn.php');
    
    if(empty($_SESSION['usertype'])) {   
        header('location:index.php');
        exit; // Add exit to stop further execution
    } else {
        if(isset($_POST['update'])){
            // Retrieve data from the form
            $payid = intval($_POST['payid']);    
            $rateDisplay = $_POST['rateDisplay'];
            $daysWorked = $_POST['daysWorked'];
            $overTime = $_POST['overTime'];
            $totalAmountDisplay = $_POST['totalAmountDisplay'];
            $advance_in_site = $_POST['advance_in_site'];
            $advance_in_home = $_POST['advance_in_home'];
            $mess = $_POST['mess'];
            $sunday_expenditure = $_POST['sunday_expenditure'];
            $penalty = $_POST['penalty'];
            $net_pay = $_POST['net_pay'];
            $CreationDate = $_POST['CreationDate'];
            $payrollMonth = $_POST['payrollMonth'];

            // Update SQL query
            $sql="UPDATE payslip 
                    SET rateDisplay=:rateDisplay,
                        daysWorked=:daysWorked,
                        overTime=:overTime,
                        totalAmountDisplay=:totalAmountDisplay,
                        advance_in_site=:advance_in_site,
                        advance_in_home=:advance_in_home,
                        mess=:mess,
                        sunday_expenditure=:sunday_expenditure,
                        penalty=:penalty,
                        net_pay=:net_pay,
                        CreationDate=:CreationDate,
                        payrollMonth=:payrollMonth 
                    WHERE id=:payid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':rateDisplay', $rateDisplay, PDO::PARAM_STR);
            $query->bindParam(':daysWorked', $daysWorked, PDO::PARAM_STR);
            $query->bindParam(':overTime', $overTime, PDO::PARAM_STR);
            $query->bindParam(':totalAmountDisplay', $totalAmountDisplay, PDO::PARAM_STR);
            $query->bindParam(':advance_in_site', $advance_in_site, PDO::PARAM_STR);
            $query->bindParam(':advance_in_home', $advance_in_home, PDO::PARAM_STR);
            $query->bindParam(':mess', $mess, PDO::PARAM_STR);
            $query->bindParam(':sunday_expenditure', $sunday_expenditure, PDO::PARAM_STR);
            $query->bindParam(':penalty', $penalty, PDO::PARAM_STR);
            $query->bindParam(':net_pay', $net_pay, PDO::PARAM_STR);
            $query->bindParam(':CreationDate', $CreationDate, PDO::PARAM_STR);
            $query->bindParam(':payrollMonth', $payrollMonth, PDO::PARAM_STR);
            $query->bindParam(':payid', $payid, PDO::PARAM_STR);
            $query->execute();
            $msg="Payroll updated successfully";
            header('location:payroll.php');
            exit();
        }

        // Fetch payslip details
        $payid = intval($_GET['payid']);
        $sql = "SELECT * FROM payslip WHERE id=:payid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':payid', $payid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
?>


<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Panel - Employee Leave</title>
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
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        $page='site';
                        include '../includes/admin-sidebar.php'
                    ?>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <?php
                $pageTitle = "View Payslip";
                $homeLink = "dashboard.php";
                $breadcrumb = "View Payslip";
                $homeText = "Home";
                include '../includes/header.php';
            ?>
            <div class="main-content-inner">
                
                
                <!-- row area start -->
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                    
                        <div class="card">
                        

                        <?php if($error){?><div class="alert alert-danger alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($error); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            
                             </div><?php } 
                                 else if($msg){?><div class="alert alert-success alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($msg); ?> 
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                 </div><?php }?>
                                

                                



                                 <form method="POST">
                                    
    <input type="hidden" name="payid" value="<?php echo htmlentities($result->id); ?>">

    <div class="form-group">
        <label for="rateDisplay" class="col-form-label">Rate</label>
        <input class="form-control" name="rateDisplay" type="text" required id="rateDisplay" readonly value="<?php echo htmlentities($result->rateDisplay); ?> " readonly>
    </div>
    <div class="form-group">
        <label for="daysWorked" class="col-form-label">Days Worked</label>
        <input class="form-control" name="daysWorked" type="text" required id="daysWorked" value="<?php echo htmlentities($result->daysWorked); ?>" oninput="calculateTotalAmount()" readonly>
    </div>
    <div class="form-group">
        <label for="overTime" class="col-form-label">Over Time</label>
        <input class="form-control" name="overTime" type="text" required id="overTime" value="<?php echo htmlentities($result->overTime); ?>" oninput="calculateTotalAmount()" readonly>
    </div>
    <div class="form-group">
        <label for="totalAmountDisplay" class="col-form-label">Total Amount Display</label>
        <input class="form-control" name="totalAmountDisplay" type="text" required id="totalAmountDisplay" value="<?php echo htmlentities($result->totalAmountDisplay); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="advance_in_site" class="col-form-label">Advance in Site</label>
        <input class="form-control" name="advance_in_site" type="text" required id="advance_in_site" value="<?php echo htmlentities($result->advance_in_site); ?>" oninput="calculateTotalAmount()" readonly>
    </div>
    <div class="form-group">
        <label for="advance_in_home" class="col-form-label">Advance in Home</label>
        <input class="form-control" name="advance_in_home" type="text" required id="advance_in_home" value="<?php echo htmlentities($result->advance_in_home); ?>" oninput="calculateTotalAmount()" readonly>
    </div>
    <div class="form-group">
        <label for="mess" class="col-form-label">Mess</label>
        <input class="form-control" name="mess" type="text" required id="mess" value="<?php echo htmlentities($result->mess); ?>" oninput="calculateTotalAmount()" readonly>
    </div>
    <div class="form-group">
        <label for="sunday_expenditure" class="col-form-label">Sunday Expenditure</label>
        <input class="form-control" name="sunday_expenditure" type="text" required id="sunday_expenditure" value="<?php echo htmlentities($result->sunday_expenditure); ?>" oninput="calculateTotalAmount()" readonly>
    </div>
    <div class="form-group">
        <label for="penalty" class="col-form-label">Penalty</label>
        <input class="form-control" name="penalty" type="text" required id="penalty" value="<?php echo htmlentities($result->penalty); ?>" oninput="calculateTotalAmount()" readonly>
    </div>
    <div class="form-group">
        <label for="net_pay" class="col-form-label">Net Pay</label>
        <input class="form-control" name="net_pay" type="text" required id="net_pay" value="<?php echo htmlentities($result->net_pay); ?>" readonly>
    </div>

    <div class="form-group">
            <label for="CreationDate" class="col-form-label"></label>
            <input type="hidden" class="form-control"  name="CreationDate" type="text" required id="CreationDate" value="<?php echo htmlentities($result->CreationDate); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="payrollMonth" class="col-form-label"></label>
            <input type="hidden" class="form-control" name="payrollMonth" type="text" required id="payrollMonth" value="<?php echo htmlentities($result->payrollMonth); ?>" readonly>
        </div>

</form>
                         </div>
                    </div>
                    <!-- Dark table end -->
                    
                </div>
                <!-- row area end -->
                
                </div>
                <!-- row area start-->
            </div>
            <?php include '../includes/footer.php' ?>
        <!-- footer area end-->
        </div>
        <!-- main content area end -->

        
    </div>
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

        <!-- Start datatable js -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    
    <!-- others plugins -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>

<?php } ?>


<script>
function calculateTotalAmount() {
    var rateDisplay = parseFloat(document.getElementById('rateDisplay').value);
    var daysWorked = parseFloat(document.getElementById('daysWorked').value);
    var overTime = parseFloat(document.getElementById('overTime').value);
    var advance_in_site = parseFloat(document.getElementById('advance_in_site').value);
    var advance_in_home = parseFloat(document.getElementById('advance_in_home').value);
    var mess = parseFloat(document.getElementById('mess').value);
    var sunday_expenditure = parseFloat(document.getElementById('sunday_expenditure').value);
    var penalty = parseFloat(document.getElementById('penalty').value);

    var totalAmount = rateDisplay * daysWorked;
    var overtimeAmount = (overTime * rateDisplay) / 12;
    var netPay = totalAmount + overtimeAmount - advance_in_site - advance_in_home - mess - sunday_expenditure - penalty;

    document.getElementById('totalAmountDisplay').value = totalAmount.toFixed(2); // Set total amount with 2 decimal places
    document.getElementById('net_pay').value = netPay.toFixed(2); // Set net pay with 2 decimal places
}
</script>