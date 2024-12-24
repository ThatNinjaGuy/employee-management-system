    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include('../includes/dbconn.php');

    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve data sent from AJAX
        $payrollID = $_POST['payrollID'];
        $siteSelect = $_POST['siteSelect'];
        $employeeSelect = $_POST['employeeSelect'];
        $rateDisplay = $_POST['rateDisplay'];
        $payrollMonth = $_POST['payrollMonth'];
        $daysWorked = $_POST['daysWorked'];
        $overTime = $_POST['overTime'];
        $totalAmountDisplay = $_POST['totalAmountDisplay'];
        $advance_in_site = $_POST['advance_in_site'];
        $advance_in_home = $_POST['advance_in_home'];
        $mess = $_POST['mess'];
        $sunday_expenditure = $_POST['sunday_expenditure'];
        $net_pay = $_POST['net_pay'];
        $penalty = $_POST['penalty'];

        // Current date and time for CreationDate
        $CreationDate = date("Y-m-d H:i:s");

        // Check if a record already exists for the employee and payroll month
        $existingSql = "SELECT COUNT(*) FROM payslip WHERE employeeSelect = :employeeSelect AND payrollMonth = :payrollMonth";
        $existingStmt = $dbh->prepare($existingSql);
        $existingStmt->bindParam(':employeeSelect', $employeeSelect);
        $existingStmt->bindParam(':payrollMonth', $payrollMonth);
        $existingStmt->execute();
        $existingCount = $existingStmt->fetchColumn();

        if ($existingCount > 0) {
            // Record already exists, prevent insertion
            echo "Error: Payroll for this employee in the selected month already exists.";
        } else {
            // Record does not exist, proceed with insertion
            $sql = "INSERT INTO payslip (payrollID, siteSelect, employeeSelect, rateDisplay, payrollMonth, daysWorked, overTime,  totalAmountDisplay, advance_in_site, advance_in_home, mess, sunday_expenditure, net_pay, penalty, CreationDate) 
                    VALUES (:payrollID, :siteSelect, :employeeSelect, :rateDisplay, :payrollMonth, :daysWorked, :overTime, :totalAmountDisplay, :advance_in_site, :advance_in_home, :mess, :sunday_expenditure, :net_pay, :penalty, :CreationDate)";
            
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':payrollID', $payrollID);
            $stmt->bindParam(':siteSelect', $siteSelect);
            $stmt->bindParam(':employeeSelect', $employeeSelect);
            $stmt->bindParam(':rateDisplay', $rateDisplay);
            $stmt->bindParam(':payrollMonth', $payrollMonth);
            $stmt->bindParam(':daysWorked', $daysWorked);
            $stmt->bindParam(':overTime', $overTime);
            $stmt->bindParam(':totalAmountDisplay', $totalAmountDisplay);
            $stmt->bindParam(':advance_in_site', $advance_in_site);
            $stmt->bindParam(':advance_in_home', $advance_in_home);
            $stmt->bindParam(':mess', $mess);
            $stmt->bindParam(':sunday_expenditure', $sunday_expenditure);
            $stmt->bindParam(':net_pay', $net_pay);
            $stmt->bindParam(':penalty', $penalty);
            $stmt->bindParam(':CreationDate', $CreationDate);

            try {
                if ($stmt->execute()) {
                    echo "Data inserted successfully!";
                    
                } else {
                    echo "Error: Failed to insert data.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    } else {
        echo "Error: Invalid request.";
    }
    ?>
