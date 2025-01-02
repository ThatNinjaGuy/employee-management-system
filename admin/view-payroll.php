<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');

if(empty($_SESSION['usertype'])) {   
    header('location:index.php');
    exit; // Add exit to stop further execution
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM payroll WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        $payrollDetails = $query->fetch(PDO::FETCH_ASSOC);
    }
}



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
                $pageTitle = "Payroll Section";
                $homeLink = "dashboard.php";
                $breadcrumb = "Payroll Management";
                $homeText = "Home";
                include '../includes/header.php';
            ?>
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-5">
<a href="" class="btn btn-sm btn-info" data-toggle="modal" data-target="#siteModal">Create New</a>

<!-- Modal for Site and Employee selection -->
<div class="modal fade" id="siteModal" tabindex="-1" role="dialog" aria-labelledby="siteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Use modal-lg or modal-xl here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="siteModalLabel">Select Site and Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           
            <div class="modal-body">
     
    
    <?php
// Assuming you have a database connection established in $dbh

// Fetch payroll IDs from the database
$sql = "SELECT id FROM payroll";
$query = $dbh->prepare($sql);
$query->execute();
$payrollIds = $query->fetchAll(PDO::FETCH_COLUMN);

// Assuming you have a variable $selectedPayrollId containing the desired selected payroll ID
$selectedPayrollId = htmlentities($payrollDetails['id']); // Replace with the actual selected payroll ID

?>

<div class="form-group">
    
       
        <input type="hidden" id="payrollID" name="payrollID" value="<?php echo htmlentities($payrollDetails['id']); ?>">
    </div>
    <div class="form-group">
      
        
        <?php
                // Calculate and display the payroll month
                $startDate = new DateTime($payrollDetails['start_date']);
                $endDate = new DateTime($payrollDetails['end_date']);
                
                $payrollMonth = $startDate->format('F Y');
                if ($startDate->format('Y-m') !== $endDate->format('Y-m')) {
                    // If start_date and end_date are in different months, display both months
                    $payrollMonth .= ' - ' . $endDate->format('F Y');
                }

                echo '<p><strong>Payroll Month:</strong> ' . htmlentities($payrollMonth) . '</p>';
                ?>


    </div>

    <div class="form-group">
        <label for="siteSelect">Select Site:</label>
        <select class="form-control" id="siteSelect" name="siteSelect">
            <!-- Options will be dynamically populated -->
        </select>
    </div>
    <div class="form-group">
        <label for="employeeSelect">Select Employee:</label>
        <select class="form-control" id="employeeSelect" name="employeeSelect">
            <!-- Options will be dynamically populated based on site selection -->
        </select>
    </div>
    <!-- <div id="overTime" name="overTime"></div> -->
 
    <div id="rateDisplay" name="rateDisplay"></div>
    <div id="overTimeAmount" name="overTimeAmount"></div>
    <!-- <div id="daysWorkedDisplay" name="daysWorkedDisplay"></div> -->
    <div id="totalAmountDisplay" name="totalAmountDisplay"></div>
    <div id="net_pay" name="net_pay"></div>
    
    <div class="form-group">
    <label for="daysWorked">Days Worked:</label>
    <input type="text" class="form-control" name="daysWorked" id="daysWorked">
</div>

<div class="form-group">
    <label for="overTime">Overtime (in hours):</label>
    <input type="text" class="form-control" name="overTime" id="overTime">
</div>


    <div class="form-group">
        <label for="advance">Advance in Site:</label>
        <input type="text" class="form-control" name="advance_in_site" id="advance_in_site">
    </div>
    <div class="form-group">
        <label for="advancehome">Advance in Home:</label>
        <input type="text" class="form-control" name="advance_in_home" id="advance_in_home">
    </div>
    <div class="form-group">
        <label for="mess">Mess:</label>
        <input type="text" class="form-control" name="mess" id="mess">
    </div>
    <div class="form-group">
        <label for="sundayExpenditure">Sunday Expenditure:</label>
        <input type="text" class="form-control" name="sunday_expenditure" id="sunday_expenditure">
    </div>
    <div class="form-group">
    <label>Final Payment?</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="finalPayment" id="yesRadio" value="yes">
        <label class="form-check-label" for="yesRadio">Yes</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="finalPayment" id="noRadio" value="no">
        <label class="form-check-label" for="noRadio">No</label>
    </div>
    
</div>

<div class="form-group" id="finalPaymentInput" style="display: none;">
    <label for="final">Penalty Amount</label>
    <input type="text" class="form-control" name="penalty" id="penalty">
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="saveButton" >Save</button>
</div>

        </div>
    </div>
</div>




    <?php
if (isset($payrollDetails) && $payrollDetails) {
?>
   <div class="card">
    <div class="card-body">
        <h5 class="card-title">Payroll Information</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Id:</strong> <?php echo htmlentities($payrollDetails['id']); ?></p>
                <p><strong>Code:</strong> <?php echo htmlentities($payrollDetails['code']); ?></p>
                <p><strong>Start Date:</strong> <?php echo htmlentities($payrollDetails['start_date']); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>End Date:</strong> <?php echo htmlentities($payrollDetails['end_date']); ?></p>
                <p><strong>Created Date:</strong> <?php echo htmlentities($payrollDetails['created_at']); ?></p>
                
                <?php
                // Calculate and display the payroll month
                $startDate = new DateTime($payrollDetails['start_date']);
                $endDate = new DateTime($payrollDetails['end_date']);
                
                $payrollMonth = $startDate->format('F Y');
                if ($startDate->format('Y-m') !== $endDate->format('Y-m')) {
                    // If start_date and end_date are in different months, display both months
                    $payrollMonth .= ' - ' . $endDate->format('F Y');
                }

                echo '<p><strong>Payroll Month:</strong> ' . htmlentities($payrollMonth) . '</p>';
                ?>
            </div>
        </div>
    </div>
</div>

<?php } else { ?>
    <div class="card">
        <div class="card-body">
            <p>No payroll details found for the provided ID.</p>
        </div>
    </div>
<?php } ?>



                    <div class="col-12 mt-5">
                    <div class="row">
    <div class="col-md-6">
        <!-- Content on the left side -->
    </div>
    <div class="col-md-6 text-right">
    <a href="pay_gen.php?selectedPayrollId=<?php echo $selectedPayrollId; ?>" class="btn btn-primary">Download Payslip Data</a>

    </div>
</div>
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
                                
                                    <table id="dataTable3" class="table table-hover table-striped text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                
                                                <th>Employee Name</th>
                                                <th>Net Pay</th>
                                             
                                                <th>Created Date</th>
                                                
                                                <th>Actions</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
// Assuming you have a database connection established in $dbh

// Fetch payroll IDs from the database
$sql = "SELECT id FROM payroll";
$query = $dbh->prepare($sql);
$query->execute();
$payrollIds = $query->fetchAll(PDO::FETCH_COLUMN);

// Assuming you have a variable $selectedPayrollId containing the desired selected payroll ID
$selectedPayrollId = htmlentities($payrollDetails['id']); // Replace with the actual selected payroll ID

?>
                                      <?php
$selectedPayrollId = htmlentities($payrollDetails['id']); // Get the selected payroll ID from your code


// Define the SQL query for viewing payroll details
    $viewSql = "SELECT payslip.*, tblemployees.FirstName, tblemployees.LastName, tblemployees.id AS employee_id
                FROM payslip
                LEFT JOIN tblemployees ON payslip.employeeSelect = tblemployees.id
                LEFT JOIN payroll ON payslip.payrollID = payroll.id
                WHERE payroll.id = :selectedPayrollId";

// Prepare and execute the SQL query
$query = $dbh->prepare($viewSql);
$query->bindParam(':selectedPayrollId', $selectedPayrollId);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;

// Loop through the results to display the data
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
?>
        <tr>
            <td><?php echo htmlentities($cnt); ?></td>
            <td><?php echo htmlentities($result->FirstName. ' ' . $result->LastName); ?></td> <!-- Display the employee name -->
            <td><?php echo sprintf("%.2f", $result->net_pay); ?></td>
            <td><?php echo htmlentities($result->CreationDate); ?></td>
            <td>
                <!-- Delete button -->
                <a href="delete-payroll.php?del=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you want to delete?');" style="text-decoration: none; margin-right: 10px;">
                    <i class="fa fa-trash" style="color: red;"></i> 
                    <span style="color: red; font-weight: bold;">Delete</span>
                </a>
                <!-- View button -->
                <a href="view-payslip.php?payid=<?php echo htmlentities($result->id); ?>" style="text-decoration: none; margin-right: 10px;">
                    <i class="fa fa-edit" style="color: blue;"></i> 
                    <span style="color: blue; font-weight: bold;">View</span>
                </a>
                <!-- Edit button -->
                <a href="edit-payroll.php?payid=<?php echo htmlentities($result->id); ?>&edit=true" style="text-decoration: none; margin-right: 10px;">
                    <i class="fa fa-edit" style="color: green;"></i> 
                    <span style="color: green; font-weight: bold;">Edit</span>
                </a>
            </td>
        </tr>
<?php
        $cnt++;
    }
}
?>




                                    </tbody>
                                    </table>
                                    <!-- Modal Structure -->

                                    <div class="modal fade" id="employeeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="employeeDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="employeeDetailsModalLabel">Employee Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="employeeDetailsContent">Loading employee details...</p>
      </div>
    </div>
  </div>
</div>
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
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    var siteSelect = $('#siteSelect');
    var employeeSelect = $('#employeeSelect');
    var payrollID = $('#payrollID');
    // Add default "Select Site" and "Select Employee" options
    siteSelect.append('<option value="">Select Site</option>');
    employeeSelect.append('<option value="">Select Employee</option>');

    // Fetch sites and populate the dropdown
    $.ajax({
        method: 'GET',
        url: 'your_php_script.php',
        data: { fetch_sites: true },
        dataType: 'json',
        success: function (data) {
            siteSelect.empty();
            employeeSelect.empty();

            siteSelect.append('<option value="">Select Site</option>');
            employeeSelect.append('<option value="">Select Employee</option>');

            $.each(data.sites, function (index, site) {
                siteSelect.append('<option value="' + site.id + '">' + site.name + '</option>');
            });

            siteSelect.change(function () {
                var selectedSite = $(this).val();
                if (selectedSite) {
                    $.ajax({
                        method: 'GET',
                        url: 'your_php_script.php',
                        data: { fetch_employees: true, site_id: selectedSite },
                        dataType: 'json',
                        success: function (data) {
                            employeeSelect.empty();
                            employeeSelect.append('<option value="">Select Employee</option>');
                            $.each(data.employees, function (index, employee) {
                                employeeSelect.append('<option value="' + employee.id + '">' + employee.FirstName + ' ' + employee.LastName + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching employees: " + error);
                        }
                    });
                } else {
                    employeeSelect.empty();
                    employeeSelect.append('<option value="">Select Employee</option>');
                }
            });

            $(document).ready(function() {
    // Initialize Select2 for site select
    $('#siteSelect').select2({
        placeholder: 'Select Site',
        allowClear: true // Option to clear selection
    });

    // Initialize Select2 for employee select
    $('#employeeSelect').select2({
        placeholder: 'Select Employee',
        allowClear: true // Option to clear selection
    });

    // Fetch sites and populate site select dropdown
    $.ajax({
        method: 'GET',
        url: 'your_php_script.php',
        data: { fetch_sites: true },
        dataType: 'json',
        success: function(data) {
            $('#siteSelect').empty();
            $('#employeeSelect').empty();
            $('#siteSelect').append('<option value="">Select Site</option>');

            $.each(data.sites, function(index, site) {
                $('#siteSelect').append('<option value="' + site.id + '">' + site.name + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching sites: " + error);
        }
    });

    // Event listener for site select change
    $('#siteSelect').change(function() {
        var selectedSite = $(this).val();

        if (selectedSite) {
            // Fetch employees for the selected site and populate employee select dropdown
            $.ajax({
                method: 'GET',
                url: 'your_php_script.php',
                data: { fetch_employees: true, site_id: selectedSite },
                dataType: 'json',
                success: function(data) {
                    $('#employeeSelect').empty();
                    $('#employeeSelect').append('<option value="">Select Employee</option>');

                    $.each(data.employees, function(index, employee) {
                        $('#employeeSelect').append('<option value="' + employee.id + '">' + employee.FirstName + ' ' + employee.LastName + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching employees: " + error);
                }
            });
        } else {
            // Clear employee select if no site selected
            $('#employeeSelect').empty();
            $('#employeeSelect').append('<option value="">Select Employee</option>');
        }
    });
});


            

            employeeSelect.change(function () {
    var selectedEmployee = $(this).val();
    if (selectedEmployee) {
        $.ajax({
            method: 'GET',
            url: 'your_php_script.php',
            data: { fetch_rate: true, employee_id: selectedEmployee },
            dataType: 'json',
            success: function (data) {
                if (data && data.rate) {
                    $('#rateDisplay').text('Rate: ' + data.rate);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching rate: " + error);
            }
        });

        // Fetch and display days worked
        $.ajax({
            method: 'GET',
            url: 'your_php_script.php',
            data: { fetch_days_worked: true, employee_id: selectedEmployee },
            dataType: 'json',
            success: function (data) {
                if (data && data.length > 0) {
                    var totalDaysWorked = data.reduce((acc, item) => acc + parseInt(item.daysWorked), 0);
                    $('#daysWorkedDisplay').text('Total Days Worked: ' + totalDaysWorked);

                    //Fetch and display rate again
                    // $.ajax({
                    //     method: 'GET',
                    //     url: 'your_php_script.php',
                    //     data: { fetch_rate: true, employee_id: selectedEmployee },
                    //     dataType: 'json',
                    //     success: function (rateData) {
                    //         if (rateData && rateData.rate) {
                    //             var totalAmount = totalDaysWorked * rateData.rate;
                    //             $('#totalAmountDisplay').text('Total Amount: ' + totalAmount);
                    //             $('#net_pay').text('Net Amount: ' + totalAmount);
                    //         }
                    //     },
                    //     error: function (xhr, status, error) {
                    //         console.error("Error fetching rate: " + error);
                    //     }
                    // });

                   // Fetch and display overtime
                    $.ajax({
                    method: 'GET',
                    url: 'your_php_script.php',
                    data: { fetch_rate: true, employee_id: selectedEmployee },
                    dataType: 'json',
                    success: function (rateData) {
                        if (rateData && rateData.rate) {
                            var totalAmount = totalDaysWorked * rateData.rate;

                    // Fetch overtime data
            //         $.ajax({
            //             method: 'GET',
            //             url: 'your_php_script.php',
            //             data: { fetch_overtime: true, employee_id: selectedEmployee },
            //             dataType: 'json',
            //             success: function (overtimeData) {
            //                 if (overtimeData && overtimeData.length > 0) {
            //                     var totalOvertime = overtimeData.reduce(function (acc, item) {
            //                         var overtimeValue = parseInt(item.overTime) || 0;
            //                         return acc + overtimeValue;
            //             }, 0);
            //             $('#overTime').text('Total Overtime: ' + totalOvertime + " Hours");
            //             // Calculate and display overTimeAmount
            //             var overTimeAmount = (totalOvertime * rateData.rate / 12).toFixed(2);
            //             $('#overTimeAmount').text('Overtime Amount: ' + overTimeAmount);

            //             // Display totalAmount and netAmount
            //             $('#totalAmountDisplay').text('Total Amount: ' + totalAmount);
            //             $('#net_pay').text('Net Amount: ' + totalAmount );
            //         }
            //     },
            //     error: function (xhr, status, error) {
            //         console.error("Error fetching overtime data: " + error);
            //     }
            // });
        }
    },
    error: function (xhr, status, error) {
        console.error("Error fetching rate: " + error);
    }
});


                } else {
                    $('#daysWorked').text('No data found');
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching days worked: " + error);
            }
        });
    }
});

        },
        error: function(xhr, status, error) {
            console.error("Error fetching sites: " + error);
        }
    });


    $('#daysWorked').on('input', function () {
    var rate = parseFloat($('#rateDisplay').text().split(': ')[1]);
    var daysWorked = parseFloat($(this).val()) || 0;
    var totalAmount = rate * daysWorked;
    $('#totalAmountDisplay').text('Total Amount: ' + totalAmount.toFixed(2));
});

// Update overtime amount when overtime is changed
$('#overTime').on('input', function () {
    var rate = parseFloat($('#rateDisplay').text().split(': ')[1]);
    var overTime = parseFloat($(this).val()) || 0;
    var overtimeAmount = overTime * rate / 12;
    $('#overTimeAmount').text('Overtime Amount: ' + overtimeAmount.toFixed(2));

    // Trigger input event on daysWorked to update totalAmountDisplay
    $('#daysWorked').trigger('input');
});

$('#advance_in_site,#advance_in_home,#daysWorked, #overTime, #mess, #sunday_expenditure').on('input', function () {
    var advanceInSiteValue = parseFloat($('#advance_in_site').val()) || 0;
    var advanceInHomeValue = parseFloat($('#advance_in_home').val()) || 0;
    var messValue = parseFloat($('#mess').val()) || 0;
    var daysWorkedValue = parseFloat($('#daysWorked').val()) || 0;
    var overTimeValue = parseFloat($('#overTime').val()) || 0;
    var sundayExpenditureValue = parseFloat($('#sunday_expenditure').val()) || 0;

    var totalAmount = parseFloat($('#totalAmountDisplay').text().split(' ')[2]) || 0;
    var overtimeAmount = parseFloat($('#overTimeAmount').text().split(' ')[2]) || 0;
    var penalty = parseFloat($('#penalty').val()) || 0;
    var netPay = totalAmount + overtimeAmount - advanceInSiteValue - advanceInHomeValue - messValue - sundayExpenditureValue - penalty ;

    $('#net_pay').text('Net Pay: ' + netPay.toFixed(2)); // Update net_pay value
});





    // Save button functionality
    $('#saveButton').on('click', function () {
    var payrollIdValue = payrollID.val();
    var siteSelectValue = siteSelect.val();
    var employeeSelectValue = employeeSelect.val();
    var advanceInSite = parseFloat($('#advance_in_site').val()) || 0;
    var advanceInHome = parseFloat($('#advance_in_home').val()) || 0;
    var mess = parseFloat($('#mess').val()) || 0;
    var sundayExpenditure = parseFloat($('#sunday_expenditure').val()) || 0;
    var daysWorked = parseFloat($('#daysWorked').val()) || 0;
    var overTime = parseFloat($('#overTime').val()) || 0;

    var rateDisplayValue = $('#rateDisplay').text().match(/\d+/);  // Extracts the numeric value
    var daysWorkedDisplayValue = $('#daysWorkedDisplay').text().match(/\d+/);  // Extracts the numeric value
    var totalAmountDisplayValue = $('#totalAmountDisplay').text().match(/\d+/); 
    var penalty = parseFloat($('#penalty').val()) || 0;
    

    var rate = rateDisplayValue ? parseFloat(rateDisplayValue[0]) : 0;
    var totalAmount = totalAmountDisplayValue ? parseFloat(totalAmountDisplayValue[0]) : 0;
    var overtimeAmount = (overTime * rate) / 12;


    var netPay = totalAmount + overtimeAmount - advanceInSite - advanceInHome - mess - sundayExpenditure - penalty;
    var payrollMonth = '<?php echo htmlentities($payrollMonth); ?>';
    var formData = {
        payrollID: payrollIdValue,
        siteSelect: siteSelectValue,
        employeeSelect: employeeSelectValue,
        advance_in_site: advanceInSite,
        advance_in_home: advanceInHome,
        mess: mess,
        sunday_expenditure: sundayExpenditure,
        rateDisplay: rateDisplayValue ? rateDisplayValue[0] : '',
        daysWorkedDisplay: daysWorkedDisplayValue ? daysWorkedDisplayValue[0] : '',
        totalAmountDisplay: totalAmountDisplayValue ? totalAmountDisplayValue[0] : '',
        daysWorked: daysWorked,
        overTime: overTime,
        net_pay: netPay,
        penalty: penalty,
        overtimeAmount : overtimeAmount,
        payrollMonth: payrollMonth // Include payrollMonth in formData
    };

    $.ajax({
        type: "POST",
        url: "insert_data.php",
        data: formData,
        success: function (response) {
    console.log(response); // Add this line to debug the response
    // Check if the response indicates success, then reset inputs and close modal
    alert(response)
    if (response.trim() === "Data inserted successfully!") {
        // Reset input fields
        $('#siteSelect').val('');
        $('#employeeSelect').val('');
        $('#advance_in_site').val('');
        $('#advance_in_home').val('');
        $('#mess').val('');
        $('#sunday_expenditure').val('');
        $('#daysWorked').val('');
        $('#overTime').val('');
        $('#penalty').val('');
        $('#rateDisplay').empty();
        $('#overTimeAmount').empty();
        $('#totalAmountDisplay').empty();
        $('#net_pay').empty();
        $('#finalPaymentInput').hide();
        $('input[name="finalPayment"]').prop('checked', false);
        // Close the modal
        $('#siteModal').modal('hide');
    } else {
        
    }
},


    });
});


});

</script>

<div class="modal" id="employeeModal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="employeeDetails"></div>
    </div>
</div>

<script>
    // Function to handle the AJAX call for viewing employee details
    function viewDetails(employeeId) {
        $.ajax({
            type: "GET",
            url: "fetch-data.php",
            data: { id: employeeId },
            success: function (data) {
                // Parse the JSON response
                const employee = JSON.parse(data);

                // Check if the employee details are fetched successfully
                if (employee.error) {
                    alert(employee.error);
                    return;
                }

                // Construct HTML content to display employee details
                const modalContent = `
                    <div class="modal-body">
                        <h2>${employee.FirstName} ${employee.LastName}</h2>
                        <p><strong>Creation Date:</strong> ${employee.CreationDate}</p>
                        <p><strong>Net Pay:</strong> ${employee.net_pay}</p>
                        <p><strong>Over time hours:</strong> ${employee.overTime}</p>
                        <p><strong>Rate:</strong> ${employee.rateDisplay}</p>
                        <p><strong>Over Time Amount:</strong> ${(employee.rateDisplay * employee.overTime / 12).toFixed(2)}</p>
                        <p><strong>Days Worked:</strong> ${employee.daysWorked}</p>
                        <p><strong>Total Amount:</strong> ${employee.totalAmountDisplay}</p>
                        <p><strong>Advance in Site:</strong> ${employee.advance_in_site}</p>
                        <p><strong>Advance in Home:</strong> ${employee.advance_in_home}</p>
                        <p><strong>Mess:</strong> ${employee.mess}</p>
                        <p><strong>Sunday Expenditure:</strong> ${employee.sunday_expenditure}</p>
                        <!-- Add other details as needed -->
                    </div>
                `;

                // Set the HTML content to the modal body
                $('#employeeDetails').html(modalContent);

                // Show the modal
                $('#employeeModal').modal('show');
            },
            error: function () {
                alert('Error fetching employee details');
            }
        });
    }

    // Close the modal when close button is clicked
    $('#closeModalBtn').click(function () {
        $('#employeeModal').modal('hide');
    });
</script>

<script>
  

</script>

<script>
$(document).ready(function() {
    $('input[name="finalPayment"]').change(function() {
        var finalPayment = $(this).val();
        var selectedEmployee = $('#employeeSelect').val(); // Assuming the employee ID is selected from a dropdown with the ID 'employeeSelect'

        if (finalPayment === 'yes') {
            // Show the finalPaymentInput
            $('#finalPaymentInput').show();
            // AJAX request to update Status to 0 for the selected employee
            updateStatus(selectedEmployee, 0);
        } else if (finalPayment === 'no') {
            // Hide the finalPaymentInput
            $('#finalPaymentInput').hide();
            // AJAX request to update Status to 1 for the selected employee
            updateStatus(selectedEmployee, 1);
        }
    });
});


function updateStatus(employeeId, status) {
    $.ajax({
        url: 'update_status.php',
        type: 'POST',
        data: { employee_id: employeeId, status: status },
        success: function(response) {
            // Handle success response
            alert('Status updated successfully.');
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error(xhr.responseText);
            alert('Error: Failed to update status.');
        }
    });
}



    </script>