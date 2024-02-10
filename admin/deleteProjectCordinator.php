<?php include('../config.php');

$projectCordinatorId = $_REQUEST['projectCordinatorId'];

if (isset($projectCordinatorId) && $projectCordinatorId > 0) {
    $sql = "update projectcoordinator set status=0 where id='" . $projectCordinatorId . "'";
    if (mysqli_query($con, $sql)) {
        echo 1;
    } else {
        echo 0;
    }

} else {
    echo 0;
}
?>