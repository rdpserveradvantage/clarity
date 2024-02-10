<?php include('../config.php');


$materialName = $_REQUEST['attribute'];
$requestId = $_REQUEST['id'];
$material_qty = $_REQUEST['material_qty'];

$invIdAr = array();
$serialNumberAr = array();

for ($i = 0; $i < $material_qty; $i++) {
    $getMaterialSql = mysqli_query($con, "Select * from inventory where material like '" . trim($materialName) . "' and status=1 order by id asc");
    if ($getMaterialSqlResult = mysqli_fetch_assoc($getMaterialSql)) {
        $invId = $getMaterialSqlResult['id'];

        $serializedAttributes = $getMaterialSqlResult['material'];
        $serializedValues = $getMaterialSqlResult['serial_no'];
        $serialNumber = $serializedSerialNumbers = $getMaterialSqlResult['serial_no'];

        mysqli_query($con, "update inventory set status=0 where id='" . $invId . "'");
        $invIdAr[] = $invId;
        $serialNumberAr[] = $serialNumber;
    }
}

$invIdArray = $invIdAr;
$invIdAr = implode(',', $invIdAr);

$serialNumberArray = $serialNumberAr;
$serialNumberAr = implode(',', $serialNumberAr);


$atmid = $_POST['atmid'];
$siteid = $_POST['siteid'];
$vendorId = $_POST['vendorId'];
$contactPersonName = $_POST['contactPersonName'];
$contactPersonNumber = $_POST['contactPersonNumber'];
$address = $_POST['address'];
$pod = $_POST['POD'];
$courier = $_POST['courier'];
$remark = $_POST['remark'];

$lho = mysqli_fetch_assoc(mysqli_query($con,"select LHO from sites where id='".$siteid."'"))['LHO'];
$query = "INSERT INTO material_send (atmid, siteid, vendorId, contactPersonName, contactPersonNumber, address, pod, courier, remark,material_qty,invID,lho) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($query);
$stmt->bind_param("ssissssssis", $atmid, $siteid, $vendorId, $contactPersonName, $contactPersonNumber, $address, $pod, $courier, $remark, $material_qty, $invIdAr,$lho);
$stmt->execute();
$stmt->close();
$materialSendId = $con->insert_id;



if ($materialSendId > 0) {
    foreach ($serialNumberArray as $k => $v) {
        $query = mysqli_query($con, "INSERT INTO material_send_details (materialSendId, attribute, value, serialNumber) 
            VALUES ('" . $materialSendId . "', '" . $serializedAttributes . "', '" . $v . "', '" . $v . "')");


        $inventorySql = mysqli_query($con, "select * from Inventory where serial_no='" . $v . "'");
        $inventorySqlResult = mysqli_fetch_assoc($inventorySql);

        $material = $inventorySqlResult['material'];
        $material_make = $inventorySqlResult['material_make'];
        $model_no = $inventorySqlResult['model_no'];
        $serial_no = $inventorySqlResult['serial_no'];
        $challan_no = $inventorySqlResult['challan_no'];
        $amount = $inventorySqlResult['amount'];
        $gst = $inventorySqlResult['gst'];
        $amount_with_gst = $inventorySqlResult['amount_with_gst'];

        $vendorInventorySql = "insert into vendorInventory(vendorId, material, material_make, model_no, serial_no,  amount, gst, amount_with_gst, 
                courier_detail, tracking_details,  created_at, created_by, status) 
                values('" . $vendorId . "','" . $material . "', '" . $material_make . "', '" . $model_no . "', '" . $serialNumberAr . "',  '" . $amount . "',
                '" . $gst . "', '" . $amount_with_gst . "', '" . $courier . "', '" . $po_number . "', '" . $datetime . "', '" . $userid . "',0)";

        $result = mysqli_query($con, $vendorInventorySql);
        mysqli_query($con, "update vendormaterialrequest set sentFromInventory=1,sentFromInventoryBy='" . $userid . "',sentFromInventoryDate='" . $datetime . "' where id='" . $requestId . "' ");

        mysqli_query($con, "insert into vendorMaterialSend(atmid,siteid,vendorId,isService,status,materialSendId) values('" . $atmid . "','" . $siteid . "','" . $vendorId . "',1,0,'" . $materialSendId . "')");
        $thisvendorMaterialSendID = $con->insert_id;
    
        mysqli_query($con, "insert into vendorMaterialSenddetails(materialSendId,attribute,value,serialNumber) values('" . $thisvendorMaterialSendID . "','" . $material . "','" . $serial_no . "','" . $serial_no . "')");
    
    }



    $response = ['status' => '200', 'message' => 'Form data saved successfully'];

} else {
    $response = ['status' => '500', 'message' => 'Error updating status in the Inventory table'];
}



echo json_encode($response);

$con->close();