<?php
    session_start();
    error_reporting(0);
    include('../includes/dbconn.php');
    if(empty($_SESSION['usertype'])) {   
        header('location:index.php');
        exit; // Add exit to stop further execution
    } else {

    //Inactive  Employee    
    if(isset($_GET['inid']))
    {
    $id=$_GET['inid'];
    $status=0;
    $sql = "UPDATE tblemployees set Status=:status  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    $query -> bindParam(':status',$status, PDO::PARAM_STR);
    $query -> execute();
    header('location:employees.php');
    }

    //Activated Employee
    if(isset($_GET['id'])){
    $id=$_GET['id'];
    $status=1;
    $sql = "UPDATE tblemployees set Status=:status  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    $query -> bindParam(':status',$status, PDO::PARAM_STR);
    $query -> execute();
    header('location:employees.php');
    }
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
                        $page='employee';
                        include '../includes/admin-sidebar.php';
                    ?>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
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

                            
                            <?php //include '../includes/admin-notification.php'?>

                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Employee Section</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="dashboard.php">Home</a></li>
                                <li><span>Employee Management</span></li>
                                
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

                            <div class="card-body">
                                <div class="data-tables datatable-dark">
                                <div class="text-center mb-3">
    <a href="add-employee.php" class="btn btn-sm btn-info mr-2">Add New Employee</a>
    <a href="generate_pdf.php" class="btn btn-sm btn-primary mr-2">Download PDF</a>
    <a href="generate_xls.php" class="btn btn-sm btn-success">Download XLS</a>
</div>
                                    <table id="dataTable3" class="table table-hover table-striped text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Employe ID</th>
                                                <th>Site</th>
                                                <th>Joined On</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                    <?php 
                                   $sql = "SELECT e.EmpId, e.FirstName, e.LastName, s.name AS SiteName, e.Status, e.id, e.doj 
                                   FROM tblemployees e
                                   LEFT JOIN tblsite s ON e.Site = s.id";
                           $query = $dbh->prepare($sql);
                           $query->execute();
                           $results = $query->fetchAll(PDO::FETCH_OBJ);
                           $cnt = 1;
                           if ($query->rowCount() > 0) {
                               foreach ($results as $result) {
                                   ?>
                                   <tr>
                                       <td><?php echo htmlentities($cnt); ?></td>
                                       <td><?php echo htmlentities($result->FirstName); ?>&nbsp;<?php echo htmlentities($result->LastName); ?></td>
                                       <td><?php echo htmlentities($result->EmpId); ?></td>
                                       <td><?php echo htmlentities($result->SiteName); ?></td>
                                       <td><?php echo htmlentities($result->doj); ?></td>
                                       <td>
                                           <?php
                                           $status = $result->Status;
                                           if ($status) {
                                               ?>
                                               <span class="badge badge-pill badge-success">Active</span>
                                           <?php } else { ?>
                                               <span class="badge badge-pill badge-danger">Inactive</span>
                                           <?php } ?>
                                       </td>
                                       <td>
                                           <a href="update-employee.php?empid=<?php echo htmlentities($result->id); ?>"><i class="fa fa-edit"
                                                   style="color:green"></i></a>
                                           <?php if ($result->Status == 1) { ?>
                                               <a href="employees.php?inid=<?php echo htmlentities($result->id); ?>"
                                                   onclick="return confirm('Are you sure you want to inactive this employee?');"><i
                                                       class="fa fa-times-circle" style="color:red" title="Inactive"></i></a>
                                           <?php } else { ?>
                                               <a href="employees.php?id=<?php echo htmlentities($result->id); ?>"
                                                   onclick="return confirm('Are you sure you want to active this employee?');"><i
                                                       class="fa fa-check" style="color:green" title="Active"></i></a>
                                           <?php } ?>
                                           <a href="employees.php?delid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to delete this employee?');">
    <i class="fa fa-trash" style="color: red" title="Delete"></i>
</a>

<?php
// Add the following code to handle the deletion logic

if (isset($_GET['delid'])) {
    $id = intval($_GET['delid']);
    
    // Soft delete by updating the status to -1 or any value indicating deleted
      $sql = "DELETE from  tblemployees  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    // Add any additional logic you need for deleting records
    // You may also consider hard delete by using DELETE query if necessary

    echo "<script>alert('Employee deleted successfully');</script>";
    echo "<script>window.location.href='employees.php'</script>";
}
?>
                                       </td>
                                   </tr>
                                   <?php
                                   $cnt++;
                               }
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
        </div>
        <!-- main content area end -->

        
        <!-- footer area end-->
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