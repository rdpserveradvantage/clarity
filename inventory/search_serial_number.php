<? include('../config.php');

$searchValue = $_GET['value'];
$material = $_GET['material'];

$sql = "SELECT serial_no FROM Inventory WHERE serial_no LIKE '%$searchValue%' AND material = '$material' AND status = 1";

$stmt = $con->prepare($sql);
$stmt->execute();

$stmt->bind_result($serialNumber);

$serialNumbers = array();

while ($stmt->fetch()) {
    $serialNumbers[] = $serialNumber;
}

$stmt->close();
$con->close();


header('Content-Type: application/json');
echo json_encode($serialNumbers);
