<? include('../config.php');

$exportSql = $_REQUEST['exportSql'];

$sql_query = $exportSql ; 

$contents = "" ; 

$contents = "Srno \t Delegated \t verificationStatus \t po \t po_date \t activity \t customer \t bank \t atmid \t atmid2 \t atmid3 \t address \t latitude \t longitude \t city \t state \t zone \t LHO \t LHO_Contact_Person \t LHO_Contact_Person_No \t LHO_Contact_Person_email \t LHO_Adv_Person \t LHO_Adv_Contact \t LHO_Adv_email \t Project_Coordinator_Name \t Project_Coordinator_No \t Project_Coordinator_email \t Customer_SLA \t Our_SLA \t Vendor \t Cash_Management \t CRA_VENDOR \t ID_on_Make \t Model \t SiteType \t PopulationGroup \t XPNET_RemoteAddress \t CONNECTIVITY \t Connectivity_Type \t Site_data_Received_for_Feasiblity_date \t created_at \t created_by" ;

$i=1 ; 
$atm_sql_res = mysqli_query($con,$sql_query);
while($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)){
        $isFeasibiltyDone = $atm_sql_result['isFeasibiltyDone'];
                    if ($isFeasibiltyDone) {
                        $delegationStatus =  'Feasibility: Done';
                    } else {
                        if ($isDelegated == 0) {
                                $delegationStatus =  'Delegation: Pending';
                        } else {
                                $delegationStatus =  'Delegation: Done';
                        }
                    }
    
        $id = $atm_sql_result['id'];
        $po = $atm_sql_result['po'];
        $po_date = $atm_sql_result['po_date'];
        $activity= $atm_sql_result['activity'];
        $customer= $atm_sql_result['customer'];
        $bank= $atm_sql_result['bank'];
        $atmid= $atm_sql_result['atmid'];
        $atmid2= $atm_sql_result['atmid2'];
        $atmid3= $atm_sql_result['atmid3'];
        $address= $atm_sql_result['address'];
        $city= $atm_sql_result['city'];
        $state= $atm_sql_result['state'];
        $zone= $atm_sql_result['zone'];
        $LHO= $atm_sql_result['LHO'];
        $LHO_Contact_Person= $atm_sql_result['LHO_Contact_Person'];
        $LHO_Contact_Person_No= $atm_sql_result['LHO_Contact_Person_No'];
        $LHO_Contact_Person_email= $atm_sql_result['LHO_Contact_Person_email'];
        $LHO_Adv_Person= $atm_sql_result['LHO_Adv_Person'];
        $LHO_Adv_Contact= $atm_sql_result['LHO_Adv_Contact'];
        $LHO_Adv_email= $atm_sql_result['LHO_Adv_email'];
        $Project_Coordinator_Name= $atm_sql_result['Project_Coordinator_Name'];
        $Project_Coordinator_No= $atm_sql_result['Project_Coordinator_No'];
        $Project_Coordinator_email= $atm_sql_result['Project_Coordinator_email'];
        $Customer_SLA= $atm_sql_result['Customer_SLA'];
        $Our_SLA= $atm_sql_result['Our_SLA'];
        $Vendor= $atm_sql_result['Vendor'];
        $Cash_Management= $atm_sql_result['Cash_Management'];
        $CRA_VENDOR= $atm_sql_result['CRA_VENDOR'];
        $ID_on_Make= $atm_sql_result['ID_on_Make'];
        $Model= $atm_sql_result['Model'];
        $SiteType= $atm_sql_result['SiteType'];
        $PopulationGroup= $atm_sql_result['PopulationGroup'];
        $XPNET_RemoteAddress= $atm_sql_result['XPNET_RemoteAddress'];
        $CONNECTIVITY= $atm_sql_result['CONNECTIVITY'];
        $Connectivity_Type= $atm_sql_result['Connectivity_Type'];
        $Site_data_Received_for_Feasiblity_date = $atm_sql_result['Site_data_Received_for_Feasiblity_date'];
        $isDelegated = $atm_sql_result['isDelegated'];
        $created_at = $atm_sql_result['created_at'];
        $created_by = $atm_sql_result['created_by'];
        $created_by = getUsername($created_by,0);
        $longitude = $atm_sql_result['longitude'] ? $atm_sql_result['longitude'] : 'NA';
        $latitude = $atm_sql_result['latitude'];
        $verificationStatus = $atm_sql_result['verificationStatus'];
    



                $contents.="\n".$i."\t";
                $contents .=($delegationStatus ? $delegationStatus : 'NA') . "\t";
                $contents.= ($verificationStatus ? $verificationStatus : 'NA') ."\t";
                $contents .= ($po ? $po : 'NA') . "\t";
                $contents .= ($po_date ? $po_date : 'NA') . "\t";
                $contents .= ($activity ? $activity : 'NA') . "\t";
                $contents .= ($customer ? $customer : 'NA') . "\t";
                $contents .= ($bank ? $bank : 'NA') . "\t";
                $contents .= ($atmid ? $atmid : 'NA') . "\t";
                $contents .= ($atmid2 ? $atmid2 : 'NA') . "\t";
                $contents .= ($atmid3 ? $atmid3 : 'NA') . "\t";
                $contents .= ($address ? $address : 'NA') . "\t";
                $contents .= ($latitude ? $latitude : 'NA') . "\t";
                $contents .= ($longitude ? $longitude : 'NA') . "\t";
                $contents .= ($city ? $city : 'NA') . "\t";
                $contents .= ($state ? $state : 'NA') . "\t";
                $contents .= ($zone ? $zone : 'NA') . "\t";
                $contents .= ($LHO ? $LHO : 'NA') . "\t";
                $contents .= ($LHO_Contact_Person ? $LHO_Contact_Person : 'NA') . "\t";
                $contents .= ($LHO_Contact_Person_No ? $LHO_Contact_Person_No : 'NA') . "\t";
                $contents .= ($LHO_Contact_Person_email ? $LHO_Contact_Person_email : 'NA') . "\t";
                $contents .= ($LHO_Adv_Person ? $LHO_Adv_Person : 'NA') . "\t";
                $contents .= ($LHO_Adv_Contact ? $LHO_Adv_Contact : 'NA') . "\t";
                $contents .= ($LHO_Adv_email ? $LHO_Adv_email : 'NA') . "\t";
                $contents .= ($Project_Coordinator_Name ? $Project_Coordinator_Name : 'NA') . "\t";
                $contents .= ($Project_Coordinator_No ? $Project_Coordinator_No : 'NA') . "\t";
                $contents .= ($Project_Coordinator_email ? $Project_Coordinator_email : 'NA') . "\t";
                $contents .= ($Customer_SLA ? $Customer_SLA : 'NA') . "\t";
                $contents .= ($Our_SLA ? $Our_SLA : 'NA') . "\t";
                $contents .= ($Vendor ? $Vendor : 'NA') . "\t";
                $contents .= ($Cash_Management ? $Cash_Management : 'NA') . "\t";
                $contents .= ($CRA_VENDOR ? $CRA_VENDOR : 'NA') . "\t";
                $contents .= ($ID_on_Make ? $ID_on_Make : 'NA') . "\t";
                $contents .= ($Model ? $Model : 'NA') . "\t";
                $contents .= ($SiteType ? $SiteType : 'NA') . "\t";
                $contents .= ($PopulationGroup ? $PopulationGroup : 'NA') . "\t";
                $contents .= ($XPNET_RemoteAddress ? $XPNET_RemoteAddress : 'NA') . "\t";
                $contents .= ($CONNECTIVITY ? $CONNECTIVITY : 'NA') . "\t";
                $contents .= ($Connectivity_Type ? $Connectivity_Type : 'NA') . "\t";
                $contents .= ($Site_data_Received_for_Feasiblity_date ? $Site_data_Received_for_Feasiblity_date : 'NA') . "\t";
                $contents .= ($created_at ? $created_at : 'NA') . "\t";
                $contents .= ($created_by ? $created_by : 'NA') . "\t";



$i++ ; 
}

$contents = strip_tags($contents);
// $contents = str_replace("\t\t", "\tNA\t", $contents);
header("Content-Disposition: attachment; filename=exportedSites.xls");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

print $contents;
?>