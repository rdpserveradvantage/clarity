<?php include('../header.php'); ?>
<div class="card">
    <div class="card-block" style="overflow:auto;">

        <table class="table table-hover table-styling table-xs">
            <thead>
                <tr class="table-primary">
                    <th>Srno</th>
                    <th>ATMID</th>
                    <th>Status</th>

                    <th>Contact Person</th>
                    <th>Contact Number</th>
                    <th>POD</th>
                    <th>Courier</th>
                    <th>Remark</th>
                    <th>Date</th>
                    <th>Dispatch</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                echo "SELECT * FROM vendorMaterialSend where vendorId='" . $RailTailVendorID . "'";
                $sql = mysqli_query($con, "SELECT * FROM vendorMaterialSend where vendorId='" . $RailTailVendorID . "'");
                while ($sql_result = mysqli_fetch_assoc($sql)) {
                    $id = $sql_result['id'];
                    $siteid = $sql_result['siteid'];
                    $atmid = $sql_result['atmid'];
                    $vendorId = $sql_result['vendorId'];
                    $vendorName = getVendorName($vendorId);
                    $address = $sql_result['address'];
                    $contactPerson = $sql_result['contactPersonName'];
                    $contactNumber = $sql_result['contactPersonNumber'];
                    $pod = $sql_result['pod'];
                    $courier = $sql_result['courier'];
                    $remark = $sql_result['remark'];
                    $date = $sql_result['created_at'];
                    $isDelivered = $sql_result['isDelivered'];

                    $isAgainSendStatus = 1;
                    $contactPersonName = $sql_result['contactPersonName'];
                    $contactPersonName = vendorUsersData($contactPersonName, 'name');

                    echo "<tr class='clickable-row' data-toggle='collapse' data-target='#details-$id'>";
                    echo "<td>$counter</td>";
                    echo "<td class='strong'>$atmid</td>";
                    echo "<td class='strong'>" .
                        ($isDelivered == 1 ? 'Delivered' : 'In-Transit') . "</td>";


                    echo "<td>" . vendorUsersData($contactPerson, 'name') . "</td>";

                    echo "<td>$contactNumber</td>";
                    // echo "<td>$contactPerson</td>";
                    echo "<td>$pod</td>";
                    echo "<td>$courier</td>";
                    echo "<td>$remark</td>";
                    echo "<td>$date</td>";
                    if ($isDelivered == 1 && $isAgainSendStatus == 0) {
                        echo "<td>
                                                    <a href='dispatchMaterial.php?siteid=$siteid&atmid=$atmid&materialSendId=$id' class='btn btn-primary'>Dispatch</a>
                                              </td>";
                    } else if ($isDelivered == 1 && $isAgainSendStatus == 1) {
                        echo "<td>
                                                        Material Send to <span class='strong'>$contactPersonName <span>
                                                </td>";

                    } else {
                        echo "<td>No Status</td>";
                    }

                    echo "</tr>";
                    $counter++;

                }
                ?>
            </tbody>
        </table>

    </div>
</div>

<?php include('../footer.php'); ?>