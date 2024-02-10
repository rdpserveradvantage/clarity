<? include('../config.php');

$vendorid = $_REQUEST['vendor'];
$vendorName = getVendorName($vendorid);

$atmid = $_REQUEST['atmid'];
$atmid_ar = explode(' ', $atmid);


if (count($atmid_ar) > 0) {
    foreach ($atmid_ar as $atmidkey => $atmidvalue) {

        $check_sql = mysqli_query($con, "select id,atmid from sites where atmid='" . $atmidvalue . "' and status=1");
        if ($check_sql_result = mysqli_fetch_assoc($check_sql)) {
            $siteid = $check_sql_result['id'];
            $atmid;
            $vendorid;
            $vendorName;

            $delegateSql = "insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by) 
                values('" . $vendorid . "','" . $vendorName . "','" . $siteid . "','" . $atmidvalue . "',1,'" . $datetime . "','" . $userid . "')";
            if (mysqli_query($con, $delegateSql)) {

                loggingRecords('sites', $siteid, 'log_before');



                $sitessql = mysqli_query($con, "select * from sites where id='" . $siteid . "'");
                $sitessql_result = mysqli_fetch_assoc($sitessql);
                $lho = $sitessql_result['LHO'];

                $lhosql = mysqli_query($con, "select * from lho where lho='" . $lho . "'");
                $lhosql_result = mysqli_fetch_assoc($lhosql);
                $lhoid = $lhosql_result['id'];

                $updatesql2 = "insert into lhositesdelegation(lhoid,lhoName,siteid,atmid,status,created_at,created_by,portal) 
            values('" . $lhoid . "','" . $lho . "','" . $siteid . "','" . $atmidvalue . "',1,'" . $datetime . "','" . $userid . "','Clarity')";







                //    echo  $update = "update sites set isDelegated=1,delegatedToVendorId='".$vendorid."',delegatedToVendorName='".$vendorName."' where id='".$siteid."'" ; 
                if (mysqli_query($con, $updatesql2)) {
                    echo 'ATMID : ' . $atmidvalue . ' Delegated to ' . $vendorName . '<br />';
                    loggingRecords('sites', $siteid, 'log_after');
                    delegateToVendor($siteid, $atmidvalue, '');
                }

            }
        }
    }

} else {
    echo 'No Sites Selected !';
}


?>
<a href="sitestest.php">Back</a>