<?php
session_start();
// Enable error reporting for debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
error_reporting(0);

include('../includes/dbconn.php');

// Check if the user is logged in and has a user type
if(empty($_SESSION['usertype'])) {   
    header('location:index.php');
    exit;
} else {
    if (isset($_POST['add'])) {
        // Retrieve form data from the POST request
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $govID = $_POST['govID'];
        $designation = $_POST['designation'];
        $site = $_POST['site'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $doj = $_POST['doj'];
        $rate = $_POST['rate'];
        $supplier = $_POST['supplier'];
        $group = $_POST['group'];

        $status = 1;

        // Check if the Aadhaar number (govID) already exists
        $sqlCheckGovID = "SELECT EmpId FROM tblemployees WHERE govID = :govID";
        $queryCheckGovID = $dbh->prepare($sqlCheckGovID);
        $queryCheckGovID->bindParam(':govID', $govID, PDO::PARAM_STR);
        $queryCheckGovID->execute();
        $existingGovID = $queryCheckGovID->fetch(PDO::FETCH_ASSOC);

        if ($existingGovID) {
            // Set error if Aadhaar number exists
            $error = "Employee with aadhaar card No $govID already exists in the database";
        } else {
            // Generate a new employee ID
            $currentYear = date('Y');
            $currentMonth = date('m');
            $empid = $currentYear . $currentMonth . '001';

            // Check if the generated empid already exists
            $sqlCheckEmpId = "SELECT EmpId FROM tblemployees WHERE EmpId = :empid";
            $queryCheckEmpId = $dbh->prepare($sqlCheckEmpId);
            $queryCheckEmpId->bindParam(':empid', $empid, PDO::PARAM_STR);
            $queryCheckEmpId->execute();
            $existingEmpId = $queryCheckEmpId->fetch(PDO::FETCH_ASSOC);

            // Increment empid until a unique one is found
            while ($existingEmpId) {
                $numericPart = intval(substr($empid, -3)) + 1;
                $empid = $currentYear . $currentMonth . sprintf('%03d', $numericPart);
                $queryCheckEmpId->bindParam(':empid', $empid, PDO::PARAM_STR);
                $queryCheckEmpId->execute();
                $existingEmpId = $queryCheckEmpId->fetch(PDO::FETCH_ASSOC);
            }

            // Insert New Employee with Generated Employee ID
            $sql = "INSERT INTO tblemployees(EmpId, FirstName, LastName, Gender, Dob, Site, doj, govID, rate, designation, supplier_id, group_id, Status) 
            VALUES(:empid, :fname, :lname, :gender, :dob, :site, :doj, :govID, :rate, :designation, :supplier, :group, :status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':empid', $empid, PDO::PARAM_STR);
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->bindParam(':lname', $lname, PDO::PARAM_STR);
            $query->bindParam(':gender', $gender, PDO::PARAM_STR);
            $query->bindParam(':dob', $dob, PDO::PARAM_STR);
            $query->bindParam(':site', $site, PDO::PARAM_STR);
            $query->bindParam(':doj', $doj, PDO::PARAM_STR);
            $query->bindParam(':govID', $govID, PDO::PARAM_STR);
            $query->bindParam(':rate', $rate, PDO::PARAM_STR);
            $query->bindParam(':designation', $designation, PDO::PARAM_STR);
            $query->bindParam(':supplier', $supplier, PDO::PARAM_INT);
            $query->bindParam(':group', $group, PDO::PARAM_INT);
            $query->bindParam(':status', $status, PDO::PARAM_STR);

            // Execute the query and check for errors
            if ($query->execute()) {
                $lastInsertId = $dbh->lastInsertId();
                if ($lastInsertId) {
                    // Redirect to employees page if successful
                    header('Location: employees.php');
                    exit;
                } else {
                    // Alert if something went wrong
                    echo "<script>alert('ERROR: Something went wrong. Please try again.');</script>";
                }
            } else {
                // Alert if something went wrong
                echo "<script>alert('ERROR: Something went wrong. Please try again.');</script>";
            }
        }
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Add Employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script>
        function checkAvailabilityEmpid() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'empcode=' + $("#empcode").val(),
                type: "POST",
                success: function(data) {
                    $("#empid-availability").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>
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
                            <h4 class="page-title pull-left">Add Employee</h4>
                            <ul class="breadcrumbs pull-left"> 
                                <li><a href="employees.php">Employee</a></li>
                                <li><span>Add Employee</span></li>
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
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-2">
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
                                <div class="card">
                                    <form name="addemp" method="POST">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="example-text-input" class="col-form-label">First Name <span style="color: red;">*</span></label>
                                                    <input class="form-control" name="firstName" type="text" required id="example-text-input">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="example-text-input" class="col-form-label">Last Name <span style="color: red;">*</span></label>
                                                    <input class="form-control" name="lastName" type="text" autocomplete="off" required id="example-text-input">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="example-text-input" class="col-form-label">Aadhaar Number <span style="color: red;">*</span></label>
                                                    <input class="form-control" name="govID" type="text" autocomplete="off" required id="example-text-input">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Designation <span style="color: red;">*</span></label>
                                                    <select class="custom-select" name="designation" required autocomplete="off">
                                                        <option value="" disabled selected>Choose..</option>
                                                        <?php $sql = "SELECT * from tbldesignation";
                                                        $query = $dbh -> prepare($sql);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if($query->rowCount() > 0){
                                                        foreach($results as $result)
                                                        {   ?> 
                                                        <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->name);?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Supplier <span style="color: red;">*</span></label>
                                                    <select class="custom-select" name="supplier" id="supplier" required autocomplete="off">
                                                        <option value="" disabled selected>Choose..</option>
                                                        <?php
                                                        $sql = "SELECT * FROM tblsupplier";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {
                                                                ?>
                                                                <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->name); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Group<span style="color: red;">*</span></label>
                                                    <select class="custom-select" name="group" id="group" required autocomplete="off">
                                                        <option value="" disabled selected>Choose..</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Gender</label>
                                                    <select class="custom-select" name="gender" autocomplete="off">
                                                        <option value="" disabled selected>Choose..</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Preferred Site <span style="color: red;">*</span></label>
                                                    <select class="custom-select" name="site" required autocomplete="off">
                                                        <option value="" disabled selected>Choose..</option>
                                                        <?php $sql = "SELECT * from tblsite";
                                                        $query = $dbh -> prepare($sql);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if($query->rowCount() > 0){
                                                        foreach($results as $result)
                                                        {   ?> 
                                                        <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->name);?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="example-date-input" class="col-form-label">D.O.B</label>
                                                    <input class="form-control" type="date" name="dob" id="birthdate">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="example-date-input" class="col-form-label">Rate (₹ /day)</label>
                                                    <input class="form-control" type="text" name="rate" id="rate">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="example-date-input" class="col-form-label">D.O.J</label>
                                                    <input class="form-control" type="date" name="doj" id="doj" value="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>

                                            <!-- Sticky submit buttons -->
                                            <div class="sticky-submit" style="display: flex;">
                                                <button class="btn btn-secondary" type="button" onclick="window.history.back();" style="flex: 1; margin-right: 5px;">Cancel</button>
                                                <button class="btn btn-primary" name="add" id="update" type="submit" style="flex: 1; margin-left: 5px;">Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script>
        // Add onchange event to supplier select
        document.getElementById('supplier').addEventListener('change', function () {
            var supplierId = this.value;
            // Use AJAX to fetch groups based on the selected supplier
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_groups.php?supplier_id=' + supplierId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update the groups select with the fetched options
                    document.getElementById('group').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });
    </script>
</body>

</html>

