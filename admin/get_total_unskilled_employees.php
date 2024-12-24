<?php
// Include database connection
include('../includes/dbconn.php');

// Check if the payrollMonth is set
if (isset($_GET['payrollMonth'])) {
    $payrollMonth = $_GET['payrollMonth'];

    // Fetch the count of unskilled employees for the selected payrollMonth
    $sqlUnskilled = "SELECT COUNT(*) AS totalUnskilledEmployees
            FROM payslip p
            JOIN tblemployees e ON p.employeeSelect = e.id
            JOIN tbldesignation d ON e.designation = d.id
            WHERE p.payrollMonth = :payrollMonth 
            AND d.status = 'unskilled'
            AND e.Status = 1";
    $stmtUnskilled = $dbh->prepare($sqlUnskilled);
    $stmtUnskilled->bindParam(':payrollMonth', $payrollMonth, PDO::PARAM_STR);
    $stmtUnskilled->execute();
    $resultUnskilled = $stmtUnskilled->fetch(PDO::FETCH_ASSOC);

    // Output the count of unskilled employees
    if ($resultUnskilled !== false && isset($resultUnskilled['totalUnskilledEmployees'])) {
        echo $resultUnskilled['totalUnskilledEmployees'];
    } else {
        echo "0";
    }
} else {
    echo "Error: Payroll month not specified.";
}
?>
