<?php include('../config.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();



$exportSql = $_REQUEST['exportSql']; 
$sql_app = mysqli_query($con, $exportSql); 

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


// Define column headers
$headers = array(
    'SR NO',
    'ATMID',
    'CREATED_AT',
    'CREATED_BY',
    'REMARK',
    'VENDOR',
    'SCHEDULEATMENGINEERNAME',
    'SCHEDULEATMENGINEERNUMBER',
    'BANKPERSONNAME',
    'BANKPERSONNUMBER',
    'BACKROOMKEYPERSONNAME',
    'BACKROOMKEYPERSONNUMBER',
    'SCHEDULEDATE',
    'SCHEDULETIME',
    'SBITICKETID',
);


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

while ($sql_result = mysqli_fetch_assoc($sql_app)) {
    
    $siteid = $sql_result['siteid'];
    $atmid = $sql_result['atmid'];
    $status = $sql_result['status'];
    $created_at = $sql_result['created_at'];
    $created_by = $sql_result['created_by'];
    $isDone = $sql_result['isDone'];
    $remark = $sql_result['remark'];
    $vendor = $sql_result['vendor'];
    $portal = $sql_result['portal'];
    $isSentToEngineer = $sql_result['isSentToEngineer'];
    $scheduleAtmEngineerName = $sql_result['scheduleAtmEngineerName'];
    $scheduleAtmEngineerNumber = $sql_result['scheduleAtmEngineerNumber'];
    $bankPersonName = $sql_result['bankPersonName'];
    $bankPersonNumber = $sql_result['bankPersonNumber'];
    $backRoomKeyPersonName = $sql_result['backRoomKeyPersonName'];
    $backRoomKeyPersonNumber = $sql_result['backRoomKeyPersonNumber'];
    $scheduleDate = $sql_result['scheduleDate'];
    $scheduleTime = $sql_result['scheduleTime'];
    $sbiTicketId = $sql_result['sbiTicketId'];




    
     $sheet->getStyle('A' . $i . ':O' . $i)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'], // Border color (black)
            ],
        ],
    ]);
    
    
        $sheet->setCellValue('A' . $i , $serial_number ) ; 
        $sheet->setCellValue('B' . $i , $atmid ? $atmid : 'NA' ) ;  
        $sheet->setCellValue('C' . $i , $created_at ? $created_at : 'NA' ) ;  
        $sheet->setCellValue('D' . $i , getUsername($created_by,true) ? getUsername($created_by,true) : 'NA' ) ;  
        $sheet->setCellValue('E' . $i , $remark ? $remark : 'NA' ) ;  
        $sheet->setCellValue('F' . $i , getVendorName($vendor) ? getVendorName($vendor) : 'NA' ) ;  
        $sheet->setCellValue('G' . $i , $scheduleAtmEngineerName ? $scheduleAtmEngineerName : 'NA' ) ;  
        $sheet->setCellValue('H' . $i , $scheduleAtmEngineerNumber ? $scheduleAtmEngineerNumber : 'NA' ) ;  
        $sheet->setCellValue('I' . $i , $bankPersonName ? $bankPersonName : 'NA' ) ;  
        $sheet->setCellValue('J' . $i , $bankPersonNumber ? $bankPersonNumber : 'NA' ) ;  
        $sheet->setCellValue('K' . $i , $backRoomKeyPersonName ? $backRoomKeyPersonName : 'NA' ) ;  
        $sheet->setCellValue('L' . $i , $backRoomKeyPersonNumber ? $backRoomKeyPersonNumber : 'NA' ) ;  
        $sheet->setCellValue('M' . $i , $scheduleDate ? $scheduleDate : 'NA' ) ;  
        $sheet->setCellValue('N' . $i , $scheduleTime ? $scheduleTime : 'NA' ) ;  
        $sheet->setCellValue('O' . $i , $sbiTicketId ? $sbiTicketId : 'NA' ) ;  


    $i++;
    $serial_number++;
    
    
}

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
header('Content-Disposition: attachment;filename="Completed_Installation.xlsx"');
header('Cache-Control: max-age=0');
readfile($tempFile);

// Close the database connection
mysqli_close($con);

// Clean up and delete the temporary file
unlink($tempFile);
?>
