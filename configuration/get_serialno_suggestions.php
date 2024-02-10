<?php include('../config.php');

if (isset($_POST['input'])) {
    $input = $_POST['input'];

     $query = "SELECT distinct(serial_no) as serial_no from inventory 
              WHERE serial_no like '%" . mysqli_real_escape_string($con, $input) . "%' AND material='Router'";
    $result = mysqli_query($con, $query);

    $suggestions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row['serial_no'];
    }

    echo json_encode($suggestions);
}
?>
