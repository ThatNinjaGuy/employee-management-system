<?php
include('../includes/dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $employeeId = $_GET['id'];

    $sql = "SELECT payslip.*, tblemployees.FirstName, tblemployees.LastName 
            FROM payslip 
            LEFT JOIN tblemployees ON payslip.employeeSelect = tblemployees.id 
            WHERE tblemployees.id = :employeeId";

    $query = $dbh->prepare($sql);
    $query->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $query->execute();
    
    if ($query->rowCount() > 0) {
        $employee = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($employee); // Return employee data as JSON
    } else {
        echo json_encode(['error' => 'Employee not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>



