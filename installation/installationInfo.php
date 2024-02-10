<? include('../header.php'); 

$baseurl = 'http://clarity.advantagesb.com/corona/eng/';
?>

<style>
        /* Style for disabled radio buttons */
        input[type="radio"]:disabled {
            /* Change color to dark red */
            color: darkred;
        }
    </style>

       <div class="card">
                                    <div class="card-block">
                                        
                                      <style>
                                          .installationImage{
                                              width:300px;
                                              height:300px;
                                          }
                                      </style>
                                      <?
                                      

                                      $siteid = $_REQUEST['siteid'];
                                      $atmid = $_REQUEST['atmid'];
                                      
                                    //   echo "SELECT * FROM `installationData` where atmid='".$atmid."' order by id desc" ; 
                                      
                                      $sql = mysqli_query($con,"SELECT * FROM `installationData` where atmid='".$atmid."' order by id desc");
                                      if($sql_result = mysqli_fetch_assoc($sql)){
                                          
                                          
                                                
                                                
                                                $atmId = $sql_result['atmId'];
                                                $atmId2 = $sql_result['atmId2'];
                                                $atmId3 = $sql_result['atmId3'];
                                                $address = $sql_result['address'];
                                                $city = $sql_result['city'];
                                                $location = $sql_result['location'];
                                                $lho = $sql_result['lho'];
                                                $state = $sql_result['state'];
                                                $atmWorking1 = $sql_result['atmWorking1'];
                                                $atmWorking2 = $sql_result['atmWorking2'];
                                                $atmWorking3 = $sql_result['atmWorking3'];
                                                $vendorName = $sql_result['vendorName'];
                                                $engineerName = $sql_result['engineerName'];
                                                $engineerNumber = $sql_result['engineerNumber'];
                                                $routerSerial = $sql_result['routerSerial'];
                                                $routerMake = $sql_result['routerMake'];
                                                $routerModel = $sql_result['routerModel'];
                                                $routerFixed = $sql_result['routerFixed'];
                                                $routerFixedRemarks = $sql_result['routerFixedRemarks'];
                                                $routerFixedSnaps = $sql_result['routerFixedSnaps'];
                                                $routerStatus = $sql_result['routerStatus'];
                                                $routerStatusRemarks = $sql_result['routerStatusRemarks'];
                                                $routerStatusSnaps = $sql_result['routerStatusSnaps'];
                                                $adaptorSnaps = $sql_result['adaptorSnaps'];
                                                $adaptorStatusRemarks = $sql_result['adaptorStatusRemarks'];
                                                $adaptorStatusSnaps = $sql_result['adaptorStatusSnaps'];
                                                $lanCableInstallRemark = $sql_result['lanCableInstallRemark'];
                                                $lanCableInstallSnap = $sql_result['lanCableInstallSnap'];
                                                $lanCableStatusNotWorkingReasons = $sql_result['lanCableStatusNotWorkingReasons'];
                                                $lanCableStatusRemark = $sql_result['lanCableStatusRemark'];
                                                $lanCableStatusSnap = $sql_result['lanCableStatusSnap'];
                                                $antennaRemarks = $sql_result['antennaRemarks'];
                                                $antennaSnaps = $sql_result['antennaSnaps'];
                                                $antennaStatus = $sql_result['antennaStatus'];
                                                $antennaStatusRemarks = $sql_result['antennaStatusRemarks'];
                                                $antennaStatusSnaps = $sql_result['antennaStatusSnaps'];
                                                $gpsRemarks = $sql_result['gpsRemarks'];
                                                $gpsSnaps = $sql_result['gpsSnaps'];
                                                $gpsStatusRemarks = $sql_result['gpsStatusRemarks'];
                                                $gpsStatusSnaps = $sql_result['gpsStatusSnaps'];
                                                $wifiRemarks = $sql_result['wifiRemarks'];
                                                $wifiSnaps = $sql_result['wifiSnaps'];
                                                $wifiStatusRemarks = $sql_result['wifiStatusRemarks'];
                                                $wifiStatusSnaps = $sql_result['wifiStatusSnaps'];
                                                $airtelSimRemarks = $sql_result['airtelSimRemarks'];
                                                $airtelSimSnaps = $sql_result['airtelSimSnaps'];
                                                $airtelSimStatusRemarks = $sql_result['airtelSimStatusRemarks'];
                                                $airtelSimStatusSnaps = $sql_result['airtelSimStatusSnaps'];
                                                $vodafoneSimRemarks = $sql_result['vodafoneSimRemarks'];
                                                $vodafoneSimSnaps = $sql_result['vodafoneSimSnaps'];
                                                $vodafoneSimStatusRemarks = $sql_result['vodafoneSimStatusRemarks'];
                                                $vodafoneSimStatusSnaps = $sql_result['vodafoneSimStatusSnaps'];
                                                $jioSimRemarks = $sql_result['jioSimRemarks'];
                                                $jioSimSnaps = $sql_result['jioSimSnaps'];
                                                $jioSimStatusRemarks = $sql_result['jioSimStatusRemarks'];
                                                $jioSimStatusSnaps = $sql_result['jioSimStatusSnaps'];
                                                $vendorStamp = $sql_result['vendorStamp'];
                                                $signatureImage = $sql_result['signatureImage'];
                                                
                                                
                                                $adaptorInstalled = $sql_result['adaptorInstalled'];
                                                $adaptorStatus = $sql_result['adaptorStatus'];
                                                $lanCableInstalled = $sql_result['lanCableInstalled'];
                                                $lanCableStatus = $sql_result['lanCableStatus'];
                                                $antennaInstalled = $sql_result['antennaInstalled'];
                                                $gpsInstalled = $sql_result['gpsInstalled'];
                                                $gpsStatus = $sql_result['gpsStatus'];
                                                $wifiInstalled = $sql_result['wifiInstalled'];
                                                $wifiStatus = $sql_result['wifiStatus'];
                                                $airtelSimInstalled = $sql_result['airtelSimInstalled'];
                                                $airtelSimStatus = $sql_result['airtelSimStatus'];
                                                $vodafoneSimInstalled = $sql_result['vodafoneSimInstalled'];
                                                $vodafoneSimStatus = $sql_result['vodafoneSimStatus'];
                                                $jioSimInstalled = $sql_result['jioSimInstalled'];
                                                $jioSimStatus = $sql_result['jioSimStatus'];


                                                
                                          ?>
                                        <input type="hidden" name="siteid" value="<? echo $siteid; ?>">
                                        <input type="hidden" name="atmid" value="<? echo $atmid; ?>">
                                        
                                        <table>
                                            <tr>
                                                <td><label for="atmId">ATM ID:</label></td>
                                                <td><input type="text" id="atmId" name="atmId" value="<? echo $atmid ; ?>"  readonly /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="address">Address:</label></td>
                                                <td><input type="text" id="address" name="address" value="<? echo $address ; ?>"  /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="city">City:</label></td>
                                                <td><input type="text" id="city" name="city" value="<? echo $city ; ?>" readonly /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="location">Location:</label></td>
                                                <td><input type="text" id="location" name="location" value="<? echo $address ; ?>"  /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="lho">LHO:</label></td>
                                                <td><input type="text" id="lho" name="lho" value="<? echo $lho ; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="state">State:</label></td>
                                                <td><input type="text" id="state" name="state" value="<? echo $state ; ?>" readonly /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="atmWorking1">Atm 1 Working </label></td>
                                                <td>
                                                    <input type="text" name="atmWorking1"  value="<?= $atmWorking1; ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><label for="vendorName">Installation Vendor Name:</label></td>
                                                <td><input type="text" id="vendorName" name="vendorName" value="<?= $vendorName ?>" readonly /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="engineerName">Installation Engineer Name & Number:</label></td>
                                                <td><input type="text" id="engineerName" name="engineerName" value="<?= $engineerName; ?>" /><input type="text" id="engineerNumber" name="engineerNumber" value="<?= $engineerNumber; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><h5>Router</h5></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerSerial">Serial No:</label></td>
                                                <td><input type="text" id="routerSerial" name="routerSerial" value="<?= $routerSerial; ?>" readonly /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerMake">Make:</label></td>
                                                <td><input type="text" id="routerMake" name="routerMake" value="<?= $routerMake; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerModel">Model:</label></td>
                                                <td><input type="text" id="routerModel" name="routerModel" value="<?= $routerModel; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><h5>Router_Fixed</h5></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerFixedYes">Yes:</label></td>
                                                <td><input type="radio" id="routerFixedYes" name="routerFixed" value="yes" <? if($routerFixed=='Yes' || $routerFixed=='yes'){ echo 'checked selected'; }?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerFixedNo">No:</label></td>
                                                <td><input type="radio" id="routerFixedNo" name="routerFixed" value="no" <? if($routerFixed=='No'){ echo 'checked'; }?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerFixedRemarks">Remarks:</label></td>
                                                <td><input type="text" id="routerFixedRemarks" name="routerFixedRemarks" value="<?= $routerFixedRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerFixedSnaps">Snaps:</label></td>
                                                <td>
                                                    <a href="<?= $baseurl.$routerFixedSnaps; ?>" target="_blank">
                                                        <img class="installationImage" src="<?= $baseurl.$routerFixedSnaps; ?>" />                                                            
                                                    </a>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h5>Router Status</h5></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerStatusWorking">Working:</label></td>
                                                <td><input type="radio" id="routerStatusWorking" name="routerStatus" value="working" <? if($routerStatus=='working'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerStatusNotWorking">Not Working:</label></td>
                                                <td><input type="radio" id="routerStatusNotWorking" name="routerStatus" value="notWorking" <? if($routerStatus=='notWorking'){ echo 'checked'; }?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerStatusRemarks">Remarks:</label></td>
                                                <td><input type="text" id="routerStatusRemarks" name="routerStatusRemarks" value="<?= $routerStatusRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="routerStatusSnaps">Snaps:</label></td>
                                                <td>
                                                    <a href="<?= $baseurl.$routerStatusSnaps; ?>" target="_blank">
                                                        <img class="installationImage" src="<?= $baseurl.$routerStatusSnaps; ?>" />                                                            
                                                    </a>


                                                </td>
                                            </tr>

                                            <tr>
                                                <td><h5>adaptor Installed</h5></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><label for="adaptorInstalledYes">Yes:</label></td>
                                                <td><input type="radio" id="adaptorInstalledYes" name="adaptorInstalled" value="yes" <? if($adaptorInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="adaptorInstalledNo">No:</label></td>
                                                <td><input type="radio" id="adaptorInstalledNo" name="adaptorInstalled" value="no" <? if($adaptorInstalled=='no'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="adaptorSnaps">Snaps:</label></td>
                                                <td>
                                                    <img class="installationImage" src="<?= $baseurl.$adaptorSnaps; ?>" />

                                                    </td>
                                            </tr>
                                            <tr>
                                                <td><h5>Adaptor Status</h5></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><label for="adaptorStatusWorking">Working:</label></td>
                                                <td><input type="radio" id="adaptorStatusWorking" name="adaptorStatus" value="working" <? if($adaptorStatus=='working'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="adaptorStatusNotWorking">Not Working:</label></td>
                                                <td><input type="radio" id="adaptorStatusNotWorking" name="adaptorStatus" value="notWorking" <? if($adaptorStatus=='notWorking'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="adaptorStatusRemarks">Remarks:</label></td>
                                                <td><input type="text" id="adaptorStatusRemarks" name="adaptorStatusRemarks" value="<?= $adaptorStatusRemarks; ?>"  /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="adaptorStatusSnaps">Snaps:</label></td>
                                                
                                                <td>
                                                <img class="installationImage" src="<?= $baseurl.$adaptorStatusSnaps; ?>" />
                                                    <!--<input type="file" id="adaptorStatusSnaps" name="adaptorStatusSnaps" />-->
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><h5>LAN Cable Installed</h5></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><label for="lanCableInstalledYes">Yes</label></td>
                                                <td><input type="radio" id="lanCableInstalledYes" name="lanCableInstalled" value="yes" <? if($lanCableInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="lanCableInstalledNo">No</label></td>
                                                <td><input type="radio" id="lanCableInstalledNo" name="lanCableInstalled" value="no" <? if($lanCableInstalled=='no'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="lanCableInstallRemark">Remarks:</label></td>
                                                <td><input type="text" id="lanCableInstallRemark" name="lanCableInstallRemark" value="<?= $lanCableInstallRemark; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="lanCableInstallSnap">Snaps:</label></td>
                                                <td>
                                                    <img class="installationImage" src="<?= $baseurl.$lanCableInstallSnap; ?>" />
                                                    <!--<input type="file" id="lanCableInstallSnap" name="lanCableInstallSnap" />-->
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><h5>LAN Cable Status</h5></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><label>Yes</label></td>
                                                <td><input type="radio" id="lanCableStatusYes" name="lanCableStatus" value="yes" <? if($lanCableStatus=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="lanCableInstalledNo">No</label></td>
                                                <td>
                                                    <input type="radio" id="lanCableStatusNo" name="lanCableStatus" value="no" <? if($lanCableStatus=='no'){ echo 'checked'; } ?> />
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    
                                                    <input type="text" value="<?= $lanCableStatusNotWorkingReasons; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="lanCableInstallRemark">Remarks:</label></td>
                                                <td><input type="text" id="lanCableStatusRemark" name="lanCableStatusRemark" value="<?= $lanCableStatusRemark; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="lanCableInstallSnap">Snaps:</label></td>
                                                <td>
                                                <img class="installationImage" src="<?= $baseurl.$lanCableStatusSnap; ?>" />
                                                    <!--<input type="file" id="lanCableStatusSnap" name="lanCableStatusSnap" />-->
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5>4G Antenna Installed</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="antennaInstalledYes">Yes:</label></td>
                                                <td><input type="radio" id="antennaInstalledYes" name="antennaInstalled" value="yes" <? if($antennaInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="antennaInstalledNo">No:</label></td>
                                                <td><input type="radio" id="antennaInstalledNo" name="antennaInstalled" value="no" <? if($antennaInstalled=='no'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="antennaRemarks">Remarks:</label></td>
                                                <td><input type="text" id="antennaRemarks" name="antennaRemarks" value="<?= $antennaRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="antennaSnaps">Snaps:</label></td>
                                                <td>
                                                <img class="installationImage" src="<?= $baseurl.$antennaSnaps; ?>" />
                                                    <!--<input type="file" id="antennaSnaps" name="antennaSnaps" />-->
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <h5>4G Antenna Status</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="antennaStatusWorking">Working:</label></td>
                                                <td><input type="radio" id="antennaStatusWorking" name="antennaStatus" value="working" <? if($antennaStatus=='working'){ echo 'checked'; } ?> /></td>
                                            </tr>

                                            <tr>
                                                <td><label for="antennaStatusNotWorking">Not Working:</label></td>
                                                <td><input type="radio" id="antennaStatusNotWorking" name="antennaStatus" value="notWorking" <? if($antennaStatus=='notWorking'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="antennaStatusRemarks">Remarks:</label></td>
                                                <td><input type="text" id="antennaStatusRemarks" name="antennaStatusRemarks" value="<?= $antennaStatusRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="antennaStatusSnaps">Snaps:</label></td>
                                                <td>
                                                <img class="installationImage" src="<?= $baseurl.$antennaStatusSnaps; ?>" />
                                                    <!--<input type="file" id="antennaStatusSnaps" name="antennaStatusSnaps" />-->
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <h5>GPS Antenna Installed</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="gpsInstalledYes">Yes:</label></td>
                                                <td><input type="radio" id="gpsInstalledYes" name="gpsInstalled" value="yes" <? if($gpsInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="gpsInstalledNo">No:</label></td>
                                                <td><input type="radio" id="gpsInstalledNo" name="gpsInstalled" value="no" <? if($gpsInstalled=='no'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="gpsRemarks">Remarks:</label></td>
                                                <td><input type="text" id="gpsRemarks" name="gpsRemarks" value="<?= $gpsRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="gpsSnaps">Snaps:</label></td>
                                                <td>
                                                    <img class="installationImage" src="<?= $baseurl.$gpsSnaps; ?>" />
                                                    <!--<input type="file" id="gpsSnaps" name="gpsSnaps" />-->
                                                    </td>
                                                
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <h5>GPS Antenna Status</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="gpsStatusWorking">Working:</label></td>
                                                <td><input type="radio" id="gpsStatusWorking" name="gpsStatus" value="working" <? if($gpsStatus=='working'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="gpsStatusNotWorking">Not Working:</label></td>
                                                <td><input type="radio" id="gpsStatusNotWorking" name="gpsStatus" value="notWorking" <? if($gpsStatus=='notWorking'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="gpsStatusRemarks">Remarks:</label></td>
                                                <td><input type="text" id="gpsStatusRemarks" name="gpsStatusRemarks" value="<?= $gpsStatusRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="gpsStatusSnaps">Snaps:</label></td>
                                                <td>
                                                    <img class="installationImage" src="<?= $baseurl.$gpsStatusSnaps; ?>" />
                                                    <!--<input type="file" id="gpsStatusSnaps" name="gpsStatusSnaps" />-->
                                                </td>
                                            </tr>

                                            <!-- Continue adding the remaining fields -->
                                            <tr>
                                                <td colspan="2">
                                                    <h5>Wifi Antenna Installed</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="wifiInstalledYes">Yes:</label></td>
                                                <td><input type="radio" id="wifiInstalledYes" name="wifiInstalled" value="yes" <? if($wifiInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="wifiInstalledNo">No:</label></td>
                                                <td><input type="radio" id="wifiInstalledNo" name="wifiInstalled" value="no" <? if($wifiInstalled=='no'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="wifiRemarks">Remarks:</label></td>
                                                <td><input type="text" id="wifiRemarks" name="wifiRemarks" value="<?= $wifiRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="wifiSnaps">Snaps:</label></td>
                                                <td>
                                                <img class="installationImage" src="<?= $baseurl.$wifiSnaps; ?>" />
                                                    <!--<input type="file" id="wifiSnaps" name="wifiSnaps" />-->
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <h5>Wifi Antenna Status</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="wifiStatusWorking">Working:</label></td>
                                                <td><input type="radio" id="wifiStatusWorking" name="wifiStatus" value="working" <? if($wifiStatus=='working'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="wifiStatusNotWorking">Not Working:</label></td>
                                                <td><input type="radio" id="wifiStatusNotWorking" name="wifiStatus" value="notWorking" <? if($wifiStatus=='notWorking'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="wifiStatusRemarks">Remarks:</label></td>
                                                <td><input type="text" id="wifiStatusRemarks" name="wifiStatusRemarks" value="<?= $wifiStatusRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="wifiStatusSnaps">Snaps:</label></td>
                                                <td>
                                                <img class="installationImage" src="<?= $baseurl.$wifiStatusSnaps; ?>" />
                                                    <!--<input type="file" id="wifiStatusSnaps" name="wifiStatusSnaps" />-->
                                                </td>
                                            </tr>

                                            <!-- Continue adding the remaining fields -->
                                            <tr>
                                                <td colspan="2">
                                                    <h5>airtel SIM Installed</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="airtelSimInstalledYes">Yes:</label></td>
                                                <td><input type="radio" id="airtelSimInstalledYes" name="airtelSimInstalled" value="yes" <? if($airtelSimInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="airtelSimInstalledNo">No:</label></td>
                                                <td><input type="radio" id="airtelSimInstalledNo" name="airtelSimInstalled" value="no" <? if($airtelSimInstalled=='no'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="airtelSimRemarks">Remarks:</label></td>
                                                <td><input type="text" id="airtelSimRemarks" name="airtelSimRemarks" value="<?= $airtelSimRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="airtelSimSnaps">Snaps:</label></td>
                                                <td>
                                                <img class="installationImage" src="<?= $baseurl.$airtelSimSnaps; ?>" />
                                                    <!--<input type="file" id="airtelSimSnaps" name="airtelSimSnaps" />-->
                                                </td>
                                            </tr>

                                            <!-- airtel SIM Status -->
                                            <tr>
                                                <td colspan="2">
                                                    <h5>airtel SIM Status</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="airtelSimStatusWorking">Working:</label></td>
                                                <td><input type="radio" id="airtelSimStatusWorking" name="airtelSimStatus" value="working" <? if($airtelSimStatus=='working'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="airtelSimStatusNotWorking">Not Working:</label></td>
                                                <td><input type="radio" id="airtelSimStatusNotWorking" name="airtelSimStatus" value="notWorking" <? if($airtelSimStatus=='notWorking'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="airtelSimStatusRemarks">Remarks:</label></td>
                                                <td><input type="text" id="airtelSimStatusRemarks" name="airtelSimStatusRemarks" value="<?= $airtelSimStatusRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="airtelSimStatusSnaps">Snaps:</label></td>
                                                <td>
                                                <img class="installationImage" src="<?= $baseurl.$airtelSimStatusSnaps; ?>" />
                                                    <!--<input type="file" id="airtelSimStatusSnaps" name="airtelSimStatusSnaps" />-->
                                                </td>
                                            </tr>

                                            <!-- Vodafone SIM Installed -->
                                            <tr>
                                                <td colspan="2">
                                                    <h5>Vodafone SIM Installed</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="vodafoneSimInstalledYes">Yes:</label></td>
                                                <td><input type="radio" id="vodafoneSimInstalledYes" name="vodafoneSimInstalled" value="yes" <? if($vodafoneSimInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="vodafoneSimInstalledNo">No:</label></td>
                                                <td><input type="radio" id="vodafoneSimInstalledNo" name="vodafoneSimInstalled" value="no" <? if($vodafoneSimInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="vodafoneSimRemarks">Remarks:</label></td>
                                                <td><input type="text" id="vodafoneSimRemarks" name="vodafoneSimRemarks" value="<?= $vodafoneSimRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="vodafoneSimSnaps">Snaps:</label></td>
                                                <td>
                                                    <img class="installationImage" src="<?= $baseurl.$vodafoneSimSnaps; ?>" />
                                                    <!--<input type="file" id="vodafoneSimSnaps" name="vodafoneSimSnaps" />-->
                                                </td>
                                            </tr>

                                            <!-- Vodafone SIM Status -->
                                            <tr>
                                                <td colspan="2">
                                                    <h5>Vodafone SIM Status</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="vodafoneSimStatusWorking">Working:</label></td>
                                                <td><input type="radio" id="vodafoneSimStatusWorking" name="vodafoneSimStatus" value="working" <? if($vodafoneSimStatus=='working'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="vodafoneSimStatusNotWorking">Not Working:</label></td>
                                                <td><input type="radio" id="vodafoneSimStatusNotWorking" name="vodafoneSimStatus" value="notWorking" <? if($vodafoneSimStatus=='notWorking'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="vodafoneSimStatusRemarks">Remarks:</label></td>
                                                <td><input type="text" id="vodafoneSimStatusRemarks" name="vodafoneSimStatusRemarks" value="<?= $vodafoneSimStatusRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="vodafoneSimStatusSnaps">Snaps:</label></td>
                                                <td>
                                                    <img class="installationImage" src="<?= $baseurl.$vodafoneSimStatusSnaps; ?>" />
                                                    <!--<input type="file" id="vodafoneSimStatusSnaps" name="vodafoneSimStatusSnaps" />-->
                                                </td>
                                            </tr>

                                            <!-- JIO SIM Installed -->
                                            <tr>
                                                <td colspan="2">
                                                    <h5>JIO SIM Installed</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="jioSimInstalledYes">Yes:</label></td>
                                                <td><input type="radio" id="jioSimInstalledYes" name="jioSimInstalled" value="yes" <? if($jioSimInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="jioSimInstalledNo">No:</label></td>
                                                <td><input type="radio" id="jioSimInstalledNo" name="jioSimInstalled" value="no" <? if($jioSimInstalled=='yes'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="jioSimRemarks">Remarks:</label></td>
                                                <td><input type="text" id="jioSimRemarks" name="jioSimRemarks" value="<?= $jioSimRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="jioSimSnaps">Snaps:</label></td>
                                                <td>
                                                    <img class="installationImage" src="<?= $baseurl.$jioSimSnaps; ?>" />
                                                    <input type="file" id="jioSimSnaps" name="jioSimSnaps" />
                                                </td>
                                            </tr>

                                            <!-- JIO SIM Status -->
                                            <tr>
                                                <td colspan="2">
                                                    <h5>JIO SIM Status</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="jioSimStatusWorking">Working:</label></td>
                                                <td><input type="radio" id="jioSimStatusWorking" name="jioSimStatus" value="working" <? if($jioSimStatus=='working'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="jioSimStatusNotWorking">Not Working:</label></td>
                                                <td><input type="radio" id="jioSimStatusNotWorking" name="jioSimStatus" value="notWorking" <? if($jioSimStatus=='notWorking'){ echo 'checked'; } ?> /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="jioSimStatusRemarks">Remarks:</label></td>
                                                <td><input type="text" id="jioSimStatusRemarks" name="jioSimStatusRemarks" value="<?= $jioSimStatusRemarks; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="jioSimStatusSnaps">Snaps:</label></td>
                                                <td>
                                                <img class="installationImage" src="<?= $baseurl.$jioSimStatusSnaps; ?>" />
                                                    <!--<input type="file" id="jioSimStatusSnaps" name="jioSimStatusSnaps" />-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: center;">
                                                    <h5>Signature of Engineer Installed</h5>

                                                    <div>
                                                        <label for="signatureCanvas">Digital Signature:</label><br />
                                                      <img class="installationImage" src="<?= $signatureImage; ?>" />
                                                      
                                                    </div>

                                                    <br />
                                                    <label for="vendorStamp">Stamp of Vendor:</label>
                                                    <img class="installationImage" src="<?= $baseurl.$vendorStamp; ?>" />
                                                    <!--<input type="file" id="vendorStamp" name="vendorStamp" />-->
                                                </td>
                                            </tr>
                                        </table>

                                          
                                      <? } ?>
                                      
                                        
                                        
                                    </div>
                                </div>
     

<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        border: 1px solid #000;
    }

    #signatureCanvas {
        border: 1px solid #000;

    }
    ul li a[disabled] {
  pointer-events: none; /* Disable click events */
  opacity: 0.5; /* Make the tab appear less visible */
  cursor: not-allowed; /* Show a "not allowed" cursor */
}

</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
<script>
        $(document).ready(function () {

            $('input[type="text"]').prop('readonly', true);
            $('input[type="radio"]').prop('disabled', true);


        $('input[type="text"]').addClass("form-control");
        $("select").addClass("form-control");
    });

</script>
    <? include('../footer.php'); ?>