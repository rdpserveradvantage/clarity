<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="row">
<div class="page-body">
                    <!--<a href="holdReason.php" target="_blank">Hold Reason</a>-->

                    <?
                    $siteid = $_REQUEST['siteid'];
                    $sql = mysqli_query($con, "select * from sites where id='" . $siteid . "'");
                    $sql_result = mysqli_fetch_assoc($sql);
                    $atmid = $sql_result['atmid'];
                    $atmid2 = $sql_result['atmid2'];
                    $atmid3 = $sql_result['atmid3'];
                    $lho = $sql_result['LHO'];
                    $city = $sql_result['city'];
                    $state = $sql_result['state'];
                    $address = $sql_result['address'];



                    $sealVerificationSql = mysqli_query($con, "select * from sealVerification where siteid='" . $siteid . "' and status=1 order by id desc");
                    $sealVerificationSqlResult = mysqli_fetch_assoc($sealVerificationSql);

                    $isVerify = $sealVerificationSqlResult['isVerify'];
                    if ($isVerify == 1) {
                        $isVerifyRemark = 'Approved';
                    } else if ($isVerify == 2) {
                        $isVerifyRemark = 'Reject';
                    } else if ($isVerify == 0) {
                        $isVerifyRemark = 'Pending';
                    }
                    echo "select * from material_send where siteid='" . $siteid . "' and atmid='" . $atmid . "' order by id desc" ;
                    $materialSql = mysqli_query($con, "select * from material_send where siteid='" . $siteid . "' and atmid='" . $atmid . "' order by id desc");
                    $materialSql_result = mysqli_fetch_assoc($materialSql);
                    $materialSendId = $materialSql_result['id'];

                    // echo "select * from material_send_details where materialSendId = '" . $materialSendId . "' and attribute like 'Router'" ; 
                    $material_send_detailsSql = mysqli_query($con, "select * from material_send_details where materialSendId = '" . $materialSendId . "' and attribute like 'Router'");
                    $material_send_detailsSqlResult = mysqli_fetch_assoc($material_send_detailsSql);
                    $serialNumber = $material_send_detailsSqlResult['serialNumber'];

                    ?>

                    <div class="card">
                        <div class="card-body" style="overflow: auto;">
                            <?
                            $checkSiteExist = mysqli_query($con, "select * from sites where id='" . $siteid . "'");
                            if ($checkSiteExist_result = mysqli_fetch_assoc($checkSiteExist)) {



                                $checkInstallationDonesql = mysqli_query($con, "select * from projectInstallation where isDone=1 and siteid='" . $siteid . "' and atmid='" . $atmid . "'");
                                if ($checkInstallationDonesql_result = mysqli_fetch_assoc($checkInstallationDonesql)) {
                                    echo ' Installation Done !';
                                } else {
                                    ?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 style="text-align: center;">ATM ID : <?= $atmid; ?></h4>
                                                    <hr>





                    
                                                    <ul class="nav nav-tabs md-tabs" role="tablist">
                                                        <li class="nav-item" style="width:33%">
                                                            <a class="nav-link active" data-bs-toggle="tab" href="#verification" role="tab" aria-selected="false"><i class="icofont icofont-home"></i>Security seal Verification</a>
                                                            <div class="slide"></div>
                                                        </li>
                                                        <li class="nav-item" style="width:33%">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#home7" role="tab" aria-selected="false" <? if ($isVerify != 1) {
                                                                echo 'disabled';
                                                            } ?>><i class="icofont icofont-home"></i>Installation Process</a>
                                                            <div class="slide"></div>
                                                        </li>
                                                        <li class="nav-item" style="width:33%">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#holdReason" role="tab" aria-selected="false"><i class="icofont icofont-ui-user"></i>Hold Reason</a>
                                                            <div class="slide"></div>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content card-block">

                                                        <div class="tab-pane fade show active" id="verification" role="tabpanel">
                                                            <br />
                                                            <style>
                                                                .image-preview-container {
                                                                    display: flex;
                                                                    flex-wrap: wrap;
                                                                }

                                                                .image-preview {
                                                                    max-width: 300px;
                                                                    max-height: 200px;
                                                                    margin: 5px;
                                                                }

                                                                .delete-button {
                                                                    cursor: pointer;
                                                                    color: red;
                                                                }
                                                            </style>


                                                            <?


                                                            $sealSql = mysqli_query($con, "select * from sealVerificationImages where siteid='" . $siteid . "' and atmid='" . $atmid . "' and status=1");

                                                            if (mysqli_num_rows($sealSql) > 0) {
                                                                echo "<h2>Seal Verification Images:</h2>";
                                                                echo "<ul>";
                                                                while ($row = mysqli_fetch_assoc($sealSql)) {
                                                                    $imagePath = $row['imageUrl'];
                                                                    echo "<li  style='display:inline-block;margin: 10px;'><img src='" . $imagePath . "' alt='Seal Image' style='max-width: 200px; max-height: 200px;' /></li>";
                                                                }
                                                                echo "</ul>";
                                                            }
                                                            ?>

                                                    
                                                            <h4>Approval Status : <? echo $isVerifyRemark; ?> </h4>


                                                            <form id="sealVerification" enctype="multipart/form-data" class="row">
                                                                <input type="hidden" name="siteid" value="<? echo $siteid; ?>">
                                                                <input type="hidden" name="atmid" value="<? echo $atmid; ?>">

                                                                <div class="col-sm-12">
                                                                    <h6 style="color:red;">Upload Security seal no. Image (can also select multiple images )</h6>

                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <br />
                                                                    <input type="file" name="sealImage[]" id="image" onchange="previewImage(event)" multiple>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <br />
                                                                    <div class="image-preview-container"></div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <br />
                                                                    <button class="btn btn-primary" id="submitSealverification">Send For Verification</button>
                                                                </div>
                                                            </form>




                                                        </div>

                                                        <div class="tab-pane fade show" id="home7" role="tabpanel">
                                                            <form id="installationForm" enctype="multipart/form-data">
                                                                <input type="hidden" name="siteid" value="<? echo $siteid; ?>">
                                                                <input type="hidden" name="atmid" value="<? echo $atmid; ?>">

                                                                <table class="table">
                                                                    <tr>
                                                                        <td><label for="atmId">ATM ID:</label></td>
                                                                        <td><input type="text" id="atmId" name="atmId" value="<? echo $atmid; ?>" readonly /></td>
                                                                    </tr>
                                                                    <!--<tr>-->
                                                                    <!--    <td><label for="atmId2">ATM ID 2:</label></td>-->
                                                                    <!--    <td><input type="text" id="atmId2" name="atmId2" value="<? echo $atmid2; ?>" /></td>-->
                                                                    <!--</tr>-->
                                                                    <!--<tr>-->
                                                                    <!--    <td><label for="atmId3">ATM ID 3:</label></td>-->
                                                                    <!--    <td><input type="text" id="atmId3" name="atmId3" value="<? echo $atmid3; ?>" /></td>-->
                                                                    <!--</tr>-->
                                                                    <tr>
                                                                        <td><label for="address">Address:</label></td>
                                                                        <td><input type="text" id="address" name="address" value="<? echo $address; ?>" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="city">City:</label></td>
                                                                        <td><input type="text" id="city" name="city" value="<? echo $city; ?>" readonly /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="location">Location:</label></td>
                                                                        <td><input type="text" id="location" name="location" value="<? echo $address; ?>" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="lho">LHO:</label></td>
                                                                        <td><input type="text" id="lho" name="lho" value="<? echo $lho; ?>" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="state">State:</label></td>
                                                                        <td><input type="text" id="state" name="state" value="<? echo $state; ?>" readonly /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="atmWorking1">Atm 1 Working </label></td>
                                                                        <td>
                                                                            <select name="atmWorking1" required>
                                                                                <option value="">Select</option>
                                                                                <option>Yes</option>
                                                                                <option>No</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <!--<tr>-->
                                                                    <!--    <td><label for="atmWorking2">Atm 2 Working </label></td>-->
                                                                    <!--    <td>-->
                                                                    <!--        <select name="atmWorking2" required>-->
                                                                    <!--            <option value="">Select</option>-->
                                                                    <!--            <option>Yes</option>-->
                                                                    <!--            <option>No</option>-->
                                                                    <!--        </select>-->
                                                                    <!--    </td>-->
                                                                    <!--</tr>-->
                                                                    <!--<tr>-->
                                                                    <!--    <td><label for="atmWorking3">Atm 3 Working </label></td>-->
                                                                    <!--    <td>-->
                                                                    <!--        <select name="atmWorking3" required>-->
                                                                    <!--            <option value="">Select</option>-->
                                                                    <!--            <option>Yes</option>-->
                                                                    <!--            <option>No</option>-->
                                                                    <!--        </select>-->
                                                                    <!--    </td>-->
                                                                    <!--</tr>-->
                                                                    <tr>
                                                                        <td><label for="vendorName">Installation Vendor Name:</label></td>
                                                                        <td><input type="text" id="vendorName" name="vendorName" value="<?= getVendorName($RailTailVendorID); ?>" readonly /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="engineerName">Installation Engineer Name & Number:</label></td>
                                                                        <td><input type="text" id="engineerName" name="engineerName" /><input type="text" id="engineerNumber" name="engineerNumber" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <h5>Router</h5>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerSerial">Serial No:</label></td>
                                                                        <td><input type="text" id="routerSerial" name="routerSerial" value="<?= $serialNumber; ?>" readonly /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerMake">Make:</label></td>
                                                                        <td><input type="text" id="routerMake" name="routerMake" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerModel">Model:</label></td>
                                                                        <td><input type="text" id="routerModel" name="routerModel" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <h5>Router_Fixed</h5>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerFixedYes">Yes:</label></td>
                                                                        <td><input type="radio" id="routerFixedYes" name="routerFixed" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerFixedNo">No:</label></td>
                                                                        <td><input type="radio" id="routerFixedNo" name="routerFixed" value="no" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerFixedRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="routerFixedRemarks" name="routerFixedRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerFixedSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="routerFixedSnaps" name="routerFixedSnaps" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <h5>Router Status</h5>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerStatusWorking">Working:</label></td>
                                                                        <td><input type="radio" id="routerStatusWorking" name="routerStatus" value="working" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerStatusNotWorking">Not Working:</label></td>
                                                                        <td><input type="radio" id="routerStatusNotWorking" name="routerStatus" value="notWorking" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerStatusRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="routerStatusRemarks" name="routerStatusRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="routerStatusSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="routerStatusSnaps" name="routerStatusSnaps" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <h5>adaptor Installed</h5>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="adaptorInstalledYes">Yes:</label></td>
                                                                        <td><input type="radio" id="adaptorInstalledYes" name="adaptorInstalled" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="adaptorInstalledNo">No:</label></td>
                                                                        <td><input type="radio" id="adaptorInstalledNo" name="adaptorInstalled" value="no" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="adaptorSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="adaptorSnaps" name="adaptorSnaps" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <h5>Adaptor Status</h5>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="adaptorStatusWorking">Working:</label></td>
                                                                        <td><input type="radio" id="adaptorStatusWorking" name="adaptorStatus" value="working" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="adaptorStatusNotWorking">Not Working:</label></td>
                                                                        <td><input type="radio" id="adaptorStatusNotWorking" name="adaptorStatus" value="notWorking" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="adaptorStatusRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="adaptorStatusRemarks" name="adaptorStatusRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="adaptorStatusSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="adaptorStatusSnaps" name="adaptorStatusSnaps" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <h5>LAN Cable Installed</h5>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="lanCableInstalledYes">Yes</label></td>
                                                                        <td><input type="radio" id="lanCableInstalledYes" name="lanCableInstalled" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="lanCableInstalledNo">No</label></td>
                                                                        <td><input type="radio" id="lanCableInstalledNo" name="lanCableInstalled" value="no" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="lanCableInstallRemark">Remarks:</label></td>
                                                                        <td><input type="text" id="lanCableInstallRemark" name="lanCableInstallRemark" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="lanCableInstallSnap">Snaps:</label></td>
                                                                        <td><input type="file" id="lanCableInstallSnap" name="lanCableInstallSnap" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <h5>LAN Cable Status</h5>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Yes</label></td>
                                                                        <td><input type="radio" id="lanCableStatusYes" name="lanCableStatus" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="lanCableInstalledNo">No</label></td>
                                                                        <td>
                                                                            <input type="radio" id="lanCableStatusNo" name="lanCableStatus" value="no" />
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <select name="lanCableStatusNotWorkingReasons">
                                                                                <option value="">--Select--</option>
                                                                                <option>Cable Faulty</option>
                                                                                <option>RJ 45 Faulty</option>
                                                                                <option>Any Other</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="lanCableInstallRemark">Remarks:</label></td>
                                                                        <td><input type="text" id="lanCableStatusRemark" name="lanCableStatusRemark" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="lanCableInstallSnap">Snaps:</label></td>
                                                                        <td><input type="file" id="lanCableStatusSnap" name="lanCableStatusSnap" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <h5>4G Antenna Installed</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="antennaInstalledYes">Yes:</label></td>
                                                                        <td><input type="radio" id="antennaInstalledYes" name="antennaInstalled" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="antennaInstalledNo">No:</label></td>
                                                                        <td><input type="radio" id="antennaInstalledNo" name="antennaInstalled" value="no" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="antennaRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="antennaRemarks" name="antennaRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="antennaSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="antennaSnaps" name="antennaSnaps" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>4G Antenna Status</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="antennaStatusWorking">Working:</label></td>
                                                                        <td><input type="radio" id="antennaStatusWorking" name="antennaStatus" value="working" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><label for="antennaStatusNotWorking">Not Working:</label></td>
                                                                        <td><input type="radio" id="antennaStatusNotWorking" name="antennaStatus" value="notWorking" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="antennaStatusRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="antennaStatusRemarks" name="antennaStatusRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="antennaStatusSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="antennaStatusSnaps" name="antennaStatusSnaps" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>GPS Antenna Installed</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="gpsInstalledYes">Yes:</label></td>
                                                                        <td><input type="radio" id="gpsInstalledYes" name="gpsInstalled" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="gpsInstalledNo">No:</label></td>
                                                                        <td><input type="radio" id="gpsInstalledNo" name="gpsInstalled" value="no" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="gpsRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="gpsRemarks" name="gpsRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="gpsSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="gpsSnaps" name="gpsSnaps" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>GPS Antenna Status</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="gpsStatusWorking">Working:</label></td>
                                                                        <td><input type="radio" id="gpsStatusWorking" name="gpsStatus" value="working" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="gpsStatusNotWorking">Not Working:</label></td>
                                                                        <td><input type="radio" id="gpsStatusNotWorking" name="gpsStatus" value="notWorking" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="gpsStatusRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="gpsStatusRemarks" name="gpsStatusRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="gpsStatusSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="gpsStatusSnaps" name="gpsStatusSnaps" /></td>
                                                                    </tr>

                                                                    <!-- Continue adding the remaining fields -->
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>Wifi Antenna Installed</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="wifiInstalledYes">Yes:</label></td>
                                                                        <td><input type="radio" id="wifiInstalledYes" name="wifiInstalled" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="wifiInstalledNo">No:</label></td>
                                                                        <td><input type="radio" id="wifiInstalledNo" name="wifiInstalled" value="no" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="wifiRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="wifiRemarks" name="wifiRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="wifiSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="wifiSnaps" name="wifiSnaps" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>Wifi Antenna Status</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="wifiStatusWorking">Working:</label></td>
                                                                        <td><input type="radio" id="wifiStatusWorking" name="wifiStatus" value="working" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="wifiStatusNotWorking">Not Working:</label></td>
                                                                        <td><input type="radio" id="wifiStatusNotWorking" name="wifiStatus" value="notWorking" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="wifiStatusRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="wifiStatusRemarks" name="wifiStatusRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="wifiStatusSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="wifiStatusSnaps" name="wifiStatusSnaps" /></td>
                                                                    </tr>

                                                                    <!-- Continue adding the remaining fields -->
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>airtel SIM Installed</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="airtelSimInstalledYes">Yes:</label></td>
                                                                        <td><input type="radio" id="airtelSimInstalledYes" name="airtelSimInstalled" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="airtelSimInstalledNo">No:</label></td>
                                                                        <td><input type="radio" id="airtelSimInstalledNo" name="airtelSimInstalled" value="no" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="airtelSimRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="airtelSimRemarks" name="airtelSimRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="airtelSimSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="airtelSimSnaps" name="airtelSimSnaps" /></td>
                                                                    </tr>

                                                                    <!-- airtel SIM Status -->
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>airtel SIM Status</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="airtelSimStatusWorking">Working:</label></td>
                                                                        <td><input type="radio" id="airtelSimStatusWorking" name="airtelSimStatus" value="working" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="airtelSimStatusNotWorking">Not Working:</label></td>
                                                                        <td><input type="radio" id="airtelSimStatusNotWorking" name="airtelSimStatus" value="notWorking" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="airtelSimStatusRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="airtelSimStatusRemarks" name="airtelSimStatusRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="airtelSimStatusSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="airtelSimStatusSnaps" name="airtelSimStatusSnaps" /></td>
                                                                    </tr>

                                                                    <!-- Vodafone SIM Installed -->
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>Vodafone SIM Installed</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="vodafoneSimInstalledYes">Yes:</label></td>
                                                                        <td><input type="radio" id="vodafoneSimInstalledYes" name="vodafoneSimInstalled" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="vodafoneSimInstalledNo">No:</label></td>
                                                                        <td><input type="radio" id="vodafoneSimInstalledNo" name="vodafoneSimInstalled" value="no" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="vodafoneSimRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="vodafoneSimRemarks" name="vodafoneSimRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="vodafoneSimSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="vodafoneSimSnaps" name="vodafoneSimSnaps" /></td>
                                                                    </tr>

                                                                    <!-- Vodafone SIM Status -->
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>Vodafone SIM Status</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="vodafoneSimStatusWorking">Working:</label></td>
                                                                        <td><input type="radio" id="vodafoneSimStatusWorking" name="vodafoneSimStatus" value="working" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="vodafoneSimStatusNotWorking">Not Working:</label></td>
                                                                        <td><input type="radio" id="vodafoneSimStatusNotWorking" name="vodafoneSimStatus" value="notWorking" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="vodafoneSimStatusRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="vodafoneSimStatusRemarks" name="vodafoneSimStatusRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="vodafoneSimStatusSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="vodafoneSimStatusSnaps" name="vodafoneSimStatusSnaps" /></td>
                                                                    </tr>

                                                                    <!-- JIO SIM Installed -->
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>JIO SIM Installed</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="jioSimInstalledYes">Yes:</label></td>
                                                                        <td><input type="radio" id="jioSimInstalledYes" name="jioSimInstalled" value="yes" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="jioSimInstalledNo">No:</label></td>
                                                                        <td><input type="radio" id="jioSimInstalledNo" name="jioSimInstalled" value="no" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="jioSimRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="jioSimRemarks" name="jioSimRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="jioSimSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="jioSimSnaps" name="jioSimSnaps" /></td>
                                                                    </tr>

                                                                    <!-- JIO SIM Status -->
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h5>JIO SIM Status</h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="jioSimStatusWorking">Working:</label></td>
                                                                        <td><input type="radio" id="jioSimStatusWorking" name="jioSimStatus" value="working" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="jioSimStatusNotWorking">Not Working:</label></td>
                                                                        <td><input type="radio" id="jioSimStatusNotWorking" name="jioSimStatus" value="notWorking" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="jioSimStatusRemarks">Remarks:</label></td>
                                                                        <td><input type="text" id="jioSimStatusRemarks" name="jioSimStatusRemarks" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="jioSimStatusSnaps">Snaps:</label></td>
                                                                        <td><input type="file" id="jioSimStatusSnaps" name="jioSimStatusSnaps" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align: center;">
                                                                            <h5>Signature of Engineer Installed</h5>

                                                                            <div>
                                                                                <label for="signatureCanvas">Digital Signature:</label><br />
                                                                                <canvas id="signatureCanvas" width="600" height="200"></canvas><br />
                                                                                <button type="button" onclick="clearSignature()">Clear</button>
                                                                            </div>

                                                                            <br />
                                                                            <label for="vendorStamp">Stamp of Vendor:</label>
                                                                            <input type="file" id="vendorStamp" name="vendorStamp" />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <button type="button" onclick="submitForm()" id="submitButton">Submit</button>
                                                                            <div id="loadingIndicator" style="display: none;">Loading...</div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </form>
                                                        </div>

                                                        <div class="tab-pane" id="holdReason" role="tabpanel">

                                                            <form id="holdInstallationForm">
                                                                <input type="hidden" name="siteid" value="<? echo $siteid; ?>">
                                                                <input type="hidden" name="atmid" value="<? echo $atmid; ?>">



                                                                <input type="hidden" name="engineerName" value="<? echo getUsername($userid); ?>">
                                                                <input type="hidden" name="engineerid" value="<? echo $userid; ?>">
                                                                <input type="hidden" name="siteid" value="<? echo $siteid; ?>">
                                                                <input type="hidden" name="atmid" value="<? echo $atmid; ?>">

                                                                <h5>Customer Dependency</h5>

                                                                <select id="dependency" name="dependency">
                                                                    <option value="">-- Select -- </option>
                                                                    <option value="ATM Shutter Down">ATM Shutter Down</option>
                                                                    <option value="Permission Issue">Permission Issue</option>
                                                                    <option value="Back Room Key">Back Room Key</option>
                                                                    <option value="Back Room EM lock">Back Room EM lock</option>
                                                                    <option value="ATM Machine Down">ATM Machine Down</option>
                                                                    <option value="Power issue">Power issue</option>
                                                                    <option value="Electrical issue">Electrical issue</option>
                                                                    <option value="UPS Issue">UPS Issue</option>
                                                                    <option value="Rodent issue">Rodent issue</option>
                                                                    <option value="LL rent issue">LL rent issue</option>
                                                                    <option value="ATM Renovation">ATM Renovation</option>
                                                                    <option value="ATM Relocation">ATM Relocation</option>
                                                                    <option value="Unwanted Material kept in backroom">Unwanted Material kept in backroom</option>
                                                                    <option value="ATM Lan cable Faulty">ATM Lan cable Faulty</option>
                                                                    <option value="Late night access not available">Late night access not available</option>
                                                                    <option value="Ladder Required">Ladder Required</option>
                                                                    <option value="ATM Not Available">ATM Not Available</option>
                                                                </select>

                                                                <div id="powerIssueDropdown" style="display: none;">
                                                                    <hr />
                                                                    <label for="powerIssue">Select the specific power issue:</label>
                                                                    <select id="powerIssue" name="powerIssue">
                                                                        <option value="">-- Select -- </option>
                                                                        <option value="Area Power failure">Area Power failure</option>
                                                                        <option value="ATM Power Disconnect by EB Department Due bill not paid">ATM Power Disconnect by EB Department Due bill not paid</option>
                                                                        <option value="Main Power Cable burn">Main Power Cable burn</option>
                                                                        <option value="Meter faulty">Meter faulty</option>
                                                                    </select>
                                                                </div>

                                                                <div id="electricalIssueDropdown" style="display: none;">
                                                                    <hr />
                                                                    <label for="electricalIssue">Select the specific electrical issue:</label>
                                                                    <select id="electricalIssue" name="electricalIssue">
                                                                        <option value="">-- Select -- </option>
                                                                        <option value="No power availble in router socket">No power availble in router socket</option>
                                                                        <option value="DB Box Short Circuit">DB Box Short Circuit</option>
                                                                        <option value="MCB Faulty">MCB Faulty</option>
                                                                        <option value="Earthing issue">Earthing issue</option>
                                                                    </select>
                                                                </div>

                                                                <div id="upsIssueDropdown" style="display: none;">
                                                                    <hr />
                                                                    <label for="upsIssue">Select the specific UPS issue:</label>
                                                                    <select id="upsIssue" name="upsIssue">
                                                                        <option value="">-- Select -- </option>
                                                                        <option value="UPS Not availble">UPS Not availble</option>
                                                                        <option value="UPS Faulty">UPS Faulty</option>
                                                                        <option value="UPS Battery backup issue">UPS Battery backup issue</option>
                                                                    </select>
                                                                </div>

                                                                <br /><br />

                                                                <h5>Hardware Dependancy</h5>

                                                                <select id="hardwareDependency" name="hardwareDependency">
                                                                    <option value="">-- Select -- </option>

                                                                    <?
                                                                    $getboqsql = mysqli_query($con, "select * from boq where needSerialNumber=1 and status=1");
                                                                    while ($getboqsqlResult = mysqli_fetch_assoc($getboqsql)) {
                                                                        $boqName = $getboqsqlResult['value'];
                                                                        echo "<option>$boqName</option>";
                                                                    }
                                                                    ?>
                                                                    <!--<option>Router Faulty</option>-->
                                                                    <!--<option>Antenna Faulty</option>-->
                                                                    <!--<option>Adaptor Faulty</option>-->
                                                                    <!--<option>Lan cable Faulty</option>-->
                                                                    <!--<option>SIM Card Faulty</option>-->
                                                                </select>

                                                                <br /><br />

                                                                <h5>Software Dependancy</h5>

                                                                <select id="softwareDependency" name="softwareDependency">
                                                                    <option value="">-- Select -- </option>
                                                                    <option>Page not opening</option>
                                                                    <option>Mobile App getting hang</option>
                                                                    <option>Software Showing Loading ...</option>
                                                                    <option>Showing Error</option>
                                                                </select>

                                                                <br />
                                                                <br />
                                                                <input type="text" name="holdRemark" class="form-control" placeholder="Enter Remarks if any ... ">

                                                                <br />

                                                                <button class="btn btn-primary" type="button" onclick="submitHoldReason()" id="submitHoldReason">Submit</button>
                                                                <div id="loadingIndicatorHoldReason" style="display: none;">Loading...</div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                <?
                                }
                            } else {
                                echo 'Site Not Exist !';
                            }

                            ?>

                        </div>
                    </div>

                </div>

</div>



<style>
    .required-field {
        border: 1px solid red;
    }
</style>
<script>
    function previewImage(event) {
        const fileInput = event.target;
        const previewContainer = document.querySelector('.image-preview-container');

        // Remove previous image previews


        const files = fileInput.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const image = document.createElement('img');
                image.src = e.target.result;
                image.classList.add('image-preview');

                const deleteButton = document.createElement('span');
                deleteButton.innerHTML = '&#x2715;';
                deleteButton.classList.add('delete-button');
                deleteButton.addEventListener('click', function() {
                    // Remove the clicked image and its delete button
                    previewContainer.removeChild(image);
                    previewContainer.removeChild(deleteButton);
                });

                previewContainer.appendChild(image);
                previewContainer.appendChild(deleteButton);
            }

            reader.readAsDataURL(file);
        }
    }


    $(document).ready(function() {

        $('#submitSealverification').click(function(e) {
            e.preventDefault();
            const submitButton = $(this);
            submitButton.prop('disabled', true).text('Loading...');
            const formData = new FormData($('#sealVerification')[0]);
            $.ajax({
                url: 'sealVerification.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (response == 200) {
                        Swal.fire('success', 'Images Added For Verification', 'success')
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000); // reload after 3 seconds
                    }
                    console.log('Form submission successful:', response);
                    submitButton.text('Send For Verification').prop('disabled', false);
                },
                error: function(error) {
                    console.error('Error submitting the form:', error);
                    submitButton.text('Send For Verification').prop('disabled', false);
                }
            });
        });
    });




    $(document).ready(function() {
        var requiredFields = ["atmId", "atmId2", "atmId3", "address", "city", "lho", "state"];
        // "routerFixedSnaps","adaptorSnaps","adaptorStatusSnaps","lanCableInstallSnap","antennaSnaps",
        // "antennaStatusSnaps","gpsSnaps","gpsStatusSnaps","wifiStatusSnaps"
        requiredFields.forEach(function(fieldName) {
            $("#" + fieldName).prop("required", true);
        });

        $('input[type="text"]').addClass("form-control");
        $("select").addClass("form-control");
    });

    var signatureCanvas;
    var signatureCtx;
    var isDrawing = false;
    var lastX = 0;
    var lastY = 0;

    // Function to initialize the signature canvas
    function initializeSignatureCanvas() {
        signatureCanvas = document.getElementById("signatureCanvas");
        signatureCtx = signatureCanvas.getContext("2d");

        signatureCanvas.addEventListener("mousedown", startDrawing);
        signatureCanvas.addEventListener("mousemove", draw);
        signatureCanvas.addEventListener("mouseup", stopDrawing);
        signatureCanvas.addEventListener("mouseout", stopDrawing);
    }

    // Function to start drawing
    function startDrawing(e) {
        isDrawing = true;
        lastX = e.offsetX;
        lastY = e.offsetY;
    }

    // Function to draw
    function draw(e) {
        if (!isDrawing) return;

        signatureCtx.beginPath();
        signatureCtx.moveTo(lastX, lastY);
        signatureCtx.lineTo(e.offsetX, e.offsetY);
        signatureCtx.stroke();

        lastX = e.offsetX;
        lastY = e.offsetY;
    }

    // Function to stop drawing
    function stopDrawing() {
        isDrawing = false;
    }

    // Function to clear the signature
    function clearSignature() {
        signatureCtx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
    }

    function submitForm() {
        var form = document.getElementById("installationForm");
        var formData = new FormData(form);
        var submitButton = document.getElementById("submitButton");
        var loadingIndicator = document.getElementById("loadingIndicator");

        // Convert the signature canvas to an image
        var signatureImage = signatureCanvas.toDataURL("image/png");

        // Append the signature image data to the form data
        formData.append("signatureImage", signatureImage);

        // Disable submit button and show loading indicator
        submitButton.disabled = true;
        loadingIndicator.style.display = "block";

        // Perform validation before submitting the form
        var requiredFields = ["atmId", "address", "city", "lho", "state"
            // "routerFixedSnaps","adaptorSnaps","adaptorStatusSnaps","lanCableInstallSnap","antennaSnaps",
            // "antennaStatusSnaps","gpsSnaps","gpsStatusSnaps","wifiStatusSnaps"
        ];

        var missingFields = [];

        for (var i = 0; i < requiredFields.length; i++) {
            var fieldName = requiredFields[i];
            var fieldValue = formData.get(fieldName).trim();
            if (fieldValue === "") {
                missingFields.push(fieldName);

                // Add the 'required-field' class to the empty required field
                $("#" + fieldName).addClass("required-field");

                $("#" + fieldName).focus();
                break;
            } else {
                // Remove the 'required-field' class from the filled required field
                $("#" + fieldName).removeClass("required-field");
            }
        }

        if (missingFields.length > 0) {
            // Show error message using SweetAlert
            Swal.fire("Error", "Please fill all required fields", "error");

            // Enable submit button and hide loading indicator
            submitButton.disabled = false;
            loadingIndicator.style.display = "none";

            return; // Prevent form submission
        }

        // Create an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "save_installation.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                // Enable submit button and hide loading indicator
                submitButton.disabled = false;
                loadingIndicator.style.display = "none";

                if (xhr.status === 200) {
                    Swal.fire("success", "Record Created Successfully !", "success");
                    setTimeout(function() {
                        window.location.href = "projectLeads.php";
                    }, 3000); // Redirect after 3 seconds
                } else {
                    // Handle errors or non-200 status codes
                    Swal.fire("error", "Error In Record Creation !", "error");
                }
            }
        };
        xhr.send(formData); // Pass formData directly to send() method
    }

    // Initialize the signature canvas when the page is loaded
    window.addEventListener("load", initializeSignatureCanvas);
</script>

<script>
    var dependencyDropdown = document.getElementById("dependency");
    var powerIssueDropdown = document.getElementById("powerIssueDropdown");
    var electricalIssueDropdown = document.getElementById("electricalIssueDropdown");
    var upsIssueDropdown = document.getElementById("upsIssueDropdown");

    dependencyDropdown.addEventListener("change", function() {
        var selectedOption = dependencyDropdown.options[dependencyDropdown.selectedIndex].value;

        if (selectedOption === "Power issue") {
            powerIssueDropdown.style.display = "block";
            electricalIssueDropdown.style.display = "none";
            upsIssueDropdown.style.display = "none";
        } else if (selectedOption === "Electrical issue") {
            powerIssueDropdown.style.display = "none";
            electricalIssueDropdown.style.display = "block";
            upsIssueDropdown.style.display = "none";
        } else if (selectedOption === "UPS Issue") {
            powerIssueDropdown.style.display = "none";
            electricalIssueDropdown.style.display = "none";
            upsIssueDropdown.style.display = "block";
        } else {
            powerIssueDropdown.style.display = "none";
            electricalIssueDropdown.style.display = "none";
            upsIssueDropdown.style.display = "none";
        }
    });


    document.addEventListener('click', function(event) {
        if (event.target && event.target.id === 'submitHoldReason') {
            submitHoldReason();
        }
    });

    function submitHoldReason() {

        document.getElementById('loadingIndicatorHoldReason').style.display = 'block';

        const form = document.getElementById('holdInstallationForm');
        const formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "holReasonResponse.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                document.getElementById('loadingIndicatorHoldReason').style.display = 'none';
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response == 200) {
                        Swal.fire("Success", "Response Stored Successfully!", "success");
                        setTimeout(function() {
                            window.location.href = "projectLeads.php";
                        }, 3000);
                    } else {
                        Swal.fire("Error", "Error in Record Creation!", "error");
                    }
                } else {
                    Swal.fire("Error", "Error In Record Creation!", "error");
                }
            }
        };
        xhr.send(formData);
    }
</script>

<? include('../footer.php'); ?>