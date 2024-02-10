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
    'SERIAL NUMBER',
    'NETWORK IP',
    'ROUTER IP',
    'ATM IP',
    'CREATED AT',
    'CREATED BY',
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
    
    $atmid = $sql_result['atmid'];
    $serialNumber = $sql_result['serialNumber'];
    $sealNumber = $sql_result['sealNumber'];
    $created_at = $sql_result['created_at'];

    $ipconfurationSql = mysqli_query($con, "select * from ipconfuration where serial_no ='" . $serialNumber . "' and status=1 order by id desc");
    $ipconfurationSqlResult = mysqli_fetch_assoc($ipconfurationSql);
    $networkIP =  $ipconfurationSqlResult['network_ip'];
    $routerIP =  $ipconfurationSqlResult['router_ip'];
    $atmIP =  $ipconfurationSqlResult['atm_ip'];

    $created_by = $sql_result['created_by'];
    $created_by = getUsername($created_by, false);

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
        $sheet->setCellValue('C' . $i , $serialNumber ? $serialNumber : 'NA' ) ;
        $sheet->setCellValue('D' . $i , $networkIP ? $networkIP : 'NA' ) ;
        $sheet->setCellValue('E' . $i , $routerIP ? $routerIP : 'NA' ) ;
        $sheet->setCellValue('F' . $i , $atmIP ? $atmIP : 'NA' ) ;
        $sheet->setCellValue('G' . $i , $created_at ? $created_at : 'NA' ) ;
        $sheet->setCellValue('H' . $i , $created_by ? $created_by : 'NA' ) ;

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
header('Content-Disposition: attachment;filename="Router Configuration.xlsx"');
header('Cache-Control: max-age=0');
readfile($tempFile);

// Close the database connection
mysqli_close($con);

// Clean up and delete the temporary file
unlink($tempFile);
?>
