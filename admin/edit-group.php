<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
include('../includes/dbconn.php');

if (empty($_SESSION['usertype'])) {
    header('location:index.php');
    exit;
}
if(isset($_POST['update'])){
    $did=intval($_GET['deptid']);    
    $totalHomeAdvance = !empty($_POST['totalHomeAdvance']) ? $_POST['totalHomeAdvance'] : null;
    $trainAllowance = !empty($_POST['trainAllowance']) ? $_POST['trainAllowance'] : null;
    $travelCost = !empty($_POST['travelCost']) ? $_POST['travelCost'] : null;
    $fooding = !empty($_POST['fooding']) ? $_POST['fooding'] : null;
    $trainTicketCost = !empty($_POST['trainTicketCost']) ? $_POST['trainTicketCost'] : null;
    $personalCosting = !empty($_POST['personalCosting']) ? $_POST['personalCosting'] : null;
    $others = !empty($_POST['others']) ? $_POST['others'] : null;
    $totalCreditedAmount = !empty($_POST['totalCreditedAmount']) ? $_POST['totalCreditedAmount'] : null;

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
    <title>Update Group</title>
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
        input[type="text"], select, form .form-control {
            height: 45px;
            width: 100%;
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
                        $page = 'group';
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
                            <h4 class="page-title pull-left">Update Group</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="group.php">Groups</a></li>
                                <li><span>Update</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <i class="fa fa-user-circle fa-2x" data-toggle="dropdown"></i>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="logout.php">Settings</a>
                                <a class="dropdown-item" href="logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-2">
                        <div class="card">
                            <?php if ($error) { ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <strong>Info: </strong><?php echo htmlentities($error); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } elseif ($msg) { ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <strong>Info: </strong><?php echo htmlentities($msg); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } ?>
                            <form method="POST">
                                <div class="card-body">
                                    <?php
                                    $did = intval($_GET['deptid']);
                                    $sql = "SELECT * FROM tblgroup WHERE id=:did";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':did', $did, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) { ?>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="example-text-input" class="col-form-label">Group Name</label>
                                                        <input class="form-control" name="name" type="text" required id="example-text-input" readOnly value="<?php echo htmlentities($result->name); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="totalCreditedAmount" class="col-form-label">Credited Amount</label>
                                                        <input class="form-control" name="totalCreditedAmount" type="text" value="<?php echo htmlentities($result->totalCreditedAmount); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="trainAllowance" class="col-form-label">Train Allowance</label>
                                                        <input class="form-control" name="trainAllowance" type="text" value="<?php echo htmlentities($result->trainAllowance); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="trainTicketCost" class="col-form-label">Train Ticket Cost</label>
                                                        <input class="form-control" name="trainTicketCost" type="text" value="<?php echo htmlentities($result->trainTicketCost); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="personalCosting" class="col-form-label">Personal Costing</label>
                                                        <input class="form-control" name="personalCosting" type="text" value="<?php echo htmlentities($result->personalCosting); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="travelCost" class="col-form-label">Travel Cost</label>
                                                        <input class="form-control" name="travelCost" type="text" value="<?php echo htmlentities($result->travelCost); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="fooding" class="col-form-label">Fooding</label>
                                                        <input class="form-control" name="fooding" type="text" value="<?php echo htmlentities($result->fooding); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="totalHomeAdvance" class="col-form-label">Home Advance</label>
                                                        <input class="form-control" name="totalHomeAdvance" type="text" value="<?php echo htmlentities($result->totalHomeAdvance); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="others" class="col-form-label">Others</label>
                                                        <input class="form-control" name="others" type="text" value="<?php echo htmlentities($result->others); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    } ?>
                                    <div class="sticky-submit" style="display: flex;">
                                        <button class="btn btn-secondary" type="button" onclick="window.history.back();" style="flex: 1; margin-right: 5px;">Cancel</button>
                                        <button class="btn btn-primary" name="update" id="update" type="submit" style="flex: 1; margin-left: 5px;">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../includes/footer.php'; ?>
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