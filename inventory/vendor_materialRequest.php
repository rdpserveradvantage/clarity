<? include('../header.php'); 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>


<style>
    #contactPersonName[readonly] {
        pointer-events: none;
    }

    .swal2-popup {
        background: white !important;
    }
</style>
                    <div class="card">
                        <div class="card-header">
                            <h5>Material Request</h5>
                        </div>
                        <div class="card-body" style="overflow:auto;">

                            <?
                            // echo "select * from vendormaterialrequest where vendorId='" . $RailTailVendorID . "' and status=1 and requestToInventory=0";
                            $srno = 1;
                            $sql = mysqli_query($con, "select * from vendormaterialrequest where vendorId='" . $RailTailVendorID . "' and status=1 and requestToInventory=0");
                            if (mysqli_num_rows($sql) > 0) {

                                echo '<table class="table table-hover table-styling table-xs">
    <thead>
        <tr class="table-primary">
            <th>Sr No</th>
            <th>Requested By</th>
            <th>ATMID</th>
            <th>Material</th>
            <th>Requested At</th>
            <th>Action</th>
            <th>AVAILABILTY</th>
        </tr>
    </thead>
    <tbody> ';

                                while ($sql_result = mysqli_fetch_assoc($sql)) {

                                    $id = $sql_result['id'];
                                    $siteid = $sql_result['siteid'];
                                    $engineerId = $sql_result['engineerId'];
                                    $engineerName = $sql_result['engineerId'];
                                    $engineerName = getUsername($engineerName);
                                    $atmid = $sql_result['atmid'];
                                    $materialName = $sql_result['materialName'];
                                    $created_at = $sql_result['created_at'];

                                    $checkInventory = mysqli_query($con, "select material,count(1) as materialCount from vendorinventory where material like '" . trim($materialName) . "' and status=1 and vendorId='" . $RailTailVendorID . "' group by material having count(1) > 0");
                                    if ($checkInventoryResult = mysqli_fetch_assoc($checkInventory)) {
                                        $matName = $checkInventoryResult['material'];
                                        $matCount = $checkInventoryResult['materialCount'];
                                        $availability = $matCount . ' In Stock ';
                                        $availabilityStatus = 1;
                                    } else {
                                        $availability = 'Not Available';
                                        $availabilityStatus = 0;
                                    }


                                    echo "<tr>
<td>$srno</td>
<td>$engineerName</td>
<td>$atmid</td>
<td>$materialName</td>
<td>$created_at</td>
<td>";

                                    if ($availabilityStatus == 1) {
                                        echo "<button type='button' class='send-from-stock btn btn-primary btn-sm' 
            data-materialName='$materialName'
            data-id='$id' data-siteid='$siteid' data-atmid='$atmid' data-engineerId='$engineerId'>
            Send From Stock
          </button>";
                                    } else {
                                        echo "<button class='btn btn-disabled'>Not In Stock</button>";
                                    }

                                    echo "
 <button type='button' class='material-request btn btn-primary btn-sm' 
    data-materialName='$materialName'
    data-id='$id' data-siteid='$siteid' data-atmid='$atmid' data-engineerId='$engineerId' >
 Material Request
</button>
</td>
<td>$availability</td>
</tr>";

                                    $srno++;
                                }

                                echo "</tbody>
</table>";
                            } else {

                                echo '
                                            
<div class="noRecordsContainer">
    <img src="../assets/images/noRecords.png">
</div>';
                            }
                            ?>


                        </div>
                    </div>
          



<div class="modal" id="sendFromStockModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send From Stock</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">



                <form id="vendorForm">
                    <input type="hidden" name="engineerId" id="engineerId">
                    <input type="hidden" name="atmid" value="<?php echo $atmid; ?>">
                    <input type="hidden" name="siteid" value="<?php echo $siteid; ?>">
                    <input type="hidden" name="vendorId" value="<?php echo $RailTailVendorID; ?>">
                    <input type="hidden" name="attribute" value="<?php echo htmlentities(serialize($attributes)); ?>">
                    <input type="hidden" name="serialNumbers"
                        value="<?php echo htmlentities(serialize($serialNumbers)); ?>">

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="">Material</label>
                            <input type="text" name="attribute" id="material" class="form-control" value="" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Serial Number</label>
                            <input type="text" name="serialNumbers" id="serialNumbers" class="form-control" value=""
                                required>
                        </div>

                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Contact Person Name</label>
                            <select class="form-control" name="contactPersonName" id="contactPersonName" readonly
                                required>
                                <option value="">Select</option>
                                <?

                                $vendorUsersSql = mysqli_query($con, "select * from vendorUsers where vendorId='" . $RailTailVendorID . "' and user_status=1 order by name asc");
                                while ($vendorUsersSqlResult = mysqli_fetch_assoc($vendorUsersSql)) {
                                    $vendorUserName = $vendorUsersSqlResult['name'];
                                    $vendorUserId = $vendorUsersSqlResult['id'];
                                    ?>
                                    <option value="<?= $vendorUserId; ?>">
                                        <?= $vendorUserName; ?>
                                    </option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label>Contact Person Number</label>
                            <input type="text" name="contactPersonNumber" id="contactPersonNumber" class="form-control"
                                readonly required>
                        </div>
                        <div class="col-sm-12">
                            <label>Address</label>
                            <textarea name="address" class="form-control" id="address" required></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label>POD</label>
                            <input type="text" name="POD" class="form-control" required />
                        </div>
                        <div class="col-sm-6">
                            <label>Courier</label>
                            <input type="text" name="courier" class="form-control" required />
                        </div>
                        <div class="col-sm-12">
                            <label>Any Other Remark</label>
                            <input type="text" name="remark" class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                            <input type="submit" name="submit" class="btn btn-primary" onclick="submitForm(event);"
                                id="submitButton" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.send-from-stock').click(function () {

            var id = $(this).data('id');
            var siteid = $(this).data('siteid');
            var atmid = $(this).data('atmid');
            var engineerId = $(this).data('engineerid');
            var materialName = $(this).data('materialname');

            $.ajax({
                type: "POST",
                url: 'getVendorUserInfo.php',
                data: 'contactPerson=' + engineerId,
                async: false,
                success: function (msg) {
                    var data = JSON.parse(msg);
                    $('#contactPersonNumber').val(data.contact);
                    $('#address').val(data.address);
                }
            });

            $('#sendFromStockModal').find('[name="atmid"]').val(atmid);
            $('#sendFromStockModal').find('[name="siteid"]').val(siteid);
            $('#sendFromStockModal').find('[name="engineerId"]').val(engineerId);
            $('#sendFromStockModal').find('[name="attribute"]').val(materialName); //attribute = material_name

            $('#sendFromStockModal').find('#contactPersonName').val(engineerId);
            $('#sendFromStockModal').modal('show');

        });




        $(document).on('click', '#contactPersonName[readonly]', function () {
            return false;
        });

        $('.material-request').click(function () {
            if (confirm('Are you sure you want to generate a material request?')) {
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: 'proceedToInventoryMaterialRequest.php',
                    data: {
                        id: id
                    },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire({
                                title: "Material Request Send Successfully !",
                                text: "Redirecting...",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500,
                                didClose: () => {
                                    window.location.href = 'materialRequest.php';
                                },
                            });
                        } else {
                            Swal.fire({
                                title: "Material Request sent error !",
                                text: 'Ooops ',
                                icon: "error",
                                showConfirmButton: true, // You can use true or false based on your preference
                            });
                        }
                    },
                    error: function (error) {
                        Swal.fire({
                            title: "Material Request sent error !",
                            text: 'Ooops ',
                            icon: "error",
                            showConfirmButton: true, // You can use true or false based on your preference
                        });
                    }
                });
            }
        });
    });
</script>
<? include('../footer.php'); ?>