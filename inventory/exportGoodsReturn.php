<?php include('../config.php');
error_reporting(0);
require '../vendor/autoload.php';


// Import necessary classes from PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$exportSql = $_REQUEST['exportSql'] ; 
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


$headers = array(
    'SRNO',
    'ATMID',
    'CONTACT PERSON',
    'CONTACT NUMBER',
    'POD',
    'COURIER',
    'REMARK',
    'DATE',
);

foreach ($headers as $index => $header) {
    $column = chr(65 + $index); // A, B, C, ...
    $sheet->setCellValue($column . '1', $header);
    $sheet->getStyle($column . '1')->applyFromArray($headerStyles); // Apply styles to the header cell
    $sheet->getColumnDimension($column)->setAutoSize(true); // Auto-fill column width
}



$i = 2;
$serial_number = 1;

while ($row = mysqli_fetch_assoc($sql_app)) {
    $id = $row['id'];
    $atmid = $row['atmid'];
    $contactPerson = $row['contactPersonName'];
    $contactNumber = $row['contactPersonNumber'];
    $pod = $row['pod'];
    $courier = $row['courier'];
    $remark = $row['remarks'];
    $date = $row['created_at'];

    // echo $serial_number ; 
    // echo $atmid ; 
    // echo $contactPerson ; 
    // echo $contactNumber ; 
    // echo $pod ;
    // echo $courier ; 
    // echo $remark ; 
    // echo $date ; 

    // echo '<br>';

    $sheet->setCellValue('A' . $i, $serial_number);
    $sheet->setCellValue('B' . $i, $atmid);
    $sheet->setCellValue('C' . $i, $contactPerson);
    $sheet->setCellValue('D' . $i, $contactNumber);
    $sheet->setCellValue('E' . $i, $pod);
    $sheet->setCellValue('F' . $i, $courier);
    $sheet->setCellValue('G' . $i, $remark);
    $sheet->setCellValue('H' . $i, $date);

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


ob_start(); // Start output buffering
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
$excelData = ob_get_contents(); 
ob_end_clean(); 


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=Goods_Return.xlsx');
header('Cache-Control: max-age=0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . strlen($excelData));

echo $excelData;

mysqli_close($con);
?>
