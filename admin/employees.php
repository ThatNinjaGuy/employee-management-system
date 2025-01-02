<?php
    session_start();
    // error_reporting(E_ALL);
    error_reporting(0);
    include('../includes/dbconn.php');

    // Redirect to login if usertype session is empty
    if(empty($_SESSION['usertype'])) {   
        header('location:index.php');
        exit;
    } else {

    // Handle AJAX request to update employee status
    if (isset($_POST['empid']) && isset($_POST['status'])) {
        $id = intval($_POST['empid']);
        $status = intval($_POST['status']);
        $sql = "UPDATE tblemployees SET Status=:status WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->execute();
        echo json_encode(['success' => true]);
        exit;
    }
 ?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- Meta tags and CSS links -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Panel - Employee Leave</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Stylesheets -->
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        /* Custom switch styling */
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 45px;
            height: 20px;
        }
        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: red;
            transition: .4s;
            border-radius: 20px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: green;
        }
        input:checked + .slider:before {
            transform: translateX(25px);
        }

        .table th:first-child,
        .table th:nth-child(2),
        .table td:first-child,
        .table td:nth-child(2) {
            text-align: left;
        }

        /* Add border to the table */
        #employeeTable {
            border-collapse: collapse;
            width: 100%;
        }
        #employeeTable th, #employeeTable td {
            border: 1px solid #ddd; /* Adds a border to table cells */
            padding: 8px; /* Adds padding for better readability */
        }

        /* #employeeTable th {
            background-color: #f2f2f2;
            text-align: center;
        } */

        /* Change cursor to pointer for clickable columns */
        .clickable-row td:not(:last-child) {
            cursor: pointer;
        }
    </style>
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
                            <h4 class="page-title pull-left">Employees</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="dashboard.php">Home</a></li>
                                <li><span>Employee Management</span></li>
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
                    <div class="col-12 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="data-tables">
                                    <div class="text-center mb-3">
                                        <!-- Action buttons -->
                                        <a href="add-employee.php" class="btn btn-sm btn-info mr-2">Add New Employee</a>
                                        <a href="generate_pdf.php" class="btn btn-sm btn-primary mr-2">Download PDF</a>
                                        <a href="generate_xls.php" class="btn btn-sm btn-success">Download XLS</a>
                                    </div>
                                    <!-- Employee table -->
                                    <table id="employeeTable" class="table table-hover table-striped text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>Name</th>
                                                <th>Site</th>
                                                <th>Joined On</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            // Fetch employee data
                                            $sql = "SELECT e.EmpId, e.FirstName, e.LastName, s.name AS SiteName, e.Status, e.id, e.doj 
                                                    FROM tblemployees e
                                                    LEFT JOIN tblsite s ON e.Site = s.id
                                                    ORDER BY e.doj DESC";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                                    ?>
                                                    <tr class="clickable-row" data-href="update-employee.php?empid=<?php echo htmlentities($result->id); ?>">
                                                        <td><?php echo htmlentities($result->FirstName); ?>&nbsp;<?php echo htmlentities($result->LastName); ?></td>
                                                        <td><?php echo htmlentities($result->SiteName); ?></td>
                                                        <td><?php echo htmlentities($result->doj); ?></td>
                                                        <td>
                                                            <!-- Status switch -->
                                                            <label class="custom-switch">
                                                                <input type="checkbox" class="status-switch" data-id="<?php echo $result->id; ?>" <?php echo $result->Status ? 'checked' : ''; ?>>
                                                                <span class="slider"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script>
    $(document).ready(function() {
        // Initialize DataTables with custom sorting for the Status column
        $('#employeeTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "order": [[2, "desc"], [3, "desc"]], // Primary order by Joined On, secondary by Status
            "columnDefs": [
                {
                    "targets": 3, // Index of the Status column
                    "orderDataType": "dom-checkbox"
                }
            ]
        });

        // Custom sorting for checkbox columns
        $.fn.dataTable.ext.order['dom-checkbox'] = function(settings, col) {
            return this.api().column(col, {order:'index'}).nodes().map(function(td, i) {
                return $('input', td).prop('checked') ? 1 : 0;
            });
        };

        // Use event delegation to handle click events on dynamically generated rows
        $('#employeeTable tbody').on('click', 'tr.clickable-row', function() {
            window.location = $(this).data('href');
        });

        // Prevent event propagation on status switch click
        $('.status-switch').click(function(event) {
            event.stopPropagation();
        });

        // Handle status switch change event
        $('.status-switch').change(function() {
            var empId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            // AJAX request to update employee status
            $.ajax({
                url: 'employees.php',
                type: 'POST',
                data: { empid: empId, status: status },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert('Employee status updated successfully');
                    } else {
                        alert('Failed to update employee status');
                    }
                }
            });
        });
    });
    </script>
</body>

</html>

<?php } ?>