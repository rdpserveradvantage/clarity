<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="row">
    <div class="col-sm-12">
        <div class="card grid-margin">
            <div class="card-block">
                <form action="<? $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>ATM ID</label>
                            <input type="text" class="form-control" name="atmid">
                        </div>

                    </div>
                    <br />

                    <div class="row">
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-primary" name="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        // if (isset($_REQUEST['submit']) || isset($_GET['page'])) {
        $sqlappCount = "SELECT count(1) as total FROM material_send where vendorId='" . $RailTailVendorID . "' and portal='clarity' ";
        $atm_sql = "SELECT * FROM material_send where vendorId='" . $RailTailVendorID . "' and portal='clarity' ";



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
        // echo $sql_query;
        
        ?>


        <div class="card grid-margin">
            <div class="card-block" style="overflow:auto;">


                <?
                $counter = 1;
                $sql = mysqli_query($con, $sql_query);
                if (mysqli_num_rows($sql) > 0) {

                    ?>
                    <div class="card-header">

                        <h5> Total Records:
                            <strong class="record-count">
                                <? echo $total_records; ?>
                            </strong>
                        </h5>
                        <hr>
                        <form action="exportMaterialReceived.php" method="POST">
                            <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                            <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                        </form>

                    </div>

                    <?
                    echo "<table class='table table-bordered table-striped table-hover dataTable js-exportable no-footer table-xs'>
                                        <thead>
                                            <tr class='table-primary'>
                                                <th>Srno</th>
                                                <th>ATMID</th>
                                                <th>Serial Number</th>
                                                <th>Status</th>
                                                <th>Update Action</th>
                                                <th>Contact Person</th>
                                                <th>Contact Number</th>
                                                <th>POD</th>
                                                <th>Courier</th>
                                                <th>Remark</th>
                                                <th>Date</th>
                                                <th>Dispatch</th>
                                                <th>Goods Return</th>
                                            </tr>
                                        </thead>
                                        <tbody>";


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



                        $detailssql = mysqli_query($con, "select * from material_send_details where materialSendId='" . $id . "' and attribute='Router'");
                        $detailssqlResult = mysqli_fetch_assoc($detailssql);

                        $serialNumber = $detailssqlResult['serialNumber'];




                        $againSend = mysqli_query($con, "select * from vendorMaterialSend where materialSendId='" . $id . "' order by id desc");
                        if ($againSendResult = mysqli_fetch_assoc($againSend)) {
                            $isAgainSendStatus = 1;
                            $contactPersonName = $againSendResult['contactPersonName'];
                            $contactPersonName = vendorUsersData($contactPersonName, 'name');
                            $status = $againSendResult['status'];
                            if ($status == 0) {
                                $isAgainSendStatus = 0;
                            }
                        } else {
                            $isAgainSendStatus = 0;
                        }

                        $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . trim($atmid) . "' and siteid='" . $siteid . "' and materialSendId='" . $id . "' order by id desc");
                        if (mysqli_num_rows($ifExistTrackingUpdateSql) > 0) {
                            $ifExistTrackingUpdate = 1;
                        } else {
                            $ifExistTrackingUpdate = 0;
                        }

                        $goodsreturnsql = mysqli_query($con, "select * from goodreturn where materialSendID='" . $id . "' and status=1");

                        if ($goodsreturnsqlResult = mysqli_fetch_assoc($goodsreturnsql)) {
                            $isGoodFound = 1;
                        } else {
                            $isGoodFound = 0;
                        }



                        echo "<tr class='clickable-row' data-toggle='collapse' data-target='#details-$id'>";
                        echo "<td>$counter</td>";
                        echo "<td class='strong'>$atmid</td>";
                        echo "<td class='strong'>$serialNumber</td>";
                        echo "<td class='strong'>" .
                            ($isDelivered == 1 ? 'Delivered' : 'In-Transit') . "</td>";
                        echo "<td>" . ($ifExistTrackingUpdate == 1 ?
                            '<button type="button" style="border:none;" class="view-dispatch-info" data-id=' . $id . '>
                                    View
                                    </button>'
                            : "<a href='vendor_updateMaterialSentTracking.php?id={$id}&siteid={$siteid}&atmid={$atmid}'>Update Receive</a>") . "</td>";
                        echo "<td>$contactPerson</td>";
                        echo "<td>$contactNumber</td>";
                        // echo "<td>$contactPerson</td>";
                        echo "<td>$pod</td>";
                        echo "<td>$courier</td>";
                        echo "<td>$remark</td>";
                        echo "<td>$date</td>";


                        if ($isDelivered == 1 && $isAgainSendStatus == 0) {
                            echo "
                            
                            <td>

                                                <a href='vendor_dispatchMaterial.php?siteid=$siteid&atmid=$atmid&materialSendId=$id'>Dispatch</a>
                                            </td>";
                            $goodsReturn = 1;

                        } else if ($isDelivered == 1 && $isAgainSendStatus == 1) {
                            echo "<td>
                                                            Material Send to <span class='strong'>$contactPersonName <span>
                                                    </td>";
                            $goodsReturn = 0;

                        } else {
                            $goodsReturn = 0;
                            echo "<td>No Status</td>";
                        }

                        if ($goodsReturn == 1 && $isGoodFound == 0) {
                            echo "<td>
                                        <a href='./vendor_goodsReturn.php?siteid=$siteid&atmid=$atmid&materialSendId=$id'>Goods Return</a>
                                        </td>";
                        } else if ($isGoodFound == 1) {
                            echo "<td>
                                            <button class='btn btn-success btn-icon'>✔</button>
                                        </td>";
                        } else {
                            echo "
                                        <td></td>
                                        ";
                        }



                        echo "</tr>";
                        $counter++;
                    }

                    echo "</tbody>
                                    </table>";




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
                        <li class="paginate_button<? if ($i == $current_page) {
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



                } else {

                    echo '
                                            
                                <div class="noRecordsContainer">
                                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
                                <dotlottie-player src="../json/nofound.json" background="transparent" speed="1" loop autoplay style="
                                height: 400px;
                                width: 100%;
                            "></dotlottie-player>
                                
                                </div>';
                }


                ?>


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
            $('.view-dispatch-info').click(function () {
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

    </div>
</div>


<? include('../footer.php'); ?>