<? include('../header.php'); ?>
<div class="row">
    <a href="pending_acceptance.php">Go Back</a>
    <?
    $checkedIds = $_REQUEST['checkedIds'];
    // echo '<pre>'; print_r($checkedIds); echo '</pre>';
    
    $acceptance_type = $_REQUEST['acceptance_type'];
    
    // echo $acceptance_type;
    
    $datetime = date('Y-m-d H:i:s');

    foreach ($checkedIds as $key => $id) {

        if ($acceptance_type == 'lho') {
            $sql = mysqli_query($con, "select * from lhositesdelegation where id='" . $id . "'");
            $sql_result = mysqli_fetch_assoc($sql);
            $siteid = $sql_result['siteid'];
            $atmid = $sql_result['atmid'];
            $updateSql = "update lhositesdelegation set isPending=0, updated_at='" . $datetime . "', 
            updated_by='" . $userid . "' where id='" . $id . "'";

            if (mysqli_query($con, $updateSql)) {
                echo $atmid . ' Accepted Successfully ! <br />';
            } else {
                echo $atmid . ' Acceptance Error !<br />';
            }
        } else {
            $sql = mysqli_query($con, "select * from vendorsitesdelegation where id='" . $id . "'");
            $sql_result = mysqli_fetch_assoc($sql);
            $siteid = $sql_result['siteid'];
            $atmid = $sql_result['amtid'];
            $vendorid = $sql_result['vendorid'];


            $updateSql = "update vendorsitesdelegation set isPending=0, upated_at='" . $datetime . "', 
        updated_by='" . $userid . "' where id='" . $id . "'";

            if (mysqli_query($con, $updateSql)) {
                $delegatedToVendorName = getVendorName($vendorid);
                mysqli_query($con,"update sites set isDelegated=1, delegatedToVendorId='".$vendorid."',
                delegatedToVendorName='".$delegatedToVendorName."' where id='".$siteid."'");
                echo $atmid . ' Accepted Successfully ! <br />';


                vendorSiteAcceptance($siteid, $atmid, '',$delegatedToVendorName);


            } else {
                echo $atmid . ' Acceptance Error !<br />';
            }






            $materialQuantities = [];
            $matsql = "SELECT value, count FROM boq";
            $result = $con->query($matsql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $materialName = $row['value'];
                    $quantity = $row['count'];
                    $materialQuantities[$materialName] = $quantity;
                }
            }




            // Generate material requests
    

            foreach ($materialQuantities as $materialName => $quantity) {
                // Insert the material request into the table

                    $sql = "INSERT INTO material_requests (siteid, feasibility_id, material_name, quantity, status, created_by,created_at,type,vendorId)
                VALUES ('$siteid', '$feasibiltyId', '$materialName', '$quantity', 'pending', '" . $userid . "','" . $datetime . "','External','".$vendorid."')";
                    if ($con->query($sql) === false) {
                        echo "Error: " . $sql . "<br>" . $con->error;
                }
            }
                generatesAutoMaterialRequest($siteid, $atmid, '');
            // End Generate material requests
    }

    }
    ?>
</div>
<? include('../footer.php'); ?>