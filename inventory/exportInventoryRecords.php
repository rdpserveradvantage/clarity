<?php include('../config.php');

// Include PhpSpreadsheet library
require '../vendor/autoload.php';

// Import necessary classes from PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Excel spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventory.xlsx"');
header('Cache-Control: max-age=0');

// Define and execute your database query to fetch data
$exportSql = $_REQUEST['exportSql']; // Replace with your SQL query
$sql_app = mysqli_query($con, $exportSql); // Execute the SQL query



// Define column headers
$headers = array(
    'Sr_no',
    'material',
    'material_make',
    'model_no',
    'serial_no',
    'challan_no',
    'amount',
    'gst',
    'amount_with_gst',
    'courier_detail',
    'tracking_details',
    'date_of_receiving',
    'receiver_name',
    'vendor_name',
    'vendor_contact',
    'po_date',
    'po_number',
    'Type',
);

// Set headers in the Excel sheet
foreach ($headers as $index => $header) {
    $column = chr(65 + $index); // A, B, C, ...
    $sheet->setCellValue($column . '1', $header);
}

// Initialize the row counter
$i = 2; // Start from row 2 for data
$serial_number = 1; // Initialize the serial number

while ($row = mysqli_fetch_assoc($sql_app)) {
    // Define the fields you want to export
    $material = $row['material'];
    $material_make = $row['material_make'];
    $model_no = $row['model_no'];
    $serial_no = $row['serial_no'];
    $challan_no = $row['challan_no'];
    $amount = $row['amount'];
    $gst = $row['gst'];
    $amount_with_gst = $row['amount_with_gst'];
    $courier_detail = $row['courier_detail'];
    $tracking_details = $row['tracking_details'];
    $date_of_receiving = $row['date_of_receiving'];
    $receiver_name = $row['receiver_name'];
    $vendor_name = $row['vendor_name'];
    $vendor_contact = $row['vendor_contact'];
    $po_date = $row['po_date'];
    $po_number = $row['po_number'];
    $inventoryType = $row['inventoryType'];

    // Set the serial number in the first column
    $sheet->setCellValue('A' . $i, $serial_number);

    // Set the data in the remaining columns
    $sheet->setCellValue('B' . $i, $material);
    $sheet->setCellValue('C' . $i, $material_make);
    $sheet->setCellValue('D' . $i, $model_no);
    $sheet->setCellValue('E' . $i, $serial_no);
    $sheet->setCellValue('F' . $i, $challan_no);
    $sheet->setCellValue('G' . $i, $amount);
    $sheet->setCellValue('H' . $i, $gst);
    $sheet->setCellValue('I' . $i, $amount_with_gst);
    $sheet->setCellValue('J' . $i, $courier_detail);
    $sheet->setCellValue('K' . $i, $tracking_details);
    $sheet->setCellValue('L' . $i, $date_of_receiving);
    $sheet->setCellValue('M' . $i, $receiver_name);
    $sheet->setCellValue('N' . $i, $vendor_name);
    $sheet->setCellValue('O' . $i, $vendor_contact);
    $sheet->setCellValue('P' . $i, $po_date);
    $sheet->setCellValue('Q' . $i, $po_number); // Assuming Q for inventoryType
    $sheet->setCellValue('R' . $i, $inventoryType); // Assuming Q for inventoryType
    // Increment the row counter and serial number
    $i++;
    $serial_number++;
}


// Create a writer to save the Excel file
$writer = new Xlsx($spreadsheet);

// Save the Excel file to a temporary location
$tempFile = tempnam(sys_get_temp_dir(), 'Inventory');
$writer->save($tempFile);

// Provide the file as a download to the user
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventory.xlsx"');
header('Cache-Control: max-age=0');
readfile($tempFile);

// Close the database connection
mysqli_close($con);

// Clean up and delete the temporary file
unlink($tempFile);
?>
