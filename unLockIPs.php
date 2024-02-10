<?php
include('config.php');

$sql = mysqli_query($con, "SELECT * FROM ips WHERE isLocked=1 AND isAssign=0");

while ($sql_result = mysqli_fetch_assoc($sql)) {
    $id = $sql_result['id'];
    $lockedTime = strtotime($sql_result['lockedTime']); // Convert lockedTime to a Unix timestamp
    $currentTime = time(); // Get the current Unix timestamp
    $timeDifference = $currentTime - $lockedTime; // Calculate the time difference in seconds

    // Check if the time difference is greater than or equal to 15 minutes (900 seconds)
    if ($timeDifference >= 1800) {
            mysqli_query($con, "UPDATE ips SET isLocked=0 WHERE id=$id");
        // echo "Unlock IP (ID: $id)\n";
    } else {
        // echo "Noting (ID: $id)\n";
    }
}
?>
