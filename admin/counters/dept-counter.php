<?php
    include '../../includes/dbconn.php';

    $sql = "SELECT id from tblsite";
    $query = $dbh -> prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $dptcount=$query->rowCount();

    echo htmlentities($dptcount);
?> 