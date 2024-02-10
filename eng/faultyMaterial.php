<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

     <div class="card">
                        <div class="card-block">

                            <?
                            $statement = "SELECT * FROM generatefaultymaterialrequest WHERE requestBy='" . $PROJECT_email . "' AND requestByPortal IN ('Clarity','Clarify') and materialRequestLevel=3 and status=1";
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
          
<script>
function dispatchCheckedItems() {

    var materialRequestIds = document.getElementsByName('materialRequestId[]');
    var selectedItems = [];

    for (var i = 0; i < materialRequestIds.length; i++) {
        if (materialRequestIds[i].checked) {
            selectedItems.push(materialRequestIds[i].value);
        }
    }

    // Send the selected items to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Display the response from the server
            console.log(xhr.responseText);
        }
    };


    console.log(selectedItems)

    xhr.open('POST', 'process_selected_items.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('selectedItems=' + JSON.stringify(selectedItems));
}
</script>

<? include('../footer.php'); ?>