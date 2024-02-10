<?php
// Include your database configuration file
include('../config.php');

// Include PhpSpreadsheet library
require '../vendor/autoload.php';

// Import necessary classes from PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Create a new Excel spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Define and execute your database query to fetch data
$exportSql = $_REQUEST['exportSql']; // Replace with your SQL query
$sql_app = mysqli_query($con, $exportSql); // Execute the SQL query

// Define column headers with coloring
$headerStyles = [
    'font' => [
        'bold' => true, // Make the text bold
        'color' => ['rgb' => 'FFFFFF'], // Font color (white)
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '0070C0'], // Background color (blue)
    ],
    'borders' => [
        'outline' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'], // Border color (black)
        ],
    ],
];

$headers = [
    'Sr_no',
    'Serial Number',
    'Router IP',
    'Network IP',
    'ATM IP',
    'Subnet IP',
    'Created AT',
    'Created By',
];

// Set headers in the Excel sheet with styles
foreach ($headers as $index => $header) {
    $column = chr(65 + $index); // A, B, C, ...
    $sheet->setCellValue($column . '1', $header);
    $sheet->getStyle($column . '1')->applyFromArray($headerStyles); // Apply styles to the header cell
    $sheet->getColumnDimension($column)->setAutoSize(true); // Auto-fill column width
}

// Initialize the row counter
$i = 2; // Start from row 2 for data
$serial_number = 1; // Initialize the serial number

while ($row = mysqli_fetch_assoc($sql_app)) {
    // Define the fields you want to export
    $serial_no = $row['serial_no'];
    $router_ip = $row['router_ip'];
    $network_ip = $row['network_ip'];
    $atm_ip = $row['atm_ip'];
    $subnet_ip = $row['subnet_ip'];
    $created_at = $row['created_at'];
    $created_by = $row['created_by'];
    $created_by = getUsername($created_by, false);

    $sheet->setCellValue('A' . $i, $serial_number);
    // Set the data in the remaining columns
    $sheet->setCellValue('B' . $i, $serial_no);
    $sheet->setCellValue('C' . $i, $router_ip);
    $sheet->setCellValue('D' . $i, $network_ip);
    $sheet->setCellValue('E' . $i, $atm_ip);
    $sheet->setCellValue('F' . $i, $subnet_ip);
    $sheet->setCellValue('G' . $i, $created_at);
    $sheet->setCellValue('H' . $i, $created_by);

    // Apply borders to the entire row
    $sheet->getStyle('A' . $i . ':H' . $i)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'], // Border color (black)
            ],
        ],
    ]);

    $i++;
    $serial_number++;
}

// Create a writer to save the Excel file
$writer = new Xlsx($spreadsheet);

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="IP Configuration.xlsx"');
header('Cache-Control: max-age=0');

// Save the Excel file to a temporary location
$tempFile = tempnam(sys_get_temp_dir(), 'IP Configuration');
$writer->save($tempFile);

// Provide the file as a download to the user
readfile($tempFile);

// Close the database connection
mysqli_close($con);

// Clean up and delete the temporary file
unlink($tempFile);
?>
