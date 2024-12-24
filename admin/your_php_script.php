<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../includes/dbconn.php');
  


if (isset($_GET['fetch_sites'])) {
    $sql = "SELECT id, name FROM tblsite";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['sites' => $sites]);
}

if (isset($_GET['fetch_employees']) && isset($_GET['site_id'])) {
    $siteId = $_GET['site_id'];
    $sql = "SELECT id ,EmpId, FirstName, LastName FROM tblemployees WHERE Site = :siteId AND Status = 1";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':siteId', $siteId);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['employees' => $employees]);
}

// ... (your existing PHP code)

// If an employee is selected
if (isset($_GET['fetch_rate'])) {
    $employeeId = $_GET['employee_id'];

    // Perform an SQL query to retrieve the rate for the selected employee
    $sql = "SELECT rate FROM tblemployees WHERE id = :employeeId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':employeeId', $employeeId);
    $query->execute();
    $rate = $query->fetch(PDO::FETCH_ASSOC);

    // Send the rate back as JSON
    echo json_encode($rate);
    exit; // Terminate the script after sending the response
}




