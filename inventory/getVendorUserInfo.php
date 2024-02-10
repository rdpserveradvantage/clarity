<? include('../config.php');

$contactPerson = $_REQUEST['contactPerson'];

$sql = mysqli_query($con,"select * from user where userid='".$contactPerson."'");
if($sql_result = mysqli_fetch_assoc($sql)){
    
    $contact = $sql_result['contact'];
    $address = $sql_result['address'];
    
    $data = ['contact'=>$contact,'address'=>$address];
    
    echo json_encode($data);
    
}
?>