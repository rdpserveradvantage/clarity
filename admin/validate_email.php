<?php
include('../config.php');

$emailid = $_REQUEST['emailid'];
$sql = mysqli_query($con, "SELECT * FROM user WHERE uname='" . $emailid . "'");

if ($sql) {
    // Check if any rows are returned
    if (mysqli_num_rows($sql) > 0) {
        // Email ID is present in the table
        echo 0;
    } else {
        // Email ID is not present in the table
        echo 1;
    }
} else {
    // Error in the SQL query
    echo -1;
}

mysqli_close($con);
?>
