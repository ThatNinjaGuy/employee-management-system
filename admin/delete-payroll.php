<?php
    session_start();
    error_reporting(0);
    include('../includes/dbconn.php');

    if(empty($_SESSION['usertype'])) {   
        header('location:index.php');
        exit; // Add exit to stop further execution
    } else {
        if(isset($_GET['del'])){
            $id = intval($_GET['del']);
            $sql = "DELETE FROM payslip WHERE id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $_SESSION['msg']="Payroll data deleted successfully";
            header('location:payroll.php');
            exit();
        } else {
            header('location:payroll.php');
            exit();
        }
    }
?>
