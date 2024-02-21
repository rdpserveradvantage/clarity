<? include('../header.php'); ?>

        <div class="card">
                                    <div class="card-block">
                                        
                                    <?
$siteid = $_REQUEST['siteid'];
$activity = $_REQUEST['activity'];
$customer = $_REQUEST['customer'];
$bank = $_REQUEST['bank'];
$atmid = $_REQUEST['atmid'];
$address = htmlspecialchars($_REQUEST['address']);
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$zone = $_REQUEST['zone'];
$LHO = $_REQUEST['LHO'];
$LHO_Contact_Person = htmlspecialchars($_REQUEST['LHO_Contact_Person']);
$LHO_Contact_Person_No = $_REQUEST['LHO_Contact_Person_No'];
$LHO_Contact_Person_email = $_REQUEST['LHO_Contact_Person_email'];
$LHO_Adv_Person = $_REQUEST['LHO_Adv_Person'];
$LHO_Adv_Contact = $_REQUEST['LHO_Adv_Contact'];
$LHO_Adv_email = $_REQUEST['LHO_Adv_email'];
$Project_Coordinator_Name = htmlspecialchars($_REQUEST['Project_Coordinator_Name']);
$Project_Coordinator_No = $_REQUEST['Project_Coordinator_No'];
$Project_Coordinator_email = $_REQUEST['Project_Coordinator_email'];
$Customer_SLA = $_REQUEST['Customer_SLA'];
$Our_SLA = $_REQUEST['Our_SLA'];
$Vendor = $_REQUEST['Vendor'];
$Cash_Management = $_REQUEST['Cash_Management'];
$CRA_VENDOR = $_REQUEST['CRA_VENDOR'];
$ID_on_Make = $_REQUEST['ID_on_Make'];
$Model = $_REQUEST['Model'];
$SiteType = $_REQUEST['SiteType'];
$PopulationGroup = $_REQUEST['PopulationGroup'];
$XPNET_RemoteAddress = $_REQUEST['XPNET_RemoteAddress'];
$CONNECTIVITY = $_REQUEST['CONNECTIVITY'];
$Connectivity_Type = $_REQUEST['Connectivity_Type'];
$po = $_REQUEST['po'];
$po_date = $_REQUEST['po_date'];
$latitude = $_REQUEST['latitude'];
$longitude = $_REQUEST['longitude'];
$verificationStatus = $_REQUEST['verificationStatus'];
$networkIP = $_REQUEST['networkIP'];
$routerIP = $_REQUEST['routerIP'];
$atmIP = $_REQUEST['atmIP'];
$subnetIP = $_REQUEST['subnetIP'];

$sql = "update sites set activity = '".$activity."', customer = '".$customer."', bank = '".$bank."', atmid = '".$atmid."', address = '".$address."', 
city = '".$city."', state = '".$state."', zone = '".$zone."', LHO = '".$LHO."', LHO_Contact_Person = '".$LHO_Contact_Person."', 
LHO_Contact_Person_No = '".$LHO_Contact_Person_No."', LHO_Contact_Person_email = '".$LHO_Contact_Person_email."', LHO_Adv_Person = '".$LHO_Adv_Person."', 
LHO_Adv_Contact = '".$LHO_Adv_Contact."', LHO_Adv_email = '".$LHO_Adv_email."', Project_Coordinator_Name = '".$Project_Coordinator_Name."', 
Project_Coordinator_No = '".$Project_Coordinator_No."', Project_Coordinator_email = '".$Project_Coordinator_email."', Customer_SLA = '".$Customer_SLA."',
Our_SLA = '".$Our_SLA."', Vendor = '".$Vendor."', Cash_Management = '".$Cash_Management."', CRA_VENDOR = '".$CRA_VENDOR."', ID_on_Make = '".$ID_on_Make."',
Model = '".$Model."', SiteType = '".$SiteType."', PopulationGroup = '".$PopulationGroup."', XPNET_RemoteAddress = '".$XPNET_RemoteAddress."', 
CONNECTIVITY = '".$CONNECTIVITY."', Connectivity_Type = '".$Connectivity_Type."', po = '".$po."', po_date = '".$po_date."', latitude = '".$latitude."',
longitude = '".$longitude."', verificationStatus = '".$verificationStatus."', networkIP = '".$networkIP."', routerIP = '".$routerIP."', atmIP = '".$atmIP."', 
subnetIP = '".$subnetIP."' where id='".$siteid."'";

if(mysqli_query($con,$sql)){
    echo 'Updated Successfully !' ; 
    echo '<a href="./sitestest.php">View Sites</a>' ; 
}
                                    
                                    ?>
                                            
                                        
                                    </div>
                                </div>
                    
    <? include('../footer.php'); ?>