<?php include('../config.php');

// Check if the record ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM boq WHERE id = $id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
}
?>
