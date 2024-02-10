<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="row">

    <div class="col-sm-12 grid-margin">
        <div class="card">
            <div class="card-body">
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
    </div>



    <?php
    // if (isset($_REQUEST['submit']) || isset($_GET['page'])) {
    

    $sqlappCount = "SELECT count(1) as total FROM goodreturn where 1  and isAccept=0 ";
    $atm_sql = "SELECT * FROM goodreturn where 1  and isAccept=0 ";



    if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
        $atmid = $_REQUEST['atmid'];
        $atm_sql .= "and atmid like '%" . $atmid . "%'";
        $sqlappCount .= "and atmid like '%" . $atmid . "%'";
    }


    $atm_sql .= "  order by id desc";
    $sqlappCount .= " ";

    // echo $atm_sql;
    
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


    <div class="col-sm-12 grid-margin">
        <div class="card
        <div class=" card-body" style="overflow:auto;">


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
                    <!-- Add an id attribute to your form for easier targeting with JavaScript -->
                    <form id="exportForm" action="exportGoodsReturn.php" method="POST">
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
                                                <th>Update Action</th>
                                                <th>Contact Person</th>
                                                <th>Contact Number</th>
                                                <th>POD</th>
                                                <th>Courier</th>
                                                <th>Remark</th>
                                                <th>Date</th>

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

                    $address = $sql_result['address'];
                    $contactPerson = $sql_result['contactPersonName'];
                    $contactNumber = $sql_result['contactPersonNumber'];
                    $pod = $sql_result['pod'];
                    $courier = $sql_result['courier'];
                    $remark = $sql_result['remarks'];
                    $date = $sql_result['created_at'];

                    $againSend = mysqli_query($con, "select * from vendorMaterialSend where materialSendId='" . $id . "'");
                    if ($againSendResult = mysqli_fetch_assoc($againSend)) {
                        $isAgainSendStatus = 1;
                        $contactPersonName = $againSendResult['contactPersonName'];
                        // $contactPersonName = vendorUsersData($contactPersonName, 'name');
                        $status = $againSendResult['status'];

                        if ($status == 0) {
                            $isAgainSendStatus = 0;
                        }
                    } else {
                        $isAgainSendStatus = 0;
                    }

                    $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . $atmid . "' and siteid='" . $siteid . "' and materialSendId='" . $id . "' order by id desc");
                    if ($ifExistTrackingUpdateSqlResult = mysqli_fetch_assoc($ifExistTrackingUpdateSql)) {
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

                    echo "<td>" . ($ifExistTrackingUpdate == 1 ?
                        '<button type="button" style="border:none;" class="view-dispatch-info" data-id=' . $id . '>
                                    View
                                    </button>'
                        : "
                                        <button class='update-receive btn btn-primary btn-sm' data-id='$id' data-siteid='$siteid' data-atmid='$atmid'>Update Receive</button> ") . "</td>";
                    echo "<td>" . getusername($contactPerson) . "</td>";
                    echo "<td>$contactNumber</td>";
                    // echo "<td>$contactPerson</td>";
                    echo "<td>$pod</td>";
                    echo "<td>$courier</td>";
                    echo "<td>$remark</td>";
                    echo "<td>$date</td>";
                    echo "</tr>";

                    echo "<tr id='details-$id' class='collapse'>";
                    echo "<td colspan='9'>";
                    $detailsQuery = "SELECT * FROM goodreturndetails WHERE goodReturnID = $id";
                    $detailsResult = mysqli_query($con, $detailsQuery);
                    echo "<table class='table table-bordered'>";
                    echo "<thead><tr><th>Product Name</th><th>Serial Number</th></tr></thead>";
                    echo "<tbody>";
                    while ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
                        $attribute = $detailsRow['material'];
                        $serialNumber = $detailsRow['serialNumber'];
                        echo "<tr><td>$attribute</td><td>$serialNumber</td></tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</td>";
                    echo "</tr>";
                    $counter++;
                }
                echo "</tbody>
                                    </table>";




                $atmid = $_REQUEST['atmid'];
                echo '<div class="pagination"><ul>';
                if ($start_window > 1) {

                    echo "<li><a href='?page=1&&atmid=$atmid'>First</a></li>";
                    echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid=' . $atmid . '">Prev</a></li>';
                }

                for ($i = $start_window; $i <= $end_window; $i++) {
                    ?>
                    <li class="<? if ($i == $current_page) {
                        echo 'active';
                    } ?>">
                        <a href="?page=<?= $i; ?>&&atmid=<?= $atmid; ?>">
                            <?= $i; ?>
                        </a>
                    </li>

                <? }

                if ($end_window < $total_pages) {

                    echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid=' . $atmid . '">Next</a></li>';
                    echo '<li><a href="?page=' . $total_pages . '&&atmid=' . $atmid . '">Last</a></li>';
                }
                echo '</ul></div>';



            } else {

                echo '
                                            
                                <div class="noRecordsContainer">
                                    <img src="../assets/images/noRecords.png">
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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="getDispatchInfo"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>


        // update-receive

        $(".update-receive").on('click', function () {
            if (confirm('Are you sure this received ?')) {

                var id = $(this).data('id');
                var siteid = $(this).data('siteid');
                var atmid = $(this).data('atmid');

                $.ajax({

                    type: "POST",
                    url: 'update-receiveGoodsReturn.php',
                    data: 'id=' + id,
                    success: function (msg) {

                        if (msg == '1') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Material Received !',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = './goodReturn.php';
                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Cancelled !',
                            });
                        }



                    }
                });
            } else {
                alert('Canceled');
            }
        });

        $('.view-dispatch-info').click(function () {
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'getDispatchInfo.php',
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


<? include('../footer.php'); ?>