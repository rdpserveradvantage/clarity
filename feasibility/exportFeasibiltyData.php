<?php include('../config.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Feasibility Data.xlsx"');
header('Cache-Control: max-age=0');


function getColumnLabel($index) {
    $base26 = '';
    if ($index >= 26) {
        $base26 .= chr(65 + ($index / 26) - 1);
    }    
    $base26 .= chr(65 + ($index % 26));
    return $base26;
}


$exportSql = $_REQUEST['exportSql']; // Replace with your SQL query
$sql_app = mysqli_query($con, $exportSql); // Execute the SQL query


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
    'Sr No',
    'Feasibility Done',
    'No Of Atm',
    'ATMID1',
    'Address',
    'City',
    'Location',
    'LHO',
    'state',
    'atm1 Status',
    'atm2 Status',
    'atm3 Status',
    'Operator',
    'signal Status',
    'Operator 2',
    'signal Status 2',
    'backroom Network Remark',
    'Antenna Routing detail',
    'EM Lock Password',
    'EM lock Available',
    'No Of Ups',
    'Password Received',
    'Remarks',
    'UPS Available',
    'UPS Batery Backup',
    'UPS Working1',
    'UPS Working2',
    'UPS Working3',
    'backroom Disturbing Material',
    'backroom Disturbing Material Remark',
    'backroom Key Name',
    'backroom Key Number',
    'backroom Key Status',
    'earthing',
    'earthing Vltg',
    'frequent Power Cut',
    'frequent Power Cut From',
    'frequent Power Cut Remark',
    'frequent Power Cut To',
    'nearest Shop Distance',
    'nearest Shop Name',
    'nearest Shop Number',
    'power Fluctuation EN',
    'power Fluctuation PE',
    'power Fluctuation PN',
    'power Socket Availability',
    'router Antena Position',
    'created at',
    'Created By',
);


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

$dataStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];


foreach ($headers as $index => $header) {
    $column = getColumnLabel($index);
    $sheet->setCellValue($column . '1', $header);
    $sheet->getStyle($column . '1')->applyFromArray($headerStyle);
}


$i = 2; 
$serial_number = 1; 

while ($row = mysqli_fetch_assoc($sql_app)) {
    
   
    $isVendor = $row['isVendor'];
                                            
    

     $sheet->getStyle('A' . $i . ':AW' . $i)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'], // Border color (black)
            ],
        ],
    ]);
    

    // Set the serial number in the first column
    $sheet->setCellValue('A' . $i, $serial_number);

    // Set the data in the remaining columns
    $sheet->setCellValue('B' . $i, ($row['feasibilityDone'] ? $row['feasibilityDone'] : 'NA'));
    $sheet->setCellValue('C' . $i, ($row['noOfAtm'] ? $row['noOfAtm'] : 'NA'));
    $sheet->setCellValue('D' . $i, ($row['ATMID1'] ? $row['ATMID1'] : 'NA'));
    $sheet->setCellValue('E' . $i, ($row['address'] ? $row['address'] : 'NA'));
    $sheet->setCellValue('F' . $i, ($row['city'] ? $row['city'] : 'NA'));
    $sheet->setCellValue('G' . $i, ($row['location'] ? $row['location'] : 'NA'));
    $sheet->setCellValue('H' . $i, ($row['LHO'] ? $row['LHO'] : 'NA'));
    $sheet->setCellValue('I' . $i, ($row['state'] ? $row['state'] : 'NA'));
    $sheet->setCellValue('J' . $i, ($row['atm1Status'] ? $row['atm1Status'] : 'NA'));
    $sheet->setCellValue('K' . $i, ($row['atm2Status'] ? $row['atm2Status'] : 'NA'));
    $sheet->setCellValue('L' . $i, ($row['atm3Status'] ? $row['atm3Status'] : 'NA'));
    $sheet->setCellValue('M' . $i, ($row['operator'] ? $row['operator'] : 'NA'));
    $sheet->setCellValue('N' . $i, ($row['signalStatus'] ? $row['signalStatus'] : 'NA'));
    $sheet->setCellValue('O' . $i, ($row['operator2'] ? $row['operator2'] : 'NA'));
    $sheet->setCellValue('P' . $i, ($row['signalStatus2'] ? $row['signalStatus2'] : 'NA')); 
    $sheet->setCellValue('Q' . $i, ($row['backroomNetworkRemark'] ? $row['backroomNetworkRemark'] : 'NA')); 
    $sheet->setCellValue('R' . $i, ($row['AntennaRoutingdetail'] ? $row['AntennaRoutingdetail'] : 'NA')); 
    $sheet->setCellValue('S' . $i, ($row['EMLockPassword'] ? $row['EMLockPassword'] : 'NA')); 
    $sheet->setCellValue('T' . $i, ($row['EMlockAvailable'] ? $row['EMlockAvailable'] : 'NA')); 
    $sheet->setCellValue('U' . $i, ($row['NoOfUps'] ? $row['NoOfUps'] : 'NA')); 
    $sheet->setCellValue('V' . $i, ($row['PasswordReceived'] ? $row['PasswordReceived'] : 'NA')); 
    $sheet->setCellValue('W' . $i, ($row['Remarks'] ? $row['Remarks'] : 'NA')); 
    $sheet->setCellValue('X' . $i, ($row['UPSAvailable'] ? $row['UPSAvailable'] : 'NA')); 
    $sheet->setCellValue('Y' . $i, ($row['UPSBateryBackup'] ? $row['UPSBateryBackup'] : 'NA')); 
    $sheet->setCellValue('Z' . $i, ($row['UPSWorking1'] ? $row['UPSWorking1'] : 'NA')); 
    $sheet->setCellValue('AA' . $i, ($row['UPSWorking2'] ? $row['UPSWorking2'] : 'NA')); 
    $sheet->setCellValue('AB' . $i, ($row['UPSWorking3'] ? $row['UPSWorking3'] : 'NA')); 
    $sheet->setCellValue('AC' . $i, ($row['backroomDisturbingMaterial'] ? $row['backroomDisturbingMaterial'] : 'NA')); 
    $sheet->setCellValue('AD' . $i, ($row['backroomDisturbingMaterialRemark'] ? $row['backroomDisturbingMaterialRemark'] : 'NA')); 
    $sheet->setCellValue('AE' . $i, ($row['backroomKeyName'] ? $row['backroomKeyName'] : 'NA')); 
    $sheet->setCellValue('AF' . $i, ($row['backroomKeyNumber'] ? $row['backroomKeyNumber'] : 'NA')); 
    $sheet->setCellValue('AG' . $i, ($row['backroomKeyStatus'] ? $row['backroomKeyStatus'] : 'NA')); 
    $sheet->setCellValue('AH' . $i, ($row['earthing'] ? $row['earthing'] : 'NA')); 
    $sheet->setCellValue('AI' . $i, ($row['earthingVltg'] ? $row['earthingVltg'] : 'NA')); 
    $sheet->setCellValue('AJ' . $i, ($row['frequentPowerCut'] ? $row['frequentPowerCut'] : 'NA')); 
    $sheet->setCellValue('AK' . $i, ($row['frequentPowerCutFrom'] ? $row['frequentPowerCutFrom'] : 'NA')); 
    $sheet->setCellValue('AL' . $i, ($row['frequentPowerCutRemark'] ? $row['frequentPowerCutRemark'] : 'NA')); 
    $sheet->setCellValue('AM' . $i, ($row['frequentPowerCutTo'] ? $row['frequentPowerCutTo'] : 'NA')); 
    $sheet->setCellValue('AN' . $i, ($row['nearestShopDistance'] ? $row['nearestShopDistance'] : 'NA')); 
    $sheet->setCellValue('AO' . $i, ($row['nearestShopName'] ? $row['nearestShopName'] : 'NA')); 
    $sheet->setCellValue('AP' . $i, ($row['nearestShopNumber'] ? $row['nearestShopNumber'] : 'NA')); 
    $sheet->setCellValue('AQ' . $i, ($row['powerFluctuationEN'] ? $row['powerFluctuationEN'] : 'NA')); 
    $sheet->setCellValue('AR' . $i, ($row['powerFluctuationPE'] ? $row['powerFluctuationPE'] : 'NA')); 
    $sheet->setCellValue('AS' . $i, ($row['powerFluctuationPN'] ? $row['powerFluctuationPN'] : 'NA')); 
    $sheet->setCellValue('AT' . $i, ($row['powerSocketAvailability'] ? $row['powerSocketAvailability'] : 'NA')); 
    $sheet->setCellValue('AU' . $i, ($row['routerAntenaPosition'] ? $row['routerAntenaPosition'] : 'NA')); 
    $sheet->setCellValue('AV' . $i, ($row['created_at'] ? $row['created_at'] : 'NA')); 
    $sheet->setCellValue('AW' . $i, (getUsername($row['created_by'], $isVendor) ? getUsername($row['created_by'], $isVendor) : 'NA')); 
    
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
