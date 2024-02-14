<?php include('../config.php');


$materialId = $_REQUEST['materialId'];

$getMaterialSql = mysqli_query($con, "Select * from inventory where id='" . $materialId . "'");
if ($getMaterialSqlResult = mysqli_fetch_assoc($getMaterialSql)) {

    $serializedAttributes = $getMaterialSqlResult['material'];
    $serializedValues = $getMaterialSqlResult['serial_no'];
    $serialNumber =  $serializedSerialNumbers = $getMaterialSqlResult['serial_no'];



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

    $query = "INSERT INTO material_send (atmid, siteid, vendorId, contactPersonName, contactPersonNumber, address, pod, courier, remark, lho, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssisssssss", $atmid, $siteid, $vendorId, $contactPersonName, $contactPersonNumber, $address, $pod, $courier, $remark, $lho,$userid);
    $stmt->execute();
    $stmt->close();

    $materialSendId = $con->insert_id;
    if ($materialSendId > 0) {
        $query = mysqli_query($con, "INSERT INTO material_send_details (materialSendId, attribute, value, serialNumber) 
        VALUES ('" . $materialSendId . "', '" . $serializedAttributes . "', '" . $serializedValues . "', '" . $serializedValues . "')");

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


        $vendorInventorySql = "insert into vendorInventory(vendorId, material, material_make, model_no, serial_no,  amount, gst, amount_with_gst, 
            courier_detail, tracking_details,  created_at, created_by, status) 
            values('" . $vendorId . "','" . $material . "', '" . $material_make . "', '" . $model_no . "', '" . $serial_no . "',  '" . $amount . "',
            '" . $gst . "', '" . $amount_with_gst . "', '" . $courier . "', '" . $po_number . "', '" . $datetime . "', '" . $userid . "',0)";

        $result = mysqli_query($con, $vendorInventorySql);

        if (!$result) {
            $response = ['status' => '500', 'message' => 'Error updating status in the Inventory table'];
        } else {
            $response = ['status' => '200', 'message' => 'Form data saved successfully'];
        }
    }
} else {
    $response = ['status' => '500', 'message' => 'Error updating status in the Inventory table'];
}



$con->close();
echo json_encode($response);
