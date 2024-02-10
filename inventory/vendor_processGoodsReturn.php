<? include('../config.php');

$serializedAttributes = $_POST['attribute'];
$serializedValues = $_POST['values'];
$serializedSerialNumbers = $_POST['serialNumbers'];

$attributes = unserialize($serializedAttributes);
$values = unserialize($serializedValues);
$serialNumbers = unserialize($serializedSerialNumbers);

$materialSendIDParent = $_POST['materialSendID'];

$atmid = $_POST['atmid'];
$siteid = $_POST['siteid'];
$vendorId = $_POST['vendorId'];
$contactPersonName = $_POST['contactPersonName'];
$contactPersonNumber = $_POST['contactPersonNumber'];
$address = $_POST['address'];
$pod = $_POST['POD'];
$courier = $_POST['courier'];
$remark = $_POST['remark'];


$statement = "insert into goodreturn(materialSendID,siteid,atmid,created_at,created_by,portal,status,remarks,contactPersonName,contactPersonNumber,address,pod,courier) 
values('" . $materialSendIDParent . "','" . $siteid . "','" . $atmid . "','" . $datetime . "','" . $userid . "','vendor','1','" . $remark . "','" . $contactPersonName . "','" . $contactPersonNumber . "','" . $address . "','" . $pod . "','" . $courier . "')";
if (mysqli_query($con, $statement)) {
    $insert_id = $con->insert_id;

    
    for ($i = 0; $i < count($attributes); $i++) {
        mysqli_query($con, "insert into goodreturndetails(goodReturnID,material,serialNumber) 
        values('" . $insert_id . "','" . $attributes[$i] . "','" . $serialNumbers[$i] . "')");
    
    
    
    }

    $response = ['status' => '200', 'message' => 'Form data saved successfully'];

} else {

    $response = ['status' => '500', 'message' => 'Error updating status in the Inventory'];
}


$con->close();

echo json_encode($response);
?>