<?php include('../config.php');


$sql = "SELECT * FROM boq where status=1";
$result = mysqli_query($con, $sql);

$boqData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $boqData[] = $row;
}
echo json_encode($boqData);
?>
