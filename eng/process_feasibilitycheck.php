<? include('../config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>



<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $check_sql = mysqli_query($con, "select * from sites where atmid='" . $ATMID1 . "' and status=1");
        $check_sql_result = mysqli_fetch_assoc($check_sql);
        $siteid = $check_sql_result['id'];


        $userid = $_POST['userid'];
        $feasibilityDone = filter_var($_POST['feasibilityDone'], FILTER_SANITIZE_STRING);

        $routerPosition = filter_var($_POST['routerPosition'], FILTER_SANITIZE_STRING);

        $ATMID1 = filter_var($_POST['ATMID1'], FILTER_SANITIZE_STRING);
        $ATMID2 = filter_var($_POST['ATMID2'], FILTER_SANITIZE_STRING);
        $ATMID3 = filter_var($_POST['ATMID3'], FILTER_SANITIZE_STRING);
        $AntennaRoutingdetail = filter_var($_POST['AntennaRoutingdetail'], FILTER_SANITIZE_STRING);
        $EMLockPassword = filter_var($_POST['EMLockPassword'], FILTER_SANITIZE_STRING);
        $EMlockAvailable = filter_var($_POST['EMlockAvailable'], FILTER_SANITIZE_STRING);
        $LHO = filter_var($_POST['LHO'], FILTER_SANITIZE_STRING);
        $NoOfUps = filter_var($_POST['NoOfUps'], FILTER_SANITIZE_NUMBER_INT);
        $PasswordReceived = filter_var($_POST['PasswordReceived'], FILTER_SANITIZE_STRING);
        $Remarks = filter_var($_POST['Remarks'], FILTER_SANITIZE_STRING);
        $UPSAvailable = filter_var($_POST['UPSAvailable'], FILTER_SANITIZE_STRING);
        $UPSBateryBackup = filter_var($_POST['UPSBateryBackup'], FILTER_SANITIZE_STRING);
        $UPSWorking1 = filter_var($_POST['UPSWorking1'], FILTER_SANITIZE_STRING);
        $UPSWorking2 = filter_var($_POST['UPSWorking2'], FILTER_SANITIZE_STRING);
        $UPSWorking3 = filter_var($_POST['UPSWorking3'], FILTER_SANITIZE_STRING);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
        $atm1Status = filter_var($_POST['atm1Status'], FILTER_SANITIZE_STRING);
        $atm2Status = filter_var($_POST['atm2Status'], FILTER_SANITIZE_STRING);
        $atm3Status = filter_var($_POST['atm3Status'], FILTER_SANITIZE_STRING);
        $backroomDisturbingMaterial = filter_var($_POST['backroomDisturbingMaterial'], FILTER_SANITIZE_STRING);
        $backroomDisturbingMaterialRemark = filter_var($_POST['backroomDisturbingMaterialRemark'], FILTER_SANITIZE_STRING);
        $backroomKeyName = filter_var($_POST['backroomKeyName'], FILTER_SANITIZE_STRING);
        $backroomKeyNumber = filter_var($_POST['backroomKeyNumber'], FILTER_SANITIZE_STRING);
        $backroomKeyStatus = filter_var($_POST['backroomKeyStatus'], FILTER_SANITIZE_STRING);
        $backroomNetworkRemark = filter_var($_POST['backroomNetworkRemark'], FILTER_SANITIZE_STRING);
        $backroomNetworkRemark2 = filter_var($_POST['backroomNetworkRemark2'], FILTER_SANITIZE_STRING);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
        $earthing = filter_var($_POST['earthing'], FILTER_SANITIZE_STRING);
        $earthingVltg = filter_var($_POST['earthingVltg'], FILTER_SANITIZE_STRING);
        $frequentPowerCut = filter_var($_POST['frequentPowerCut'], FILTER_SANITIZE_STRING);
        $frequentPowerCutFrom = filter_var($_POST['frequentPowerCutFrom'], FILTER_SANITIZE_STRING);
        $frequentPowerCutRemark = filter_var($_POST['frequentPowerCutRemark'], FILTER_SANITIZE_STRING);
        $frequentPowerCutTo = filter_var($_POST['frequentPowerCutTo'], FILTER_SANITIZE_STRING);
        $location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
        $nearestShopDistance = filter_var($_POST['nearestShopDistance'], FILTER_SANITIZE_STRING);
        $nearestShopName = filter_var($_POST['nearestShopName'], FILTER_SANITIZE_STRING);
        $nearestShopNumber = filter_var($_POST['nearestShopNumber'], FILTER_SANITIZE_STRING);
        $noOfAtm = filter_var($_POST['noOfAtm'], FILTER_SANITIZE_NUMBER_INT);
        $operator = filter_var($_POST['operator'], FILTER_SANITIZE_STRING);
        $operator2 = filter_var($_POST['operator2'], FILTER_SANITIZE_STRING);
        $powerFluctuationEN = filter_var($_POST['powerFluctuationEN'], FILTER_SANITIZE_STRING);
        $powerFluctuationPE = filter_var($_POST['powerFluctuationPE'], FILTER_SANITIZE_STRING);
        $powerFluctuationPN = filter_var($_POST['powerFluctuationPN'], FILTER_SANITIZE_STRING);
        $powerSocketAvailability = filter_var($_POST['powerSocketAvailability'], FILTER_SANITIZE_STRING);
        $powerSocketAvailabilityUPS = filter_var($_POST['powerSocketAvailabilityUPS'], FILTER_SANITIZE_STRING);
        $routerAntenaPosition = filter_var($_POST['routerAntenaPosition'], FILTER_SANITIZE_STRING);
        $signalStatus = filter_var($_POST['signalStatus'], FILTER_SANITIZE_STRING);
        $signalStatus2 = filter_var($_POST['signalStatus2'], FILTER_SANITIZE_STRING);
        $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);


        if (
            isset($noOfAtm) && isset($ATMID1) && isset($city) && isset($location) && isset($LHO) && isset($state) &&
            !empty($noOfAtm) && !empty($ATMID1) && !empty($city) && !empty($location) && !empty($LHO) && !empty($state)
        ) {



            $sql = "insert into feasibilityCheck(siteid,ATMID1,ATMID2,ATMID3,AntennaRoutingdetail,EMLockPassword,EMlockAvailable,LHO,NoOfUps,PasswordReceived,Remarks,UPSAvailable,
            UPSBateryBackup,UPSWorking1,UPSWorking2,UPSWorking3,address,atm1Status,atm2Status,atm3Status,backroomDisturbingMaterial,backroomDisturbingMaterialRemark,
            backroomKeyName,backroomKeyNumber,backroomKeyStatus,backroomNetworkRemark,backroomNetworkRemark2,city,earthing,earthingVltg,frequentPowerCut,frequentPowerCutFrom,frequentPowerCutRemark,
            frequentPowerCutTo,location,nearestShopDistance,nearestShopName,nearestShopNumber,noOfAtm,operator,operator2,powerFluctuationEN,powerFluctuationPE,powerFluctuationPN,
            powerSocketAvailability,routerAntenaPosition,signalStatus,signalStatus2,state,status,created_at,powerSocketAvailabilityUPS,created_by,feasibilityDone,isVendor,routerPosition) values(
            '" . $siteid . "','" . $ATMID1 . "','" . $ATMID2 . "','" . $ATMID3 . "','" . $AntennaRoutingdetail . "','" . $EMLockPassword . "','" . $EMlockAvailable . "','" . $LHO . "','" . $NoOfUps . "','" . $PasswordReceived . "',
            '" . $Remarks . "','" . $UPSAvailable . "','" . $UPSBateryBackup . "','" . $UPSWorking1 . "','" . $UPSWorking2 . "','" . $UPSWorking3 . "','" . $address . "','" . $atm1Status . "','" . $atm2Status . "',
            '" . $atm3Status . "','" . $backroomDisturbingMaterial . "','" . $backroomDisturbingMaterialRemark . "','" . $backroomKeyName . "','" . $backroomKeyNumber . "',
            '" . $backroomKeyStatus . "','" . $backroomNetworkRemark . "','" . $backroomNetworkRemark2 . "','" . $city . "','" . $earthing . "','" . $earthingVltg . "','" . $frequentPowerCut . "','" . $frequentPowerCutFrom . "',
            '" . $frequentPowerCutRemark . "','" . $frequentPowerCutTo . "','" . $location . "','" . $nearestShopDistance . "','" . $nearestShopName . "','" . $nearestShopNumber . "','" . $noOfAtm . "',
            '" . $operator . "','" . $operator2 . "','" . $powerFluctuationEN . "','" . $powerFluctuationPE . "','" . $powerFluctuationPN . "','" . $powerSocketAvailability . "','" . $routerAntenaPosition . "',
            '" . $signalStatus . "','" . $signalStatus2 . "','" . $state . "',1,'" . $created_at . "','" . $powerSocketAvailabilityUPS . "','" . $userid . "','" . $feasibilityDone . "','1','" . $routerPosition . "'
            )";

            if (mysqli_query($con, $sql)) {
                $insertid = $con->insert_id;
            }

            $currentYear = date('Y');
            $currentMonth = date('m');

            $targetDir = "../feasibiltyData/$currentYear/$currentMonth/$insertid/";

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $uploadedFiles = [];
            $fileInputs = array(
                'ATMID1Snap',
                'backroomNetworkSnap',
                'backroomNetworkSnap2',
                'routerAntenaSnap',
                'AntennaRoutingSnap',
                'UPSAvailableSnap',
                'NoOfUpsSnap',
                'upsWorkingSnap',
                'powerSocketAvailabilitySnap',
                'powerSocketAvailabilityUPSSnap',
                'earthingSnap',
                'powerFluctuationSnap',
                'remarksSnap',
                'backroomDisturbingMaterialSnap',
                'routerPositionSnap'
            );






            foreach ($fileInputs as $inputName) {
                if (!empty($_FILES[$inputName]["tmp_name"])) {
                    $uploadedFiles[$inputName] = handleUploads($_FILES[$inputName], $targetDir);
                }
            }





            // Update SQL query
            $update = "UPDATE feasibilityCheck SET 
                        backroomNetworkSnap = '" . implode(',', $uploadedFiles['backroomNetworkSnap']) . "',
                        routerAntenaSnap = '" . implode(',', $uploadedFiles['routerAntenaSnap']) . "',
                        AntennaRoutingSnap = '" . implode(',', $uploadedFiles['AntennaRoutingSnap']) . "',
                        UPSAvailableSnap = '" . implode(',', $uploadedFiles['UPSAvailableSnap']) . "',
                        NoOfUpsSnap = '" . implode(',', $uploadedFiles['NoOfUpsSnap']) . "',
                        upsWorkingSnap = '" . implode(',', $uploadedFiles['upsWorkingSnap']) . "',
                        powerSocketAvailabilitySnap = '" . implode(',', $uploadedFiles['powerSocketAvailabilitySnap']) . "',
                        earthingSnap = '" . implode(',', $uploadedFiles['earthingSnap']) . "',
                        powerFluctuationSnap = '" . implode(',', $uploadedFiles['powerFluctuationSnap']) . "',
                        remarksSnap = '" . implode(',', $uploadedFiles['remarksSnap']) . "',
                        powerSocketAvailabilityUPSSnap = '" . implode(',', $uploadedFiles['powerSocketAvailabilityUPSSnap']) . "',
                        backroomNetworkSnap2 = '" . implode(',', $uploadedFiles['backroomNetworkSnap2']) . "', 
                        ATMID1Snap = '" . implode(',', $uploadedFiles['ATMID1Snap']) . "',
                        backroomDisturbingMaterialSnap = '" . implode(',', $uploadedFiles['backroomDisturbingMaterialSnap']) . "', 
                        routerPositionSnap = '" . implode(',', $uploadedFiles['routerPositionSnap']) . "'
                        WHERE id = '" . $insertid . "'";


            if (mysqli_query($con, $update)) {


                mysqli_query($con, "update sites set isFeasibiltyDone=1 where atmid='" . $ATMID1 . "' and status=1");
                mysqli_query($con, "update delegation set isFeasibilityDone=1 where siteid='" . $siteid . "'");

                projectTeamFeasibilityCheck($siteid, $ATMID1, '');



                $response = array(
                    "code" => 200,
                    "response" => "Saved successfully"
                );
                ?>

                <script>
                    Swal.fire("Success", "Response Saved Successfully!", "success")
                        .then(() => {
                            window.location.href = "assignLeads.php";
                        });


                </script>
            <?

            } else {

                $response = array(
                    "code" => 500,
                    "response" => "Saved Error",
                    "error" => mysqli_error($con)
                );
                ?>
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please fill in all the required fields"
                    });

                </script>

                <?php

            }

        } else {

            $response = array(
                "code" => 300,
                "response" => "Some fields are require !",
                "error" => mysqli_error($con)
            );

            ?>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please fill in all the required fields"
                });

            </script>

            <?php


        }

    } else {
        $response = array(
            "code" => 405,
            "response" => "Method Not Allowed !",
            "error" => mysqli_error($con)
        );
        ?>
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please fill in all the required fields"
            });

        </script>

        <?php

    }

    ?>
</body>

</html>