<?php include('../config.php');

$id = $_REQUEST['id'];

if(mysqli_query($con,"update routerconfiguration set status=0 where id='".$id."'")){
    echo '1';
}else{
    echo '0';
}



?>