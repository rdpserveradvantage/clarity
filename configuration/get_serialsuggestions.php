<?php include('../config.php');

if (isset($_POST['input'])) {
    $input = $_POST['input'];

     $query = "SELECT serial_no FROM ipconfuration a
              WHERE a.serial_no like '%" . mysqli_real_escape_string($con, $input) . "%' AND a.status = 1";

    $result = mysqli_query($con, $query);

    $suggestions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row['serial_no'];
    }

    echo json_encode($suggestions);
}
?>
