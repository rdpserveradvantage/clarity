<? include('../config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$siteId = $_REQUEST['siteId'];
$userid = $_REQUEST['userid'];

$givenDatetime = $_REQUEST['datetime'];
$givenDatetime = new DateTime($givenDatetime);
$givenDatetime = $givenDatetime->format("Y-m-d H:i:s");
$givenDatetime;
$type = $_REQUEST['type'];
$atmid = $_REQUEST['atmid'];


if($type=='ESD'){
    $update = "update sites set ESD='".$givenDatetime."' where id='".$siteId."'" ; 
    if(mysqli_query($con,$update)){
        engineerESD($siteId,$atmid,'');
        addSD($siteId,$atmid,$userid,$type,$givenDatetime);
        
        $data = ['statusCode'=>200,'response'=>'ESD Updated Successfully !'] ; 
    }else{
        $data = ['statusCode'=>500,'response'=>'ESD Updated Error !'] ;
    }
}else if($type=="ASD"){
    $update = "update sites set ASD='".$givenDatetime."' where id='".$siteId."'" ; 
    if(mysqli_query($con,$update)){
        engineerASD($siteId,$atmid,'');
        addSD($siteId,$atmid,$userid,$type,$givenDatetime);
        $data = ['statusCode'=>200,'response'=>'ASD Updated Successfully !'] ; 
    }else{
        $data = ['statusCode'=>500,'response'=>'ASD Updated Error !'] ;
    }
}

echo json_encode($data);
?>