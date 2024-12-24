<?php
include('../includes/dbconn.php');

if (isset($_GET['supplier_id'])) {
    $supplierId = $_GET['supplier_id'];

    // Fetch groups based on the selected supplier
    $sql = "SELECT * FROM tblgroup WHERE supplier_id = :supplierId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':supplierId', $supplierId, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            ?>
            <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->name); ?></option>
            <?php
        }
    }
}
?>
