<? include('../header.php');

$statement = "select id,noOfAtm,ATMID1,address,city,location,LHO,state,atm1Status,atm2Status,atm3Status,operator,signalStatus,
backroomNetworkRemark,backroomNetworkSnap,AntennaRoutingdetail,EMLockPassword,EMlockAvailable,NoOfUps,PasswordReceived,Remarks,
UPSAvailable,UPSBateryBackup,UPSWorking1,UPSWorking2,UPSWorking3,backroomDisturbingMaterial,backroomDisturbingMaterialRemark,backroomKeyName,
backroomKeyNumber,backroomKeyStatus,earthing,earthingVltg,frequentPowerCut,frequentPowerCutFrom,frequentPowerCutRemark,frequentPowerCutTo,
nearestShopDistance,nearestShopName,nearestShopNumber,powerFluctuationEN,powerFluctuationPE,powerFluctuationPN,powerSocketAvailability,
routerAntenaPosition,routerAntenaSnap,AntennaRoutingSnap,UPSAvailableSnap,NoOfUpsSnap,upsWorkingSnap,powerSocketAvailabilitySnap,earthingSnap,
powerFluctuationSnap,remarksSnap,created_at,created_by,feasibilityDone,isVendor,operator2,signalStatus2 from feasibilityCheck where status=1 ";



$sqlappCount = "select count(1) as totalCount from feasibilityCheck where status=1 ";


if ($assignedLho) {
    $statement .= " and LHO like '" . $assignedLho . "'";
    $sqlappCount .= " and LHO like '" . $assignedLho . "'";
}

$atmid = $_REQUEST["atmid"];
$lho = $_REQUEST["lho"];
$state = $_REQUEST["state"];
$city = $_REQUEST["city"];


if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
    $atmid = $_REQUEST['atmid'];
    $statement .= "and ATMID1 like '%" . trim($atmid) . "%'";
    $sqlappCount .= "and ATMID1 like '%" . trim($atmid) . "%'";
}

if (isset($_REQUEST['lho']) && $_REQUEST['lho'] != '') {
    $lho = $_REQUEST['lho'];
    $statement .= "and LHO like '%" . $lho . "%'";
    $sqlappCount .= "and LHO like '%" . $lho . "%'";
}
if (isset($_REQUEST['state']) && $_REQUEST['state'] != '') {
    $state = $_REQUEST['state'];
    $statement .= "and state like '%" . $state . "%'";
    $sqlappCount .= "and state like '%" . $state . "%'";
}

if (isset($_REQUEST['city']) && $_REQUEST['city'] != '') {
    $city = $_REQUEST['city'];
    $statement .= "and city like '%" . $city . "%'";
    $sqlappCount .= "and city like '%" . $city . "%'";
}

if ($assignedLho) {
    if ($ADVANTAGE_level == 2 || $ADVANTAGE_level == 5) {
        $statement .= "and LHO = '" . $assignedLho . "' ";
        $sqlappCount .= "and LHO= '" . $assignedLho . "' ";
    }

}
$statement .= " order by id desc";
$sqlappCount;

$page_size = 10;
$result = mysqli_query($con, $sqlappCount);
$row = mysqli_fetch_assoc($result);
$total_records = $row['totalCount'];

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $page_size;
$total_pages = ceil($total_records / $page_size);
$window_size = 10;
$start_window = max(1, $current_page - floor($window_size / 2));
$end_window = min($start_window + $window_size - 1, $total_pages);
$sql_query = "$statement LIMIT $offset, $page_size";



?>


<div class="col-12 grid-margin">
    <div class="card" id="filter">
        <div class="card-body">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="">Atmid</label>
                        <input type="text" name="atmid" class="form-control" value="<?= $_REQUEST['atmid']; ?>" />
                    </div>
                    <div class="col-sm-3">
                        <label for="">LHO</label>
                        <select name="lho" id="lho" class="form-control">
                            <option value="">Select</option>
                            <?

                            $lho_sql = mysqli_query($con, "select distinct(LHO) as lho from feasibilitycheck");
                            while ($lho_sqlResult = mysqli_fetch_assoc($lho_sql)) { ?>
                                <option <? if ($_REQUEST['lho'] == $lho_sqlResult['lho']) {
                                    echo 'selected';
                                } ?>>
                                    <?= $lho_sqlResult['lho']; ?>
                                </option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="">State</label>
                        <select name="state" id="state" class="form-control">
                            <option value="">Select</option>
                            <?
                            $state_sql = mysqli_query($con, "select distinct(state) as state from feasibilitycheck");
                            while ($state_sqlResult = mysqli_fetch_assoc($state_sql)) {
                                ?>
                                <option <? if ($_REQUEST['state'] == $state_sqlResult['state']) {
                                    echo 'selected';
                                } ?>>
                                    <?= $state_sqlResult['state']; ?>
                                </option>
                            <?
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="">City</label>
                        <select name="city" id="city" class="form-control">
                            <option value="">Select</option>
                            <?
                            $city_sql = mysqli_query($con, "select distinct(city) as city from feasibilitycheck");
                            while ($city_sqlResult = mysqli_fetch_assoc($city_sql)) {
                                ?>
                                <option <? if ($_REQUEST['city'] == $city_sqlResult['city']) {
                                    echo 'selected';
                                } ?>>
                                    <?= $city_sqlResult['city']; ?>
                                </option>
                            <?
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <br>
                        <input type="submit" class="btn btn-primary" name="filterSubmit">

                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-header">
            <h5>Total Sites: <strong class="record-count">
                    <?= $total_records; ?>
                </strong></h5>

            <hr />
            <form action="exportFeasibiltyData.php" method="POST">
                <input type="hidden" name="exportSql" value="<?= $statement; ?>">
                <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
            </form>

        </div>
        <div class="card-block">

            <div class="card-body" style="overflow:auto;">
                <table id="example"
                    class="table table-bordered table-striped table-hover dataTable js-exportable no-footer"
                    style="width:100%">
                    <thead>
                        <tr class="table-primary">
                            <th>id</th>
                            <th>Feasibility Done</th>
                            <th>No Of Atm</th>
                            <th>ATMID1</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Location</th>
                            <th>LHO</th>
                            <th>state</th>
                            <th>atm1 Status</th>
                            <th>atm2 Status</th>
                            <th>atm3 Status</th>
                            <th>Operator</th>
                            <th>signal Status</th>
                            <th>Operator 2</th>
                            <th>signal Status 2</th>
                            <th>backroom Network Remark</th>
                            <th>backroom Network Snap</th>
                            <th>Antenna Routing detail</th>
                            <th>EM Lock Password</th>
                            <th>EM lock Available</th>
                            <th>No Of Ups</th>
                            <th>Password Received</th>
                            <th>Remarks</th>
                            <th>UPS Available</th>
                            <th>UPS Batery Backup</th>
                            <th>UPS Working1</th>
                            <th>UPS Working2</th>
                            <th>UPS Working3</th>
                            <th>backroom Disturbing Material</th>
                            <th>backroom Disturbing Material Remark</th>
                            <th>backroom Key Name</th>
                            <th>backroom Key Number</th>
                            <th>backroom Key Status</th>
                            <th>earthing</th>
                            <th>earthing Vltg</th>
                            <th>frequent Power Cut</th>
                            <th>frequent Power Cut From</th>
                            <th>frequent Power Cut Remark</th>
                            <th>frequent Power Cut To</th>
                            <th>nearest Shop Distance</th>
                            <th>nearest Shop Name</th>
                            <th>nearest Shop Number</th>
                            <th>power Fluctuation EN</th>
                            <th>power Fluctuation PE</th>
                            <th>power Fluctuation PN</th>
                            <th>power Socket Availability</th>
                            <th>router Antena Position</th>
                            <th>router Antena Snap</th>
                            <th>Antenna Routing Snap</th>
                            <th>UPS Available Snap</th>
                            <th>No Of Ups Snap</th>
                            <th>ups Working Snap</th>
                            <th>power Socket Availability Snap</th>
                            <th>earthing Snap</th>
                            <th>power Fluctuation Snap</th>
                            <th>remarks Snap</th>
                            <th>created at</th>
                            <th>Created By</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?

                        $noImageUrl = "No Image Found";
                        $counter = ($current_page - 1) * $page_size + 1;
                        $sql = mysqli_query($con, $sql_query);
                        while ($sql_result = mysqli_fetch_assoc($sql)) {
                            $id = $sql_result['id'];
                            $isVendor = $sql_result['isVendor'];
                            $baseurl = 'http://clarity.advantagesb.com/';

                            ?>

                            <tr>
                                <td>
                                    <?= $counter; ?>
                                </td>
                                <td>
                                    <?= ($sql_result['feasibilityDone'] ? $sql_result['feasibilityDone'] : 'NA'); ?>
                                </td>

                                <td>
                                    <?= ($sql_result['noOfAtm'] ? $sql_result['noOfAtm'] : 'NA'); ?>
                                </td>
                                <td class="strong">
                                    <?= ($sql_result['ATMID1'] ? $sql_result['ATMID1'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['address'] ? $sql_result['address'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['city'] ? $sql_result['city'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['location'] ? $sql_result['location'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['LHO'] ? $sql_result['LHO'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['state'] ? $sql_result['state'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['atm1Status'] ? $sql_result['atm1Status'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['atm2Status'] ? $sql_result['atm2Status'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['atm3Status'] ? $sql_result['atm3Status'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['operator'] ? $sql_result['operator'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['signalStatus'] ? $sql_result['signalStatus'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['operator2'] ? $sql_result['operator2'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['signalStatus2'] ? $sql_result['signalStatus2'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['backroomNetworkRemark'] ? $sql_result['backroomNetworkRemark'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?
                                    $imageFileName = pathinfo($baseurl . $sql_result['backroomNetworkSnap'], PATHINFO_BASENAME);
                                    if (isImageFile($imageFileName)) {
                                        echo '<a href="' . $baseurl . $sql_result['backroomNetworkSnap'] . '" target="_blank">View</a>';
                                    } else {
                                        echo 'No Image Found';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?= ($sql_result['AntennaRoutingdetail'] ? $sql_result['AntennaRoutingdetail'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['EMLockPassword'] ? $sql_result['EMLockPassword'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['EMlockAvailable'] ? $sql_result['EMlockAvailable'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['NoOfUps'] ? $sql_result['NoOfUps'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['PasswordReceived'] ? $sql_result['PasswordReceived'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['Remarks'] ? $sql_result['Remarks'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['UPSAvailable'] ? $sql_result['UPSAvailable'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['UPSBateryBackup'] ? $sql_result['UPSBateryBackup'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['UPSWorking1'] ? $sql_result['UPSWorking1'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['UPSWorking2'] ? $sql_result['UPSWorking2'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['UPSWorking3'] ? $sql_result['UPSWorking3'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['backroomDisturbingMaterial'] ? $sql_result['backroomDisturbingMaterial'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['backroomDisturbingMaterialRemark'] ? $sql_result['backroomDisturbingMaterialRemark'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['backroomKeyName'] ? $sql_result['backroomKeyName'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['backroomKeyNumber'] ? $sql_result['backroomKeyNumber'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['backroomKeyStatus'] ? $sql_result['backroomKeyStatus'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['earthing'] ? $sql_result['earthing'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['earthingVltg'] ? $sql_result['earthingVltg'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['frequentPowerCut'] ? $sql_result['frequentPowerCut'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['frequentPowerCutFrom'] ? $sql_result['frequentPowerCutFrom'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['frequentPowerCutRemark'] ? $sql_result['frequentPowerCutRemark'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['frequentPowerCutTo'] ? $sql_result['frequentPowerCutTo'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['nearestShopDistance'] ? $sql_result['nearestShopDistance'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['nearestShopName'] ? $sql_result['nearestShopName'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['nearestShopNumber'] ? $sql_result['nearestShopNumber'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['powerFluctuationEN'] ? $sql_result['powerFluctuationEN'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['powerFluctuationPE'] ? $sql_result['powerFluctuationPE'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['powerFluctuationPN'] ? $sql_result['powerFluctuationPN'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['powerSocketAvailability'] ? $sql_result['powerSocketAvailability'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($sql_result['routerAntenaPosition'] ? $sql_result['routerAntenaPosition'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?
                                    $imageFileName = pathinfo($baseurl . $sql_result['routerAntenaSnap'], PATHINFO_BASENAME);
                                    if (isImageFile($imageFileName)) {
                                        echo '<a href="' . $baseurl . $sql_result['routerAntenaSnap'] . '" target="_blank">View</a>';
                                    } else {
                                        echo 'No Image Found';
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?
                                    $imageFileName = pathinfo($baseurl . $sql_result['AntennaRoutingSnap'], PATHINFO_BASENAME);
                                    if (isImageFile($imageFileName)) {
                                        echo '<a href="' . $baseurl . $sql_result['AntennaRoutingSnap'] . '" target="_blank">View</a>';
                                    } else {
                                        echo 'No Image Found';
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?
                                    $imageFileName = pathinfo($baseurl . $sql_result['UPSAvailableSnap'], PATHINFO_BASENAME);
                                    if (isImageFile($imageFileName)) {
                                        echo '<a href="' . $baseurl . $sql_result['UPSAvailableSnap'] . '" target="_blank">View</a>';
                                    } else {
                                        echo 'No Image Found';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?
                                    $imageFileName = pathinfo($baseurl . $sql_result['NoOfUpsSnap'], PATHINFO_BASENAME);
                                    if (isImageFile($imageFileName)) {
                                        echo '<a href="' . $baseurl . $sql_result['NoOfUpsSnap'] . '" target="_blank">View</a>';
                                    } else {
                                        echo 'No Image Found';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?
                                    $imageFileName = pathinfo($baseurl . $sql_result['upsWorkingSnap'], PATHINFO_BASENAME);
                                    if (isImageFile($imageFileName)) {
                                        echo '<a href="' . $baseurl . $sql_result['upsWorkingSnap'] . '" target="_blank">View</a>';
                                    } else {
                                        echo 'No Image Found';
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?
                                    $imageFileName = pathinfo($baseurl . $sql_result['powerSocketAvailabilitySnap'], PATHINFO_BASENAME);
                                    if (isImageFile($imageFileName)) {
                                        echo '<a href="' . $baseurl . $sql_result['powerSocketAvailabilitySnap'] . '" target="_blank">View</a>';
                                    } else {
                                        echo 'No Image Found';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?
                                    $imageFileName = pathinfo($baseurl . $sql_result['earthingSnap'], PATHINFO_BASENAME);
                                    if (isImageFile($imageFileName)) {
                                        echo '<a href="' . $baseurl . $sql_result['earthingSnap'] . '" target="_blank">View</a>';
                                    } else {
                                        echo 'No Image Found';
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?
                                    $imageFileName = pathinfo($baseurl . $sql_result['powerFluctuationSnap'], PATHINFO_BASENAME);
                                    if (isImageFile($imageFileName)) {
                                        echo '<a href="' . $baseurl . $sql_result['powerFluctuationSnap'] . '" target="_blank">View</a>';
                                    } else {
                                        echo 'No Image Found';
                                    }
                                    ?>


                                </td>

                                <td>


                                    <a href="<?= $baseurl . $sql_result['remarksSnap']; ?>" target="_blank">View</a>
                                </td>
                                <td>
                                    <?= ($sql_result['created_at'] ? $sql_result['created_at'] : 'NA'); ?>
                                </td>
                                <td>
                                    <?= getUsername($sql_result['created_by'], $isVendor); ?>
                                </td>
                            </tr>

                            <? $counter++;
                        } ?>
                    </tbody>
                </table>
            </div>




            <?

            $atmid = $_REQUEST['atmid'];
            $lho = $_REQUEST['lho'];
            $state = $_REQUEST['state'];
            $city = $_REQUEST['city'];

            echo '
            <div class="dataTables_wrapper form-inline dt-bootstrap no-footer" style="margin: auto;"> 
            <div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><ul class="pagination">';
           
            if ($start_window > 1) {

                echo "<li class='paginate_button'><a href='?page=1&&atmid=$atmid&&lho$lho&&state=$state&&city=$city'>First</a></li>";
                echo '<li class="paginate_button"><a href="?page=' . ($start_window - 1) . '&&atmid=' . $atmid . '&&lho=' . $lho . '&&state=' . $state . '&&city=' . $city . '">Prev</a></li>';
            }

            for ($i = $start_window; $i <= $end_window; $i++) {
                ?>
                <li class="paginate_button <? if ($i == $current_page) {
                    echo 'active';
                } ?>">
                    <a
                        href="?page=<?= $i; ?>&&atmid=<?= $atmid; ?>&&lho=<?= $lho; ?>&&state=<?= $state; ?>&&city=<?= $city; ?>">
                        <?= $i; ?>
                    </a>
                </li>

            <? }

            if ($end_window < $total_pages) {

                echo '<li class="paginate_button"><a href="?page=' . ($end_window + 1) . '&&atmid=' . $atmid . '&&lho=' . $lho . '&&state=' . $state . '&&city=' . $city . '">Next</a></li>';
                echo '<li class="paginate_button"><a href="?page=' . $total_pages . '&&atmid=' . $atmid . '&&lho' . $lho . '&&state=' . $state . '&&city=' . $city . '">Last</a></li>';
            }
            echo '</ul></div></div>';


            ?>



        </div>
    </div>

</div>





<? include('../footer.php'); ?>