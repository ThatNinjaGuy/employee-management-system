<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Commission Data</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>All Commission Data</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Payroll Month</th>
                        <th>Total Days Worked (Skilled)</th>
                        <th>Total Days Worked (Unskilled)</th>
                        <th>Rate (Skilled)</th>
                        <th>Rate (Unskilled)</th>
                        <th>Total Amount (Skilled)</th>
                        <th>Total Amount (Unskilled)</th>
                        <th>Supplier Personal Amount Credited</th>
                        <th>Supplier Personal Group Costing</th>
                        <th>Net Amount</th>
                        <th>Total Skilled Employees</th>
                        <th>Total Unskilled Employees</th>
                        <th>Supplier Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../includes/dbconn.php');

                    // Check if supplier_id is provided in the URL
                    if (isset($_GET['supplier_id'])) {
                        $supplier_id = $_GET['supplier_id'];

                        // Fetch the supplier name based on the supplier_id
                        $sql_supplier = "SELECT name FROM tblsupplier WHERE id = :supplier_id";
                        $stmt_supplier = $dbh->prepare($sql_supplier);
                        $stmt_supplier->bindParam(':supplier_id', $supplier_id, PDO::PARAM_INT);
                        $stmt_supplier->execute();
                        $supplier_name = $stmt_supplier->fetchColumn();

                        // Fetch all commission data for the selected supplier
                        $sql_commission = "SELECT * FROM comissionData WHERE supplierName = :supplier_name";
                        $stmt_commission = $dbh->prepare($sql_commission);
                        $stmt_commission->bindParam(':supplier_name', $supplier_name, PDO::PARAM_STR);
                        $stmt_commission->execute();
                        $commissions = $stmt_commission->fetchAll(PDO::FETCH_ASSOC);

                        // Output the commission data in a table
                        foreach ($commissions as $commission) {
                            echo "<tr>";
                            echo "<td>" . $commission['payrollMonth'] . "</td>";
                            echo "<td>" . $commission['totalDaysWorkedSkilled'] . "</td>";
                            echo "<td>" . $commission['totalDaysWorkedUnskilled'] . "</td>";
                            echo "<td>" . $commission['rateSkilled'] . "</td>";
                            echo "<td>" . $commission['rateUnskilled'] . "</td>";
                            echo "<td>" . $commission['totalAmountSkilled'] . "</td>";
                            echo "<td>" . $commission['totalAmountUnskilled'] . "</td>";
                            echo "<td>" . $commission['supplierPersonalAmountCredited'] . "</td>";
                            echo "<td>" . $commission['supplierPersonalGroupCosting'] . "</td>";
                            echo "<td>" . $commission['netAmount'] . "</td>";
                            echo "<td>" . $commission['totalSkilledEmployees'] . "</td>";
                            echo "<td>" . $commission['totalUnskilledEmployees'] . "</td>";
                            echo "<td>" . $commission['supplierName'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>No supplier ID provided</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
