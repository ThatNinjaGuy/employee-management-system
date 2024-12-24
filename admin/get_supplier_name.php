<?php
// Include database connection file
include('../includes/dbconn.php');

// Check if supplier_id is provided
if (isset($_GET['supplier_id'])) {
    // Sanitize the input to prevent SQL injection
    $supplier_id = $_GET['supplier_id'];

    // Fetch the name of the supplier from the database
    $sql = "SELECT name FROM tblsupplier WHERE id = :supplier_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':supplier_id', $supplier_id, PDO::PARAM_INT);
    $stmt->execute();
    $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a supplier with the provided ID exists
    if ($supplier) {
        // Return the name of the supplier
        echo $supplier['name'];
    } else {
        // Return an error message if the supplier doesn't exist
        echo 'Supplier not found';
    }
} else {
    // Return an error message if supplier_id is not provided
    echo 'No supplier ID provided';
}
?>
