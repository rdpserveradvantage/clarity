<?php



if ($assignedLho) {

  $query1 = "SELECT COUNT(1) AS count FROM sites a INNER JOIN lhositesdelegation b ON a.id=b.siteid where a.status=1 and a.LHO like '" . $assignedLho . "' and b.isPending=0";
  //  $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1 and LHO like '" . $assignedLho . "'";
  $query2 = "SELECT COUNT(distinct a.atmid) AS count FROM projectInstallation a inner join sites b on a.atmid = b.atmid where isDone=1 and LHO like '" . $assignedLho . "' and a.status=1";

} else if ($_SESSION['PROJECT_level'] == 3) {

  $query1 = "select COUNT(1) as count from delegation where engineerId='" . $userid . "' and status=1 and isFeasibilityDone = 1";
  $query2 = "select count(1) as count from assignedInstallation where assignedToId='" . $userid . "' and status=1 and isDone=1";

} else if ($_SESSION['isVendor'] == 1) {

  $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1 and delegatedToVendorId='" . $_GLOBAL_VENDOR_ID . "'";
  $query2 = "SELECT COUNT(distinct atmid) AS count FROM projectInstallation where isDone=1 and status=1 and vendor='" . $_GLOBAL_VENDOR_ID . "'";


} else {
  $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1";
  $query2 = "SELECT COUNT(distinct atmid) AS count FROM projectInstallation where isDone=1 and status=1";
}

$queries = [$query1, $query2];
$results = [];
foreach ($queries as $query) {
  $result = mysqli_query($con, $query);
  $count = mysqli_fetch_assoc($result)['count'];
  $results[] = $count;
}


?>

<link rel="stylesheet" href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/assets/css/ionicons.min.css">

<div class="row">

  <div class="col-lg-3 col-xs-6" style="color: white;">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3 id="info_box_online">
          <?= $results[1] . ' / ' . $results[0]; ?>
        </h3>
        <p>Active / All </p>
      </div>
      <div class="icon">
        <i class="mdi mdi-chart-pie"></i>

      </div>
      <a href="./sites/sitestest.php" class="small-box-footer">Sites
        <i class="fa fa-arrow-circle-right"></i>
        <ion-icon name="pie-chart-outline"></ion-icon>
      </a>
    </div>
  </div>





  <?

  if ($assignedLho) {

    $query3 = "SELECT COUNT(DISTINCT atmid) AS today_record_count FROM projectInstallation 
    WHERE DATE(scheduleDate) = CURDATE()";
$query33 = "SELECT COUNT(DISTINCT atmid) as today_record_count FROM projectInstallation WHERE DATE(scheduleDate) = CURDATE() and isDone=1";

  } else if ($_SESSION['PROJECT_level'] == 3) {
    
    $query3 = "SELECT COUNT(DISTINCT atmid) AS today_record_count FROM projectInstallation 
    WHERE DATE(scheduleDate) = CURDATE()";
$query33 = "SELECT COUNT(DISTINCT atmid) as today_record_count FROM projectInstallation WHERE DATE(scheduleDate) = CURDATE() and isDone=1";
    
  } else if ($_SESSION['isVendor'] == 1 && $_SESSION['PROJECT_level'] != 3) {

    
    $query3 = "SELECT COUNT(DISTINCT atmid) AS today_record_count FROM projectInstallation 
    WHERE DATE(scheduleDate) = CURDATE()";
$query33 = "SELECT COUNT(DISTINCT atmid) as today_record_count FROM projectInstallation WHERE DATE(scheduleDate) = CURDATE() and isDone=1";
    
  } else if ($_SESSION['PROJECT_level'] == 3) {
    
    $query3 = "SELECT COUNT(DISTINCT atmid) AS today_record_count FROM projectInstallation 
    WHERE DATE(scheduleDate) = CURDATE()";
    
    $query33 = "SELECT COUNT(DISTINCT atmid) as today_record_count FROM projectInstallation WHERE DATE(scheduleDate) = CURDATE() and isDone=1";

  } else {
    
    $query3 = "SELECT COUNT(DISTINCT atmid) AS today_record_count FROM projectInstallation 
    WHERE DATE(scheduleDate) = CURDATE()";
$query33 = "SELECT COUNT(DISTINCT atmid) as today_record_count FROM projectInstallation WHERE DATE(scheduleDate) = CURDATE() and isDone=1";
    
  }

  $sql = mysqli_query($con, $query3);
  $sql_result = mysqli_fetch_assoc($sql);



  $sql2 = mysqli_query($con, $query33);
  $sql_result2 = mysqli_fetch_assoc($sql2);


?>


  <div class="col-lg-3 col-xs-6" style="color: white;">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3 id="info_box_online">
          <?= $sql_result['today_record_count'] . ' / ' . $sql_result2['today_record_count']; ?>
        </h3>
        <p>Est. Plan / Actual Live Sites</p>
      </div>
      <div class="icon">
        <i class="mdi mdi-settings"></i>
      </div>
      <a href="./sites/sitestest.php" class="small-box-footer">Todays Installation
        <i class="fa fa-arrow-circle-right"></i>
        <ion-icon name="pie-chart-outline"></ion-icon>
      </a>
    </div>
  </div>







  <?


  if ($assignedLho) {
    $inv_sql = mysqli_query($con, "SELECT isDelivered,count(1) as total FROM `material_send` where lho='" . $assignedLho . "' group by isDelivered");
  } else if ($_SESSION['PROJECT_level'] == 3) {

    $inv_sql = mysqli_query($con, "SELECT isDelivered,count(1) as total FROM `vendormaterialsend` where contactPersonName='" . $userid . "' group by isConfirm");

  } else if ($_SESSION['isVendor'] == 1 && $_SESSION['PROJECT_level'] != 3) {
    $inv_sql = mysqli_query($con, "SELECT isDelivered,count(1) as total FROM `vendormaterialsend` where vendorId='" . $_GLOBAL_VENDOR_ID . "' group by isDelivered");

  } else {
    $inv_sql = mysqli_query($con, "SELECT isDelivered,count(1) as total FROM `material_send` group by isDelivered");
  }

  while ($inv_sql_result = mysqli_fetch_assoc($inv_sql)) {
    $isDelivered = $inv_sql_result['isDelivered'];
    $statusCount[] = $inv_sql_result['total'];
  }


  ?>



  <div class="col-lg-3 col-xs-6" style="color: white;">
    <div class="small-box bg-green">
      <div class="inner">
        <h3 id="info_box_online">
          <?= ($statusCount[0] ? $statusCount[0] : '0') . ' / ' . ($statusCount[1] ? $statusCount[1] : '0'); ?>
        </h3>
        <p>In-transit / Delivered </p>
      </div>
      <div class="icon">
        <i class="mdi mdi-chart-line"></i>
      </div>
      <a href="./inventory/materialSent.php" class="small-box-footer">Material
        <i class="fa fa-arrow-circle-right"></i>
        <ion-icon name="pie-chart-outline"></ion-icon>
      </a>
    </div>
  </div>





  <div class="col-lg-3 col-xs-6" style="color: white;">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3 id="info_box_online">
          <?= ($statusCount[0] ? $statusCount[0] : '0') . ' / ' . ($statusCount[1] ? $statusCount[1] : '0'); ?>
        </h3>
        <p>In-transit / Delivered </p>
      </div>
      <div class="icon">
        <i class="mdi mdi-counter"></i>
      </div>
      <a href="./inventory/materialSent.php" class="small-box-footer">Material
        <i class="fa fa-arrow-circle-right"></i>
        <ion-icon name="pie-chart-outline"></ion-icon>
      </a>
    </div>
  </div>









</div>