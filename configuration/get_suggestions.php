<?php include('../config.php');

if (isset($_POST['input'])) {
    $input = $_POST['input'];

     $query = "SELECT a.atmid FROM sites a
              WHERE a.atmid like '%" . mysqli_real_escape_string($con, $input) . "%'";

    $result = mysqli_query($con, $query);

    $suggestions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row['atmid'];
    }

    echo json_encode($suggestions);
}
?>
