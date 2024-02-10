<? include('../config.php');

$response = array();

$siteids = $_REQUEST['siteid'];
$siteidar = explode(',', $siteids);
$atmid = $_REQUEST['atmid'];
$atmid = explode(',', $atmid);

$engineer = $_REQUEST['engineer'];
$redelegate = $_REQUEST['action'];
$delegateTo = $_REQUEST['delegateTo'];
$vendor = $_REQUEST['vendor'];
$vendorName = getVendorName($vendor);

$i = 0;

foreach ($siteidar as $siteidarkey => $siteid) {


    loggingRecords('sites', $siteid, 'log_before');
    // $updatesql = "update sites set isDelegated=1, delegatedToVendorId = '" . $vendor . "', 
    // delegatedToVendorName='" . $vendorName . "' where id='" . $siteid . "'";
    $delegationStatus = array(
        'siteid' => $siteid,
        'atmid' => $atmid[$i],
        'success' => false
    );

    $updatesql = "insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by,portal) 
        values('" . $vendor . "','" . $vendorName . "','" . $siteid . "','" . $atmid[$i] . "',1,'" . $datetime . "','" . $userid . "','Advantage')";

    // if (mysqli_query($con, $updatesql)) {

    if (mysqli_query($con, $updatesql)) {

        $sitessql = mysqli_query($con, "select * from sites where id='" . $siteid . "'");
        $sitessql_result = mysqli_fetch_assoc($sitessql);
        $lho = $sitessql_result['LHO'];

        $lhosql = mysqli_query($con, "select * from lho where lho='" . $lho . "'");
        $lhosql_result = mysqli_fetch_assoc($lhosql);
        $lhoid = $lhosql_result['id'];

        $updatesql2 = "insert into lhositesdelegation(lhoid,lhoName,siteid,atmid,status,created_at,created_by,portal) 
    values('" . $lhoid . "','" . $lho . "','" . $siteid . "','" . $atmid[$i] . "',1,'" . $datetime . "','" . $userid . "','Advantage')";
        mysqli_query($con, $updatesql2);
        loggingRecords('sites', $siteid, 'log_after');
        delegateToVendor($siteid, $atmid[$i], '');
        addNotification('Advantage', $userid, $vendor, ' 1 New Site Delegated ! ', $siteid, $atmid[$i]);
        $delegationStatus['success'] = true;

        mysqli_query($con,"update sites set isDelegated=1 where atmid='".$atmid[$i]."'");

        // echo $atmid[$i] . ' delegated Successfully ! <br />';
    }
    // }

    $response = $delegationStatus;
    $i++;
}

echo json_encode($response);

?>