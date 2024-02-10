<? include('../config.php');

$ipID = $_REQUEST['ipID'];
if ($ipID) {
    $sql = mysqli_query($con, "select * from ips where isAssign=0 and status=1 and id='" . $ipID . "'");
    if ($sql_result = mysqli_fetch_assoc($sql)) {
        echo 1;
    } else {
        echo 0;
    }

} else {
    echo 0;
}


?>