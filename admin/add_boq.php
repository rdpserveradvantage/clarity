<?php
header("Content-Type: application/json");

include('../config.php');
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method Not Allowed"));
    exit();
}


$data = json_decode(file_get_contents("php://input"), true);
$boq_name = $data["boq_name"];
$quantity = $data["quantity"];
$needSerialNumber = $data['needSerialNumber'];

$attribute = strtolower($boq_name);
$attribute = str_replace(' ', '_', $boq_name);

$sql = "INSERT INTO boq (attribute, value, count, status,needSerialNumber) VALUES ('$attribute', '$boq_name', '$quantity', 1,'".$needSerialNumber."')";

if (mysqli_query($con, $sql)) {

    echo json_encode(array('status'=>200,"message" => "BoQ added successfully"));
} else {

    echo json_encode(array('status'=>500,"message" => "Error adding BoQ"));
}

?>
