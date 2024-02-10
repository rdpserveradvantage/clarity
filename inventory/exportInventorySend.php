<?php  include('../config.php');

// library
require '../vendor/autoload.php';

// Import necessary classes from PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Excel spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Define and execute your database query to fetch data
$exportSql = $_REQUEST['exportSql']; // Replace with your SQL query
$sql_app = mysqli_query($con, $exportSql); // Execute the SQL query

function getColumnLabel($index) {
    $base26 = '';

    if ($index >= 26) {
        $base26 .= chr(65 + ($index / 26) - 1);
    }
    
    // Calculate the second part of the label (A, B, C, ...)
    $base26 .= chr(65 + ($index % 26));
    
    return $base26;
}

// Define column headers
$headers = array(
    'Srno',
    'ATMID',
    'Status',
    'Actions',
    'Vendor',
    'Address',
    'Contact_Person',
    'Contact_Number',
    'POD',
    'Courier',
    'Remark',
    'Date',
);

$boqSql = mysqli_query($con, "select * from boq where status=1");
while ($boqSqlResult = mysqli_fetch_assoc($boqSql)) {
    $attributeAr[] = trim($boqSqlResult['value']);
    $headers[] = trim($boqSqlResult['value']);
}

// Set Header Styles
$headerStyle = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startcolor' => ['rgb' => 'FFA500'], // Change this color as needed
    ],
];

// Apply Header Styles
foreach ($headers as $index => $header) {
    $column = getColumnLabel($index);
    $sheet->setCellValue($column . '1', $header);
    $sheet->getStyle($column . '1')->applyFromArray($headerStyle);
}

// Initialize the row counter
$i = 2; // Start from row 2 for data
$serial_number = 1; // Initialize the serial number

// Add Data and Borders to Data Cells
$dataStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

while ($row = mysqli_fetch_assoc($sql_app)) {
    
     $id = $row['id'];
    $atmid = $row['atmid'];
    $isDelivered = $row['isDelivered'];
    $ifExistTrackingUpdate = $row['ifExistTrackingUpdate'];
    $vendorId = $row['vendorId'];
    $vendorName = getVendorName($vendorId);
    $address = $row['address'];
    $contactPerson = $row['contactPersonName'];
    $contactNumber = $row['contactPersonNumber'];
    $pod = $row['pod'];
    $courier = $row['courier'];
    $remark = $row['remark'];
    $date = $row['created_at'];

    $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . $atmid . "' and siteid='" . $siteid . "' order by id desc");
    if ($ifExistTrackingUpdateSqlResult = mysqli_fetch_assoc($ifExistTrackingUpdateSql)) {
        $ifExistTrackingUpdate = 1;
    } else {
        $ifExistTrackingUpdate = 0;
    }


    $sheet->setCellValue('A' . $i, $serial_number);
    $sheet->setCellValue('B' . $i, $atmid);
    $sheet->setCellValue('C' . $i, ($isDelivered == 1 ? 'Delivered' : 'In-Transit'));
    $sheet->setCellValue('D' . $i, ($ifExistTrackingUpdate == 1 ? '-' : '-'));
    $sheet->setCellValue('E' . $i, $vendorName);
    $sheet->setCellValue('F' . $i, $address);
    $sheet->setCellValue('G' . $i, $contactPerson);
    $sheet->setCellValue('H' . $i, $contactNumber);
    $sheet->setCellValue('I' . $i, $pod);
    $sheet->setCellValue('J' . $i, $courier);
    $sheet->setCellValue('K' . $i, $remark);
    $sheet->setCellValue('L' . $i, $date);

    $attributeColumn = 'M';
    foreach ($attributeAr as $attributeArKey => $attributeArVal) {
$detailsQuery = "SELECT COUNT(1) as total FROM material_send_details WHERE materialSendId = '".$id."' AND attribute LIKE '%" . mysqli_real_escape_string($con, $attributeArVal) . "%'";
        $detailsResult = mysqli_query($con, $detailsQuery);
    
        if ($detailsResult) {
            $detailsRow = mysqli_fetch_assoc($detailsResult);
            $count = $detailsRow['total'];
        } else {
            $count = 0;
        }
        
        
        $sheet->setCellValue($attributeColumn . $i, $count);
        $sheet->getStyle($attributeColumn . $i)->applyFromArray($dataStyle);
        $attributeColumn++;
    }

    $i++;
    $serial_number++;
}

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventory.xlsx"');
header('Cache-Control: max-age=0');

// Create a writer to save the Excel file
$writer = new Xlsx($spreadsheet);

// Save the Excel file to a temporary location
$tempFile = tempnam(sys_get_temp_dir(), 'Inventory');
$writer->save($tempFile);

// Provide the file as a download to the user
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="SentMaterial.xlsx"');
header('Cache-Control: max-age=0');
readfile($tempFile);

// Close the database connection
mysqli_close($con);

// Clean up and delete the temporary file
unlink($tempFile);
