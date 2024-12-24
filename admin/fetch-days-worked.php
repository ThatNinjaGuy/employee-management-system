<?php

// include('dbconn.php'); 

// if (isset($_POST['employeeID'])) {
//     $employeeID = $_POST['employeeID'];
//     $daysWorked = 0; 
//     $overTime = 0;
 
//     $sql = "SELECT overTime, daysWorked FROM attendance WHERE employeeSelect = :employeeID";
//     $query = $dbh->prepare($sql);
//     $query->bindParam(':employeeID', $employeeID);
//     $query->execute();
//     $result = $query->fetch(PDO::FETCH_ASSOC);
//     if ($result) {
//         $daysWorked = $result['daysWorked'];
//         $overTime = $result['overTime'];
//     }
//     echo $daysWorked;
//     echo $overTime;
// }
?>

<?php

include('dbconn.php'); 

if (isset($_POST['employeeID'])) {
    $employeeID = $_POST['employeeID'];
    $daysWorked = 0; 
    $overTime = 0;

    $sql = "SELECT a.daysWorked,a.overTime
            FROM attendance a
            JOIN payroll p ON a.date BETWEEN p.start_date AND p.end_date
            WHERE a.employeeSelect = :employeeID";
    
    $query = $dbh->prepare($sql);
    $query->bindParam(':employeeID', $employeeID);
    if ($query->execute()) {
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $daysWorked = $result['daysWorked'];
            $overTime = $result['overTime'];
        }
    } else {
        print_r($query->errorInfo()); // Output any error information
        exit; // Terminate the script
    }

    echo $daysWorked;
    echo $overTime;
}
?>

