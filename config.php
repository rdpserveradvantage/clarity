<?php session_start();
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$base_url = "http://clarity.advantagesb.com/corona/";

$host = "10.63.21.6";
$user = "advantage";
$pass = "qwerty121";
$dbname = "adv";
// $dbname = "sarmicrosystems_advantage";


function connectToDatabase()
{
    global $host, $user, $pass, $dbname;

    $con = new mysqli($host, $user, $pass, $dbname);

    if ($con->connect_error) {
        die; // You might want to handle the connection error appropriately
    } else {
        return $con;
    }
}

function getConnectedDatabase()
{
    global $con;

    if (!$con || !$con->ping()) {
        $con = connectToDatabase();
    }

    return $con;
}

// Usage example:
$con = getConnectedDatabase();



if (!function_exists('vendorUsersData')) {

    function vendorUsersData($id,$parameter){
        global $con;
        // echo "select $parameter from user where userid ='".$id."'";
            $sql = mysqli_query($con,"select $parameter from user where userid ='".$id."'");
            $sql_result = mysqli_fetch_assoc($sql);
            return $sql_result[$parameter];

    }
}

if (!function_exists('getVendorName')) {

    function getVendorName($id)
    {
        global $con;
        $sql = mysqli_query($con, "select * from vendor where id ='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result['vendorName'];

    }
}

$ADVANTAGE_level = $_SESSION['ADVANTAGE_level'];
$ADVANTAGE_uname = $_SESSION['ADVANTAGE_uname'];
$username = $_SESSION['ADVANTAGE_username'];
define('PORTAL', 'CLARITY');

$_GLOBAL_VENDOR_ID = $_SESSION['vendor_id'];
$RailTailVendorID = $_GLOBAL_VENDOR_ID;
$RailTailVendorName = getVendorName($RailTailVendorID);



if($_SESSION['isVendor']==1){
    $_VENDOR_LOGIN = true;
}else {
    $_VENDOR_LOGIN = false;

}



if ($con->connect_error) {
    // die ; 
} else {
}


$getLhoSql = "select a.contactPersonEmail , b.lho from lhoADVContactDetails a INNER JOIN lho b ON a.lhoid = b.id where a.contactPersonEmail like '%" . $ADVANTAGE_uname . "%'";
$lhosql = mysqli_query($con, $getLhoSql);
$lhosqlResult = mysqli_fetch_assoc($lhosql);
$assignedLho = $lhosqlResult['lho'];


$userid = $_SESSION['ADVANTAGE_userid'];
$datetime = date('Y-m-d H:i:s');

$server_path = $_SERVER['DOCUMENT_ROOT'] . '/css/dash/esir/';

if ($userid > 0) {

    $assign_cust_sql = mysqli_query($con, "select cust_id,permission from user where userid ='" . $userid . "'");
    if ($assign_cust_sql_result = mysqli_fetch_assoc($assign_cust_sql)) {
        $assigned_customer = $assign_cust_sql_result['cust_id'];
    }

    $assigned_customer = explode(',', $assigned_customer);
    $assigned_customer = json_encode($assigned_customer);
    $assigned_customer = str_replace(array('[', ']', '"'), '', $assigned_customer);
    $assigned_customer = explode(',', $assigned_customer);
    $assigned_customer = "'" . implode("', '", $assigned_customer) . "'";
    $menuPermission = $assign_cust_sql_result['permission'];
    $menuPermissionAr = explode(',', $menuPermission);
}





if (!function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }
}


if (!function_exists('clean')) {
    function clean($string)
    {
        $string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
    }

}
if (!function_exists('remove_special')) {

    function remove_special($site_remark2)
    {
        $site_remark2_arr = explode(" ", $site_remark2);

        foreach ($site_remark2_arr as $k => $v) {
            $a[] = preg_split('/\n/', $v);
        }

        $site_remark = '';
        foreach ($a as $key => $value) {
            foreach ($value as $ke => $va) {
                $site_remark .= $va . " ";
            }
        }
        return clean($site_remark);
    }
}


if (!function_exists('getUsername')) {

    function getUsername($id, $vendor = FALSE)
    {
        global $con;

        $sql = mysqli_query($con, "select * from user where userid ='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result['name'];
    }
}


if (!function_exists('get_misstate')) {

    function get_misstate($id)
    {
        global $con;
        $sql = mysqli_query($con, "select * from sites where id='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result['state'];
    }

}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $requestData = json_encode($_REQUEST);
    $sessionData = json_encode($_SESSION);
    $fileData = json_encode($_FILES);

    $dataRecordsSql = "insert into dataRecords(requestData,sessionData,fileData,created_at,created_by) 
            values('" . $requestData . "','" . $sessionData . "','" . $fileData . "','" . $datetime . "','" . $userid . "')";

    mysqli_query($con, $dataRecordsSql);
}


// require_once 'log_functions.php';



function loggingRecords($tableName, $id, $logTableName)
{
    global $con, $userid, $datetime;
    $sql = "SELECT * FROM " . $tableName . " WHERE id = " . $id;
    $rowData = array();
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        foreach ($row as $columnName => $columnValue) {
            $rowData[$columnName] = $columnValue;
        }
    }
    $timestamp = $datetime;
    $status = "retrieved";
    $logSql = "INSERT INTO " . $logTableName . " (tableName, tableId, data, created_at, created_by, status,portal) 
               VALUES ('" . $tableName . "', " . $id . ", '" . json_encode($rowData) . "', '" . $timestamp . "', '" . $userid . "', '" . $status . "','" . PORTAL . "')";
    $con->query($logSql);
    return json_encode($rowData);
}


function logEvent($siteId, $atmid, $portal, $eventName, $eventDescription, $table, $remark = null)
{
    global $con;
    $timestamp = date('Y-m-d H:i:s');
    $sql = "INSERT INTO event_log (site_id, atmid, portal, event_name, event_timestamp, event_description,tableName,remark) 
            VALUES ($siteId,'".trim($atmid)."', '$portal', '$eventName', '$timestamp', '$eventDescription','$table','$remark')";

    $con->query($sql);
}


function uploadSitesAtAdvantage($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Advantage', 'Sites Uploaded', 'Sites uploaded at Advantage portal', $table);
}
function confurationDone($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Advantage', 'Cofigured', 'Configuration Done', $table);
}

function delegateToVendor($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Advantage', 'Sites Delegated To Vendor', 'Sites delegated to vendor for processing', $table);
}

function reopenRedelegateToVendor($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Advantage', 'Site Re-open From Rejection And Assign To Vendor', 'Site Reopen Redelegated to vendor for processing', $table);
}

function feasibilityApprovalReject($siteId, $atmid, $table, $remark = null)
{
    logEvent($siteId, $atmid, 'Advantage', 'Feasibility Reject', 'Feasibility Reject', $table, $remark);
}


function feasibilityApprovalVerify($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Advantage', 'Feasibility Approved', 'Feasibility Approved', $table);
}
function generatesAutoMaterialRequest($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Advantage', 'Material Request', 'Material Request Generates Automatically', $table);
}
function generatesManualMaterialRequest($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Advantage', 'Material Request', 'Material Request Generates Manually By Advantage', $table);
}


function installationProceed($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Advantage', 'Proceed Installation', 'Installation Request Sent To Vendor From Advantage With Schedule', $table);
}


function unholdInstallation($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Advantage', 'Unhold Installation', 'Installation Unhold By Advantage', $table);
}



function getLatestEvent($siteid, $atmid)
{

    
    global $con;
    $sql = mysqli_query($con, "select * from event_log where site_id='" . $siteid . "' and atmid  like '%" . trim($atmid) . "%' order by id desc");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['event_description'];
}

function addNotification($senderType, $senderId, $recipientId, $message, $siteId, $atmId)
{
    global $con, $datetime;
    $senderType = $con->real_escape_string($senderType);
    $senderId = (int) $senderId;
    $recipientId = (int) $recipientId;
    $message = $con->real_escape_string($message);
    $siteId = (int) $siteId;
    $atmId = $con->real_escape_string($atmId);

    $sql = "INSERT INTO notifications (sender_type, sender_id, recipient_id, message, siteid, atmid,created_at) 
            VALUES ('" . $senderType . "', '" . $senderId . "', '" . $recipientId . "', '" . $message . "', '" . $siteId . "', '" . $atmId . "','" . $datetime . "')";

    if ($con->query($sql) === true) {

        return true;
    } else {
        return false;
    }
}


function fetchNotifications($recipientType, $userid)
{
    global $con;
    $recipientType = $con->real_escape_string($recipientType);
    $recipientId = (int) $recipientId;

    $sql = "SELECT * FROM notifications WHERE recipient_id = '" . $userid . "'  ORDER BY created_at DESC";
    // AND sender_type != '".$recipientType."'
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $notifications = [];
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
        $con->close();

        return $notifications;
    } else {
        $con->close();
        return [];
    }
}

function isImageFile($fileName)
{
    $imageExtensions = array('jpg', 'jpeg', 'png', 'gif'); // Add more extensions if needed
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    return in_array(strtolower($fileExtension), $imageExtensions);
}



function getMaterialRequestInitiatorName($siteid)
{
    global $con;
    $sql = mysqli_query($con, "select * from material_requests where siteid='" . $siteid . "' and isProject=1");
    $sql_result = mysqli_fetch_assoc($sql);
    $vendorId = $sql_result['vendorId'];
    return getVendorName($vendorId);
}

function getMaterialRequestStatus($siteid)
{
    global $con;
    // echo "select status from material_requests where siteid='" . $siteid . "' and isProject=1" ; 
    $sql = mysqli_query($con, "select status from material_requests where siteid='" . $siteid . "' and isProject=1");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['status'];
}

function getMaterial_requestData($siteid, $parameter)
{
    global $con;
    $sql = mysqli_query($con, "select $parameter from material_requests where siteid='" . $siteid . "' order by id desc");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$parameter];
}

function engineerESD($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Project', 'Update ESD', 'Engineer Update Estimated Schedule Date', $table);
}


function engineerASD($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Project', 'Update ASD', 'Engineer Update Actual Schedule Date', $table);
}

function addSD($siteid, $atmid, $userid, $type, $scheduleDatetime)
{
    global $con, $datetime;

    mysqli_query($con, "insert into scheduleASDESDHistory(siteid,atmid,userid,portal,type,scheduleDatetime,created_at,status)
    values('" . $siteid . "','" . $atmid . "','" . $userid . "','Project','" . $type . "','" . $scheduleDatetime . "','" . $datetime . "',1)
    ");
}



if (!function_exists('usersData')) {

    function usersData($id, $parameter)
    {
        global $con;
        $sql = mysqli_query($con, "select $parameter from user where userid ='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result[$parameter];

    }
}
function installationProceedFromVendor($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Vendor', 'Proceed Installation', 'Installation Request Sent To Engineer From Vendor', $table);
}

function sendMaterialToVendor($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Inventory', 'Material Sent', 'Material Sent To Vendor From Inventory', $table);
}

function confirmMaterialReceive($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Vendor', 'Material Received', 'Vendor Confirm Material Receive', $table);
}

function sendMaterialToEngineer($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Vendor', 'Material Sent', 'Material dispatch from vendor side ', $table);
}

function projectTeamFeasibilityCheck($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Project', 'Feasibility Check', 'Feasibility check done by project team', $table);
}
function delegateToProjectExecutive($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Vendor', 'Sites Delegated To Project Executive', 'Sites delegated to Project Executive', $table);
}

function delegateToEngineer($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Vendor', 'Sites Delegated To Engineer', 'Sites delegated to Engineer for processing', $table);
}



function projectTeamInstallation($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Project', 'Installation', 'Installation Done By Project Team Engineer',$table);
}
function projectTeamInstallationHold($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Project', 'Installation Hold', 'Installation Hold By Project Team Engineer',$table);
}
?>