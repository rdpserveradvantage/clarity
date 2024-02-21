<? include('../config.php');

$id = $_REQUEST['id'];

if ($id > 0) {
    if (mysqli_query($con, "update ipconfuration  set status = 0, updated_at='" . $datetime . "',updatedBy='" . $userid . "' where id='" . $id . "'")) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}


?>