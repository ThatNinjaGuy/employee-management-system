<?php
// Include database connection or any necessary files
include('../includes/dbconn.php');

// Check if the supplier ID is set in the request
if (isset($_GET['supplier_id'])) {
    $supplier_id = $_GET['supplier_id'];

    // Fetch distinct payroll months associated with the specified supplier
    $sqlDistinctMonths = "SELECT DISTINCT payrollMonth FROM payslip WHERE employeeSelect IN (SELECT id FROM tblemployees WHERE supplier_id = :supplier_id) AND payrollMonth IS NOT NULL";
    $queryDistinctMonths = $dbh->prepare($sqlDistinctMonths);
    $queryDistinctMonths->bindParam(':supplier_id', $supplier_id, PDO::PARAM_INT);
    $queryDistinctMonths->execute();
    $distinctMonths = $queryDistinctMonths->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any distinct months fetched
    if ($distinctMonths) {
        // Build HTML options for the dropdown menu
        $options = '<option value="">Select...</option>';
        foreach ($distinctMonths as $month) {
            $options .= '<option value="' . $month['payrollMonth'] . '">' . $month['payrollMonth'] . '</option>';
        }
        // Output the HTML options
        echo $options;
    } else {
        // If no distinct months found, return an error message
        echo '<option value="">No payroll months found</option>';
    }
} else {
    // If supplier ID is not specified in the request, return an error message
    echo '<option value="">Error: Supplier ID not specified</option>';
}
?>



