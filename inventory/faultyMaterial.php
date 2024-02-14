<? include('../header.php'); 


if ($_SESSION['PROJECT_level'] == 3) {
?>
<script>
    window.location.href="/eng/faultyMaterial.php";
</script>
<?
}
else if ($_SESSION['isVendor'] == 1 && $_SESSION['PROJECT_level'] != 3) {
?>
<script>
    window.location.href="/contractor/faultyMaterial.php";
</script>
<?
}


?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="row">


    <div class="card">
        <div class="card-block">

            <?

            $statement = "SELECT * FROM generatefaultymaterialrequest WHERE requestByPortal='vendor' and requestForPortal IN ('advantage','inventory') 
                            and requestFor=1 and status=1";
            $sql = mysqli_query($con, $statement);

            if (mysqli_num_rows($sql) > 0) {
                echo '
    <table class="table">
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
                <td><a href='#'></a></td>

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

</div>



<div class="modal fade" id="dispatchModal" tabindex="-1" role="dialog" aria-labelledby="dispatchModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dispatchModalLabel">Enter OEM Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
                <form id="oemDetailsForm">
                    <div class="form-group">
                        <label for="oemName">OEM Name</label>
                        <input type="text" class="form-control" id="oemName" name="oemName" required>
                    </div>
                    <div class="form-group">
                        <label for="oemContact">Contact Number</label>
                        <input type="tel" class="form-control" id="oemContact" name="oemContact" required>
                    </div>
                    <div class="form-group">
                        <label for="oemAddress">Address</label>
                        <textarea class="form-control" id="oemAddress" name="oemAddress" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="shippingDetails">Shipping Details</label>
                        <textarea class="form-control" id="shippingDetails" name="shippingDetails" rows="3"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="podDate">Proof of Delivery (POD) Date</label>
                        <input type="date" class="form-control" id="podDate" name="podDate" required>
                    </div>
                    <div class="form-group">
                        <label for="courierChallan">Courier Challan</label>
                        <input type="text" class="form-control" id="courierChallan" name="courierChallan" required>
                    </div>
                    <div class="form-group">
                        <label for="documentUpload">Document Upload</label>
                        <input type="file" class="form-control-file" id="documentUpload" name="documentUpload">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitOemDetails">Submit</button>
            </div>
        </div>
    </div>
</div>



<script>
    function dispatchCheckedItems() {
        var materialRequestIds = document.getElementsByName('materialRequestId[]');
        var selectedItems = [];

        for (var i = 0; i < materialRequestIds.length; i++) {
            if (materialRequestIds[i].checked) {
                selectedItems.push(materialRequestIds[i].value);
            }
        }

        if (selectedItems.length > 0) {
            // Open the Bootstrap modal
            $('#dispatchModal').modal('show');
        } else {
            // Handle the case where no items are selected
            alert('Please select at least one item to dispatch.');
        }
    }

    document.getElementById('submitOemDetails').addEventListener('click', function () {
        // Get form data
        var oemName = document.getElementById('oemName').value;
        // Get other form fields as needed

        // Perform validation if necessary

        // Send the form data to the server using AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Handle a successful response from the server
                    console.log(xhr.responseText);
                    // Close the modal
                    $('#dispatchModal').modal('hide');
                } else {
                    // Handle errors
                    console.error('Error: ' + xhr.status);
                }
            }
        };

        // xhr.open('POST', 'process_oem_details.php', true);
        // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        // xhr.send('oemName=' + oemName); // Send data to the server

        // Clear the form fields if needed
    });

</script>

<? include('../footer.php'); ?>