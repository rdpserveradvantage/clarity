<? include('../config.php');

$atmid = $_REQUEST['atmid'];
$siteid = $_REQUEST['siteid'];
$engineer = $_REQUEST['engineer'];
$redelegate = $_REQUEST['action'];

$vendor = $RailTailVendorID;
$vendorName = getVendorName($vendor);


if(isset($redelegate) && !empty($redelegate)){
    
    $statement2 = "update delegation set status=0 where siteid='".$siteid."'";
    if(mysqli_query($con,$statement2)){
        
    }
    $statement = "insert into delegation(siteid,engineerId,status,created_at,vendorId,vendorName,isVendor,created_by,atmid) 
        values('".$siteid."','".$engineer."',1,'".$datetime."','".$RailTailVendorID."','".$RailTailVendorName."',1,'".$userid."','".$atmid."')";
        $engName = getUsername($engineer);
        if(mysqli_query($con,$statement)){
            
              mysqli_query($con,"insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by,portal) 
                    values('".$vendor."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."','Vendor')");
                    echo 202;
            delegateToEngineer($siteid,$atmid,'',$engName);
        }  
    }else{
        $statement = "insert into delegation(siteid,engineerId,status,created_at,vendorId,vendorName,isVendor,created_by,atmid) 
        values('".$siteid."','".$engineer."',1,'".$datetime."','".$RailTailVendorID."','".$RailTailVendorName."',1,'".$userid."','".$atmid."')";
        $engName = getUsername($engineer);
        
        if(mysqli_query($con,$statement)){
    
        if(mysqli_query($con,"update sites set isDelegated=1,delegatedByVendor=1 where id='".$siteid."'")){
            
            mysqli_query($con,"insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by,portal) 
                    values('".$vendor."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."','Vendor')");
            echo json_encode(200);
            delegateToEngineer($siteid,$atmid,'',$engName);
            
        }
    }

}

?>