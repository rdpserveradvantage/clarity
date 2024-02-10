<? include('config.php');

$siteid = $_REQUEST['siteid'];
$reason = $_REQUEST['reason'];

if($userid && !empty($userid)){
    
}else{
   $userid = $_REQUEST['userid']; 
}

$sql = "update sites set status=0 where id='".$siteid."'";
if(mysqli_query($con,$sql)){
    
    $getsitesql = mysqli_query($con,"select * from sites where id='".$siteid."'");
    $getsitesqlResult = mysqli_fetch_assoc($getsitesql);
    $atmid = $getsitesqlResult['atmid'];
    
    $inactiveSitesSql = "insert into inactiveSites(siteid,atmid,reason,created_at,created_by,status) 
    values('".$siteid."','".$atmid."','".$reason."','".$datetime."','".$userid."',1)";
        
        if(mysqli_query($con,$inactiveSitesSql)){
            echo json_encode(200);
        }else{
            echo json_encode(500);
        }
}else{
    echo json_encode(500);
}


?>