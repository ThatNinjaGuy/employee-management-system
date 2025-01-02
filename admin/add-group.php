<?php
session_start();
error_reporting(0);

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
        $label = !empty($_POST['label']) ? $_POST['label'] : ''; // Retrieve label from POST

        // Fetch supplier name from the database based on the selected ID
        $sqlSupplierName = "SELECT name FROM tblsupplier WHERE id = :supplier_id";
        $querySupplierName = $dbh->prepare($sqlSupplierName);
        $querySupplierName->bindParam(':supplier_id', $selectedSupplierId, PDO::PARAM_INT);
        $querySupplierName->execute();
        $supplier = $querySupplierName->fetch(PDO::FETCH_ASSOC);

        // Process supplier name to handle multiple words
        $supplierNameParts = explode(' ', $supplier['name']);
        $supplierNameWithUnderscores = implode('_', $supplierNameParts);

        // Conditionally append the label to the group name
        $groupNamePrefix = $supplierNameWithUnderscores;
        if (!empty($label)) {
            $groupNamePrefix .= '_' . $label;
        }
        $groupNamePrefix .= '_Group_';

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

        // Assign POST values to variables and handle empty strings
        $totalHomeAdvance = !empty($_POST['totalHomeAdvance']) ? $_POST['totalHomeAdvance'] : null;
        $trainAllowance = !empty($_POST['trainAllowance']) ? $_POST['trainAllowance'] : null;
        $travelCost = !empty($_POST['travelCost']) ? $_POST['travelCost'] : null;
        $fooding = !empty($_POST['fooding']) ? $_POST['fooding'] : null;
        $trainTicketCost = !empty($_POST['trainTicketCost']) ? $_POST['trainTicketCost'] : null;
        $personalCosting = !empty($_POST['personalCosting']) ? $_POST['personalCosting'] : null;
        $others = !empty($_POST['others']) ? $_POST['others'] : null;
        $totalCreditedAmount = !empty($_POST['totalCreditedAmount']) ? $_POST['totalCreditedAmount'] : null;

        // Insert into tblgroup with supplier ID
        $sql = "INSERT INTO tblgroup(name, supplier_id, totalHomeAdvance, trainAllowance, travelCost, fooding, trainTicketCost, personalCosting, others, totalCreditedAmount, creation_date)
        VALUES(:name, :supplier_id, :totalHomeAdvance, :trainAllowance, :travelCost, :fooding, :trainTicketCost, :personalCosting, :others, :totalCreditedAmount, NOW())";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $groupName, PDO::PARAM_STR);
        $query->bindParam(':supplier_id', $selectedSupplierId, PDO::PARAM_INT);

        // Bind variables instead of direct $_POST values
        $query->bindParam(':totalHomeAdvance', $totalHomeAdvance, PDO::PARAM_STR);
        $query->bindParam(':trainAllowance', $trainAllowance, PDO::PARAM_STR);
        $query->bindParam(':travelCost', $travelCost, PDO::PARAM_STR);
        $query->bindParam(':fooding', $fooding, PDO::PARAM_STR);
        $query->bindParam(':trainTicketCost', $trainTicketCost, PDO::PARAM_STR);
        $query->bindParam(':personalCosting', $personalCosting, PDO::PARAM_STR);
        $query->bindParam(':others', $others, PDO::PARAM_STR);
        $query->bindParam(':totalCreditedAmount', $totalCreditedAmount, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            $msg = "Group Created Successfully. Group Name: " . $groupName;
            header('Location: group.php'); // Redirect to groups.php
            exit; // Ensure no further code is executed
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
    <title>Add Group</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        /* Sticky submit button styling */
        .sticky-submit {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            text-align: center;
        }
        input[type="text"], select {
            height: 45px; /* Set the height to 45px for both input and select elements */
            width: 100%; /* Set the width to 100% to ensure they take the full width of their container */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form .form-control {
            height: 45px !important; /* Force the height to 45px for both input and select elements */
            width: 100%; /* Ensure full width of the container */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
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
                        $page='group';
                        include '../includes/admin-sidebar.php';
                    ?>
                </div>
            </div>
        </div>
        <div class="main-content">
            <?php
                $pageTitle = "Add Group";
                $homeLink = "group.php";
                $breadcrumb = "Add Group";
                $homeText = "Groups";
                include '../includes/header.php';
            ?>
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-2">
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
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="supplierSelect" class="col-form-label">Supplier <span class="text-danger">*</span></label>
                    <select class="form-control" name="supplier_id" id="supplierSelect" required>
                        <option value="" disabled selected>Choose..</option>
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
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="label" class="col-form-label">Group Name</label>
                    <input class="form-control" name="label" type="text">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="travelCost" class="col-form-label">Credited Amount</label>
                    <input class="form-control" name="totalCreditedAmount" type="text" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="travelCost" class="col-form-label">Train Allowance</label>
                    <input class="form-control" name="trainAllowance" type="text" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="trainTicketCost" class="col-form-label">Train Ticket Cost</label>
                    <input class="form-control" name="trainTicketCost" type="text" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="personalCosting" class="col-form-label">Personal Costing</label>
                    <input class="form-control" name="personalCosting" type="text" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="travelCost" class="col-form-label">Travel Cost</label>
                    <input class="form-control" name="travelCost" type="text" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fooding" class="col-form-label">Fooding</label>
                    <input class="form-control" name="fooding" type="text">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="travelCost" class="col-form-label">Home Advance</label>
                    <input class="form-control" name="totalHomeAdvance" type="text" >
                </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="others" class="col-form-label">Others</label>
                    <input class="form-control" name="others" type="text" >
                </div>
            </div>
        <!-- Can be enabled if the group name is dynamically generated and displayed. Not required as of now. -->
            <!-- <div class="col-md-6">
                <div class="form-group">
                    <label for="autoGeneratedName" class="col-form-label">Auto-Generated Group Name</label>
                    <input class="form-control" name="autoGeneratedName" type="text" readonly value="<?php echo $groupName; ?>">
                </div>
            </div> -->
        </div>
        <div class="sticky-submit" style="display: flex;">
            <button class="btn btn-secondary" type="button" onclick="window.history.back();" style="flex: 1; margin-right: 5px;">Cancel</button>
            <button class="btn btn-primary" name="add" id="add" type="submit" style="flex: 1; margin-left: 5px;">Add Group</button>
        </div>
    </div>
</form>
                        </div> 
                    </div>
                </div>
                </div>
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
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>

