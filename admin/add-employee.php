<?php
session_start();
error_reporting(E_ALL);
include('../includes/dbconn.php');

if(empty($_SESSION['usertype'])) {   
    header('location:index.php');
    exit; // Add exit to stop further execution
} else {
    if (isset($_POST['add'])) {
        // Retrieve form data
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

        // Check if the generated empid already exists
        $sqlCheckGovID = "SELECT EmpId FROM tblemployees WHERE govID = :govID";
        $queryCheckGovID = $dbh->prepare($sqlCheckGovID);
        $queryCheckGovID->bindParam(':govID', $govID, PDO::PARAM_STR);
        $queryCheckGovID->execute();
        $existingGovID = $queryCheckGovID->fetch(PDO::FETCH_ASSOC);

        if ($existingGovID) {
            $error = "Employee with aadhaar card No $govID already exists in the database";
        } else {
            // Find the next available empid if the current one already exists
            $currentYear = date('Y');
            $currentMonth = date('m');
            $empid = $currentYear . $currentMonth . '001'; // Initialize with the first ID of the month

            // Check if the generated empid already exists
            $sqlCheckEmpId = "SELECT EmpId FROM tblemployees WHERE EmpId = :empid";
            $queryCheckEmpId = $dbh->prepare($sqlCheckEmpId);
            $queryCheckEmpId->bindParam(':empid', $empid, PDO::PARAM_STR);
            $queryCheckEmpId->execute();
            $existingEmpId = $queryCheckEmpId->fetch(PDO::FETCH_ASSOC);

            // Find the next available empid if the current one already exists
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
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                $msg = "Record has been added Successfully with Employee ID: $empid";
            } else {
                $error = "ERROR";
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
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- Custom form script -->
    <!-- <script type="text/javascript">
        function valid(){
            if(document.addemp.password.value!= document.addemp.confirmpassword.value) {
            alert("New Password and Confirm Password Field do not match  !!");
            document.addemp.confirmpassword.focus();
            return false;
                } return true;
        }
    </script> -->

    <script>
        function checkAvailabilityEmpid() {
            $("#loaderIcon").show();
            jQuery.ajax({
            url: "check_availability.php",
            data:'empcode='+$("#empcode").val(),
            type: "POST",
            success:function(data){
            $("#empid-availability").html(data);
            $("#loaderIcon").hide();
            },
            error:function (){}
            });
        }
    </script>

    <!-- <script>
        function checkAvailabilityEmailid() {
            $("#loaderIcon").show();
            jQuery.ajax({
            url: "check_availability.php",
            data:'emailid='+$("#email").val(),
            type: "POST",
            success:function(data){
            $("#emailid-availability").html(data);
            $("#loaderIcon").hide();
            },
            error:function (){}
            });
        }
    </script> -->
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
                            <h4 class="page-title pull-left">Add Employee Section</h4>
                            <ul class="breadcrumbs pull-left"> 
                                <li><a href="employees.php">Employee</a></li>
                                <li><span>Add</span></li>
                                
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
                <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <!-- Input form start -->
                            <div class="col-12 mt-5">
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
                                        <p class="text-muted font-14 mb-4">Please fill up the form in order to add employee records</p>

                                        <!-- <div class="form-group">
    <label for="empcode" class="col-form-label">Employee ID</label>
    <input class="form-control" name="empcode" type="text" readonly id="empcode" value="<?php echo $empid; ?>">
</div> -->

                                    

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">First Name</label>
                                            <input class="form-control" name="firstName"  type="text" required id="example-text-input">
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Last Name</label>
                                            <input class="form-control" name="lastName" type="text" autocomplete="off" required id="example-text-input">
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Aadhaar Number</label>
                                            <input class="form-control" name="govID" type="text" autocomplete="off" required id="example-text-input">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Designation</label>
                                            <select class="custom-select" name="designation" autocomplete="off">
                                                <option value="">Choose..</option>
                                                <?php $sql = "SELECT * from tbldesignation";
                                                $query = $dbh -> prepare($sql);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query->rowCount() > 0){
                                                foreach($results as $result)
                                                {   ?> 
                                                <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->name);?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <!-- Supplier Select -->
<div class="form-group">
    <label class="col-form-label">Supplier</label>
    <select class="custom-select" name="supplier" id="supplier" autocomplete="off">
        <option value="">Choose..</option>
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

<!-- Group Select (Dynamically Loaded) -->
<div class="form-group">
    <label class="col-form-label">Group</label>
    <select class="custom-select" name="group" id="group" autocomplete="off">
        <option value="">Choose..</option>
    </select>
</div>

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


                                        <div class="form-group">
                                            <label class="col-form-label">Preferred Site</label>
                                            <select class="custom-select" name="site" autocomplete="off">
                                                <option value="">Choose..</option>
                                                <?php $sql = "SELECT * from tblsite";
                                                $query = $dbh -> prepare($sql);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query->rowCount() > 0){
                                                foreach($results as $result)
                                                {   ?> 
                                                <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->name);?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Gender</label>
                                            <select class="custom-select" name="gender" autocomplete="off">
                                                <option value="">Choose..</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">D.O.B</label>
                                            <input class="form-control" type="date" name="dob" id="birthdate" >
                                        </div>

                                       
                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">D.O.j</label>
                                            <input class="form-control" type="date" name="doj" id="doj" >
                                        </div>
                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">Rate</label>
                                            <input class="form-control" type="text" name="rate" id="doj" >
                                        </div>


                                        <!-- <h4>Set Password for Employee Login</h4>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Password</label>
                                            <input class="form-control" name="password" type="password" autocomplete="off" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Confirmation Password</label>
                                            <input class="form-control" name="confirmpassword" type="password" autocomplete="off" required>
                                        </div> -->

                        

                                        <button class="btn btn-primary" name="add" id="update" type="submit" onclick="return valid();">PROCEED</button>
                                        
                                    </div>
                                </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Input Form Ending point -->
                    
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
    
    <!-- others plugins -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>

