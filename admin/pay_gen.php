<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../includes/dbconn.php");
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$selectedPayrollId = isset($_GET['selectedPayrollId']) ? $_GET['selectedPayrollId'] : null;

if (!$selectedPayrollId) {
    // Handle error: selectedPayrollId is not provided
    // For example, redirect the user back to the view-payroll page
    header('Location: view-payroll.php');
    exit;
}

// Retrieve data from the payslip table
$sql = "SELECT payslip.*, tblemployees.FirstName, tblemployees.LastName, tblemployees.id AS employee_id
FROM payslip
LEFT JOIN tblemployees ON payslip.employeeSelect = tblemployees.id
LEFT JOIN payroll ON payslip.payrollID = payroll.id
WHERE payroll.id = :selectedPayrollId";// Adjust the SQL query according to your table structure
$query = $dbh->prepare($sql);
$query->bindParam(':selectedPayrollId', $selectedPayrollId, PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$styleArray = [
      'font' => [
        'bold' => true,
        'size' => 14, // Font size set to 14
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => ['argb' => 'FFA0A0A0'],
        'endColor' => ['argb' => 'FFFFFFFF'],
    ],
];

$sheet->getStyle('A1:M1')->applyFromArray($styleArray);

// Add headers to the Excel file
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'FirstName'); // If employee name is displayed in the table
$sheet->setCellValue('C1', 'LastName');
$sheet->setCellValue('D1', 'Rate');
$sheet->setCellValue('E1', 'No of Days Worked');
$sheet->setCellValue('F1', 'Total Amount');
$sheet->setCellValue('G1', 'Mess');
$sheet->setCellValue('H1', 'Advance');
$sheet->setCellValue('I1', 'Home Advance');
$sheet->setCellValue('J1', 'Sunday Expenditure');
$sheet->setCellValue('K1', 'Net Pay');
$sheet->setCellValue('L1', 'Creation Date');

$row = 2; // Start writing data from the second row

// Insert data from the database into the Excel file
foreach ($results as $result) {
    $sheet->setCellValue('A' . $row, $result->id);
    $sheet->setCellValue('B' . $row, $result->FirstName); 
    $sheet->setCellValue('C' . $row, $result->LastName);
    $sheet->setCellValue('D' . $row, $result->rateDisplay);
    $sheet->setCellValue('E' . $row, $result->daysWorked);
    $sheet->setCellValue('F' . $row, $result->totalAmountDisplay);
    $sheet->setCellValue('G' . $row, $result->mess);
    $sheet->setCellValue('H' . $row, $result->advance_in_site);
    $sheet->setCellValue('I' . $row, $result->advance_in_home);
    $sheet->setCellValue('J' . $row, $result->sunday_expenditure);
    $sheet->setCellValue('K' . $row, $result->net_pay);
    $sheet->setCellValue('L' . $row, $result->CreationDate);

    $row++;
}

// Save the Excel file
$writer = new Xlsx($spreadsheet);
//$objWriter = new Xlsx($spreadsheet);
$fileName = 'payslip_data.xlsx';
//$objWriter->save('/Applications/XAMPP/xamppfiles/htdocs/client-payroll/payslip_data.xlsx');

$writer->save($fileName);

// Set headers to initiate the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

// Output the Excel file for download
readfile($fileName);
