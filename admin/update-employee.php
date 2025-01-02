<?php
session_start();
// Suppress error reporting
error_reporting(0);
include('../includes/dbconn.php');

// Redirect to login if usertype session is empty
if(empty($_SESSION['usertype'])) {   
    header('location:index.php');
    exit;
} else {
    // Get employee ID from URL
    $eid = intval($_GET['empid']);

    // Check if the update form is submitted
    if (isset($_POST['update'])) {
        // Retrieve form data
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $site = $_POST['site'];
        $doj = $_POST['doj'];
        $rate = $_POST['rate'];
        $status = $_POST['status'];

        try {
            // Prepare SQL query to update employee details
            $sql = "UPDATE tblemployees SET FirstName=:fname, LastName=:lname, Gender=:gender, dob=:dob, Site=:site, doj=:doj, rate=:rate, Status=:status WHERE id=:eid";
            $query = $dbh->prepare($sql);
            // Bind parameters to the query
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->bindParam(':lname', $lname, PDO::PARAM_STR);
            $query->bindParam(':gender', $gender, PDO::PARAM_STR);
            $query->bindParam(':dob', $dob, PDO::PARAM_STR);
            $query->bindParam(':site', $site, PDO::PARAM_STR);
            $query->bindParam(':doj', $doj, PDO::PARAM_STR);
            $query->bindParam(':rate', $rate, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_INT);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);

            // Execute the query and check if successful
            if ($query->execute()) {
                header('Location: employees.php');
                exit;
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        } catch(PDOException $e) {
            echo "<script>alert('Database error');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and CSS links -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Update Employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
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
    </style>
</head>
</html>

<?php } ?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- Meta tags and CSS links -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Employee Leave</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    
    <div class="page-container">
        <!-- Sidebar -->
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
        
        <div class="main-content">
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Update employee details</h4>
                            <ul class="breadcrumbs pull-left"> 
                                <li><a href="employees.php">Employee</a></li>
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
            
            <!-- Main content area -->
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <!-- Display error or success messages -->
                                <?php if($error){?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>Info: </strong><?php echo htmlentities($error); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php } else if($msg){?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>Info: </strong><?php echo htmlentities($msg); ?> 
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php }?>
                                <div class="card">
                                    <!-- Form to update employee details -->
                                    <form name="addemp" method="POST">
                                        <div class="card-body">
                                            <?php 
                                                // Fetch employee details
                                                $eid = intval($_GET['empid']);
                                                $sql = "SELECT * from tblemployees where id=:eid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) { 
                                            ?> 
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <small class="text-muted">Employee ID: <?php echo htmlentities($result->EmpId); ?></small>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="example-text-input" class="col-form-label">First Name <span style="color: red;">*</span></label>
                                                    <input class="form-control" name="firstName" value="<?php echo htmlentities($result->FirstName); ?>" type="text" required id="example-text-input">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="example-text-input" class="col-form-label">Last Name <span style="color: red;">*</span></label>
                                                    <input class="form-control" name="lastName" value="<?php echo htmlentities($result->LastName); ?>" type="text" autocomplete="off" required id="example-text-input">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="example-date-input" class="col-form-label">D.O.B</label>
                                                    <input class="form-control" type="date" name="dob" id="birthdate" value="<?php echo htmlentities($result->Dob); ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="example-date-input" class="col-form-label">Rate</label>
                                                    <input class="form-control" type="text" name="rate" id="rate" value="<?php echo htmlentities($result->rate); ?>">
                                                </div>
                                            </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="example-date-input" class="col-form-label">D.O.J</label>
                                                <input class="form-control" type="date" name="doj" id="doj" value="<?php echo htmlentities($result->doj); ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Assigned Site</label>
                                                <select class="custom-select" name="site" autocomplete="off">
                                                    <?php
                                                    $sql = "SELECT * FROM tblsite";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $sites = $query->fetchAll(PDO::FETCH_OBJ);

                                                        foreach ($sites as $site) { ?>
                                                            <option value="<?php echo htmlentities($site->id); ?>" <?php if ($site->id == $result->Site) echo 'selected'; ?>>
                                                                <?php echo htmlentities($site->name); ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Gender</label>
                                                    <select class="custom-select" name="gender" autocomplete="off">
                                                        <option value="Male" <?php if($result->Gender == 'Male') echo 'selected'; ?>>Male</option>
                                                        <option value="Female" <?php if($result->Gender == 'Female') echo 'selected'; ?>>Female</option>
                                                        <option value="Other" <?php if($result->Gender == 'Other') echo 'selected'; ?>>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Status</label>
                                                    <select class="custom-select" name="status" autocomplete="off">
                                                        <option value="1" <?php if ($result->Status == 1) echo 'selected'; ?>>Active</option>
                                                        <option value="0" <?php if ($result->Status == 0) echo 'selected'; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php }
                                                } ?>
                                        </div>
                                        <!-- Sticky submit buttons -->
                                        <div class="sticky-submit" style="display: flex;">
                                            <button class="btn btn-secondary" type="button" onclick="window.history.back();" style="flex: 1; margin-right: 5px;">Cancel</button>
                                            <button class="btn btn-primary" name="update" id="update" type="submit" style="flex: 1; margin-left: 5px;">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../includes/footer.php' ?>
        </div>
    </div>
    <!-- JavaScript files -->
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>

    <!-- Chart and plugin scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <script src="assets/js/line-chart.js"></script>
    <script src="assets/js/pie-chart.js"></script>
    
    <!-- Additional plugins -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>


