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
    $sql = "DELETE from  tblgroup  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    $query -> execute();
    $msg="The selected group has been deleted";

    }

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Manage Groups</title>
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
    <style>
        .clickable-row:hover {
            cursor: pointer;
        }

        #groupTable th:first-child,
        #groupTable td:first-child {
            text-align: left;
        }

        #groupTable {
            border-collapse: collapse;
            width: 100%;
        }

        #groupTable th, #groupTable td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
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
        <div class="main-content">
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Manage Groups</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="dashboard.php">Home</a></li>
                                <li><span>Groups</span></li>
                                
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="../assets/images/admin.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">ADMIN<i class="fa fa-angle-down"></i></h4>
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

                            <div class="card-body">
                                <div class="table-responsive">                                
                                    <div class="mb-4">
                                        <center><a href="add-group.php" class="btn btn-sm btn-info">Add New Group</a></center>
                                    </div>
                                    <table id="groupTable" class="table table-hover table-striped text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Name</th>
                                                <th>Supplier Name</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT tblgroup.*, tblsupplier.name AS supplier_name FROM tblgroup
                                                    LEFT JOIN tblsupplier ON tblgroup.supplier_id = tblsupplier.id";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) { ?>
                                                    <tr class="clickable-row" data-href="edit-group.php?deptid=<?php echo htmlentities($result->id); ?>">
                                                        <td><?php echo htmlentities($result->name); ?></td>
                                                        <td><?php echo htmlentities($result->supplier_name); ?></td>
                                                        <td><?php echo htmlentities($result->creation_date); ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } ?>
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
    <script>
        $(document).ready(function() {
            $('#groupTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [[0, "asc"]]
            });

            $('.clickable-row').on('click', function() {
                window.location = $(this).data('href');
            });
        });
    </script>
</body>

</html>

<?php } ?>