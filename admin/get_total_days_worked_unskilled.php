<?php
// Include database connection
include('../includes/dbconn.php');

// Check if the payrollMonth is set
if (isset($_GET['payrollMonth'])) {
    $payrollMonth = $_GET['payrollMonth'];

    // Fetch sum of days worked for unskilled employees for the selected payrollMonth
    $sqlUnskilled = "SELECT SUM(p.daysWorked) AS totalDaysWorkedUnskilled
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

    // Output the sum of days worked for unskilled employees
    if (!empty($resultUnskilled['totalDaysWorkedUnskilled'])) {
        echo 'Total Days Worked For UnSkilled Employees :' . $resultUnskilled['totalDaysWorkedUnskilled'];
    } else {
        echo "Total Days Worked For UnSkilled Employees :0";
    }
} else {
    echo "Error: Payroll month not specified.";
}
?>
