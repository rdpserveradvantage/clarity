<? include('../header.php'); ?>

     
                                <div class="card">
                                    <div class="card-block">
                                    <?

$atmid = $_REQUEST['atmid'];
$atmid_ar = explode(' ',$atmid);
$atmid_ar = array_filter($atmid_ar, 'strlen');
$unique_atmid_ar = array_unique($atmid_ar);



foreach($unique_atmid_ar as $atmidkey=>$atmidvalue){

    $check_sql = mysqli_query($con,"select id,atmid,delegatedToVendorId from sites where atmid='".$atmidvalue."' and status=1");
    if($check_sql_result = mysqli_fetch_assoc($check_sql)){
        $siteid = $check_sql_result['id'];
        
        $vendorId = $check_sql_result['delegatedToVendorId'] ; 
        // Initiate Material Request here
        $materialQuantities = [];
        $sql = "SELECT value, count FROM boq where status=1";
        $result = $con->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $materialName = $row['value'];
                $quantity = $row['count'];
                $materialQuantities[$materialName] = $quantity;
            }
        }
        
        $type = 'Internal' ;
        
        $feasibiltyId = 0 ; // this should update in future as feasibilty done //
        // Generate material requests
        foreach ($materialQuantities as $materialName => $quantity) {
        // Insert the material request into the table
            echo $sql = "INSERT INTO material_requests (siteid, feasibility_id, material_name, quantity, status, created_by,created_at,type,vendorId)
            VALUES ('$siteid', '$feasibiltyId', '$materialName', '$quantity', 'pending', '".$userid."','".$datetime."','".$type."','".$vendorId."')";
                if ($con->query($sql) === false) {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
                // echo '<br>';
            }

            generatesManualMaterialRequest($siteid,$atmidvalue,'') ;
            
            
            
        echo 'Material Request Sent for ATMID : <span style="color:red;">'. $atmidvalue .'</span>'; 
        echo '<br>';
        
            
        }else{
         echo $atmidvalue . ' Invalid ATMID ';
         echo '<br />';
     }

     
     
 }

?>
                                        
                                    </div>
                                </div>
                    
                    
    <? include('../footer.php'); ?>



