<?php
    session_start();
    error_reporting(0);
    include('../includes/dbconn.php');
    if(empty($_SESSION['usertype'])) {   
        header('location:index.php');
        exit; // Add exit to stop further execution
    } else {
    if(isset($_POST['update'])){

        $did=intval($_GET['deptid']);    
        $totalHomeAdvance=$_POST['totalHomeAdvance'];
        $trainAllowance=$_POST['trainAllowance'];
        $travelCost=$_POST['travelCost'];
        $fooding=$_POST['fooding'];
        $trainTicketCost=$_POST['trainTicketCost'];
        $personalCosting=$_POST['personalCosting'];
        $others=$_POST['others'];
        $totalCreditedAmount=$_POST['totalCreditedAmount'];

        $sql="UPDATE tblgroup set totalHomeAdvance=:totalHomeAdvance,trainAllowance=:trainAllowance,travelCost=:travelCost,fooding=:fooding,trainTicketCost=:trainTicketCost,personalCosting=:personalCosting,others=:others,totalCreditedAmount=:totalCreditedAmount where id=:did";
        $query = $dbh->prepare($sql);
        $query->bindParam(':totalHomeAdvance',$totalHomeAdvance,PDO::PARAM_STR);
        $query->bindParam(':trainAllowance',$trainAllowance,PDO::PARAM_STR);
        $query->bindParam(':travelCost',$travelCost,PDO::PARAM_STR);
        $query->bindParam(':fooding',$fooding,PDO::PARAM_STR);
        $query->bindParam(':trainTicketCost',$trainTicketCost,PDO::PARAM_STR);
        $query->bindParam(':personalCosting',$personalCosting,PDO::PARAM_STR);
        $query->bindParam(':others',$others,PDO::PARAM_STR);
        $query->bindParam(':totalCreditedAmount',$totalCreditedAmount,PDO::PARAM_STR);
        $query->bindParam(':did',$did,PDO::PARAM_STR);
        $query->execute();
        $msg="Group updated Successfully";
        header('location:group.php');
            exit();
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
                        $page='site';
                        include '../includes/admin-sidebar.php'
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
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>

                            <!-- Notification bell -->
                            <?php include '../includes/admin-notification.php'?>

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
                            <h4 class="page-title pull-left">Site Section</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="site.php">Site</a></li>
                                <li><span>Update</span></li>
                                
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
                                        
                                        <p class="text-muted font-14 mb-4">Please make changes on the form below in order to update group</p>

                                        <?php 
                                            $did=intval($_GET['deptid']);
                                            $sql = "SELECT * from tblgroup WHERE id=:did";
                                            $query = $dbh -> prepare($sql);
                                            $query->bindParam(':did',$did,PDO::PARAM_STR);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0)
                                            {
                                            foreach($results as $result)
                                            {               ?> 
                                    

                                    
	
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Group Name</label>
                                            <input class="form-control" name="name" type="text" required id="example-text-input" readOnly value="<?php echo htmlentities($result->name);?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">total Home Advance</label>
                                            <input class="form-control" name="totalHomeAdvance" type="text" autocomplete="off" required id="example-text-input" value="<?php echo htmlentities($result->totalHomeAdvance);?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">train Allowance</label>
                                            <input class="form-control" name="trainAllowance" type="text" autocomplete="off" required id="example-text-input" value="<?php echo htmlentities($result->trainAllowance);?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">travel Cost</label>
                                            <input class="form-control" name="travelCost" type="text" autocomplete="off" required id="example-text-input" value="<?php echo htmlentities($result->travelCost);?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">fooding</label>
                                            <input class="form-control" name="fooding" type="text" autocomplete="off" required id="example-text-input" value="<?php echo htmlentities($result->fooding);?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">train Ticket Cost</label>
                                            <input class="form-control" name="trainTicketCost" type="text" autocomplete="off" required id="example-text-input" value="<?php echo htmlentities($result->trainTicketCost);?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">personal Costing	</label>
                                            <input class="form-control" name="personalCosting" type="text" autocomplete="off" required id="example-text-input" value="<?php echo htmlentities($result->personalCosting);?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">others</label>
                                            <input class="form-control" name="others" type="text" autocomplete="off" required id="example-text-input" value="<?php echo htmlentities($result->others);?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">totalCreditedAmount</label>
                                            <input class="form-control" name="totalCreditedAmount" type="text" autocomplete="off" required id="example-text-input" value="<?php echo htmlentities($result->totalCreditedAmount);?>">
                                        </div>
                                    

                                        <?php }
                                        }?>

                                        <button class="btn btn-primary" name="update" id="update" type="submit">MAKE CHANGES</button>
                                        
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