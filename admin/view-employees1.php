<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');

if(empty($_SESSION['usertype'])) {   
    header('location:index.php');
    exit; // Add exit to stop further execution
} else {
    if (isset($_GET['supplier_id'])) {
        $supplier_id = $_GET['supplier_id'];

        // Fetch supplier details
        $sqlSupplier = "SELECT * FROM tblsupplier WHERE id = :supplier_id";
        $querySupplier = $dbh->prepare($sqlSupplier);
        $querySupplier->bindParam(':supplier_id', $supplier_id, PDO::PARAM_STR);
        $querySupplier->execute();
        $supplierDetails = $querySupplier->fetch(PDO::FETCH_ASSOC);

        // Fetch employees based on the supplier_id
        $sqlEmployees = "SELECT e.*, p.advance_in_home 
                FROM tblemployees e
                LEFT JOIN payslip p ON e.id = p.employeeSelect
                WHERE e.supplier_id = :supplier_id";

$queryEmployees = $dbh->prepare($sqlEmployees);
$queryEmployees->bindParam(':supplier_id', $supplier_id, PDO::PARAM_STR);
$queryEmployees->execute();
$employees = $queryEmployees->fetchAll(PDO::FETCH_OBJ);
        $employeeCount = $queryEmployees->rowCount();
        // Fetch group information
        $groupId = $supplierDetails['group_id'];
        $sqlGroup = "SELECT * FROM tblgroup WHERE supplier_id = :supplier_id";
        $queryGroup = $dbh->prepare($sqlGroup);
        $queryGroup->bindParam(':supplier_id', $supplier_id, PDO::PARAM_STR);
        $queryGroup->execute();
        $groupDetails = $queryGroup->fetch(PDO::FETCH_ASSOC);

        // Fetch total number of employees in the group
        $sqlTotalEmployees = "SELECT COUNT(*) AS total_employees FROM tblemployees WHERE group_id = :group_id";
        $queryTotalEmployees = $dbh->prepare($sqlTotalEmployees);
        $queryTotalEmployees->bindParam(':group_id', $groupId, PDO::PARAM_STR);
        $queryTotalEmployees->execute();
        $totalEmployees = $queryTotalEmployees->fetch(PDO::FETCH_ASSOC)['total_employees'];
// Fetch total expenditure from tblgroup for a specific group within a supplier

$groupId = $groupDetails['id'];
$sqlTotalExpenditure = "SELECT totalCreditedAmount,
    SUM(CAST(totalHomeAdvance AS DECIMAL(10,2))) AS totalHomeAdvance,
    SUM(CAST(trainAllowance AS DECIMAL(10,2))) AS trainAllowance,
    SUM(CAST(travelCost AS DECIMAL(10,2))) AS travelCost,
    SUM(CAST(fooding AS DECIMAL(10,2))) AS fooding,
    SUM(CAST(trainTicketCost AS DECIMAL(10,2))) AS trainTicketCost,
    SUM(CAST(personalCosting AS DECIMAL(10,2))) AS personalCosting,
    SUM(CAST(others AS DECIMAL(10,2))) AS others,
    SUM(CAST(totalCreditedAmount AS DECIMAL(10,2))) AS totalCreditedAmount
FROM tblgroup 
WHERE supplier_id = :supplier_id AND id = :group_id";

$queryTotalExpenditure = $dbh->prepare($sqlTotalExpenditure);
$queryTotalExpenditure->bindParam(':supplier_id', $supplier_id, PDO::PARAM_STR);
$queryTotalExpenditure->bindParam(':group_id', $groupId, PDO::PARAM_STR); // Assuming $groupId is the group ID
$queryTotalExpenditure->execute();
$totalExpenditure = $queryTotalExpenditure->fetch(PDO::FETCH_ASSOC);






// Calculate total sum for the specific group
$sumTotalExpenditure = $totalExpenditure['totalHomeAdvance']
    + $totalExpenditure['trainAllowance']
    + $totalExpenditure['travelCost']
    + $totalExpenditure['fooding']
    + $totalExpenditure['trainTicketCost']
    + $totalExpenditure['personalCosting']
    + $totalExpenditure['others'];

    $difference = $totalExpenditure['totalCreditedAmount'] -$sumTotalExpenditure;


    } else {
        // Redirect to the supplier list if no supplier_id is provided
        header('location:supplier.php');
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

    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
 
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <!-- <link rel="stylesheet" href="../assets/css/styles.css"> -->
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    
</head>

<body>
   
   
 
    
    <div class="page-container">
       
        <div class="main-content">
            <?php
                $pageTitle = "View Employees";
                $homeLink = "dashboard.php";
                $breadcrumb = "View Employees";
                $homeText = "Home";
                include '../includes/header.php';
            ?>
            <div class="main-content-inner">
           
<?php if ($supplierDetails) { ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Supplier Information</h5>
            <p><strong>Supplier ID:</strong> <?php echo htmlentities($supplierDetails['id']); ?></p>
            <p><strong>Supplier Name:</strong> <?php echo htmlentities($supplierDetails['name']); ?></p>
            <?php if ($groupDetails) { ?>
                <p><strong>Group ID:</strong> <?php echo htmlentities($groupDetails['id']); ?></p>
                <p><strong>Group Name:</strong> <?php echo htmlentities($groupDetails['name']); ?></p>




                
                <p><strong>Total Expenditure in Group:</strong> <?php echo htmlentities($sumTotalExpenditure); ?></p>
                <p><strong>Total Credited Amount in Group:</strong> <?php echo htmlentities($totalExpenditure['totalCreditedAmount']); ?></p>
                <p><strong>Due / Advance On Supplier :</strong> <?php echo htmlentities($difference); ?></p>

            <?php } else { ?>
                <p><strong>Group ID:</strong> N/A</p>
                <p><strong>Group Name:</strong> N/A</p>
                <p><strong>Total Expenditure in Group:</strong> N/A</p>
            <?php } ?>
            <?php if ($totalEmployees !== false) { ?>
                <p><strong>Total Employees in Group:</strong> <?php echo htmlentities($employeeCount); ?></p>
            <?php } else { ?>
                <p><strong>Total Employees in Group:</strong> N/A</p>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <div class="card">
        <div class="card-body">
            <p>No supplier details found for the provided ID.</p>
        </div>
    </div>
<?php } ?>
</div>


   

                
                
                <div class="row">
                  
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

                            <div class="card-body">
                                <div class="data-tables datatable-dark">
                               
                                    <table id="dataTable3" class="table table-hover table-striped text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                
                                                <th>id</th>
                                                <th>First  Name</th>
                                             
                                                <th>Home Advance</th>
                                               
                                                <th></th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
        $cnt = 1;
        foreach ($employees as $employee) {
            ?>
                                        <tr>
                                            <td> <?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($employee->id);?></td>
                                            <td><?php echo htmlentities($employee->FirstName);?></td>
                                            
                                            <td><?php echo htmlentities($employee->advance_in_home);?></td>

                                        
                                        </tr>
                                        <?php
            $cnt++;
        }
        ?>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
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




