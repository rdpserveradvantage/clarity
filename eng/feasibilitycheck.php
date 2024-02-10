<? include('../header.php'); ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="row">

    <style>
        .highlight {
            border-color: red;
        }

        select:focus,
        input:focus {
            border-bottom: 1px solid red !important;
        }

        input.form-control,
        input {
            border: none;
            margin: 10px auto;
        }

        .form-control:focus {
            color: #55595c;
            background-color: #fff;
            border-color: #66afe9;
            outline: none;
            box-shadow: none;
            border: none;
        }

        .highlight {
            border-color: red;
        }

        .swal-overlay {
            background-color: rgba(43, 165, 137, 0.45);
        }

        input.form-control,
        input {
            border: none;
            margin: 10px auto;
        }

        select.form-control,
        select {
            border: none;
            margin: 10px auto;
        }

        form .form-control {
            border-bottom: 1px solid #d4d4d4;
            color: #5a5a5a;
        }

        .second_card .row {
            margin: 30px auto;
            /*border-bottom: 0.1px solid #efefef;*/
        }
    </style>
    <link rel="stylesheet" type="text/css" href="files/assets/pages/j-pro/css/j-pro-modern.css" />


    <div class="page-body">
        <?
        $siteid = $_REQUEST['siteid'];
        if (isset($siteid) && !empty($siteid)) {

            $sql = mysqli_query($con, "select * from sites where id='" . $siteid . "' and status=1");
            if ($sql_result = mysqli_fetch_assoc($sql)) {
                $atmid = $sql_result['atmid'];
                $atmid2 = $sql_result['atmid2'];
                $atmid3 = $sql_result['atmid3'];
                $address = $sql_result['address'];
                $city = $sql_result['city'];
                $state = $sql_result['state'];
                $lho = $sql_result['LHO'];
            }
        }



        ?>

        <h3>Feasibility Check</h3>
        
        
        <form id="feasibilityForm" action="./process_feasibilitycheck.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="userid" value="<? echo $userid; ?>" />


            <div class="card grid-margin">
                <div class="card-body">
                    <div class="row" style="display:none;">
                        <div class="col-sm-6">
                            <label>Number of ATM Available</label>
                            <select class="form-control" name="noOfAtm" id="noOfAtm" required >
                                <option value="">Select</option>
                                <option selected>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <label>ATMID 1</label>
                            <input type="text" id="ATMID1" name="ATMID1" class="form-control" value="<? echo $atmid; ?>" <? if ($atmid) {
                                   echo 'readonly';
                               } ?> /> 
                               
                       </div>
                                            <div class="col-sm-3">
                            <label>ATMID1 Snap</label>
                            
                                   <input type="file" name="ATMID1Snap" required />
                        </div>
                    </div>
                    
                    <div class="row">
                    
                        <div class="col-sm-3 atmid2Section" style="display:none;">
                            <label for="ATMID2" id="atmId2Label">ATMID 2</label>
                            <input type="text" name="ATMID2" class="form-control" value="<? echo $atmid2; ?>" />
                            ATMID2 Snap &nbsp; <input type="file" name="ATMID2Snap" />
                        </div>
                        <div class="col-sm-3 atmid3Section" style="display:none;">
                            <label for="ATMID3" id="atmId3Label" style="display: none;">ATMID 3</label>
                            <input type="text" name="ATMID3" class="form-control" value="<? echo $atmid3; ?>" />
                            ATMID3 Snap &nbsp; <input type="file" name="ATMID3Snap" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <label>City</label>
                            <input type="text" id="city" name="city" class="form-control" value="<? echo $city; ?>" <? if ($atmid) {
                                   echo 'readonly';
                               } ?> />
                        </div>
                        <div class="col-sm-3">
                            <label>Location</label>
                            <input type="text" id="location" name="location" class="form-control"
                                value="<? echo $address; ?>" <? if ($atmid) {
                                       echo 'readonly';
                                   } ?> />
                        </div>
                        <div class="col-sm-3">
                            <label>LHO</label>
                            <input type="text" id="LHO" name="LHO" class="form-control" value="<? echo $lho; ?>" <? if ($atmid) {
                                   echo 'readonly';
                               } ?> />
                        </div>
                        <div class="col-sm-3">
                            <label>State</label>
                            <input type="text" id="state" name="state" class="form-control" value="<? echo $state; ?>" <? if ($atmid) {
                                   echo 'readonly';
                               } ?> />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label>Address</label>
                            <input type="text" id="address" name="address" class="form-control"
                                value="<? echo $address; ?>" <? if ($atmid) {
                                       echo 'readonly';
                                   } ?> />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label id="atm1StatusLabel" >ATMID 1 Working</label>
                            <select class="form-control" name="atm1Status">
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label id="atm2StatusLabel" style="display: none;">ATMID 2 Working</label>
                            <select class="form-control atm-status" name="atm2Status">
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label id="atm3StatusLabel" style="display: none;">ATMID 3 Working</label>
                            <select class="form-control atm-status" name="atm3Status">
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card second_card grid-margin">
                <div class="card-block">
                    <div class="row">
                        <h6 class="col-sm-3">Network available in back room</h6>
                        <div class="col-sm-2">
                            <label>Operator 1</label>
                            <select name="operator" class="form-control" required>
                                <option value="">Select</option>
                                <option>Airtel</option>
                                <option>Vodafone</option>
                                <option>Jio</option>
                                <option>Any Other</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>Status of Signal</label>
                            <input name="signalStatus" type="text" class="form-control" required />
                        </div>
                        <div class="col-sm-3">
                            <label>Remark</label>
                            <input name="backroomNetworkRemark" type="text" class="form-control" required />
                        </div>
                        <div class="col-sm-2">
                            <label>Snapshot</label>
                            <input name="backroomNetworkSnap" type="file" required />
                        </div>

                        <h6 class="col-sm-3"></h6>
                        <div class="col-sm-2">
                            <label>Operator 2</label>
                            <select name="operator2" class="form-control">
                                <option value="">Select</option>
                                <option>Airtel</option>
                                <option>Vodafone</option>
                                <option>Jio</option>
                                <option>Any Other</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>Status of Signal</label>
                            <input name="signalStatus2" type="text" class="form-control" />
                        </div>
                        <div class="col-sm-3">
                            <label>Remark</label>
                            <input name="backroomNetworkRemark2" type="text" class="form-control" />
                        </div>
                        <div class="col-sm-2">
                            <label>Snapshot</label>
                            <input name="backroomNetworkSnap2" type="file" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="card second_card grid-margin">
                <div class="card-block">

                    <div class="row">
                        <h6 class="col-sm-3">Back Room Key</h6>
                        <div class="col-sm-3">
                            <label>Status</label>
                            <select name="backroomKeyStatus" class="form-control" required>
                                <option value="">Select</option>
                                <option>Available with LL</option>
                                <option>Available with HK Person</option>
                                <option>Available with MSP </option>
                                <option>Available with Bank</option>
                                <option>Not Available</option>
                                <option>Any Other</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Backroom Contact Person Name</label>
                            <input name="backroomKeyName" type="text" class="form-control" required />
                        </div>
                        <div class="col-sm-3">
                            <label>Backroom Contact Person Number</label>
                            <input name="backroomKeyNumber" type="text" class="form-control" required />
                        </div>
                    </div>
                </div>
            </div>


            <div class="card second_card grid-margin">
                <div class="card-block">

                    <div class="row">
                        <h6 class="col-sm-3">EM lock Available</h6>
                        <div class="col-sm-9">
                            <select class="form-control" name="EMlockAvailable" id="emLockAvailableSelect"
                                onchange="toggleEmLockAccess(this)" required>
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>

                    <div id="emLockAccessSection" style="display: none;" class="extra_highlight">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6>EM lock Access</h6>
                            </div>
                            <div class="col-sm-3">
                                <label>Password Received</label>
                                <select class="form-control" name="PasswordReceived"
                                    onchange="togglePasswordField(this)">
                                    <option value="">Select</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                            <div class="col-sm-3" id="emLockPasswordField" style="display: none;">
                                <label>EM Lock Password</label>
                                <input type="text" name="EMLockPassword" class="form-control" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="card second_card grid-margin">
                <div class="card-block">


                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Place to fix router</h6>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name="routerPosition" required>
                                <option value="">Select</option>
                                <option>Rack Available</option>
                                <option>Fixed on wall</option>
                                <option>Above Ceiling</option>
                                <option>Any Other</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="routerPositionSnap" required />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Place to fix Router Antenna</h6>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name="routerAntenaPosition" required>
                                <option value="">Select</option>
                                <option>Above Ceiling</option>
                                <option>In ATM lobby</option>
                                <option>Out Side the lobby</option>
                                <option>Any Other</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="routerAntenaSnap" required />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Antenna Wire Routing detail</h6>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="AntennaRoutingdetail" class="form-control" required />
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="AntennaRoutingSnap" required />
                        </div>
                    </div>

                </div>
            </div>



            <div class="card second_card grid-margin">
                <div class="card-block">



                    <div class="row">
                        <div class="col-sm-3">
                            <h6>UPS Available</h6>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" name="UPSAvailable" id="upsAvailableSelect" required>
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>

                    <div id="upsOptionsContainer" class="extra_highlight">


                        <div class="row">
                            <div class="col-sm-3">
                                <h6>UPS Snap</h6>
                            </div>
                            <div class="col-sm-3">
                                <input type="file" name="UPSAvailableSnap" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <h6>No. of UPS</h6>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" name="NoOfUps" id="noOfUpsSelect">
                                    <option value="">Select</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="file" name="NoOfUpsSnap" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <h6>UPS Working</h6>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="UPSWorking1" id="upsWorking1Select">
                                    <option value="">Select</option>
                                    <option>Yes</option>
                                    <option>NO</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="UPSWorking2" id="upsWorking2Select">
                                    <option value="">Select</option>
                                    <option>Yes</option>
                                    <option>NO</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="UPSWorking3" id="upsWorking3Select">
                                    <option value="">Select</option>
                                    <option>Yes</option>
                                    <option>NO</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="file" name="upsWorkingSnap" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <h6>UPS Battery Backup</h6>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="UPSBateryBackup" class="form-control" placeholder="Hrs ..." />
                            </div>
                        </div>
                    </div>

                    <script>
                        function toggleEmLockAccess(emLockAvailableSelect) {
                            const emLockAccessSection = document.getElementById('emLockAccessSection');
                            if (emLockAvailableSelect.value === 'Yes') {
                                emLockAccessSection.style.display = 'block';
                            } else {
                                emLockAccessSection.style.display = 'none';
                            }
                        }

                        function togglePasswordField(passwordReceivedSelect) {
                            const emLockPasswordField = document.getElementById('emLockPasswordField');
                            if (passwordReceivedSelect.value === 'Yes') {
                                emLockPasswordField.style.display = 'block';
                            } else {
                                emLockPasswordField.style.display = 'none';
                            }
                        }


                        const upsAvailableSelect = document.getElementById('upsAvailableSelect');

                        // Get the UPS options container
                        const upsOptionsContainer = document.getElementById('upsOptionsContainer');

                        // Function to toggle visibility based on UPS Available selection
                        function toggleUpsOptionsVisibility() {
                            const isUpsAvailable = upsAvailableSelect.value === 'Yes';
                            upsOptionsContainer.style.display = isUpsAvailable ? 'block' : 'none';
                        }

                        // Initial call to set the visibility based on the default value
                        toggleUpsOptionsVisibility();

                        // Attach an event listener to the UPS Available select element
                        upsAvailableSelect.addEventListener('change', toggleUpsOptionsVisibility);
                    </script>




                </div>
            </div>


            <div class="card second_card grid-margin">
                <div class="card-block">

                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Power Socket Available for Router in DB</h6>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name="powerSocketAvailability" required>
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="powerSocketAvailabilitySnap" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Power Socket Available for Router in UPS</h6>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name="powerSocketAvailabilityUPS" required>
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="powerSocketAvailabilityUPSSnap" required />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Earthing</h6>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name="earthing" required>
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="earthingVltg" class="form-control"
                                placeholder="EN Vtg ... " required />
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="earthingSnap" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Power Fluctuation</h6>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="powerFluctuationPE" placeholder="PE vtg.." required />
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="powerFluctuationPN" placeholder="PN vtg.." required />
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="powerFluctuationEN" placeholder="EN vtg.." required />
                        </div>

                        <div class="col-sm-3">
                            <input type="file" name="powerFluctuationSnap" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Frequent Power cut</h6>
                        </div>
                        <div class="col-sm-2">
                            <select name="frequentPowerCut" class="form-control" onchange="toggleFields(this)" required>
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="col-sm-2" id="powerCutFromContainer" style="display: none;">
                            <input type="text" class="form-control" name="frequentPowerCutFrom"
                                placeholder="Frequent Power Cut From" />
                        </div>
                        <div class="col-sm-2" id="powerCutToContainer" style="display: none;">
                            <input type="text" class="form-control" name="frequentPowerCutTo" placeholder="To" />
                        </div>
                        <div class="col-sm-3" id="powerCutRemarkContainer" style="display: none;">
                            <input type="text" class="form-control" name="frequentPowerCutRemark"
                                class="form-control" />
                        </div>
                    </div>
                </div>
            </div>



            <div class="card second_card grid-margin">
                <div class="card-block">


                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Unwanted material in back room which bars access for working</h6>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name="backroomDisturbingMaterial"
                                onchange="toggleFields2(this)">
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="col-sm-3" id="backroomRemarkContainer" style="display: none;">
                            <input type="text" name="backroomDisturbingMaterialRemark" class="form-control"
                                placeholder="Remarks ... " />
                        </div>
                        <div class="col-sm-3" id="backroomSnapContainer" style="display: none;">
                            <input type="file" name="backroomDisturbingMaterialSnap" />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Nearest Hadware or Electric Shop</h6>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="nearestShopDistance"
                                placeholder="Distance From ATM " required />
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="nearestShopName" placeholder="Name ..." />
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="nearestShopNumber" placeholder="Number ..." />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Any Other Remark</h6>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="Remarks" class="form-control" placeholder="Remarks ... " />
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="remarksSnap" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Feasibility Done</h6>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" name="feasibilityDone" required>
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <br />
            <div class="row">
                <div class="col-sm-12">
                    <button type="submit" id="submitButton" class="btn btn-success" onclick="saveForm()">Save</button>
                    <div id="loadingIndicator" style="display: none;">Please Wait ...</div>
                    <!--<input type="submit" name="submit" class="btn btn-success" />-->
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {

            // Show/hide ATMID 2 and ATMID 3 based on the selected value

            $(".atm-status").hide();
            $("#noOfAtm").on("change", function () {
                var noOfAtm = $(this).val();
                $(".atm-status").hide();
                $(".atm-status").prev("label").hide();
                for (var i = 1; i <= noOfAtm; i++) {
                    $("select[name='atm" + i + "Status']").show();
                    $("label#atmId" + i + "Label").show();
                    $("label#atm" + i + "StatusLabel").show();
                }

                if (noOfAtm >= 1) {
                    $("input[name='ATMID1']").show();
                    $("label[for='ATMID1']").show();
                    $("input[name='ATMID1Snap']").show();

                } else {
                    $("input[name='ATMID1']").hide();
                    $("label[for='ATMID1']").hide();
                    $("input[name='ATMID1Snap']").hide();
                }

                if (noOfAtm >= 2) {
                    $(".atmid2Section").show();
                } else {
                    $(".atmid2Section").hide();
                }
                if (noOfAtm >= 3) {
                    $(".atmid3Section").show();
                } else {
                    $(".atmid3Section").hide();

                }


            });

            $("#noOfUpsSelect").change(function () {
                var noOfUps = $(this).val();
                // Show/hide UPSWorking fields based on selected NoOfUps
                $("#upsWorking1Select").toggle(noOfUps >= 1);
                $("#upsWorking2Select").toggle(noOfUps >= 2);
                $("#upsWorking3Select").toggle(noOfUps >= 3);

                $("#upsWorking1Select").prop("required", noOfUps >= 1);
                $("#upsWorking2Select").prop("required", noOfUps >= 2);
                $("#upsWorking3Select").prop("required", noOfUps >= 3);
            });
        });

        $(document).ready(function () {
            // Function to populate form fields

            function populateFormFields(data) {
                if (data) {
                    $("#address").prop("readonly", true);
                    $("#city").prop("readonly", true);
                    $("#location").prop("readonly", true);
                    $("#LHO").prop("readonly", true);
                    $("#state").prop("readonly", true);

                    $("#address").val(data.address);
                    $("#city").val(data.city);
                    $("#location").val(data.location);
                    $("#LHO").val(data.lho);
                    $("#state").val(data.state);
                } else {
                    $("#address").prop("readonly", false);
                    $("#city").prop("readonly", false);
                    $("#location").prop("readonly", false);
                    $("#LHO").prop("readonly", false);
                    $("#state").prop("readonly", false);

                    $("#address").val("");
                    $("#city").val("");
                    $("#location").val("");
                    $("#LHO").val("");
                    $("#state").val("");
                }
            }

            // Event listener for change in ATMID1
            $("#ATMID1").change(function () {
                var atmID = $(this).val();
                if (atmID !== "") {
                    // AJAX request to fetch ATM details
                    $.ajax({

                        url: "../admin/API/getATMIDInfo.php?ATMID1=" + atmID,
                        type: "GET",
                        dataType: "json",
                        success: function (response) {
                            $("#address").val("");
                            $("#city").val("");
                            $("#location").val("");
                            $("#LHO").val("");
                            $("#state").val("");

                            if (response.code === 200) {
                                populateFormFields(response); // Populate form fields with response data
                            } else if (response.code === 300) {
                                populateFormFields(response);
                                Swal.fire({
                                  icon: "error",
                                  title: "Oops...",
                                  text: "ATMID Not found!"
                                });

                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                            alert("An error occurred while fetching ATM details. Please try again.");
                        },
                    });
                } else {
                    // Clear form fields if ATMID1 is empty
                    $("#address").val("");
                    $("#city").val("");
                    $("#location").val("");
                    $("#LHO").val("");
                    $("#state").val("");
                }
            });
        });

        function toggleFields2(selectElement) {
            var backroomRemarkContainer = document.getElementById("backroomRemarkContainer");
            var backroomSnapContainer = document.getElementById("backroomSnapContainer");

            if (selectElement.value === "Yes") {
                backroomRemarkContainer.style.display = "block";
                backroomSnapContainer.style.display = "block";
            } else {
                backroomRemarkContainer.style.display = "none";
                backroomSnapContainer.style.display = "none";
            }
        }

        function togglePasswordField(selectElement) {
            var emLockPasswordField = document.getElementById("emLockPasswordField");

            if (selectElement.value === "Yes") {
                emLockPasswordField.style.display = "block";
            } else {
                emLockPasswordField.style.display = "none";
            }
        }

        function toggleFields(selectElement) {
            var powerCutFromContainer = document.getElementById("powerCutFromContainer");
            var powerCutToContainer = document.getElementById("powerCutToContainer");
            var powerCutRemarkContainer = document.getElementById("powerCutRemarkContainer");

            if (selectElement.value === "Yes") {
                powerCutFromContainer.style.display = "block";
                powerCutToContainer.style.display = "block";
                powerCutRemarkContainer.style.display = "block";
            } else {
                powerCutFromContainer.style.display = "none";
                powerCutToContainer.style.display = "none";
                powerCutRemarkContainer.style.display = "none";
            }
        }

        // function saveForm() {
        //     event.preventDefault();

        //     var submitButton = document.getElementById("submitButton");
        //     var loadingIndicator = document.getElementById("loadingIndicator");

        //     submitButton.disabled = true;
        //     loadingIndicator.style.display = "block";

        //     var formData = new FormData($("#feasibilityForm")[0]);
        //     var requiredFields = $("#feasibilityForm :required");
        //     var emptyFields = [];

        //     // Check for empty required fields
        //     requiredFields.each(function () {
        //         if ($(this).val() === "") {
        //             emptyFields.push($(this).attr("name"));
        //         }
        //     });

        //     if (emptyFields.length > 0) {

        //         Swal.fire({
        //           icon: "error",
        //           title: "Oops...",
        //           text: "Please fill in all the required fields"
        //         });


        //         $("input, select").removeClass("highlight");
        //         $.each(emptyFields, function (index, fieldName) {
        //             $('[name="' + fieldName + '"]').addClass("highlight");
        //         });

        //         return; // Exit the function if empty fields exist

        //     }

        //     $.ajax({
        //         url: "process_feasibilitycheck.php",
        //         type: "POST",
        //         data: formData,
        //         contentType: false, // Important: Set contentType to false for file uploads
        //         processData: false, // Important: Disable processing of the data
        //         headers: {
        //             'Referrer-Policy': 'strict-origin-when-cross-origin'
        //         },

        //         success: function (response) {
        //             console.log(response);
        //             var jsonResponse = JSON.parse(response); // Parse the JSON response
        //             console.log(jsonResponse.code);
        //             if (jsonResponse.code == 200) {
        //                 submitButton.disabled = false;
        //                 loadingIndicator.style.display = "none";
        //                 Swal.fire({
        //                   title: "Good job!",
        //                   text: "Response Saved Successfully !",
        //                   icon: "success"
        //                 });

        //                 setTimeout(function () {
        //                     window.location.href = "assignLeads.php";
        //                 }, 3000); // Redirect after 3 seconds
        //             } else {
        //                 console.error(jsonResponse.error); // Assuming the error message is provided in the response
        //                 submitButton.disabled = false;
        //                 loadingIndicator.style.display = "none";
        //                 alert("An error occurred. Please check log for details.");
        //             }
        //         },

        //         error: function (xhr, status, error) {
        //             console.error(error);

        //             alert("An error occurred: " + error); // Display a generic error message

        //             if (xhr.responseText) {
        //                 try {
        //                     var errorResponse = JSON.parse(xhr.responseText);
        //                     if (errorResponse.response) {
        //                         alert("Server Error: " + errorResponse.response);
        //                     }
        //                 } catch (e) {
        //                     console.error("Error parsing error response:", e);
        //                 }
        //             }

        //         },
        //     });
        // }
    </script>


</div>


<? include('../footer.php'); ?>