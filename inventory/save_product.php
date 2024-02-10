<?php include('../config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if (isset($_POST['submit'])) {

    $inventoryType = $_REQUEST['inventoryType'];

    $date = date('Y-m-d h:i:s a', time());
    $only_date = date('Y-m-d');
    $target_dir = '../PHPExcel/';
    $file_name = $_FILES["excelFile"]["name"];
    $file_tmp = $_FILES["excelFile"]["tmp_name"];
    $file =  $target_dir.'/'.$file_name;
    $created_at = date('Y-m-d H:i:s');

    move_uploaded_file($file_tmp, $target_dir.'/'.$file_name);
    include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
    $inputFileName = $file;

    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
            $e->getMessage());
    }

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    for ($row = 1; $row <= $highestRow; $row++) {
        $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
    }

    $row = $row - 2;
    $error = '0';
    $contents = '';

    // Loop through the rows and insert data into the Inventory table
    for ($i = 1; $i <= $row; $i++) {
        $material = $rowData[$i][0][0];
        $material_make = $rowData[$i][0][1];
        $model_no = $rowData[$i][0][2];
        $serial_no = $rowData[$i][0][3];
        
        $challan_no = $rowData[$i][0][4];
        $amount = $rowData[$i][0][5];
        $gst = $rowData[$i][0][6];
        $amount_with_gst = $rowData[$i][0][7];
        $courier_detail = $rowData[$i][0][8];
        $tracking_details = $rowData[$i][0][9];
        $date_of_receiving = $rowData[$i][0][10];
        $receiver_name = $rowData[$i][0][11];
        $vendor_name = $rowData[$i][0][12];
        $vendor_contact = $rowData[$i][0][13];
        $po_date = $rowData[$i][0][14];
        $po_number = $rowData[$i][0][15];

        if(isset($serial_no) && $material=='Router'){
            $checkSerial = mysqli_query($con,"select * from inventory where serial_no='".$serial_no."'");
            if($checkSerialResult = mysqli_fetch_assoc($checkSerial)){
                echo $serial_no . ' Already exists <br>'  ; 
            }else{
                $sql = "INSERT INTO Inventory (material, material_make, model_no, serial_no, challan_no, amount, gst, amount_with_gst, courier_detail, tracking_details, date_of_receiving, receiver_name, vendor_name, vendor_contact, po_date, po_number, created_at,created_by,inventoryType)
                VALUES ('$material', '$material_make', '$model_no', '$serial_no', '$challan_no', $amount, $gst, $amount_with_gst, '$courier_detail', '$tracking_details', '$date_of_receiving', '$receiver_name', '$vendor_name', '$vendor_contact', '$po_date', '$po_number', '$created_at','$userid','$inventoryType')";
            }
        }else if($material!='Router' || $material!='router'){
            $sql = "INSERT INTO Inventory (material, material_make, model_no, serial_no, challan_no, amount, gst, amount_with_gst, courier_detail, tracking_details, date_of_receiving, receiver_name, vendor_name, vendor_contact, po_date, po_number, created_at,created_by,inventoryType)
            VALUES ('$material', '$material_make', '$model_no', '$serial_no', '$challan_no', $amount, $gst, $amount_with_gst, '$courier_detail', '$tracking_details', '$date_of_receiving', '$receiver_name', '$vendor_name', '$vendor_contact', '$po_date', '$po_number', '$created_at','$userid','$inventoryType')";

        }
        // Execute the query
        if (mysqli_query($con, $sql)) {
            echo 'Inventory data inserted successfully for row ' . $i . '<br>';
        } else {
            echo 'Error inserting inventory data for row ' . $i . ': ' . mysqli_error($con) . '<br>';
        }
    }
}
?>

<a href="stockIn.php">Back</a>
