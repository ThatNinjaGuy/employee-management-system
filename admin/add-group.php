<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../includes/dbconn.php');

$error = ""; // Initialize $error variable
$msg = "";   // Initialize $msg variable
$groupName = ""; // Initialize $groupName variable

if(empty($_SESSION['usertype'])) {   
    header('location:index.php');
    exit; // Add exit to stop further execution
} else {
    if (isset($_POST['add'])) {
        // Retrieve selected supplier ID and name from the form
        $selectedSupplierId = $_POST['supplier_id'];

        // Fetch supplier name from the database based on the selected ID
        $sqlSupplierName = "SELECT name FROM tblsupplier WHERE id = :supplier_id";
        $querySupplierName = $dbh->prepare($sqlSupplierName);
        $querySupplierName->bindParam(':supplier_id', $selectedSupplierId, PDO::PARAM_INT);
        $querySupplierName->execute();
        $supplier = $querySupplierName->fetch(PDO::FETCH_ASSOC);

        // Process supplier name to handle multiple words
        $supplierNameParts = explode(' ', $supplier['name']);
        $supplierNameWithUnderscores = implode('_', $supplierNameParts);

        // Auto-generate a unique group name starting with the processed supplier name
        $groupNamePrefix = $supplierNameWithUnderscores . '_Group_';

        // Fetch the latest counter value from the database
        $sqlCounter = "SELECT counter FROM group_counter WHERE supplier_id = :supplier_id";
        $queryCounter = $dbh->prepare($sqlCounter);
        $queryCounter->bindParam(':supplier_id', $selectedSupplierId, PDO::PARAM_INT);
        $queryCounter->execute();
        $counterRow = $queryCounter->fetch(PDO::FETCH_ASSOC);
        $counter = $counterRow ? $counterRow['counter'] + 1 : 1;

        // Pad the counter with zeros
        $paddedCounter = str_pad($counter, 4, '0', STR_PAD_LEFT);

        // Update the counter value in the database
        $sqlUpdateCounter = "INSERT INTO group_counter (supplier_id, counter) VALUES (:supplier_id, :counter)
                             ON DUPLICATE KEY UPDATE counter = :counter";
        $queryUpdateCounter = $dbh->prepare($sqlUpdateCounter);
        $queryUpdateCounter->bindParam(':supplier_id', $selectedSupplierId, PDO::PARAM_INT);
        $queryUpdateCounter->bindParam(':counter', $counter, PDO::PARAM_INT);
        $queryUpdateCounter->execute();

        // Combine the counter with the prefix
        $groupName = $groupNamePrefix . $paddedCounter;

        // Insert into tblgroup with supplier ID
        $sql = "INSERT INTO tblgroup(name, supplier_id, totalHomeAdvance, trainAllowance, travelCost, fooding, trainTicketCost, personalCosting, others,totalCreditedAmount, creation_date)
        VALUES(:name, :supplier_id, :totalHomeAdvance, :trainAllowance, :travelCost, :fooding, :trainTicketCost, :personalCosting, :others, :totalCreditedAmount ,NOW())";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $groupName, PDO::PARAM_STR);
        $query->bindParam(':supplier_id', $selectedSupplierId, PDO::PARAM_INT);
        $query->bindParam(':totalHomeAdvance', $_POST['totalHomeAdvance'], PDO::PARAM_STR);
        $query->bindParam(':trainAllowance', $_POST['trainAllowance'], PDO::PARAM_STR);
        $query->bindParam(':travelCost', $_POST['travelCost'], PDO::PARAM_STR);
        $query->bindParam(':fooding', $_POST['fooding'], PDO::PARAM_STR);
        $query->bindParam(':trainTicketCost', $_POST['trainTicketCost'], PDO::PARAM_STR);
        $query->bindParam(':personalCosting', $_POST['personalCosting'], PDO::PARAM_STR);
        $query->bindParam(':others', $_POST['others'], PDO::PARAM_STR);
        $query->bindParam(':totalCreditedAmount', $_POST['totalCreditedAmount'], PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            $msg = "Group Created Successfully. Group Name: " . $groupName;
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
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
                        $page='department';
                        include '../includes/admin-sidebar.php';
                    ?>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <!-- <div class="header-area">
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
            </div> -->
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Group Section</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="group.php">Group</a></li>
                                <li><span>Add</span></li>
                                
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
    <div class="card-body">
        <p class="text-muted font-14 mb-4">Please fill up the form in order to add a new group</p>

        <div class="form-group">
            <label for="supplierSelect" class="col-form-label">Select Supplier</label>
            <select class="form-control" name="supplier_id" id="supplierSelect" required>
                <?php
                // Fetch data from tblsupplier
                $sqlSupplier = "SELECT id, name FROM tblsupplier";
                $querySupplier = $dbh->prepare($sqlSupplier);
                $querySupplier->execute();
                $suppliers = $querySupplier->fetchAll(PDO::FETCH_ASSOC);

                // Populate the dropdown options
                foreach ($suppliers as $supplier) {
                    echo "<option value='{$supplier['id']}'>{$supplier['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="travelCost" class="col-form-label">Total Home Advance</label>
            <input class="form-control" name="totalHomeAdvance" type="text" required>
        </div>
        <div class="form-group">
            <label for="travelCost" class="col-form-label">Total Credited Amount</label>
            <input class="form-control" name="totalCreditedAmount" type="text" required>
        </div>
        <div class="form-group">
            <label for="travelCost" class="col-form-label">Train Allowance</label>
            <input class="form-control" name="trainAllowance" type="text" required>
        </div>
        <div class="form-group">
            <label for="travelCost" class="col-form-label">Travel Cost</label>
            <input class="form-control" name="travelCost" type="text" required>
        </div>

        <div class="form-group">
            <label for="fooding" class="col-form-label">Fooding</label>
            <input class="form-control" name="fooding" type="text" required>
        </div>

        <div class="form-group">
            <label for="trainTicketCost" class="col-form-label">Train Ticket Cost</label>
            <input class="form-control" name="trainTicketCost" type="text" required>
        </div>

        <div class="form-group">
            <label for="personalCosting" class="col-form-label">Personal Costing</label>
            <input class="form-control" name="personalCosting" type="text" required>
        </div>

        <div class="form-group">
            <label for="others" class="col-form-label">Others</label>
            <input class="form-control" name="others" type="text" required>
        </div>

        <div class="form-group">
            <label for="autoGeneratedName" class="col-form-label">Auto-Generated Group Name</label>
            <input class="form-control" name="autoGeneratedName" type="text" readonly value="<?php echo $groupName; ?>">
        </div>
        

        <button class="btn btn-primary" name="add" id="add" type="submit">ADD</button>
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

