<?php include('../config.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// var_dump($_REQUEST)
// ;

$siteid = $_REQUEST['siteId'];
// echo "select * from projectInstallation where siteid='".$siteid."' oder by id desc";
$sql = mysqli_query($con,"select * from projectInstallation where siteid='".$siteid."' order by id desc");
$sql_result = mysqli_fetch_assoc($sql) ; 

$vendor = $sql_result['vendor'];
$vendorName = getVendorName($vendor);
$sbiTicketId = $sql_result['sbiTicketId'];
$scheduleAtmEngineerName = $sql_result['scheduleAtmEngineerName'];
$scheduleAtmEngineerNumber = $sql_result['scheduleAtmEngineerNumber'];
$bankPersonName = $sql_result['bankPersonName'];
$bankPersonNumber = $sql_result['bankPersonNumber'];

$backRoomKeyPersonName = $sql_result['backRoomKeyPersonName'];
$backRoomKeyPersonNumber = $sql_result['backRoomKeyPersonNumber'];
$scheduleDate = $sql_result['scheduleDate'];
$scheduleTime = $sql_result['scheduleTime'];


?>

<style>
    .scheduled_task label{
font-weight: 500;
font-size: 20px;

    }
    .scheduled_task p{
/* font-weight: 500; */
font-size: 18px;
    }
</style>

<div class="card" style="background-color: #ffffff;">
    <div class="card-body scheduled_task">
       
            <div class="row">
                <div class="col-sm-6" >
                    <label>Select Vendor For Installation</label>
                  <p><?= $vendorName ; ?></p> 
                </div>
                <div class="col-sm-6">
                    <label>SBIN Ticket ID</label>
                    <p><?= $sbiTicketId ; ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <label>Schedule ATM Engineer</label>
                    
                    <p><?= $scheduleAtmEngineerName ; ?></p>

                </div>

                <div class="col-sm-6">
                    <label>Schedule ATM Engineer Number</label>
                    <p><?= $scheduleAtmEngineerNumber ; ?></p>
                    
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <label>Bank Person</label>                    
                    <p><?= $bankPersonName ; ?></p>
                    

                </div>

                <div class="col-sm-6">
                    <label>Bank Person Number</label>
                    <p><?= $bankPersonNumber ; ?></p>

                    
                    

                    
                    
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <label>Back-room key Person </label>
                    <p><?= $backRoomKeyPersonName ; ?></p>
                   
                </div>

                <div class="col-sm-6">
                    <label>Back-room key person number</label>
                    <p><?= $backRoomKeyPersonNumber ; ?></p>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-sm-6">
                    <label for="dateInput">Select a date:</label>
                    <p><?= $scheduleDate ; ?></p>

                </div>
                <div class="col-sm-6">
                    <label for="timeInput">Select a time:</label>
                    <p><?= $scheduleTime ; ?></p>
                 </div>
            </div>



         
        
    </div>
</div>