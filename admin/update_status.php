<?php
// Include database connection or initialization file
include('../includes/dbconn.php');

// Check if employee ID and status are provided in the POST request
if (isset($_POST['employee_id']) && isset($_POST['status'])) {
    $employee_id = $_POST['employee_id'];
    $status = $_POST['status'];

    // Update the Status column in the tblemployees table for the specific employee
    $sql = "UPDATE tblemployees SET Status = :status WHERE id = :employee_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        echo "Status updated successfully.";
    } else {
        echo "Error: Failed to update status.";
    }
} else {
    echo "Error: Employee ID or status not provided.";
}
?>
