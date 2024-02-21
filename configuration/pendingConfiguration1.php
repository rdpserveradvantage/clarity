<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="row">


<div class="col-sm-12 grid-margin">
<div class="card">
                        <div class="card-body">
                            <div class="two_end">
                                <h5>Router Configuration <span style="font-size:12px; color:red;">(add router serial
                                        number along with seal number)</span></h5>

                            </div>
                            <hr>


                            <form id="routerConfigForm" action="processPendingConfiguration.php" method="post">
                                <div class="form-group">
                                    <label>Atmid</label>
                                    <input type="text" id="atmid" class="form-control" list="atmidOptions" name="atmid"
                                        required>
                                    <datalist id="atmidOptions"></datalist>
                                </div>
                                <div class="form-group">
                                    <label for="serialNumber">Serial Number</label>
                                    <input type="text" class="form-control" id="serialNumber" list="serialOptions"
                                        name="serialNumber" required>
                                    <datalist id="serialOptions"></datalist>

                                </div>


                                <div class="row" id="additionalInfo" style="display:none">
                                    <div class="col-sm-4 grid-margin">
                                        <label for="networkIP">Network IP</label>
                                        <input type="text" id="networkIP" name="networkIP" class="form-control"
                                            value="<?= $networkIP; ?>" readonly />
                                    </div>

                                    <div class="col-sm-4 grid-margin">
                                        <label for="routerIP">Router IP</label>
                                        <input type="text" id="routerIP" name="routerIP" class="form-control"
                                            value="<?= $routerIP; ?>" readonly />
                                    </div>
                                    <div class="col-sm-4 grid-margin">
                                        <label for="atmIP">ATM IP</label>
                                        <input type="text" id="atmIP" name="atmIP" class="form-control"
                                            value="<?= $atmIP; ?>" readonly />
                                    </div>


                                    <div class="col-sm-4 grid-margin">
                                        <label class="label_label">Region</label>
                                        <input class="form-control" type="text" name="region" id="region"
                                            value="<? echo $region; ?>">
                                    </div>

                                    <div class="col-sm-4 grid-margin">
                                        <label class="label_label">City</label>
                                        <input class="form-control" type="text" name="city" id="city"
                                            value="<? echo $city; ?>" required>
                                    </div>

                                    <div class="col-sm-4 grid-margin">
                                        <label class="label_label">State</label>
                                        <select name="state" id="state" class="form-control" required>
                                            <option value="">Select State</option>
                                            <?
                                            $state_sql = mysqli_query($con, "select distinct(state) as state from sites where status=1");
                                            while ($state_sql_result = mysqli_fetch_assoc($state_sql)) { ?>
                                                <option value="<? echo $state_sql_result['state']; ?>" <? if ($state == $state_sql_result['state']) {
                                                       echo 'selected';
                                                   } ?>>
                                                    <? echo $state_sql_result['state']; ?>
                                                </option>
                                            <? } ?>
                                        </select>

                                    </div>

                                    <div class="col-sm-12 grid-margin">
                                        <label class="label_label">Locations</label>
                                        <input class="form-control" type="text" name="location" id="location"
                                            value="<? echo $location; ?>">
                                    </div>
                                </div>
                                <br />
                                <!-- <div class="form-group">
                                    <label for="sealNumber">Seal Number</label>
                                    <input type="text" class="form-control" id="sealNumber" name="sealNumber" required>
                                </div> -->
                                <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                            </form>







                        </div>
                    </div>
                    </div>
                    
    <div class="col-sm-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="atmid" class="form-control"
                                            placeholder="Enter Atmid ..." value="<?= $_REQUEST['atmid']; ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="serial_no" class="form-control"
                                            placeholder="Enter Serial Number ..."
                                            value="<?= $_REQUEST['serial_no']; ?>" />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="submit" name="filterSubmit" class="btn btn-sm btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                    <?

                    $sqlappCount = "select count(1) as total from routerConfiguration where 1 ";
                    $atm_sql = "select * from routerConfiguration where 1 ";


                    if (isset($_REQUEST['serial_no']) && $_REQUEST['serial_no'] != '') {
                        $serial_no = $_REQUEST['serial_no'];
                        $atm_sql .= "and serialNumber like '%" . $serial_no . "%'";
                        $sqlappCount .= "and serialNumber like '%" . $serial_no . "%'";
                    }
                    if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
                        $atmid = $_REQUEST['atmid'];
                        $atm_sql .= "and atmid like '%" . $atmid . "%'";
                        $sqlappCount .= "and atmid like '%" . $atmid . "%'";
                    }



                    $atm_sql .= " and status=1 order by id desc";
                    $sqlappCount .= " and status=1";

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

// echo $sql_query ; 

                    ?>


<div class="col-sm-12 grid-margin">
                    <div class="card">
                        <div class="card-header">
                            <h5>Total Records: <strong class="record-count">
                                    <? echo $total_records; ?>
                                </strong></h5>

                            <hr>
                            <form action="export_ROUTER_CONFIGURATION.php" method="POST">
                                <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                                <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                            </form>

                        </div>



                        <div class="card-body" style="overflow:auto;">

                            <?
                            $i = 1;
                            // echo "select * from routerConfiguration where status=1 order by id desc" ; 
                            $sql = mysqli_query($con, "select * from routerConfiguration where status=1 order by id desc");
                            if (mysqli_num_rows($sql) > 0) {

                                echo '<table class="table table-hover table-styling table-xs" style="width:100%;">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>Atm id</th>
                                        <th>Serial Number</th>
                                        <th>Network IP</th>
                                        <th>Router IP</th>
                                        <th>ATM IP</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>ATMID ROUTER UNBIND</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                $counter = ($current_page - 1) * $page_size + 1;
                                $sql_app = mysqli_query($con, $sql_query);
                                while ($sql_result = mysqli_fetch_assoc($sql_app)) {

                                    $id = $sql_result['id'];
                                    $atmid = $sql_result['atmid'];
                                    $serialNumber = $sql_result['serialNumber'];
                                    $sealNumber = $sql_result['sealNumber'];
                                    $created_at = $sql_result['created_at'];

                                    $ipconfurationSql = mysqli_query($con, "select * from ipconfuration where serial_no ='" . $serialNumber . "' and status=1 order by id desc");
                                    $ipconfurationSqlResult = mysqli_fetch_assoc($ipconfurationSql);

                                    $networkIP = $ipconfurationSqlResult['network_ip'];
                                    $routerIP = $ipconfurationSqlResult['router_ip'];
                                    $atmIP = $ipconfurationSqlResult['atm_ip'];

                                    $created_by = $sql_result['created_by'];
                                    $created_by = getUsername($created_by, false);


                                    echo "<tr>
                                            <td>{$counter}</td>
                                            <td>{$atmid}</td>
                                            <td>{$serialNumber}</td>
                                            <td>{$networkIP}</td>
                                            <td>{$routerIP}</td>
                                            <td>{$atmIP}</td>
                                            <td>{$created_at}</td>
                                            <td>{$created_by}</td>
                                            <td><a href='#' data-bs-toggle='modal' data-bs-target='#unbindModal' data-id='{$id}'>Unbind</a></td>

                                        </tr>";

                                    $counter++;
                                }

                                echo "    </tbody>
                            </table>";

                                $serial_no = $_REQUEST['serial_no'];
                                $atmid = $_REQUEST['atmid'];
                                echo '
                                <div class="dataTables_wrapper form-inline dt-bootstrap no-footer" style="margin: auto;"> 
                                <div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><ul class="pagination">';
            
                                if ($start_window > 1) {

                                    echo "<li class='paginate_button'><a href='?page=1&&serial_no=$serial_no&&atmid=$atmid'>First</a></li>";
                                    echo '<li class="paginate_button"><a href="?page=' . ($start_window - 1) . '&&serial_no=' . $serial_no . '&&atmid=' . $atmid . '">Prev</a></li>';
                                }

                                for ($i = $start_window; $i <= $end_window; $i++) {
                                    ?>
                                    <li  class="paginate_button <? if ($i == $current_page) {
                                        echo 'active';
                                    } ?>">
                                        <a href="?page=<?= $i; ?>&&serial_no=<?= $serial_no; ?>&&atmid=<?= $atmid; ?>">
                                            <?= $i; ?>
                                        </a>
                                    </li>

                                <? }

                                if ($end_window < $total_pages) {

                                    echo '<li class="paginate_button"><a href="?page=' . ($end_window + 1) . '&&serial_no=' . $serial_no . '&&atmid=' . $atmid . '">Next</a></li>';
                                    echo '<li class="paginate_button"><a href="?page=' . $total_pages . '&&serial_no=' . $serial_no . '&&atmid=' . $atmid . '">Last</a></li>';
                                }
                                echo '</ul></div>';


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

                    </div>






<div class="modal fade" id="unbindModal" tabindex="-1" role="dialog" aria-labelledby="unbindModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unbindModalLabel">Unbind Confirmation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to unbind this item?</p>
                <input type="hidden" id="unbindItemId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmUnbind()">Unbind</button>
            </div>
        </div>
    </div>
</div>



<script>
    
    $(document).on("click", "a[data-bs-target='#unbindModal']", function () {
        var id = $(this).data('id');
        document.getElementById("unbindItemId").value = id;
    });


    function confirmUnbind() {
        var idToUnbind = document.getElementById("unbindItemId").value;
        // alert(idToUnbind)
        $.ajax({
            type: "POST",
            url: "unbind_router_atmid.php",
            data: { id: idToUnbind },
            success: function (response) {
                // console.log(response);
                if (response == '1') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Unbind Success !'
                    }).then(function () {
                        window.location.href = 'pendingConfiguration1.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unbind Error !'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        $('#unbindModal').modal('hide');
    }

    $(document).ready(function () {

      


        function populateATMDatafromIP(serial_no) {
            $.ajax({
                type: "POST",
                url: 'get_ip_data.php',
                data: 'serial_no=' + serial_no,
                success: function (msg) {
                    console.log(msg);

                    if (msg != 0) {
                        var obj = JSON.parse(msg);
                        var fields = ['networkIP', 'routerIP', 'atmIP'];


                        fields.forEach(function (field) {
                            if (!obj[field]) {
                                $("#" + field).focus();
                            } else {
                                $("#" + field).val(obj[field]);
                                $('#' + field).attr('readonly', true);
                            }
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'No Info With This Serial Number',
                        }).then(function () {
                            // $("#form")[0].reset();
                        });

                    }
                }
            });

        }

        function populateATMDatafromSites(atmid) {
            $.ajax({
                type: "POST",
                url: 'get_atm_data.php',
                data: 'atmid=' + atmid,
                success: function (msg) {
                    console.log(msg);

                    if (msg != 0) {
                        var obj = JSON.parse(msg);
                        var fields = ['customer', 'bank', 'engineer', 'location', 'region', 'state', 'city', 'branch', 'bm', 'lho'];

                        if (obj.isConfigurationFound == 1) {
                            $("#submitButton").prop("disabled", true);
                            alert('Router already Configure with given atmid !');

                        } else {
                            $("#submitButton").prop("disabled", false);

                        }


                        fields.forEach(function (field) {
                            if (!obj[field]) {
                                $("#" + field).focus();
                            } else {
                                $("#" + field).val(obj[field]);
                                $('#' + field).attr('readonly', true);
                            }
                        });

                        if (obj.customer && obj.bank && obj.location && obj.region && obj.state && obj.city && obj.branch && obj.bm && obj.lho) {
                            $("#call_receive").focus();
                        }

                        $("#call_type").focus();
                        $("#additionalInfo").css('display', 'flex');
                    } else {
                        $("#additionalInfo").css('display', 'none');
                        Swal.fire({
                            icon: 'error',
                            title: 'No Info With This ATM',
                        }).then(function () {
                            // Reset the form
                            $("#form")[0].reset();
                        });

                    }
                }
            });

        }

        $("#atmid").on('input', function () {
            var input = $(this).val();

            $.ajax({
                type: "POST",
                url: 'get_suggestions.php',
                data: {
                    input: input
                },
                success: function (response) {
                    console.log(response)
                    var datalist = $("#atmidOptions");
                    datalist.empty();

                    var suggestions = JSON.parse(response);

                    suggestions.forEach(function (suggestion) {
                        datalist.append($("<option>").attr('value', suggestion).text(suggestion));
                    });
                }
            });
        });


        $("#serialNumber").on('input', function () {
            var input = $(this).val();

            $.ajax({
                type: "POST",
                url: 'get_serialsuggestions.php',
                data: {
                    input: input
                },
                success: function (response) {
                    console.log(response)
                    var datalist = $("#serialOptions");
                    datalist.empty();

                    var suggestions = JSON.parse(response);

                    suggestions.forEach(function (suggestion) {
                        datalist.append($("<option>").attr('value', suggestion).text(suggestion));
                    });
                }
            });
        });


        $("#atmid").on('change', function () {
            var atmid = $(this).val();
            populateATMDatafromSites(atmid);
        });


        $("#serialNumber").on('change', function () {
            var serial_no = $(this).val();
            populateATMDatafromIP(serial_no);
        });


    });
</script>

</div>


<? include('../footer.php'); ?>



