<? include('../header.php');


$atmid = $_REQUEST['atmid'];

?>




<style>
    tr th:first-child {
        width: 40%;
    }
</style>

<div class="row">
    <div class="col-lg-12">



        <div class="card">
            <div class="card-header">
                <h5 class="card-header-text">Feasibility Report for ATMID : <span
                        style="color:red;display: inline-block;">
                        <? echo $atmid; ?>
                    </span></h5>
            </div>
            <div class="card-block accordion-block">

                <div class="accordion accordion-filled" id="accordion-7" role="tablist">
                    <?php


                    if (isset($_POST['rejectsubmit'])) {
                        $status = 'Reject';

                        $feasibilityRemark = $_REQUEST['feasibilityRemark'];
                        $feasibiltyId = $_REQUEST['feasibiltyId'];
                        $atm_id = $_REQUEST['atmid'];
                        $getsiteIdSql = mysqli_query($con, "select * from sites where atmid='" . $atm_id . "'");
                        $getsiteIdSql_result = mysqli_fetch_assoc($getsiteIdSql);
                        $siteid = $getsiteIdSql_result['id'];

                        mysqli_query($con, "update sites set verificationStatus='" . $status . "' where id='" . $siteid . "'");
                        mysqli_query($con, "update feasibilityCheck set verificationStatus='" . $status . "' where id='" . $feasibiltyId . "'");

                        feasibilityApprovalReject($siteid, $atm_id, '', $feasibilityRemark);



                    } else if (isset($_POST['verifysubmit'])) {
                        $status = 'Verify';
                        $feasibiltyId = $_REQUEST['feasibiltyId'];
                        $atm_id = $_REQUEST['atmid'];
                        $getsiteIdSql = mysqli_query($con, "select * from sites where atmid='" . $atm_id . "'");
                        $getsiteIdSql_result = mysqli_fetch_assoc($getsiteIdSql);
                        $siteid = $getsiteIdSql_result['id'];

                        mysqli_query($con, "update sites set verificationStatus='" . $status . "' where id='" . $siteid . "'");
                        mysqli_query($con, "update feasibilityCheck set verificationStatus='" . $status . "', verificationBy='" . $userid . "',verificationByName='" . $username . "' where id='" . $feasibiltyId . "'");



                        feasibilityApprovalVerify($siteid, $atm_id, '');
                        // Initiate Material Request here
                    
                        $materialQuantities = [];
                        $sql = "SELECT value, count FROM boq";
                        $result = $con->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $materialName = $row['value'];
                                $quantity = $row['count'];
                                $materialQuantities[$materialName] = $quantity;
                            }
                        }



                        $feasSql = mysqli_query($con, "select * from feasibilityCheck where id='" . $feasibiltyId . "'");
                        $feasSql_result = mysqli_fetch_assoc($feasSql);
                        $isVendor = $feasSql_result['isVendor'];

                        if ($isVendor == 0) {
                            $type = 'Internal';
                            $vendorId = 0;
                        } else if ($isVendor == 1) {
                            $type = 'External';
                            $feasibiltyCreatedBy = $feasSql_result['created_by'];

                            $vendorsql = mysqli_query($con, "select * from user where id='" . $feasibiltyCreatedBy . "'");
                            $vendorsql_result = mysqli_fetch_assoc($vendorsql);
                            $vendorId = $vendorsql_result['vendorid'];

                        }





                        // Generate material requests
                    

                        foreach ($materialQuantities as $materialName => $quantity) {
                            // Insert the material request into the table
                    
                            $checkMaterialRequstSql = mysqli_query($con, "select * from material_requests where siteid='" . $siteid . "' and material_name='" . $materialName . "'");
                            if ($checkMaterialRequstSql_result = mysqli_fetch_assoc($checkMaterialRequstSql)) {

                                mysqli_query($con, "update material_requests set feasibility_id='" . $feasibiltyId . "' where 
                                                    siteid='" . $siteid . "' and material_name='" . $materialName . "'");

                                $manualSendFound = 1;
                            } else {
                                $sql = "INSERT INTO material_requests (siteid, feasibility_id, material_name, quantity, status, created_by,created_at,type,vendorId)
                                                            VALUES ('$siteid', '$feasibiltyId', '$materialName', '$quantity', 'pending', '" . $userid . "','" . $datetime . "','" . $type . "',$vendorId)";
                                if ($con->query($sql) === false) {
                                    echo "Error: " . "<br>" . $con->error;
                                    // echo "Error: " . $sql . "<br>" . $con->error;
                    
                                }
                                // echo '<br />';
                            }


                        }

                        if ($manualSendFound == 0) {
                            generatesAutoMaterialRequest($siteid, $atm_id, '');
                        }






                        // End Material Request
                    


                    }


                    $query = "SELECT * FROM feasibilityCheck where ATMID1='" . $atmid . "' order by id desc";

                    $result = $con->query($query);

                    if ($result->num_rows > 0) {
                        $i = 1;
                        if ($row = $result->fetch_assoc()) {
                            $id = $row['id'];

                            $noOfAtm = $row['noOfAtm'];
                            $ATMID1 = $row['ATMID1'];
                            $ATMID2 = $row['ATMID2'];
                            $ATMID3 = $row['ATMID3'];
                            $address = $row['address'];
                            $city = $row['city'];
                            $location = $row['location'];
                            $LHO = $row['LHO'];
                            $state = $row['state'];
                            $atm1Status = $row['atm1Status'];
                            $atm2Status = $row['atm2Status'];
                            $atm3Status = $row['atm3Status'];
                            $operator = $row['operator'];
                            $signalStatus = $row['signalStatus'];
                            $backroomNetworkRemark = $row['backroomNetworkRemark'];
                            $backroomNetworkSnap = $row['backroomNetworkSnap'];
                            $AntennaRoutingdetail = $row['AntennaRoutingdetail'];
                            $EMLockPassword = $row['EMLockPassword'];
                            $EMlockAvailable = $row['EMlockAvailable'];
                            $NoOfUps = $row['NoOfUps'];
                            $PasswordReceived = $row['PasswordReceived'];
                            $Remarks = $row['Remarks'];
                            $UPSAvailable = $row['UPSAvailable'];
                            $UPSBateryBackup = $row['UPSBateryBackup'];
                            $UPSWorking1 = $row['UPSWorking1'];
                            $UPSWorking2 = $row['UPSWorking2'];
                            $UPSWorking3 = $row['UPSWorking3'];
                            $backroomDisturbingMaterial = $row['backroomDisturbingMaterial'];
                            $backroomDisturbingMaterialRemark = $row['backroomDisturbingMaterialRemark'];
                            $backroomKeyName = $row['backroomKeyName'];
                            $backroomKeyNumber = $row['backroomKeyNumber'];
                            $backroomKeyStatus = $row['backroomKeyStatus'];
                            $earthing = $row['earthing'];
                            $earthingVltg = $row['earthingVltg'];
                            $frequentPowerCut = $row['frequentPowerCut'];
                            $frequentPowerCutFrom = $row['frequentPowerCutFrom'];
                            $frequentPowerCutRemark = $row['frequentPowerCutRemark'];
                            $frequentPowerCutTo = $row['frequentPowerCutTo'];
                            $nearestShopDistance = $row['nearestShopDistance'];
                            $nearestShopName = $row['nearestShopName'];
                            $nearestShopNumber = $row['nearestShopNumber'];
                            $powerFluctuationEN = $row['powerFluctuationEN'];
                            $powerFluctuationPE = $row['powerFluctuationPE'];
                            $powerFluctuationPN = $row['powerFluctuationPN'];
                            $powerSocketAvailability = $row['powerSocketAvailability'];
                            $routerAntenaPosition = $row['routerAntenaPosition'];
                            $routerAntenaSnap = $row['routerAntenaSnap'];
                            $AntennaRoutingSnap = $row['AntennaRoutingSnap'];
                            $UPSAvailableSnap = $row['UPSAvailableSnap'];
                            $NoOfUpsSnap = $row['NoOfUpsSnap'];
                            $upsWorkingSnap = $row['upsWorkingSnap'];
                            $powerSocketAvailabilitySnap = $row['powerSocketAvailabilitySnap'];
                            $earthingSnap = $row['earthingSnap'];
                            $powerFluctuationSnap = $row['powerFluctuationSnap'];
                            $remarksSnap = $row['remarksSnap'];
                            $status = $row['status'];
                            $created_at = $row['created_at'];
                            $powerSocketAvailabilityUPS = $row['powerSocketAvailabilityUPS'];
                            $powerSocketAvailabilityUPSSnap = $row['powerSocketAvailabilityUPSSnap'];
                            $operator2 = $row['operator2'];
                            $signalStatus2 = $row['signalStatus2'];
                            $backroomNetworkRemark2 = $row['backroomNetworkRemark2'];
                            $backroomNetworkSnap2 = $row['backroomNetworkSnap2'];
                            $created_by = $row['created_by'];
                            $feasibilityDone = $row['feasibilityDone'];
                            $isVendor = $row['isVendor'];
                            $ticketid = $row['ticketid'];
                            $verificationStatus = $row['verificationStatus'];
                            $ATMID1Snap = $row['ATMID1Snap'];
                            $ATMID2Snap = $row['ATMID2Snap'];
                            $ATMID3Snap = $row['ATMID3Snap'];
                            $verificationByName = $row['verificationByName'];
                            $routerPosition = $row['routerPosition'];
                            $routerPositionSnap = $row['routerPositionSnap'];
                            $getverificationStatus = $row['verificationStatus'];


                            $isVendor = $row['isVendor'];
                            $atm_id = $row['atmid'];

                            $baseurl = 'http://clarity.advantagesb.com/corona/API/';


                            // $baseurl = $baseurl . '/corona' ;
                    
                            ?>

                            <div class="card">
                                <div class="card-header" role="tab" id="heading-<?= $i; ?>">
                                    <h5 class="mb-0">
                                        <? echo 'Feasibility Check - ' . ($verificationStatus ? $verificationStatus : 'Pending'); ?>

                                    </h5>
                                </div>

                                <form action="<? $_SERVER['PHP_SELF'] . '?atmid=' . $atmid ?> " method="POST">

                                    <table class="table">
                                        <tr>
                                            <th> No of Atm Available</th>
                                            <td>
                                                <?= $noOfAtm; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>A T M I D1</th>
                                            <td>
                                                <?= $ATMID1; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>
                                                <?= $address; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>City</th>
                                            <td>
                                                <?= $city; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <td>
                                                <?= $location; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>L H O</th>
                                            <td>
                                                <?= $LHO; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>
                                                <?= $state; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ATMID 1 Working</th>
                                            <td>
                                                <?= $atm1Status; ?>
                                            </td>
                                        </tr>

                                        
                                        <tr>
                                            <th>Backroom Network Snap 1</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $ATMID1Snap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $ATMID1Snap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>




                                            </td>
                                        </tr>
                                    </table>







                                    <br>

                                    <table class="table">


                                        <tr>Network available in back room</tr>

                                        <tr>
                                            <th>Operator 1</th>
                                            <td>
                                                <?= $operator; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Signal Status 1</th>
                                            <td>
                                                <?= $signalStatus; ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>Backroom Network Remark 1 </th>
                                            <td>
                                                <?= $backroomNetworkRemark; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Backroom Network Snap 1</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $backroomNetworkSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $backroomNetworkSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>




                                            </td>
                                        </tr>


                                        <tr>
                                            <th>Operator 2</th>
                                            <td>
                                                <?= $operator2; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Signal Status 2</th>
                                            <td>
                                                <?= $signalStatus2; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Backroom Network Remark 2</th>
                                            <td>
                                                <?= $backroomNetworkRemark2; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Backroom Network Snap 2</th>
                                            <td>
                                                <a href="<?= $baseurl . $backroomNetworkSnap2; ?>" target="_blank">View
                                                    Image</a>
                                            </td>
                                        </tr>

                                    </table>



                                    <br>

                                    <table class="table">
                                        <tr>Back Room Key</tr>
                                        <tr>
                                            <th>Backroom Key Name</th>
                                            <td>
                                                <?= $backroomKeyName; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Backroom Key Number</th>
                                            <td>
                                                <?= $backroomKeyNumber; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Backroom Key Status</th>
                                            <td>
                                                <?= $backroomKeyStatus; ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>


                                    EMlockAvailable

                                    <table class="table">
                                        <tr>
                                            <th>EM lock Available</th>
                                            <td>
                                                <?= $EMlockAvailable; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Password Received</th>
                                            <td>
                                                <?= $PasswordReceived; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>E M Lock Password</th>
                                            <td>
                                                <?= $EMLockPassword; ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>




                                    <table class="table">
                                        <tr>router</tr>
                                        <tr>
                                            <th>Place to fix router</th>
                                            <td>
                                                <?= $routerPosition; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Place to fixe router Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $routerPositionSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $routerPositionSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Place to fix Router Antenna</th>
                                            <td>
                                                <?= $routerAntenaPosition; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Router Antena Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $routerAntenaSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $routerAntenaSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>


                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Antenna Routingdetail</th>
                                            <td>
                                                <?= $AntennaRoutingdetail; ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>Antenna Routing Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $AntennaRoutingSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $AntennaRoutingSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                    </table>
                                    <br>





                                    <table class="table">
                                        <tr>UPS</tr>
                                        <tr>
                                            <th>U P S Available</th>
                                            <td>
                                                <?= $UPSAvailable; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>U P S Available Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $UPSAvailableSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $UPSAvailableSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>

                                            </td>
                                        </tr>

                                        <tr>
                                            <th>No Of Ups</th>
                                            <td>
                                                <?= $NoOfUps; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>No Of Ups Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $NoOfUpsSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $NoOfUpsSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>U P S Working1</th>
                                            <td>
                                                <?= $UPSWorking1; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>U P S Working2</th>
                                            <td>
                                                <?= $UPSWorking2; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>U P S Working3</th>
                                            <td>
                                                <?= $UPSWorking3; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>UPS Working Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $upsWorkingSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $upsWorkingSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>

                                            </td>
                                        </tr>

                                        <tr>
                                            <th>U P S Batery Backup</th>
                                            <td>
                                                <?= $UPSBateryBackup; ?>
                                            </td>
                                        </tr>
                                    </table>


                                    <br>

                                    <table class="table">
                                        <tr>Power</tr>

                                        <tr>
                                            <th>Power Socket Available for Router in DB</th>
                                            <td>
                                                <?= $powerSocketAvailability; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Power Socket Availability Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $powerSocketAvailabilitySnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $powerSocketAvailabilitySnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>

                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Power Socket Available for Router in UPS</th>
                                            <td>
                                                <?= $powerSocketAvailabilityUPS; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Power Socket Available for Router in UPS Snap</th>
                                            <td>
                                                <a href="<?= $baseurl . $powerSocketAvailabilityUPSSnap; ?>"
                                                    target="_blank">View Image</a>
                                            </td>
                                        </tr>




                                        <tr>
                                            <th>Earthing</th>
                                            <td>
                                                <?= $earthing; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Earthing Vltg</th>
                                            <td>
                                                <?= $earthingVltg; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Earthing Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $earthingSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $earthingSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>
                                            </td>
                                        </tr>



                                        <tr>
                                            <th>Power Fluctuation PE</th>
                                            <td>
                                                <?= $powerFluctuationPE; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Power Fluctuation PN</th>
                                            <td>
                                                <?= $powerFluctuationPN; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Power Fluctuation EN</th>
                                            <td>
                                                <?= $powerFluctuationEN; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Power Fluctuation Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $powerFluctuationSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $powerFluctuationSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Frequent Power Cut</th>
                                            <td>
                                                <?= $frequentPowerCut; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Frequent Power Cut From</th>
                                            <td>
                                                <?= $frequentPowerCutFrom; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Frequent Power Cut To</th>
                                            <td>
                                                <?= $frequentPowerCutTo; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Frequent Power Cut Remark</th>
                                            <td>
                                                <?= $frequentPowerCutRemark; ?>
                                            </td>
                                        </tr>

                                    </table>
                                    <br>



                                    <table class="table">

                                        <tr>Other </tr>
                                        <tr>
                                            <th>Backroom Disturbing Material</th>
                                            <td>
                                                <?= $backroomDisturbingMaterial; ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>Backroom Disturbing Material Remark</th>
                                            <td>
                                                <?= $backroomDisturbingMaterialRemark; ?>
                                            </td>
                                        </tr>




                                        <tr>
                                            <th>Remarks</th>
                                            <td>
                                                <?= $Remarks; ?>
                                            </td>
                                        </tr>









                                        <tr>
                                            <th>Nearest Shop Distance</th>
                                            <td>
                                                <?= $nearestShopDistance; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nearest Shop Name</th>
                                            <td>
                                                <?= $nearestShopName; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nearest Shop Number</th>
                                            <td>
                                                <?= $nearestShopNumber; ?>
                                            </td>
                                        </tr>











                                        <tr>
                                            <th>Remarks Snap</th>
                                            <td>
                                                <?
                                                $imageFileName = pathinfo($baseurl . $remarksSnap, PATHINFO_BASENAME);
                                                if (isImageFile($imageFileName)) {
                                                    echo '<a href="' . $baseurl . $remarksSnap . '" target="_blank">View</a>';
                                                } else {
                                                    echo 'No Image Found';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created Date</th>
                                            <td>
                                                <?= $created_at; ?>
                                            </td>
                                        </tr>




                                        <tr>
                                            <th>Created By</th>
                                            <td>
                                                <?= getUsername($created_by, true); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Feasibility Done</th>
                                            <td>
                                                <?= $feasibilityDone; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Is Vendor</th>
                                            <td>
                                                <?= getVendorName($isVendor); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Ticketid</th>
                                            <td>
                                                <?= $id; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ATMID1 Snap</th>
                                            <td>
                                                <a href="<?= $baseurl . $ATMID1Snap; ?>" target="_blank">View Image</a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Verification Status</th>
                                            <td>
                                                <?= $verificationStatus; ?>
                                            </td>
                                        </tr>



                                        <tr>
                                            <th> Action By </th>
                                            <td>
                                                <?= $verificationByName; ?>
                                            </td>
                                        </tr>




                                    </table>

                                    <br>
                                    <?

                                    if (isset($getverificationStatus) && !empty($getverificationStatus)) {
                                        if ($getverificationStatus == 'Reject') {
                                            echo '<h4>Rejected !</h4>';
                                        } else if ($getverificationStatus == 'Verify') {
                                            echo '<h4>Verified !</h4>';
                                        }
                                    } else {

                                        echo '<input type="text" name="feasibilityRemark" class="form-control" placeholder="Enter Remarks !" required />';
                                        echo '<input type="hidden" name="atm_id" value="' . $atm_id . '" />';
                                        echo '<input type="hidden" name="feasibiltyId" value="' . $id . '" />';
                                        echo '<br />';
                                        echo '<input type="submit" name="verifysubmit" value="Verify" class="btn btn-primary" onclick="return confirm(\'Are you sure you want to verify ?\');">';
                                        echo '&nbsp;&nbsp;<input type="submit" name="rejectsubmit" value="Reject" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to reject ?\');">';

                                    }

                                    ?>
                                </form>


                            </div>



                            <?



                            $i++;
                        }
                    } else {
                        echo "No records found.";
                    }

                    $con->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? include('../footer.php'); ?>