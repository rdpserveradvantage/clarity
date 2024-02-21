<?php include('../header.php'); ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<?

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



// var_dump($_SESSION);

// if (isset($_REQUEST['submit']) || isset($_GET['page'])) {


// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';


$isVendor = $_SESSION['isVendor'];
$islho = $_SESSION['islho'];
$ADVANTAGE_level = $_SESSION['ADVANTAGE_level'];

if ($islho == 0 && $isVendor == 0) {
    ?>
    <script>
        window.location.href = "/sites/sites.php";
    </script>
<?
    // header('Location: /');
    // exit;

} else if ($ADVANTAGE_level == 3) {
    ?>
        <script>
            window.location.href = "/sites/engsites.php";
        </script>
<?
}


function getBranchName($id)
{
    global $con;
    $sql = mysqli_query($con, "select * from mis_city where id='" . $id . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['city'];
}




$sqlappCount = "select count(1) as total from sites a ";
$atm_sql = "select a.po,a.po_date,a.id,a.activity,a.customer,a.bank,a.atmid,a.address,a.city,a.state,a.zone,a.LHO,a.LHO_Contact_Person,a.LHO_Contact_Person_No,
a.LHO_Contact_Person_email,a.LHO_Adv_Person,a.LHO_Adv_Contact,a.LHO_Adv_email,a.Project_Coordinator_Name,a.Project_Coordinator_No,
a.Project_Coordinator_email,a.Customer_SLA,a.Our_SLA,a.Vendor,a.Cash_Management,a.CRA_VENDOR,a.ID_on_Make,a.Model,a.SiteType,a.PopulationGroup,
a.XPNET_RemoteAddress,a.CONNECTIVITY,a.Connectivity_Type,a.Site_data_Received_for_Feasiblity_date,a.isDelegated,a.created_at,a.created_by,
a.isFeasibiltyDone,a.latitude,a.longitude,a.verificationStatus,a.delegatedtoVendorId,a.ESD,a.ASD
                                from sites a 
                               ";



if ($_VENDOR_LOGIN) {
    // echo 'vendor';

    $sqlappCount .= " INNER JOIN vendorsitesdelegation b
    ON a.id = b.siteid and b.vendorid = '" . $_GLOBAL_VENDOR_ID . "'";
    $atm_sql .= " INNER JOIN vendorsitesdelegation b
                                ON a.id = b.siteid
                                and b.vendorid = '" . $_GLOBAL_VENDOR_ID . "'
                                and b.status=1 

                                ";
} else {
    // echo 'advantage';

    $sqlappCount .= " INNER JOIN lhositesdelegation b
    ON a.id = b.siteid  
    and a.LHO like '" . $assignedLho . "'
    
    ";

    $atm_sql .= " INNER JOIN lhositesdelegation b
                                ON a.id = b.siteid 
                                and a.LHO like '" . $assignedLho . "'
                                ";


}

$atm_sql .= " where 1 ";

if (isset($_REQUEST['vendorId']) && $_REQUEST['vendorId'] != '') {
    $vendorId = $_REQUEST['vendorId'];
    $atm_sql .= "and a.delegatedToVendorId like '%" . $vendorId . "%'";
    $sqlappCount .= "and a.delegatedToVendorId like '%" . $vendorId . "%'";
}
if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
    $atmid = $_REQUEST['atmid'];
    $atm_sql .= "and a.atmid like '%" . $atmid . "%'";
    $sqlappCount .= "and a.atmid like '%" . $atmid . "%'";
}

if (isset($_REQUEST['isFeasibiltyDone']) && $_REQUEST['isFeasibiltyDone'] != '') {
    $isFeasibiltyDonefilter = $_REQUEST['isFeasibiltyDone'];
    $atm_sql .= "and a.isFeasibiltyDone like '%" . $isFeasibiltyDonefilter . "%'";
    $sqlappCount .= "and a.isFeasibiltyDone like '%" . $isFeasibiltyDonefilter . "%'";
}
if (isset($_REQUEST['isDelegated']) && $_REQUEST['isDelegated'] != '') {
    $isDelegatedFilter = $_REQUEST['isDelegated'];
    $atm_sql .= "and a.delegatedByVendor like '%" . $isDelegatedFilter . "%'";
    $sqlappCount .= "and a.delegatedByVendor like '%" . $isDelegatedFilter . "%'";
}

if (isset($_REQUEST['cust']) && $_REQUEST['cust'] != '') {
    $atm_sql .= "and a.customer like '%" . $_REQUEST['cust'] . "%' ";
    $sqlappCount .= "and a.customer like '%" . $_REQUEST['cust'] . "%' ";
}

if (isset($_REQUEST['zone']) && $_REQUEST['zone'] != '') {
    $atm_sql .= "and a.zone = '" . $_REQUEST['zone'] . "' ";
    $sqlappCount .= "and a.zone = '" . $_REQUEST['zone'] . "' ";
}

if (isset($_REQUEST['state']) && $_REQUEST['state'] != '') {
    $atm_sql .= "and a.state= '" . $_REQUEST['state'] . "' ";
    $sqlappCount .= "and a.state= '" . $_REQUEST['state'] . "' ";
}

if ($assignedLho) {
    if ($ADVANTAGE_level == 2 || $ADVANTAGE_level == 5) {
        $atm_sql .= "and a.LHO like '%" . $assignedLho . "%' ";
        $sqlappCount .= "and a.LHO= '%" . $assignedLho . "%' ";
    }

}








$atm_sql .= "and a.status=1 and b.isPending=0 group by a.atmid order by a.id desc";
$sqlappCount .= "and a.status=1 and b.isPending=0  group by a.atmid ";

// echo $sqlappCount;
$page_size = 20;
$result = mysqli_query($con, $sqlappCount);
$row = mysqli_fetch_assoc($result);
$total_records = mysqli_num_rows($result);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $page_size;
$total_pages = ceil($total_records / $page_size);
$window_size = 10;
$start_window = max(1, $current_page - floor($window_size / 2));
$end_window = min($start_window + $window_size - 1, $total_pages);
$sql_query = "$atm_sql LIMIT $offset, $page_size";

// echo $sql_query;

?>


<div class="row">
    <div class="col-12  grid-margin">
        <div class="card" id="filter">
            <div class="card-body">
                <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                    <div class="row">
                        <div class="col-md-2">
                            <label>ATMID</label>
                            <input type="text" class="form-control" name="atmid"
                                value="<? echo $_REQUEST['atmid']; ?>" />
                        </div>

                        <div class="col-md-2">
                            <label>Feasibilty Done</label>
                            <select name="isFeasibiltyDone" class="form-control">
                                <option value="">Select</option>
                                <option value="1" <? if (isset($isFeasibiltyDonefilter) && $isFeasibiltyDonefilter == 1) {
                                    echo 'selected';
                                } ?>>Yes</option>
                                <option value="0" <? if (isset($isFeasibiltyDonefilter) && $isFeasibiltyDonefilter == 0) {
                                    echo 'selected';
                                } ?>>No</option>
                            </select>

                        </div>

                        <div class="col-md-2">
                            <label>Contractor</label>
                            <select name="vendorId" class="form-control mdb-select md-form" searchable="Search here..">

                                <option value="">-- Select Contractor --</option>

                                <?php
                                $i = 0;
                                $vendorSql = mysqli_query($con, "SELECT * from vendor where status=1");
                                while ($fetch_data = mysqli_fetch_assoc($vendorSql)) {
                                    ?>
                                    <option value="<?php echo $fetch_data['id'] ?>" <?php if ($_REQUEST['vendorId'] == $fetch_data['id']) {
                                           echo 'selected';
                                       } ?>>
                                        <?php echo $fetch_data['vendorName']; ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>



                        <div class="col-md-2">
                            <label>Customer</label>
                            <select name="cust" class="form-control mdb-select md-form" searchable="Search here..">

                                <option value="">-- Select Customer --</option>

                                <?php
                                $i = 0;
                                $custlist = mysqli_query($con, "SELECT id,customer from sites where customer!='' group by customer ");
                                while ($fetch_data = mysqli_fetch_assoc($custlist)) {
                                    ?>
                                    <option value="<?php echo $fetch_data['customer'] ?>" <?php if ($_REQUEST['cust'] == $fetch_data['customer']) {
                                           echo 'selected';
                                       } ?>>
                                        <?php echo $fetch_data['customer']; ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>


                        <div class="col-md-2">
                            <label>State</label>
                            <select name="state" class="form-control">
                                <option value="">-- Select State--</option>

                                <?php
                                $i = 0;
                                $statelist = mysqli_query($con, "SELECT id,state from sites where state!='' group by state ");
                                while ($fetch_data = mysqli_fetch_assoc($statelist)) {
                                    ?>
                                    <option value="<?php echo $fetch_data['state'] ?>" <?php if ($_REQUEST['state'] == $fetch_data['state']) {
                                           echo 'selected';
                                       } ?>>
                                        <?php echo $fetch_data['state']; ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="col-md-2">
                            <label>Delegated</label>
                            <select name="isDelegated" class="form-control">
                                <option value="">Select</option>
                                <option value="1" <? if (isset($isDelegatedFilter) && $isDelegatedFilter == 1) {
                                    echo 'selected';
                                } ?>> Yes </option>
                                <option value="0" <? if (isset($isDelegatedFilter) && $isDelegatedFilter == 0) {
                                    echo 'selected';
                                } ?>>No</option>
                            </select>

                        </div>


                    </div>
                    <br>
                    <div class="col" style="display:flex;justify-content:center;">
                        <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                    </div>

                </form>
            </div>
        </div>
    </div>



    <div class="col-12  grid-margin">


        <div class="card">

            <div class="card-body">
                <h5>Total Records: <strong class="record-count">
                        <? echo $total_records; ?>
                    </strong></h5>

                <hr />
                <form action="exportsites.php" method="POST">
                    <input type="hidden" name="exportSql" value="<? echo $atm_sql; ?>">
                    <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                </form>

                <!-- <form id="submitForm" class="<? if ($islho == 1) {
                    echo 'displayNone';
                } ?>">
                    <button type="submit">Bulk Delegate</button>
                </form> -->

            </div>
            <div class="card-body" style="overflow:auto;">

                <?
                // if (isset($_REQUEST['submit']) || isset($_GET['page'])) { 
                
                ?>

                <table class="table dataTable js-exportable no-footer table-xs" style="width:100%;">
                    <thead>
                        <tr class="table-primary">
                            <th>#</th>
                            <th>atmid </th>
                            <th class="<? if ($islho == 1) {
                                echo 'displayNone';
                            } ?>">Delegation</th>
                            <th class="<? if ($islho == 1) {
                                echo 'displayNone';
                            } ?>">Delegated To</th>
                            <th>History</th>
                            <th>Current Status</th>
                            <th>Assign</th>
                            <th>PO Number</th>
                            <th>PO Date</th>
                            <th>activity </th>
                            <th>customer </th>
                            <th>bank </th>
                            <th>address </th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>city </th>
                            <th>state </th>
                            <th>zone </th>
                            <th>LHO </th>
                            <th>LHO Contact Person </th>
                            <th>LHO Contact Person No. </th>
                            <th>LHO Contact Person email </th>
                            <th>LHO Adv Person </th>
                            <th>LHO Adv Contact </th>
                            <th>LHO Adv email </th>
                            <th>Project Coordinator Name </th>
                            <th>Project Coordinator No. </th>
                            <th>Project Coordinator email </th>
                            <th>Customer SLA </th>
                            <th>Our SLA </th>
                            <th>Vendor </th>
                            <th>Cash Management </th>
                            <th>CRA VENDOR </th>
                            <th>ID on Make </th>
                            <th>Model </th>
                            <th>SiteType </th>
                            <th>PopulationGroup </th>
                            <th>XPNET_RemoteAddress </th>
                            <th>CONNECTIVITY </th>
                            <th>Connectivity Type </th>
                            <th>Site data Received for Feasiblity date </th>
                            <th>ESD</th>
                            <th>ASD</th>
                            <th>Created At</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;

                        $counter = ($current_page - 1) * $page_size + 1;
                        $atm_sql_res = mysqli_query($con, $sql_query);
                        while ($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)) {
                            $isFeasibiltyDoneRecord = $atm_sql_result['isFeasibiltyDone'];

                            $id = $atm_sql_result['id'];
                            $po = $atm_sql_result['po'];
                            $po_date = $atm_sql_result['po_date'];
                            $activity = $atm_sql_result['activity'];
                            $customer = $atm_sql_result['customer'];
                            $bank = $atm_sql_result['bank'];
                            $atmid = $atm_sql_result['atmid'];
                            $address = $atm_sql_result['address'];
                            $city = $atm_sql_result['city'];
                            $state = $atm_sql_result['state'];
                            $zone = $atm_sql_result['zone'];
                            $LHO = $atm_sql_result['LHO'];
                            $LHO_Contact_Person = $atm_sql_result['LHO_Contact_Person'];
                            $LHO_Contact_Person_No = $atm_sql_result['LHO_Contact_Person_No'];
                            $LHO_Contact_Person_email = $atm_sql_result['LHO_Contact_Person_email'];
                            $LHO_Adv_Person = $atm_sql_result['LHO_Adv_Person'];
                            $LHO_Adv_Contact = $atm_sql_result['LHO_Adv_Contact'];
                            $LHO_Adv_email = $atm_sql_result['LHO_Adv_email'];
                            $Project_Coordinator_Name = $atm_sql_result['Project_Coordinator_Name'];
                            $Project_Coordinator_No = $atm_sql_result['Project_Coordinator_No'];
                            $Project_Coordinator_email = $atm_sql_result['Project_Coordinator_email'];
                            $Customer_SLA = $atm_sql_result['Customer_SLA'];
                            $Our_SLA = $atm_sql_result['Our_SLA'];
                            $Vendor = $atm_sql_result['Vendor'];
                            $Cash_Management = $atm_sql_result['Cash_Management'];
                            $CRA_VENDOR = $atm_sql_result['CRA_VENDOR'];
                            $ID_on_Make = $atm_sql_result['ID_on_Make'];
                            $Model = $atm_sql_result['Model'];
                            $SiteType = $atm_sql_result['SiteType'];
                            $PopulationGroup = $atm_sql_result['PopulationGroup'];
                            $XPNET_RemoteAddress = $atm_sql_result['XPNET_RemoteAddress'];
                            $CONNECTIVITY = $atm_sql_result['CONNECTIVITY'];
                            $Connectivity_Type = $atm_sql_result['Connectivity_Type'];
                            $Site_data_Received_for_Feasiblity_date = $atm_sql_result['Site_data_Received_for_Feasiblity_date'];
                            $isDelegated = $atm_sql_result['isDelegated'];
                            $created_at = $atm_sql_result['created_at'];
                            $created_by = $atm_sql_result['created_by'];
                            $created_by = getUsername($created_by, 0);
                            $longitude = $atm_sql_result['longitude'] ? $atm_sql_result['longitude'] : 'NA';
                            $latitude = $atm_sql_result['latitude'];
                            $verificationStatus = $atm_sql_result['verificationStatus'];
                            $delegatedtoVendorId = $atm_sql_result['delegatedtoVendorId'];
                            $ESD = $atm_sql_result['ESD'];
                            $ASD = $atm_sql_result['ASD'];
                            $lastUpdate = getLatestEvent($id, $atmid);

                            $projectInstallationsql = mysqli_query($con, "select * from projectInstallation where siteid = '" . $id . "' and status=1 order by id desc");
                            if ($projectInstallationsql_result = mysqli_fetch_assoc($projectInstallationsql)) {
                                $projectInstallation = true;
                                $projectInstallationVendor = $projectInstallationsql_result['vendor'];
                                $projectinstallationID = $projectInstallationsql_result['id'];
                            } else {
                                $projectInstallation = false;
                            }





                            $sql22 = "SELECT a.atmid, a.siteid, MAX(a.created_at) as latest_created_at, MAX(a.isSentToEngineer) as isSentToEngineer,
                            MAX(a.isDone) as isDone, MAX(b.assignedToId) as assignedToId, MAX(b.assignedToName) as assignedToName FROM projectInstallation a
                            LEFT JOIN assignedInstallation b ON a.siteid = b.siteid AND a.atmid = b.atmid WHERE a.vendor = '" . $RailTailVendorID . "' AND a.status = 1 
                            and a.atmid='" . $atmid . "'
                            GROUP BY a.atmid, a.siteid";
                            $result22 = mysqli_query($con, $sql22);
                            $row22 = mysqli_fetch_assoc($result22);


                            $sql23 = mysqli_query($con, "select * from projectInstallation where atmid='" . $atmid . "' and isDone=0");
                            if ($sql23Result = mysqli_fetch_assoc($sql23)) {
                                $foundForInstallation = 1;
                            } else {
                                $foundForInstallation = 0;
                            }


                            $isSentToEngineer = $row22['isSentToEngineer'];
                            $assignedToName = getusername($row22['assignedToId']);
                            $isDone = $row22['isDone'];


                            $delegatedTo = '';

                            ?>

                            <tr>
                                <th>
                                    <?php echo $counter; ?>
                                </th>
                                <td class="strong"> 
                                    <? echo $atmid; ?>
                                </td>
                                <td class="<? if ($islho == 1) {
                                    echo 'displayNone';
                                } ?>">
                                
                                    <?php

                                    $isScheduleFound = mysqli_fetch_assoc(mysqli_query($con, "select count(1) as total from projectinstallation where atmid='" . $atmid . "' and status=1"))['total'];
                                    if ($isScheduleFound) {
                                        if ($isFeasibiltyDoneRecord) {
                                            echo 'Feasibility: Done | ';
                                            echo '<a href="./feasibilityReport1.php?atmid=' . $atmid . '" target="_blank">Report</a>';
                                        } else {
                                            if ($isDelegated == 0) {
                                                echo '<a href="vendorsDelegation.php?id=' . $id . '&atmid=' . $atmid . '">Delegate ➜</a>';
                                            } else {
                                                echo '<button class="btn btn-success btn-icon" style="  width: 20px;height: auto !important;">&#10004;</button> | <a href="vendorsDelegation.php?id=' . $id . '&atmid=' . $atmid . '&action=redelegate">Delegate ➜</a>';
                                            }
                                        }

                                    } else {
                                        echo 'No Schedule';
                                    }
                                    ?>
                                </td>

                                <td class="<? if ($islho == 1) {
                                    echo 'displayNone';
                                } ?>">

                                    <?
                                    if ($isDelegated == 1) {

                                        //  echo "select * from vendorSitesDelegation where amtid='".$atmid."' order by id desc" ; 
                                        $delegationsql = mysqli_query($con, "select * from vendorSitesDelegation where amtid='" . $atmid . "' order by id desc");
                                        $delegationsql_result = mysqli_fetch_assoc($delegationsql);
                                        $delegationDate = $delegationsql_result['created_at'];

                                        $checkdel_query = mysqli_query($con, "SELECT engineerId FROM `delegation` WHERE atmid like '" . trim($atmid) . "' order by id desc");


                                        if (mysqli_num_rows($checkdel_query) > 0) {
                                            // echo 'eng' ; 
                                            $row = mysqli_fetch_assoc($checkdel_query);
                                            $delEngID = $row['engineerId'];
                                            echo $delegatedTo = '<span>' . getUsername($delEngID) . '</span> on <span>' . $delegationDate . '</span>';

                                        } else {
                                            // echo "SELECT vendorid FROM `vendorsitesdelegation` WHERE amtid='$atmid'" ; 
                                
                                            // echo "SELECT vendorid FROM `vendorsitesdelegation` WHERE amtid like '".trim($atmid)."'" ; 
                                            $delEngID = mysqli_fetch_assoc(mysqli_query($con, "SELECT vendorid FROM `vendorsitesdelegation` WHERE amtid like '" . trim($atmid) . "'"))['vendorid'];
                                            echo $delegatedTo = '<span>' . getVendorName($delEngID) . '</span> on <span>' . $delegationDate . '</span>';
                                        }


                                    } else {
                                        echo 'No data';
                                    }

                                    ?>
                                </td>
                                <td>

                                    <a href="#" data-bs-toggle="modal" class="history-link" data-bs-target="#historyModal"
                                        data-act="add" data-siteid="<?php echo $id; ?>">History</a>

                                    <?
                                    if ($projectInstallation) {
                                        ?>
                                        |
                                        <a href="#" data-bs-toggle="modal" class="schedule-link" data-bs-target="#scheduleModal"
                                            data-act="add" data-siteid="<?php echo $id; ?>">View Schedule</a>
                                    <?php }
                                    ?>

                                </td>
                                <td>
                                    <?
                                    echo ($verificationStatus
                                        ? ($verificationStatus === 'Verify' ? '<button class="btn btn-success btn-icon" title="Verification Approved">&#10004;</button>'
                                            : '<button class="btn btn-danger btn-icon" title="Verification Reject ">R</button> | <a href="reopenRejectFeasibility.php?id=' . $id . '&atmid=' . $atmid . '&action=reopen_redelegation&vendor=' . $projectInstallationVendor . '">Reopen <span style="color:red">⟳</span></a>')
                                        . ($projectInstallation
                                            ? ' '
                                            : ($verificationStatus === 'Verify'
                                                ? ''
                                                : '')
                                        )
                                        : '<button class="btn btn-warning btn-icon" style="  width: 20px;height: auto !important;" title="Pending">P</button>'
                                    );

                                    echo ' | <strong style="    color: #01a9ac;box-shadow: 1px 1px 1px 1px gray;
                                            padding: 4px;">' . $lastUpdate . '</strong>';



                                    ?>
                                </td>



                                <td>
                                    <?

                                    if ($isDone == 1) {
                                        echo 'Installation Done !';
                                    } else {
                                        if ($isSentToEngineer == 1 && $isFeasibiltyDoneRecord) {
                                            echo 'Assigned to <strong>' . $assignedToName . '</strong>';
                                        } else if ($isFeasibiltyDoneRecord && $foundForInstallation == 1) {
                                            echo '<a href="assignProjectInstallation.php?id=' . $projectinstallationID . '&siteid=' . $id . '&atmid=' . $atmid . '">Engineer Assign</a>';
                                        } else {
                                            echo '-';
                                        }
                                    }
                                    ?>
                                </td>



                                <td>
                                    <?= ($po ? $po : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($po_date ? $po_date : 'NA'); ?>
                                </td>

                                <td>
                                    <?= ($activity ? $activity : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($customer ? $customer : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($bank ? $bank : 'NA'); ?>
                                </td>

                                <td>
                                    <?= ($address ? $address : 'NA'); ?>
                                </td>

                                <td>
                                    <?= ($latitude ? $latitude : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($longitude ? $longitude : 'NA'); ?>
                                </td>

                                <td>
                                    <?= ($city ? $city : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($state ? $state : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($zone ? $zone : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($LHO ? $LHO : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($LHO_Contact_Person ? $LHO_Contact_Person : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($LHO_Contact_Person_No ? $LHO_Contact_Person_No : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($LHO_Contact_Person_email ? $LHO_Contact_Person_email : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($LHO_Adv_Person ? $LHO_Adv_Person : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($LHO_Adv_Contact ? $LHO_Adv_Contact : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($LHO_Adv_email ? $LHO_Adv_email : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Project_Coordinator_Name ? $Project_Coordinator_Name : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Project_Coordinator_No ? $Project_Coordinator_No : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Project_Coordinator_email ? $Project_Coordinator_email : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Customer_SLA ? $Customer_SLA : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Our_SLA ? $Our_SLA : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Vendor ? $Vendor : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Cash_Management ? $Cash_Management : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($CRA_VENDOR ? $CRA_VENDOR : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($ID_on_Make ? $ID_on_Make : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Model ? $Model : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($SiteType ? $SiteType : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($PopulationGroup ? $PopulationGroup : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($XPNET_RemoteAddress ? $XPNET_RemoteAddress : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($CONNECTIVITY ? $CONNECTIVITY : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Connectivity_Type ? $Connectivity_Type : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($Site_data_Received_for_Feasiblity_date ? $Site_data_Received_for_Feasiblity_date : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($ESD != '0000-00-00 00:00:00' ? $ESD : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($ASD != '0000-00-00 00:00:00' ? $ASD : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($created_at ? $created_at : 'NA'); ?>
                                </td>
                                <td>
                                    <?= ($created_by ? $created_by : 'NA'); ?>
                                </td>
                            </tr>
                            <? $counter++;
                        } ?>
                    </tbody>
                </table>

                <?
                // }
                ?>
            </div>




            <?




            $fromdt = $_REQUEST['fromdt'];
            $todt = $_REQUEST['todt'];
            $local_branch = $_REQUEST['local_branch'];
            $customer = $_REQUEST['customer'];
            $atmid = $_REQUEST['atmid'];
            $isDelegated = $_REQUEST['isDelegated'];
            $isFeasibiltyDone = $_REQUEST['isFeasibiltyDone'];
            $vendorId = $_REQUEST['vendorId'];
            $state = $_REQUEST['state'];



            echo '
            <div class="dataTables_wrapper form-inline dt-bootstrap no-footer" style="margin: auto;"> 
            <div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><ul class="pagination">';
            if ($start_window > 1) {

                echo "<li class='paginate_button'><a href='?page=1&&atmid=$atmid&&$customer&&page_size=$page_size&&isDelegated=$    &&isFeasibiltyDone=$isFeasibiltyDone&vendorId=$vendorId'&state='.$state.'>First</a></li>";
                echo '<li class="paginate_button"><a href="?page=' . ($start_window - 1) . '&&atmid=' . $atmid . '&&customer=' . $customer . '&&page_size=' . $page_size . '&&isDelegated=' . $isDelegated . '&&isFeasibiltyDone=' . $isFeasibiltyDone . '&vendorId=' . $vendorId . '&state=' . $state . '">Prev</a></li>';
            }

            for ($i = $start_window; $i <= $end_window; $i++) {
                ?>
                <li class="paginate_button <? if ($i == $current_page) {
                    echo 'active';
                } ?>">
                    <a
                        href="?page=<? echo $i; ?>&&atmid=<? echo $atmid; ?>&&customer=<? echo $customer; ?>&&page_size=<? echo $page_size; ?>&&isDelegated=<? echo $isDelegated; ?>&&isFeasibiltyDone=<? echo $isFeasibiltyDone; ?>&vendorId=<?= $vendorId; ?>&state=<?= $state; ?>">
                        <? echo $i; ?>
                    </a>
                </li>

            <? }

            if ($end_window < $total_pages) {

                echo '<li class="paginate_button"><a href="?page=' . ($end_window + 1) . '&&atmid=' . $atmid . '&&customer=' . $customer . '&&page_size=' . $page_size . '&&isDelegated=' . $isDelegated . '&&isFeasibiltyDone=' . $isFeasibiltyDone . '&vendorId=' . $vendorId . '&state=' . $state . '">Next</a></li>';
                echo '<li class="paginate_button"><a href="?page=' . $total_pages . '&&atmid=' . $atmid . '&&customer' . $customer . '&&page_size=' . $page_size . '&&isDelegated=' . $isDelegated . '&&isFeasibiltyDone=' . $isFeasibiltyDone . '&vendorId=' . $vendorId . '&state=' . $state . '">Last</a></li>';
            }
            echo '</ul></div></div>';


            ?>


        </div>

    </div>
</div>


<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="ModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Schedule</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="schduleContent" style="overflow: scroll;max-height: 70vh;"></div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="ModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">New message</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="historyContent" style="overflow: scroll;max-height: 70vh;"></div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script>


    $(document).on('click', '.schedule-link', function () {

        var siteId = $(this).data("siteid");

        var modal = document.getElementById("scheduleModal");
        $.ajax({
            url: "getschedule.php",
            type: "POST",
            data: {
                siteId: siteId
            },
            success: function (response) {
                $("#schduleContent").html(response);
                modal.style.display = "block";
            },
            error: function () {
                alert("Failed to fetch schdule data.");
            }
        });
    });

    $("#check_all").change(function () {
        $(".single_site_delegate").prop('checked', $(this).prop("checked"));
    });

    $("#submitForm").submit(function (e) {
        e.preventDefault();
        var checkedIds = [];
        $(".single_site_delegate:checked").each(function () {
            checkedIds.push($(this).val());
        });
        var form = $('<form action="vendorsDelegation.php" method="post"></form>');
        for (var i = 0; i < checkedIds.length; i++) {
            form.append('<input type="hidden" name="checkedIds[]" value="' + checkedIds[i] + '" />');
        }
        $('body').append(form);
        form.submit();
    });



    $(document).on('click', '.history-link', function () {

        var siteId = $(this).data("siteid");

        console.log('ds');
        var modal = document.getElementById("historyModal");
        $.ajax({
            url: "getHistory.php",
            type: "POST",
            data: {
                siteId: siteId
            },
            success: function (response) {
                $("#historyContent").html(response);
                modal.style.display = "block";
            },
            error: function () {
                alert("Failed to fetch history data.");
            }
        });
    });
</script>


<script src="../assets/vendors/js/vendor.bundle.base.js"></script>
<!-- <script src="../../assets/vendors/js/vendor.bundle.base.js"></script> -->

<?php include('../footer.php'); ?>