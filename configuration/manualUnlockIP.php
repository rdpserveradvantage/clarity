<?php include('../config.php');

$ipID = $_REQUEST['ipID'];
if ($ipID > 0) {
    if (mysqli_query($con, "UPDATE ips SET isLocked=0 WHERE id=$ipID")) {
        echo 1;
    } else {
        echo 0;
    }

}

?>