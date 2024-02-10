<? include('../header.php');


$isVendor = $_SESSION['isVendor'];
$islho = $_SESSION['islho'];
$ADVANTAGE_level = $_SESSION['ADVANTAGE_level'];

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';


if($ADVANTAGE_level==3){
    echo 'You are not authorised to see this page !'
    ;
    }
    else if($isVendor==1){
    ?>
<script>
    window.location.href="/corona/inventory/vendor_materialSent.php";
</script>
    <?
}
else if ($islho == 0 && $isVendor == 0) {

?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="row">

    <div class="col-sm-12 grid-margin">

        <div class="card" id="filter">
            <div class="card-block">

                <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                    <div class="row">


                        <div class="col-sm-12">
                            <label>ATM ID</label>
                            <input type="text" name="atmid" class="form-control" value="<?= $_REQUEST['atmid']; ?>"
                                placeholder="Enter ATM ID ..." />
                        </div>

                    </div>
                    <br>
                    <div class="col" style="display:flex;justify-content:center;">
                        <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                    </div>

                </form>
            </div>
        </div>

    </div>


    <?php
    // if (isset($_REQUEST['submit']) || isset($_GET['page'])) {
    $sqlappCount = "select count(1) as total from material_send where 1 ";
    $atm_sql = "select * from material_send where 1 ";

    if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
        $atmid = $_REQUEST['atmid'];
        $atm_sql .= "and atmid like '%" . $atmid . "%'";
        $sqlappCount .= "and atmid like '%" . $atmid . "%'";
    }



    $atm_sql .= "  order by id desc";
    $sqlappCount .= " ";

    $page_size = 10;
    $result = mysqli_query($con, $sqlappCount);
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $page_size;
    $total_pages = ceil($total_records / $page_size);
    $window_size = 10;
    $start_window = max(1, $current_page - floor($window_size / 2));
    $end_window = min($start_window + $window_size - 1, $total_pages);
    $sql_query = "$atm_sql LIMIT $offset, $page_size";
    // }
    // echo $sql_query ; 
    




    ?>

    <div class="col-sm-12 grid-margin">
        <div class="card">
            <div class="card-block">
                <h5>Total Records: <strong class="record-count">
                        <? echo $total_records; ?>
                    </strong></h5>
                <hr>
                <form action="exportInventorySend.php" method="POST">
                    <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                    <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                </form>
            </div>

            <div class="card-block" style="overflow:auto; ">
                <table class="table table-hover table-styling table-xs">
                    <thead>
                        <tr class="table-primary">
                            <th>Srno</th>
                            <th>ATMID</th>
                            <th>Status</th>
                            <th>View Details</th>
                            <th>Vendor</th>
                            <th>Contact Person</th>
                            <th>Contact Number</th>
                            <th>POD</th>
                            <th>Courier</th>
                            <th>Remark</th>
                            <th>Date</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $counter = ($current_page - 1) * $page_size + 1;
                        $sql_app = mysqli_query($con, $sql_query);
                        while ($sql_result = mysqli_fetch_assoc($sql_app)) {
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

                            $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . $atmid . "' and siteid='" . $siteid . "' order by id desc");
                            if ($ifExistTrackingUpdateSqlResult = mysqli_fetch_assoc($ifExistTrackingUpdateSql)) {
                                $ifExistTrackingUpdate = 1;
                            } else {
                                $ifExistTrackingUpdate = 0;
                            }



                            echo "<tr class='clickable-row' data-toggle='collapse' data-target='#details-$id'>";
                            echo "<td>$counter</td>";
                            echo "<td class='strong'>$atmid</td>";
                            echo "<td class='strong text-center'>" .
                                ($isDelivered == 1 ?
                                    '<img src="http://103.216.208.241/assets/deliverydone.png" title="Delivered" alt="Delivered" class="deliveredImg" />' :
                                    'In-Transit') . "</td>";

                            echo "<td>" . ($ifExistTrackingUpdate == 1 ?
                            
                            '<button type="button" style="border:none;" class="view-dispatch-info" data-id=' . $id . '>
                            View
                            </button>' 
                            : 
                                
                                // "<a href='updateMaterialSentTracking.php?id={$id}&siteid={$siteid}&atmid={$atmid}'>Update</a>"
                                ''
                                ) . "</td>";

                            echo "<td>$vendorName</td>";
                            echo "<td>$contactPerson</td>";
                            echo "<td>$contactNumber</td>";
                            echo "<td>$pod</td>";
                            echo "<td>$courier</td>";
                            echo "<td>$remark</td>";
                            echo "<td>$date</td>";
                            echo "<td>$address</td>";
                            echo "</tr>";
                            echo "<tr id='details-$id' class='collapse'>";
                            echo "<td colspan='9'>";

                            // Retrieve and display the material_send_details
                            $detailsQuery = "SELECT * FROM material_send_details WHERE materialSendId = $id";
                            $detailsResult = mysqli_query($con, $detailsQuery);
                            echo "<table class='table table-bordered'>";
                            echo "<thead><tr><th>Product Name</th><th>Serial Number</th></tr></thead>";
                            echo "<tbody>";
                            while ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
                                $attribute = $detailsRow['attribute'];
                                $serialNumber = $detailsRow['serialNumber'];
                                echo "<tr><td>$attribute</td><td>$serialNumber</td></tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";

                            echo "</td>";
                            echo "</tr>";
                            $counter++;
                        }
                        ?>
                    </tbody>
                </table>




                <?

                $atmid = $_REQUEST['atmid'];
                echo '
                <div class="dataTables_wrapper form-inline dt-bootstrap no-footer" style="margin: auto;"> 
                <div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><ul class="pagination">';

                
                if ($start_window > 1) {

                    echo "<li class='paginate_button'><a href='?page=1&&atmid=$atmid'>First</a></li>";
                    echo '<li class="paginate_button"><a href="?page=' . ($start_window - 1) . '&&atmid=' . $atmid . '">Prev</a></li>';
                }

                for ($i = $start_window; $i <= $end_window; $i++) {
                    ?>
                    <li class="paginate_button <? if ($i == $current_page) {
                        echo 'active';
                    } ?>">
                        <a href="?page=<?= $i; ?>&&atmid=<?= $atmid; ?>">
                            <?= $i; ?>
                        </a>
                    </li>

                <? }

                if ($end_window < $total_pages) {

                    echo '<li class="paginate_button"><a href="?page=' . ($end_window + 1) . '&&atmid=' . $atmid . '">Next</a></li>';
                    echo '<li class="paginate_button"><a href="?page=' . $total_pages . '&&atmid=' . $atmid . '">Last</a></li>';
                }
                echo '</ul></div></div>';


                ?>







            </div>
        </div>
    </div>

</div>



<div class="modal" id="viewdispatchinfo">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Info</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div id="getDispatchInfo"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<script>

    $(document).on('click','.view-dispatch-info',function(){

                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'vendor_getDispatchInfo.php',
                    data: {
                        id: id
                    },
                    success: function (response) {
                        $("#getDispatchInfo").html(response);
                    },
                    error: function (error) {
                        $("#getDispatchInfo").html('Nothing found here !');

                    }
                });

                $('#viewdispatchinfo').modal('show');


            });
</script>

<? } ?>
<? include('../footer.php'); ?>