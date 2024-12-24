<?php
// Include database connection
include('../includes/dbconn.php');

// Check if the payrollMonth is set
if (isset($_GET['payrollMonth'])) {
    $payrollMonth = $_GET['payrollMonth'];

    // Fetch sum of days worked for skilled employees for the selected payrollMonth
    $sqlSkilled = "SELECT SUM(p.daysWorked) AS totalDaysWorkedSkilled
            FROM payslip p
            JOIN tblemployees e ON p.employeeSelect = e.id
            JOIN tbldesignation d ON e.designation = d.id
            WHERE p.payrollMonth = :payrollMonth 
            AND d.status = 'skilled'
            AND e.Status = 1";
    $stmtSkilled = $dbh->prepare($sqlSkilled);
    $stmtSkilled->bindParam(':payrollMonth', $payrollMonth, PDO::PARAM_STR);
    $stmtSkilled->execute();
    $resultSkilled = $stmtSkilled->fetch(PDO::FETCH_ASSOC);

    // Output the sum of days worked for skilled employees
    if ($resultSkilled !== false && isset($resultSkilled['totalDaysWorkedSkilled'])) {
        echo 'Total Days Worked For Skilled Employees :' . $resultSkilled['totalDaysWorkedSkilled'];
    } else {
        echo "Total Days Worked For Skilled Employees :0";
    }
} else {
    echo "Error: Payroll month not specified.";
}
?>

