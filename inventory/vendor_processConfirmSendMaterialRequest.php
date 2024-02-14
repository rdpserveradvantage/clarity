<?php include('../config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$serializedAttributes = $_POST['attribute'];
$serializedValues = $_POST['values'];
$serializedSerialNumbers = $_POST['serialNumbers'];

$attributes = unserialize($serializedAttributes);
// var_dump($attributes);

$values = unserialize($serializedValues);
$serialNumbers = unserialize($serializedSerialNumbers);

$atmid = $_POST['atmid'];
$siteid = $_POST['siteid'];
$vendorId = $_POST['vendorId'];
$contactPersonName = $_POST['contactPersonName'];
$contactPersonNumber = $_POST['contactPersonNumber'];
$address = $_POST['address'];
$pod = $_POST['POD'];
$courier = $_POST['courier'];
$remark = $_POST['remark'];
$portal = 'vendor';

$prematerialSendId = $_REQUEST['materialSendID'] ; 

$withoutSerialAttributes = $withSerialAttributes = array();

foreach ($attributes as $attributesKey => $attributesVal) {
    $sql = mysqli_query($con, "Select * from boq where needSerialNumber=1 and value like '" . trim($attributesVal) . "'");
    if ($sqlResult = mysqli_fetch_assoc($sql)) {
        $withSerialAttributes[] = $sqlResult['value'];
    } else {
        $withoutSerialAttributes[] = trim($attributesVal);
    }
}



foreach ($serialNumbers as $serialNumbersKey => $serialNumbersVal) {
    $serialNumbersValAr[] = $serialNumbersVal;
}

$lho = mysqli_fetch_assoc(mysqli_query($con, "select LHO from sites where id='" . $siteid . "'"))['LHO'];



$query = "INSERT INTO material_send (atmid, siteid, vendorId, contactPersonName, contactPersonNumber, address, pod, courier, remark, portal, lho, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($query);

$stmt->bind_param("sissssssssss", $atmid, $siteid, $vendorId, $contactPersonName, $contactPersonNumber, $address, $pod, $courier, $remark, $portal, $lho, $userid);
$stmt->execute();
$stmt->close();



$materialSendId = $con->insert_id;
mysqli_query($con, "update material_requests set status='Material Sent' where siteid='" . $siteid . "' and isProject=1");



mysqli_query($con, "insert into vendorMaterialSend(atmid,siteid,vendorId,isService,status,materialSendId,isProject,contactPersonName,contactPersonNumber
) 
values('" . $atmid . "','" . $siteid . "','" . $vendorId . "',0,1,'" . $prematerialSendId . "',1,'".$contactPersonName."','".$contactPersonNumber
."')");
$vendorMaterialSendId = $con->insert_id;


$counter = 0;
foreach ($withSerialAttributes as $withSerialKey => $withSerialValue) {
    if ($withSerialValue == 'Router') {
        $routerSerial = $serialNumbersValAr[$counter];
    }
    $query = mysqli_query($con, "INSERT INTO material_send_details (materialSendId, attribute, value, serialNumber) 
    VALUES ('" . $materialSendId . "', '" . $withSerialValue . "', '" . $serialNumbersValAr[$counter] . "', '" . $serialNumbersValAr[$counter] . "')");
    $materialNameAr[] = $withSerialValue;
    $serialNumberAr[] = $serialNumbersValAr[$counter];

    mysqli_query($con, "insert into vendorMaterialSenddetails(materialSendId,attribute,value,serialNumber) 
    values('" . $vendorMaterialSendId . "','" . $withSerialValue . "','" . $serialNumbersValAr[$counter] . "','" . $serialNumbersValAr[$counter] . "')");

    $counter++;

}

foreach ($withoutSerialAttributes as $withoutSerialKeys => $withoutSerialValues) {


    $checkinventory = mysqli_query($con, "select * from inventory where material like '%" . $withoutSerialValues . "' and status=1 and serial_no='' order by id asc");
    if ($checkinventoryResult = mysqli_fetch_assoc($checkinventory)) {
        $invId = $checkinventoryResult['id'];
        $lowercaseItemName = strtolower($withoutSerialValues);
        $thisNewGeneratedSerialNumber = $routerSerial . '_' . str_replace(' ', '_', $lowercaseItemName);

        $query = mysqli_query($con, "INSERT INTO material_send_details (materialSendId, attribute, value, serialNumber) 
        VALUES ('" . $materialSendId . "', '" . $withoutSerialValues . "', '" . $thisNewGeneratedSerialNumber . "', '" . $thisNewGeneratedSerialNumber . "')");
        $invUpdate = mysqli_query($con, "update inventory set serial_no ='" . $thisNewGeneratedSerialNumber . "',status=0 where id='" . $invId . "'");
        $materialNameAr[] = $withoutSerialValues;
        $serialNumberAr[] = $thisNewGeneratedSerialNumber;


        mysqli_query($con, "insert into vendorMaterialSenddetails(materialSendId,attribute,value,serialNumber) values('" . $vendorMaterialSendId . "','" . $withSerialValue . "','" . $serialNumbersValAr[$counter] . "','" . $serialNumbersValAr[$counter] . "')");

    }
}

sendMaterialToVendor($siteid, $atmid, '');

if (!empty($serialNumberAr)) {

    foreach ($serialNumberAr as $serialNumber) {
        $inventorySql = mysqli_query($con, "select * from Inventory where serial_no='" . $serialNumber . "'");
        $inventorySqlResult = mysqli_fetch_assoc($inventorySql);

        $material = $inventorySqlResult['material'];
        $material_make = $inventorySqlResult['material_make'];
        $model_no = $inventorySqlResult['model_no'];
        $serial_no = $inventorySqlResult['serial_no'];
        $challan_no = $inventorySqlResult['challan_no'];
        $amount = $inventorySqlResult['amount'];
        $gst = $inventorySqlResult['gst'];
        $amount_with_gst = $inventorySqlResult['amount_with_gst'];


        $enginventorySql = "insert into enginventory(eng_userid, material, material_make, model_no, serial_no,  amount, gst, amount_with_gst, 
        courier_detail, tracking_details,  created_at, created_by, status,material_send_id) 
        values('" . $contactPersonName . "','" . $material . "', '" . $material_make . "', '" . $model_no . "', '" . $serial_no . "',  '" . $amount . "',
        '" . $gst . "', '" . $amount_with_gst . "', '" . $courier . "', '" . $pod . "', '" . $datetime . "', '" . $userid . "',0,'" . $materialSendId . "')";

        $result = mysqli_query($con, $enginventorySql);

        if (!$result) {
            $response = ['status' => '500', 'message' => 'Error updating status in the Inventory table'];

        } else {

            $response = ['status' => '200', 'message' => 'Form data saved successfully'];
        }
    }
}



echo json_encode($response);
