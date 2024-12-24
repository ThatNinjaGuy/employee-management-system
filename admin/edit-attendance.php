<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');

if(empty($_SESSION['usertype'])) {   
    header('location:index.php');
    exit; // Add exit to stop further execution
} else {
    $attid = filter_input(INPUT_GET, 'attid', FILTER_VALIDATE_INT);

    if (isset($_POST['update'])) {
        $daysWorked = $_POST['daysWorked'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        // Validate user inputs
        if ($attid && $daysWorked !== false && $startDate && $endDate) {
            try {
                $sql = "UPDATE attendance SET daysWorked=:daysWorked, startDate=:startDate, endDate=:endDate WHERE id=:attid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':daysWorked', $daysWorked, PDO::PARAM_STR);
                $query->bindParam(':startDate', $startDate, PDO::PARAM_STR);
                $query->bindParam(':endDate', $endDate, PDO::PARAM_STR);
                $query->bindParam(':attid', $attid, PDO::PARAM_INT);
                $query->execute();
                $msg = "Attendance updated successfully";
            } catch (PDOException $e) {
                $error = "Error updating attendance: " . $e->getMessage();
            }
        } else {
            $error = "Invalid input data";
        }
    }

    // Fetch attendance details based on attid from the database
    if ($attid) {
        $sql = "SELECT a.*, e.FirstName FROM attendance a
                INNER JOIN tblemployees e ON a.employee_id = e.id
                WHERE a.id=:attid";
        $query1 = $dbh->prepare($sql);
        $query1->bindParam(':attid', $attid, PDO::PARAM_INT);
        $query1->execute();
        $results = $query1->fetchAll(PDO::FETCH_OBJ);
    }
}
?>

<!DOCTYPE html>
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
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    
</head>

<body>

    <div class="page-container">
        <!-- sidebar menu area start -->
      
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <?php include '../includes/admin-header.php'; ?>
         

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <?php if($error) { ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <strong>Error:</strong> <?php echo htmlentities($error); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } else if($msg) { ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <strong>Success:</strong> <?php echo htmlentities($msg); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } ?>

                            <form method="POST">
                                <div class="card-body">
                                    <p class="text-muted font-14 mb-4">Please make changes on the form below in order to update attendance</p>
                                    <?php if ($query1->rowCount() > 0) : ?>
                                        <?php foreach ($results as $result) : ?>
                                            <div class="form-group">
    <label for="employeeName">Employee Name</label>
    <input class="form-control" name="employeeName" type="text" readonly value="<?php echo isset($result->FirstName) ? htmlentities($result->FirstName) : ''; ?>">
</div
                                            <div class="form-group">
                                                <label for="daysWorked">Days Worked</label>
                                                <input class="form-control" name="daysWorked" type="text" required id="daysWorked" value="<?php echo isset($result->daysWorked) ? htmlentities($result->daysWorked) : ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="startDate">Start Date</label>
                                                <input class="form-control" name="startDate" type="text" autocomplete="off" required id="startDate" value="<?php echo isset($result->startDate) ? htmlentities($result->startDate) : ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="endDate">End Date</label>
                                                <input class="form-control" name="endDate" type="text" autocomplete="off" required id="endDate" value="<?php echo isset($result->endDate) ? htmlentities($result->endDate) : ''; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                        <button class="btn btn-primary" name="update" id="update" type="submit">MAKE CHANGES</button>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

    script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
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
