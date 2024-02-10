<? include('../config.php');

$atmid = $_REQUEST['atmid'];
$id =  $_REQUEST['id'];
$siteid =  $_REQUEST['siteid'];
$sbiTicketId =  $_REQUEST['sbiTicketId'];
$scheduleAtmEngineerName =  $_REQUEST['scheduleAtmEngineerName'];
$scheduleAtmEngineerNumber =  $_REQUEST['scheduleAtmEngineerNumber'];
$bankPersonName =  $_REQUEST['bankPersonName'];
$bankPersonNumber =  $_REQUEST['bankPersonNumber'];
$backRoomKeyPersonName =  $_REQUEST['backRoomKeyPersonName'];
$backRoomKeyPersonNumber =  $_REQUEST['backRoomKeyPersonNumber'];
$date =  $_REQUEST['date'];
$time =  $_REQUEST['time'];

$checksql = mysqli_query($con, "select * from projectinstallation where siteid='" . $siteid . "' and status=1 order by id desc");
if ($checksql_result = mysqli_fetch_assoc($checksql)) {
    $projectinstallationID = $checksql_result['id'];
    $sql = "UPDATE projectinstallation set bankPersonName='" . $bankPersonName . "', bankPersonNumber='" . $bankPersonNumber . "', backRoomKeyPersonName='" . $backRoomKeyPersonName . "', 
    backRoomKeyPersonNumber='" . $backRoomKeyPersonNumber . "', scheduleDate='" . $scheduleDate . "', scheduleTime='" . $scheduleTime . "', sbiTicketId='" . $sbiTicketId . "' where id = '" . $projectinstallationID . "'"
    ;
} else {
    $sql = "insert into projectinstallation(siteid, atmid, status, created_at, created_by, isDone,  bankPersonName, bankPersonNumber, backRoomKeyPersonName, backRoomKeyPersonNumber, scheduleDate, scheduleTime, sbiTicketId)
    values('" . $siteid . "','" . $atmid . "',1,'" . $datetime . "','" . $userid . "',0,'" . $bankPersonName . "','" . $bankPersonNumber . "','" . $backRoomKeyPersonName . "','" . $backRoomKeyPersonName . "','" . $scheduleDate . "','" . $sbiTicketId . "')
    ";
    // vendor, portal, isSentToEngineer
    // scheduleAtmEngineerName, scheduleAtmEngineerNumber, 
}
// echo $sql ; 

if (mysqli_query($con, $sql)) {
    echo json_encode(200);

} else {
    echo json_encode(500);
}



?>