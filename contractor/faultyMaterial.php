<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

   <div class="card">
                        <div class="card-block">

                            <?

                            $statement = "SELECT * FROM generatefaultymaterialrequest WHERE requestFor='" . $RailTailVendorID . "' and requestForPortal IN ('vendor') 
                            and materialRequestLevel=2 and status=1";
                            $sql = mysqli_query($con, $statement);
                            if (mysqli_num_rows($sql) > 0) {
                                echo '
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer table-xs">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Sr No</th>
                                                <th>Material</th>
                                                <th>Serial Number</th>
                                                <th>ATMID</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    <tbody>';

                                $i = 1;

                                while ($sql_result = mysqli_fetch_assoc($sql)) {
                                    $id = $sql_result['id'];
                                    $atmid = $sql_result['atmid'];

                                    echo "<tr>
                                        <td>$i &nbsp;&nbsp;&nbsp;
                                        <input type='checkbox' name='materialRequestId[]' value='$id' /> 
                                        </td>
                                        <td class='strong' colspan='3'>$atmid</td>
                                        <td><a href='#'>Dispatch Item</a></td>

                                     </tr>";
                                    $detailsSql = mysqli_query($con, "SELECT * FROM generatefaultymaterialrequestdetails WHERE requestId='" . $id . "'");
                                    $counter2 = 1;

                                    while ($detailsSql_result = mysqli_fetch_assoc($detailsSql)) {
                                        $MaterialName = $detailsSql_result['MaterialName'];
                                        $MaterialSerialNumber = $detailsSql_result['MaterialSerialNumber'];

                                        echo "<tr>
                                        <td></td>
                                        <td>$MaterialName</td>
                                        <td>$MaterialSerialNumber</td>
                                        <td></td>
                                        <td></td>
                                    </tr>";

                                        $counter2++;
                                    }

                                    $i++;
                                }

                                echo '</tbody>
                                </table>';
                                
                                echo '<a href="#" class="btn btn-primary" onclick="dispatchCheckedItems()">Dispatch Checked Item</a>                                ';
                            } else {
                                echo 'No Data Found!';
                            }

                            ?>
                        </div>
                    </div>
            


<div class="modal fade" id="dispatchModal" tabindex="-1" role="dialog" aria-labelledby="dispatchModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form id="receiversForm" action="process_faultyMaterial.php" method="POST">
                <input name="vendorName" id="vendorName" type="hidden" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="dispatchModalLabel">Enter OEM Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Contact Person Name</label>
                            <input type="text" name="contactPersonName" id="contactPersonName" class="form-control"
                                required>

                        </div>
                        <div class="col-sm-6">
                            <label>Contact Person Number</label>
                            <input type="text" name="contactPersonNumber" id="contactPersonNumber" class="form-control"
                                required>
                        </div>
                        <div class="col-sm-12">
                            <label>Address</label>
                            <textarea name="address" class="form-control" id="address" required></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label>POD</label>
                            <input type="text" name="POD" id="POD" class="form-control" required />
                        </div>
                        <div class="col-sm-6">
                            <label>Courier</label>
                            <input type="text" name="courier" id="courier" class="form-control" required />
                        </div>
                        <div class="col-sm-12">
                            <label>Any Other Remark</label>
                            <input type="text" name="remark" id="remark" class="form-control" />
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <input type="submit" name="Submit" value="Submit"/>  -->
                    <button type="button" id="submitVendorDetails" class="btn btn-primary"
                        id="submitOemDetails">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    var selectedItems = []; // Variable to store selected item IDs

    function dispatchCheckedItems() {
        var materialRequestIds = document.getElementsByName('materialRequestId[]');

        for (var i = 0; i < materialRequestIds.length; i++) {
            if (materialRequestIds[i].checked) {
                selectedItems.push(materialRequestIds[i].value);
            }
        }

        if (selectedItems.length > 0) {
            $('#dispatchModal').modal('show');
        } else {
            alert('Please select at least one item to dispatch.');
        }
    }

    document.getElementById('submitVendorDetails').addEventListener('click', function () {
        var vendorName = document.getElementById('vendorName').value;

        // Get data from the modal form
        var contactPersonName = document.getElementById('contactPersonName').value;
        var contactPersonNumber = document.getElementById('contactPersonNumber').value;
        var address = document.getElementById('address').value;
        var POD = document.getElementById('POD').value;
        var courier = document.getElementById('courier').value;
        var remark = document.getElementById('remark').value;

        if (selectedItems.length > 0) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        console.log();
                        if (xhr.responseText == 1) {
                            Swal.fire("Success", "Material Send Successfully !", "success").then(() => {
                                location.reload();
                            });

                        } else {
                            Swal.fire("Error", "Some error occured", "error");

                        }
                        $('#dispatchModal').modal('hide');
                    } else {
                        console.error('Error: ' + xhr.status);
                    }
                }
            };

            xhr.open('POST', 'process_selected_items.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Include modal form data in the request
            xhr.send('vendorName=' + encodeURIComponent(vendorName) +
                '&selectedItems=' + JSON.stringify(selectedItems) +
                '&contactPersonName=' + encodeURIComponent(contactPersonName) +
                '&contactPersonNumber=' + encodeURIComponent(contactPersonNumber) +
                '&address=' + encodeURIComponent(address) +
                '&POD=' + encodeURIComponent(POD) +
                '&courier=' + encodeURIComponent(courier) +
                '&remark=' + encodeURIComponent(remark)
            );
        } else {
            alert('Please select at least one item to dispatch.');
        }
    });
</script>


<? include('../footer.php'); ?>