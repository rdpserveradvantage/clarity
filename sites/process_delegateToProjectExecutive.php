<? include('config.php');

$atmid = $_REQUEST['atmid'];
$siteid = $_REQUEST['siteid'];
$engineer = $_REQUEST['engineer'];
$redelegate = $_REQUEST['action'];

$vendor = $RailTailVendorID;
$vendorName = getVendorName($vendor);
$projectExecutive = $_REQUEST['projectExecutive'];
$projectExecutiveName = $_REQUEST['projectExecutiveName'];

    $statement = "insert into projectExecutiveDelegation(siteid,atmid,projectExecutiveId,status,created_at,vendorId,vendorName,created_by,isDelegatedToEngineer,projectExecutiveName) 
    values('".$siteid."','".$atmid."','".$projectExecutive."',1,'".$datetime."','".$RailTailVendorID."','".$RailTailVendorName."','".$userid."',0,'".$projectExecutiveName."')";
        
        if(mysqli_query($con,$statement)){
            $statement = "insert into delegation(siteid,engineerId,status,created_at,vendorId,vendorName,isVendor,created_by,atmid) 
                values('".$siteid."','".$projectExecutive."',1,'".$datetime."','".$RailTailVendorID."','".$RailTailVendorName."',0,'".$userid."','".$atmid."')";
                
            if(mysqli_query($con,"update sites set isDelegated=1, delegatedByVendor=1 where id='".$siteid."'")){
                mysqli_query($con,"insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by,portal) 
                        values('".$vendor."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."','Vendor')");
                echo json_encode(200);
                delegateToProjectExecutive($siteid,$atmid,'');
            }
    }else{
        echo json_encode(500);
    }


?>