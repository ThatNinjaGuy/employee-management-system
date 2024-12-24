<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commission Section</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Commission Section</h1>
        <!-- Dropdown menu for selecting payroll month -->
        <label for="payrollMonth">Select Payroll Month:</label>
        <select id="payrollMonth" name="payrollMonth">
            <option value="">Select...</option>
            <?php
            include('../includes/dbconn.php');
            if (isset($_GET['supplier_id'])) {
                $supplier_id = $_GET['supplier_id'];
                // Fetch distinct payroll months associated with the specified supplier
                $sql = "SELECT DISTINCT payrollMonth FROM payslip WHERE employeeSelect IN (SELECT id FROM tblemployees WHERE supplier_id = :supplier_id)";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':supplier_id', $supplier_id, PDO::PARAM_INT);
                $stmt->execute();
                $months = $stmt->fetchAll(PDO::FETCH_COLUMN);
                // Output HTML options for the dropdown menu
                foreach ($months as $month) {
                    echo "<option value='$month'>$month</option>";
                }
            } else {
                echo "<option value=''>No supplier ID provided</option>";
            }
            ?>
        </select>
        <div id="supplierNameContainer" class="mt-3"></div>
        <input type="hidden" id="supplierName" name="supplierName">

        <div id="totalSkilledEmployeesContainer" class="mt-3"></div>
        <div id="totalUnskilledEmployeesContainer" class="mt-3"></div>
      <!-- Container to display total days worked for skilled employees -->
<div id="totalDaysWorkedSkilledContainer" class="mt-3"></div>

<!-- Container to display total days worked for unskilled employees -->
<div id="totalDaysWorkedUnskilledContainer" class="mt-3"></div>

        <!-- Container to display payroll information -->
        <div id="payrollInfoContainer"></div>

        <!-- Input field for entering rate for skilled employees -->
        <div class="form-group mt-3">
            <label for="skilledRate" class="font-weight-bold">Rate for Skilled Employees:</label>
            <input type="number" step="0.01" id="skilledRate" name="skilledRate" class="form-control" placeholder="Enter rate for skilled employees">
        </div>

        <!-- Input field for entering rate for unskilled employees -->
        <div class="form-group mt-3">
            <label for="unskilledRate" class="font-weight-bold">Rate for Unskilled Employees:</label>
            <input type="number" step="0.01" id="unskilledRate" name="unskilledRate" class="form-control" placeholder="Enter rate for unskilled employees">
        </div>

        <!-- Container to display total amount for skilled employees -->
        <div id="totalAmountSkilledContainer" class="mt-3"></div>

        <!-- Container to display total amount for unskilled employees -->
        <div id="totalAmountUnskilledContainer" class="mt-3"></div>




    <!-- Input field for entering the supplier personal amount credited -->
<div class="form-group mt-3">
    <label for="supplierPersonalAmountCredited" class="font-weight-bold">Supplier Personal Amount Credited:</label>
    <input type="number" step="0.01" id="supplierPersonalAmountCredited" name="supplierPersonalAmountCredited" class="form-control" placeholder="Enter amount credited">
</div>


<!-- Input field for supplier personal group costing -->
<div class="form-group mt-3">
    <label for="supplierPersonalGroupCosting" class="font-weight-bold">Supplier Personal Group Costing:</label>
    <input type="number" step="0.01" id="supplierPersonalGroupCosting" name="supplierPersonalGroupCosting" class="form-control" placeholder="Enter supplier personal group costing">
</div>

<!-- Container to display net amount -->
<div id="netAmountContainer" class="mt-3"></div>

<!-- Save button -->
<button id="savePayrollData" class="btn btn-primary mt-3">Save Comission Data</button>

    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <div id="totalDaysWorkedContainer"></div>
    
    <script>
        $(document).ready(function() {
            // Event listener for when the rate input field for skilled employees changes
            $('#skilledRate').on('input', function() {
                // Get the entered rate for skilled employees
                var skilledRate = parseFloat($(this).val());

                // Fetch the total days worked for skilled employees dynamically
                $.ajax({
                    url: 'get_payroll_info.php',
                    type: 'GET',
                    data: { payrollMonth: $('#payrollMonth').val() }, // Pass the selected payroll month
                    success: function(response) {
                        // Parse the response as a float
                        var totalDaysWorkedSkilled = parseFloat(response);

                        // Check if the values are valid numbers
                        if (!isNaN(skilledRate) && !isNaN(totalDaysWorkedSkilled)) {
                            // Calculate the total amount for skilled employees
                            var totalAmountSkilled = skilledRate * totalDaysWorkedSkilled;

                            // Update the total amount container for skilled employees with the calculated value
                            $('#totalAmountSkilledContainer').html('<p>Total Amount for Skilled Employees: ' + totalAmountSkilled.toFixed(2) + '</p>');
                        } else {
                            // If either value is not a valid number, display an error message
                            $('#totalAmountSkilledContainer').html('<p>Error: Invalid input.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#totalAmountSkilledContainer').html('<p>Error fetching total days worked for skilled employees.</p>');
                    }
                });
            });

            // Event listener for when the rate input field for unskilled employees changes
            $('#unskilledRate').on('input', function() {
                // Get the entered rate for unskilled employees
                var unskilledRate = parseFloat($(this).val());

                // Fetch the total days worked for unskilled employees dynamically
                $.ajax({
                    url: 'get_payroll_un.php',
                    type: 'GET',
                    data: { payrollMonth: $('#payrollMonth').val() }, // Pass the selected payroll month
                    success: function(response) {
                        // Parse the response as a float
                        var totalDaysWorkedUnskilled = parseFloat(response);
                     console.log(totalDaysWorkedUnskilled);
                        // Check if the values are valid numbers
                        if (!isNaN(unskilledRate) && !isNaN(totalDaysWorkedUnskilled)) {
                            // Calculate the total amount for unskilled employees
                            var totalAmountUnskilled = unskilledRate * totalDaysWorkedUnskilled;

                            // Update the total amount container for unskilled employees with the calculated value
                            $('#totalAmountUnskilledContainer').html('<p>Total Amount for Unskilled Employees: ' + totalAmountUnskilled.toFixed(2) + '</p>');
                        } else {
                            // If either value is not a valid number, display an error message
                            $('#totalAmountUnskilledContainer').html('<p>Error: Invalid input.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#totalAmountUnskilledContainer').html('<p>Error fetching total days worked for unskilled employees.</p>');
                    }
                });
            });
        });

// Calculate net amount and display
$(document).ready(function() {
    // Event listener for when the "Supplier Personal Amount Credited" input field changes
    $('#supplierPersonalAmountCredited').on('input', function() {
        // Call the function to calculate the net amount
        calculateNetAmount();
    });

    // Event listener for when the "Supplier Personal Group Costing" input field changes
    $('#supplierPersonalGroupCosting').on('input', function() {
        // Call the function to calculate the net amount
        calculateNetAmount();
    });

    // Function to calculate the net amount
    function calculateNetAmount() {
        var totalAmountSkilled = parseFloat($('#totalAmountSkilledContainer').text().replace('Total Amount for Skilled Employees: ', '').trim());
        var totalAmountUnskilled = parseFloat($('#totalAmountUnskilledContainer').text().replace('Total Amount for Unskilled Employees: ', '').trim());
        var supplierPersonalAmountCredited = parseFloat($('#supplierPersonalAmountCredited').val());
        var supplierPersonalGroupCosting = parseFloat($('#supplierPersonalGroupCosting').val());
        
        // Check if all values are valid numbers
        if (!isNaN(totalAmountSkilled) && !isNaN(totalAmountUnskilled) && !isNaN(supplierPersonalAmountCredited)) {
            // Calculate the net amount
            var netAmount = totalAmountSkilled + totalAmountUnskilled - supplierPersonalAmountCredited;
            // If "Supplier Personal Group Costing" is a valid number, deduct it from the net amount
            if (!isNaN(supplierPersonalGroupCosting)) {
                netAmount -= supplierPersonalGroupCosting;
            }
            // Display the net amount
            $('#netAmountContainer').html('<p>Net Amount: ' + netAmount.toFixed(2) + '</p>');
        } else {
            // If any value is not a valid number, display an error message
            $('#netAmountContainer').html('<p>Error: Invalid input.</p>');
        }
    }
});


    </script>
    <script>
        $(document).ready(function() {
    // Event listener for when a month is selected
    $('#payrollMonth').change(function() {
        // Fetch the selected payroll month
        var selectedMonth = $(this).val();
        
        // Fetch the total days worked for skilled employees dynamically
        $.ajax({
            url: 'get_total_days_worked_skilled.php',
            type: 'GET',
            data: { payrollMonth: selectedMonth },
            success: function(response) {
                $('#totalDaysWorkedSkilledContainer').text(' ' + response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
               
            }
        });

        // Fetch the total days worked for unskilled employees dynamically
        $.ajax({
            url: 'get_total_days_worked_unskilled.php',
            type: 'GET',
            data: { payrollMonth: selectedMonth },
            success: function(response) {
                $('#totalDaysWorkedUnskilledContainer').text(' ' + response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);    
                $('#totalDaysWorkedUnskilledContainer').text('');
            }
        });
    });
});

    </script>

<script>
$('#savePayrollData').click(function() {
    // Gather data from form fields
    var payrollMonth = $('#payrollMonth').val();
    var totalDaysWorkedSkilled = extractNumericValue($('#totalDaysWorkedSkilledContainer').text().trim());
    var totalDaysWorkedUnskilled = extractNumericValue($('#totalDaysWorkedUnskilledContainer').text().trim());
    var skilledRate = $('#skilledRate').val();
    var unskilledRate = $('#unskilledRate').val();
    var totalAmountSkilled = extractNumericValue($('#totalAmountSkilledContainer').text().trim());
    var totalAmountUnskilled = extractNumericValue($('#totalAmountUnskilledContainer').text().trim());
    var supplierPersonalAmountCredited = $('#supplierPersonalAmountCredited').val();
    var supplierPersonalGroupCosting = $('#supplierPersonalGroupCosting').val();
    var netAmount = extractNumericValue($('#netAmountContainer').text().trim());
    var totalSkilledEmployees = extractNumericValue($('#totalSkilledEmployeesContainer').text().trim());
    var totalUnskilledEmployees = extractNumericValue($('#totalUnskilledEmployeesContainer').text().trim());
    var supplierName = $('#supplierName').val(); // Retrieve the supplier name from the hidden input field

    // Log the values to the console for debugging
    console.log('Payroll Month:', payrollMonth);
    console.log('Total Days Worked Skilled:', totalDaysWorkedSkilled);
    console.log('Total Days Worked Unskilled:', totalDaysWorkedUnskilled);
    console.log('Skilled Rate:', skilledRate);
    console.log('Unskilled Rate:', unskilledRate);
    console.log('Total Amount Skilled:', totalAmountSkilled);
    console.log('Total Amount Unskilled:', totalAmountUnskilled);
    console.log('Supplier Personal Amount Credited:', supplierPersonalAmountCredited);
    console.log('Supplier Personal Group Costing:', supplierPersonalGroupCosting);
    console.log('Net Amount:', netAmount);
    console.log('Total Skilled Employees:', totalSkilledEmployees);
    console.log('Total Unskilled Employees:', totalUnskilledEmployees);
    console.log('Supplier Name:', supplierName); // Log the supplier name

    // Prepare data to send to server
    var formData = {
        payrollMonth: payrollMonth,
        totalDaysWorkedSkilled: totalDaysWorkedSkilled,
        totalDaysWorkedUnskilled: totalDaysWorkedUnskilled,
        skilledRate: skilledRate,
        unskilledRate: unskilledRate,
        totalAmountSkilled: totalAmountSkilled,
        totalAmountUnskilled: totalAmountUnskilled,
        supplierPersonalAmountCredited: supplierPersonalAmountCredited,
        supplierPersonalGroupCosting: supplierPersonalGroupCosting,
        netAmount: netAmount,
        totalSkilledEmployees: totalSkilledEmployees,
        totalUnskilledEmployees: totalUnskilledEmployees,
        supplierName: supplierName // Include the supplier name in the formData
    };

    // Log the form data to the console for debugging
    console.log('Form Data:', formData);

    // Send data to server-side script for insertion into database
    $.ajax({
        url: 'save_comission_data.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            // Handle success response
            alert('Comission data saved successfully.');
            // You can also redirect the user or perform other actions as needed
            window.location.href = 'supplier.php';
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error(xhr.responseText);
            alert('Error: Failed to save comission data.');
        }
    });
});
function updateSupplierName(name) {
    $('#supplierName').val(name);
}
// Extract numeric value from text
function extractNumericValue(text) {
    // Use regular expression to match digits
    var matches = text.match(/\d+/);
    // If matches found, return the first match (assuming there's only one)
    if (matches && matches.length > 0) {
        return parseInt(matches[0]); // Convert to integer
    } else {
        return 0; // Return 0 if no numeric value found
    }
}
</script>



<script>
        $(document).ready(function() {
            // Event listener for when a month is selected
            $('#payrollMonth').change(function() {
                var selectedMonth = $(this).val();
                
                // Fetch the total days worked for skilled employees dynamically
                $.ajax({
                    url: 'get_total_days_worked_skilled.php',
                    type: 'GET',
                    data: { payrollMonth: selectedMonth },
                    success: function(response) {
                        $('#totalDaysWorkedSkilledContainer').text(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#totalDaysWorkedSkilledContainer').text('Error fetching total days worked for skilled employees.');
                    }
                });

                // Fetch the total days worked for unskilled employees dynamically
                $.ajax({
                    url: 'get_total_days_worked_unskilled.php',
                    type: 'GET',
                    data: { payrollMonth: selectedMonth },
                    success: function(response) {
                        $('#totalDaysWorkedUnskilledContainer').text(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#totalDaysWorkedUnskilledContainer').text('Error fetching total days worked for unskilled employees.');
                    }
                });

                // Fetch the total number of skilled employees dynamically
                $.ajax({
                    url: 'get_total_skilled_employees.php',
                    type: 'GET',
                    data: { payrollMonth: selectedMonth },
                    success: function(response) {
                        $('#totalSkilledEmployeesContainer').text('Total Skilled Employees: ' + response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#totalSkilledEmployeesContainer').text('Error fetching total skilled employees.');
                    }
                });

                // Fetch the total number of unskilled employees dynamically
                $.ajax({
                    url: 'get_total_unskilled_employees.php',
                    type: 'GET',
                    data: { payrollMonth: selectedMonth },
                    success: function(response) {
                        $('#totalUnskilledEmployeesContainer').text('Total Unskilled Employees: ' + response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#totalUnskilledEmployeesContainer').text('Error fetching total unskilled employees.');
                    }
                });
            });
        });
    </script>


<script>
   // Fetch the supplier name dynamically
$.ajax({
    url: 'get_supplier_name.php',
    type: 'GET',
    data: { supplier_id: <?php echo isset($_GET['supplier_id']) ? $_GET['supplier_id'] : '0'; ?> }, // Pass the supplier ID
    success: function(response) {
        // Update the supplier name container with the fetched name
        $('#supplierNameContainer').html('Supplier: ' + response);
        updateSupplierName(response); // Update the hidden input field with the supplier name
    },
    error: function(xhr, status, error) {
        console.error(xhr.responseText);
        // Display an error message if fetching the supplier name fails
        $('#supplierNameContainer').text('Error fetching supplier name.');
    }
});

</script>


</body>
</html>
