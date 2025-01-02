<?php
    session_start();
    error_reporting(0);
    include('../includes/dbconn.php');
    if(empty($_SESSION['usertype'])) {   
        header('location:index.php');
        exit; // Add exit to stop further execution
    } else { 
    if(isset($_GET['del']))
    {
    $id=$_GET['del'];
    $sql = "DELETE from  payroll  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    $query -> execute();
    $msg="The selected payroll has been deleted";

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
        <div class="main-content">
            <?php
                $pageTitle = "Manage Payroll";
                $homeLink = "dashboard.php";
                $breadcrumb = "Manage Payroll";
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

                            <div class="card-body">
                                <div class="data-tables datatable-dark">
                                <center><a href="add-payroll.php" class="btn btn-sm btn-info">Add New Payroll</a></center>
                                    <table id="dataTable3" class="table table-hover table-striped text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Created Date</th>
                                                <th>Actions</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?php $sql = "SELECT * from payroll";
                                    $query = $dbh -> prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0)
                                    {
                                    foreach($results as $result)
                                    {               ?>  
                                        <tr>
                                            <td> <?php echo htmlentities($cnt);?></td>
                                            <td> <?php echo htmlentities($result->code);?></td>
                                            <td><?php echo htmlentities($result->start_date);?></td>
                                            <td><?php echo htmlentities($result->end_date);?></td>
                                            <td><?php echo htmlentities($result->created_at);?></td>
                                                            <td>
                                                <!-- Action buttons -->
                                                <a href="edit-payroll.php?payid=<?php echo htmlentities($result->id); ?>" style="text-decoration: none; margin-right: 10px;">
                                                    <i class="fa fa-edit" style="color: green;"></i> <span style="color: green; font-weight: bold;">Edit</span>
                                                </a>
                                                <a href="designation.php?del=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you want to delete');" style="text-decoration: none; margin-right: 10px;">
                                                    <i class="fa fa-trash" style="color: red;"></i> <span style="color: red; font-weight: bold;">Delete</span>
                                                </a>
                                                <a href="view-payroll.php?id=<?php echo htmlentities($result->id); ?>" style="text-decoration: none;">
                                         <i class="fa fa-eye" style="color: blue;"></i> <span style="color: blue; font-weight: bold;">View</span>
                                                </a>

                                             </td>

                                        </tr>
                                         <?php $cnt++;} }?>
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

<?php } ?>