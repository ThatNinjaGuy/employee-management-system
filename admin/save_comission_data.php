<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../includes/dbconn.php');

// Retrieve form inputs
$payrollMonth = $_POST['payrollMonth'];
$totalDaysWorkedSkilled = $_POST['totalDaysWorkedSkilled'];
$totalDaysWorkedUnskilled = $_POST['totalDaysWorkedUnskilled'];
$rateSkilled = $_POST['skilledRate'];
$rateUnskilled = $_POST['unskilledRate'];
$totalAmountSkilled = $_POST['totalAmountSkilled'];
$totalAmountUnskilled = $_POST['totalAmountUnskilled'];
$supplierPersonalAmountCredited = $_POST['supplierPersonalAmountCredited'];
$supplierPersonalGroupCosting = $_POST['supplierPersonalGroupCosting'];
$netAmount = $_POST['netAmount'];
$totalSkilledEmployees = $_POST['totalSkilledEmployees'];
$totalUnskilledEmployees = $_POST['totalUnskilledEmployees'];
$supplierName = $_POST['supplierName']; // Retrieve the supplier name from the form data

try {
    // Check if the entry already exists
    $checkSql = "SELECT COUNT(*) FROM comissionData WHERE supplierName = :supplierName AND payrollMonth = :payrollMonth";
    $checkStmt = $dbh->prepare($checkSql);
    $checkStmt->execute([':supplierName' => $supplierName, ':payrollMonth' => $payrollMonth]);
    $rowCount = $checkStmt->fetchColumn();

    if ($rowCount > 0) {
        http_response_code(400); // Set HTTP status code to 400
        echo "Error: Duplicate entry for the same supplier and payroll month.";
    } else {
        // Prepare the SQL statement
        $sql = "INSERT INTO comissionData 
                (payrollMonth, totalDaysWorkedSkilled, totalDaysWorkedUnskilled, rateSkilled, rateUnskilled, 
                totalAmountSkilled, totalAmountUnskilled, supplierPersonalAmountCredited, 
                supplierPersonalGroupCosting, netAmount, totalSkilledEmployees, totalUnskilledEmployees, supplierName) 
                VALUES 
                (:payrollMonth, :totalDaysWorkedSkilled, :totalDaysWorkedUnskilled, :rateSkilled, :rateUnskilled, 
                :totalAmountSkilled, :totalAmountUnskilled, :supplierPersonalAmountCredited, 
                :supplierPersonalGroupCosting, :netAmount, :totalSkilledEmployees, :totalUnskilledEmployees, :supplierName)";

        // Prepare and execute the statement
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            ':payrollMonth' => $payrollMonth,
            ':totalDaysWorkedSkilled' => $totalDaysWorkedSkilled,
            ':totalDaysWorkedUnskilled' => $totalDaysWorkedUnskilled,
            ':rateSkilled' => $rateSkilled,
            ':rateUnskilled' => $rateUnskilled,
            ':totalAmountSkilled' => $totalAmountSkilled,
            ':totalAmountUnskilled' => $totalAmountUnskilled,
            ':supplierPersonalAmountCredited' => $supplierPersonalAmountCredited,
            ':supplierPersonalGroupCosting' => $supplierPersonalGroupCosting,
            ':netAmount' => $netAmount,
            ':totalSkilledEmployees' => $totalSkilledEmployees,
            ':totalUnskilledEmployees' => $totalUnskilledEmployees,
            ':supplierName' => $supplierName // Bind the supplier name parameter
        ]);

        // Check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            echo "Data inserted successfully.";
        } else {
            // If no rows were affected, it's an error
            http_response_code(400); // Set HTTP status code to 400
            echo "Error: Failed to insert data.";
        }
    }
} catch (PDOException $e) {
    http_response_code(500); // Set HTTP status code to 500 for PDO exceptions
    echo "Error: " . $e->getMessage(); // Handle PDO exceptions
}
?>
