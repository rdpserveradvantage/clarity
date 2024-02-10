<? include('../config.php');

$id = $_POST['id'];

if($id>0){

    $sql = "update vendor set status='0' where id ='".$id."'";
    if(mysqli_query($con,$sql)){
        // mysqli_query($con,"update vendorUsers set user_status=0 where vendorId='".$id."'");
        echo 1;
        
    }else{
        echo 0;
    }
}

?>