<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');
if(empty($_SESSION['usertype'])) {   
    header('location:index.php');
    exit; // Add exit to stop further execution
} else {
    $error = '';

    if (isset($_POST['submitAttendance'])) {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $siteId = $_POST['siteId'];
        $employeeIds = $_POST['employeeIds'];
        $daysWorked = $_POST['daysWorked'];
        $overTime = $_POST['overTime'];

        // Validate dates and site ID
        if ($startDate && $endDate && $siteId && !empty($employeeIds) && !empty($daysWorked) && !empty($overTime)) {
            // Perform additional validation if needed

            try {
                $dbh->beginTransaction();

                // Loop through the employees and their corresponding days worked
                foreach ($employeeIds as $key => $employeeId) {
                    // Access the nested arrays for daysWorked and overTime
                    $daysArray = $daysWorked[$employeeId];
                    $overtimeArray = $overTime[$employeeId];

                    // Check if daysArray and overtimeArray are set and not empty
                    if (!isset($daysArray[0]) || !isset($overtimeArray[0]) || empty($daysArray[0]) || empty($overtimeArray[0])) {
                        // Handle the error, e.g., skip this employee or show an error message
                        $_SESSION['error_msg'] = "Days Worked and Overtime are required for employee ID $employeeId";
                        header("Location: add-attendance.php");
                        exit;
                    }

                    // Retrieve the values from the nested arrays
                    $days = $daysArray[0];
                    $overtime = $overtimeArray[0];

                    // Check if attendance records already exist for the selected employee and month
                    $existingAttendanceSql = "SELECT COUNT(*) AS count FROM attendance WHERE employee_id = :employeeId AND MONTH(startDate) = MONTH(:startDate) AND YEAR(startDate) = YEAR(:startDate)";
                    $existingAttendanceQuery = $dbh->prepare($existingAttendanceSql);
                    $existingAttendanceQuery->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
                    $existingAttendanceQuery->bindParam(':startDate', $startDate, PDO::PARAM_STR);
                    $existingAttendanceQuery->execute();
                    $existingAttendanceCount = $existingAttendanceQuery->fetch(PDO::FETCH_ASSOC)['count'];

                    if ($existingAttendanceCount == 0) {
                        // Insert attendance record if none exists
                        $insertAttendanceSql = "INSERT INTO attendance (employee_id, startDate, endDate, daysWorked, overTime, created_at, updated_at) VALUES (:employeeId, :startDate, :endDate, :days, :overtime, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                        $insertAttendanceQuery = $dbh->prepare($insertAttendanceSql);
                        $insertAttendanceQuery->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
                        $insertAttendanceQuery->bindParam(':startDate', $startDate, PDO::PARAM_STR);
                        $insertAttendanceQuery->bindParam(':endDate', $endDate, PDO::PARAM_STR);
                        $insertAttendanceQuery->bindParam(':days', $days, PDO::PARAM_INT);
                        $insertAttendanceQuery->bindParam(':overtime', $overtime, PDO::PARAM_INT);
                        $insertAttendanceQuery->execute();
                    } else {
                        $_SESSION['error_msg'] = "Attendance records already exist for employee ID $employeeId in the selected month";
                        header("Location: add-attendance.php");
                        exit;
                    }
                }

                $dbh->commit();
                $_SESSION['success_msg'] = "Attendance records added successfully";
                header("Location: add-attendance.php");
                exit;
            } catch (PDOException $e) {
                $dbh->rollBack();
                $_SESSION['error_msg'] = "Error: " . $e->getMessage();
            }
        } else {
            $_SESSION['error_msg'] = "Please fill in all the necessary information";
            // Handle other validation issues if needed
        }
    }

    if (isset($_POST['siteId'])) {
        $siteId = $_POST['siteId'];

        // Fetch employees' names and IDs in the selected site
        $sql = "SELECT id, CONCAT(FirstName, ' ', LastName) AS FullName FROM tblemployees WHERE Site = :siteId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':siteId', $siteId, PDO::PARAM_INT);
        $query->execute();
        $employees = $query->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        if ($employees) {
            foreach ($employees as $employee) {
                echo '<div class="form-group d-flex align-items-center">
                <label for="daysWorked_' . $employee['id'] . '"><strong>' . strtoupper($employee['FullName']) . ':</strong></label>
                <div class="d-flex ml-2">
                    <input type="number" class="form-control" name="daysWorked[' . $employee['id'] . '][]" id="daysWorked_' . $employee['id'] . '" placeholder="Days Worked" required>
                    <span class="ml-2">Days</span>
                </div>
                <div class="d-flex ml-2">
                    <input type="number" class="form-control" name="overTime[' . $employee['id'] . '][]" id="overTime_' . $employee['id'] . '" placeholder="Overtime hours" required>
                    <span class="ml-2">Overtime Hours</span>
                </div>
                <input type="hidden" name="employeeIds[]" value="' . $employee['id'] . '">
            </div>';
            }


        } else {
            echo 'No employees found for the selected site';
        }
        exit; // Stop further execution after sending the employee list
    }
}

$sql = "SELECT * FROM tblsite";
$query = $dbh->prepare($sql);
$query->execute();
$sites = $query->fetchAll(PDO::FETCH_ASSOC);
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
                $pageTitle = "Add Attendance";
                $homeLink = "dashboard.php";
                $breadcrumb = "Add Attendance";
                $homeText = "Home";
                include '../includes/header.php';
            ?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                    
                        <div class="card">
                        

                        <?php
if (!empty($_SESSION['success_msg'])) {
    echo '<p id="successMessage" style="color: green;">' . htmlentities($_SESSION['success_msg']) . '</p>';
    echo '<script>document.getElementById("successMessage").style.display = "block";</script>';
    unset($_SESSION['success_msg']); // Clear the session variable
}
if (!empty($_SESSION['error_msg'])) {
    echo '<p id="errorMessage" style="color: red;">' . htmlentities($_SESSION['error_msg']) . '</p>';
    unset($_SESSION['error_msg']); // Clear the session variable
}
?>
                                
                                 <form id="attendanceForm" method="POST">
            <div class="form-group">
                <label for="startDate">Start Date:</label>
                <input type="date" class="form-control" name="startDate" required>
            </div>

            <div class="form-group">
                <label for="endDate">End Date:</label>
                <input type="date" class="form-control" name="endDate" required>
            </div>

            <div class="form-group">
                <label for="siteId">Select Site:</label>
                <select name="siteId" id="siteId" class="form-control" required>
                    <option value="">Select Site</option>
                    <?php foreach ($sites as $site) : ?>
                        <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="employeeList" class="mt-3">
                <!-- Employees and their input fields will be populated here -->
            </div>

            <button type="submit" name="submitAttendance" class="btn btn-primary mt-3">Submit Attendance</button>
<p id="successMessage" style="color: green; display: none;">Attendance records added successfully!</p>

<?php
                    if ($msg) {
                        echo '<p id="successMessage" style="color: green;">' . htmlentities($msg) . '</p>';
                        echo '<script>document.getElementById("successMessage").style.display = "block";</script>';
                    }
                    if ($error) {
                        echo '<p id="errorMessage" style="color: red;">' . htmlentities($error) . '</p>';
                    }
                    ?>

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

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
 $(document).ready(function() {
    $('#siteId').on('change', function() {
        var siteId = $(this).val();
        if (siteId) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $_SERVER['PHP_SELF']; ?>',
                data: {
                    siteId: siteId,
                },
                success: function(data) {
                    $('#employeeList').html(data);
                }
            });
        } else {
            $('#employeeList').html('');
        }
    });
});


    </script>
</body>

</html>


