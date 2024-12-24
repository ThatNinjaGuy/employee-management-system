<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../includes/dbconn.php");
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Retrieve data from the payslip table
$sql = "SELECT * from tblemployees";// Adjust the SQL query according to your table structure
$query = $dbh->prepare($sql);
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
$sheet->setCellValue('E1', 'Gov ID');
$sheet->setCellValue('F1', 'Date Of Joining ');
$sheet->setCellValue('G1', 'Date Of Birth');
$sheet->setCellValue('H1', 'Gender');
$sheet->setCellValue('I1', 'Status');
$sheet->setCellValue('J1', 'Creation Date');

$row = 2; // Start writing data from the second row

// Insert data from the database into the Excel file
foreach ($results as $result) {
    $sheet->setCellValue('A' . $row, $result->id);
    $sheet->setCellValue('B' . $row, $result->FirstName); 
    $sheet->setCellValue('C' . $row, $result->LastName);
    $sheet->setCellValue('D' . $row, $result->rate);
    $sheet->setCellValue('E' . $row, $result->govID);
    $sheet->setCellValue('F' . $row, $result->doj);
    $sheet->setCellValue('G' . $row, $result->Dob);
    $sheet->setCellValue('H' . $row, $result->Gender);
    $sheet->setCellValue('I' . $row, $result->Status);
    $sheet->setCellValue('J' . $row, $result->CreationDate);

    $row++;
}

// Save the Excel file
$writer = new Xlsx($spreadsheet);
//$objWriter = new Xlsx($spreadsheet);
$fileName = 'employees_data.xlsx';
//$objWriter->save('/Applications/XAMPP/xamppfiles/htdocs/client-payroll/payslip_data.xlsx');

$writer->save($fileName);

// Set headers to initiate the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

// Output the Excel file for download
readfile($fileName);
