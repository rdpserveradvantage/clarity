<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="row">
    <style>
        .form-control {
            font-size: 16px !important;
            border-radius: 2px;
            border: 1px solid #ccc;
        }
    </style>


    <div class="col-sm-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="two_end">
                    <h5>Router Configuration <span style="font-size:12px; color:red;">(add router serial number along
                            with seal number)</span></h5>
                </div>
                <hr>
                <form id="routerConfigForm" action="<? $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label>Serial No</label>
                        <input type="text" id="serial_no" class="form-control" list="serial_noOptions" name="serial_no"
                            autocomplete="off" required>
                        <datalist id="serial_noOptions"></datalist>
                    </div>
                    <div class="row" id="IPinfoBox" style="display:none">
                        <input type="hidden" name="ipID" id="ipID" value="" />
                        <div class="col-sm-12" id="msgDiv" style="display:none;">
                            Message : <label id="msg"></label>
                        </div>

                        <div class="col-sm-12">
                            <label>Network IP</label>
                            <input class="form-control" readonly type="text" name="network_ip" id="network_ip" value="">
                        </div>
                        <div class="col-sm-12">
                            <label>Router IP</label>
                            <input class="form-control" readonly type="text" name="router_ip" id="router_ip" value="">
                        </div>

                        <div class="col-sm-12">
                            <label>ATM IP</label>
                            <input class="form-control" readonly type="text" name="atm_ip" id="atm_ip" value="">
                        </div>
                        <div class="col-sm-12">
                            <label>Subnet Mask</label>
                            <input class="form-control" readonly type="text" name="subnet_mask" id="subnet_mask"
                                value="">
                        </div>
                    </div>
                    <br />
                    <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Configure">
                </form>
            </div>
        </div>
    </div>

    <?

    if (isset($_REQUEST['submit'])) {

        ?>



        <div class="col-sm-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <?

                    $serial_no = $_REQUEST["serial_no"];
                    $router_ip = $_REQUEST["router_ip"];
                    $network_ip = $_REQUEST["network_ip"];
                    $atm_ip = $_REQUEST["atm_ip"];
                    $subnet_mask = $_REQUEST["subnet_mask"];
                    $ipID = $_REQUEST['ipID'];

                    if ($ipID > 0) {

                        $checkSql = mysqli_query($con, "select * from ipconfuration where serial_no='" . $serial_no . "' and status=1");
                        if ($checkSqlResult = mysqli_fetch_assoc($checkSql)) {

                            echo '<h5> This Serial Number is already configured. </h5>';
                        } else {
                            if (mysqli_query($con, "update inventory set isIPAssign=1 where serial_no='" . $serial_no . "'")) {
                                echo '<h5>IP Assigned To Serial Number : ' . $serial_no . '</h5>';
                                mysqli_query($con, "update ips set isAssign=1 where id='" . $ipID . "'");
                                mysqli_query($con, "insert into ipconfuration(ipID, serial_no, router_ip, network_ip, atm_ip, subnet_ip, created_at, created_by, status)
                                        values('" . $ipID . "','" . $serial_no . "','" . $router_ip . "','" . $network_ip . "','" . $atm_ip . "','" . $subnet_mask . "','" . $datetime . "','" . $userid . "',1)");
                            } else {
                                echo '<h5>Error In IP Assigned To Serial Number : ' . $serial_no . '</h5>';
                            }
                        }
                    } else {
                        echo '<h5>Something Wrong</h5>';
                    }
                    ?>
                </div>
            </div>
        </div>

    <? } ?>








    <?php
    // if (isset($_REQUEST['submit']) || isset($_GET['page'])) {
    $sqlappCount = "select count(1) as total from ipconfuration where 1 ";
    $atm_sql = "select id,serial_no,router_ip,network_ip,atm_ip,subnet_ip,created_at,created_by,status,updated_at,updatedBy from ipconfuration where 1 ";

    if (isset($_REQUEST['serial_no']) && $_REQUEST['serial_no'] != '') {
        $serial_no = $_REQUEST['serial_no'];
        $atm_sql .= "and serial_no like '%" . $serial_no . "%'";
        $sqlappCount .= "and serial_no like '%" . $serial_no . "%'";
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


    <div class="col-sm-12 grid-margin">
        <div class="card">


            <div class="card-body">
                <h5>Total Records: <strong class="record-count">
                        <? echo $total_records; ?>
                    </strong></h5>

                <hr />
                <form action="exportdoneConfigured.php" method="POST">
                    <input type="hidden" name="exportSql" value="<? echo $atm_sql; ?>">
                    <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                </form>
            </div>
            <div class="card-body" style="overflow: auto;">
                <hr>
                <?
                $i = 1;
                $sql = mysqli_query($con, "select * from ipconfuration order by id desc");
                if (mysqli_num_rows($sql) > 0) {

                    echo '
                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>Serial Number</th>
                                        <th>Network IP</th>
                                        <th>Router IP</th>
                                        <th>ATM IP</th>
                                        <th>Subnet IP</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Updated By</th>
                                        <th>Updated At</th>
                                        
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    $i = 1;
                    $counter = ($current_page - 1) * $page_size + 1;
                    $sql_app = mysqli_query($con, $sql_query);
                    while ($row = mysqli_fetch_assoc($sql_app)) {

                        $id = $row['id'];
                        $serialNumber = $row['serial_no'];
                        $created_at = $row['created_at'];
                        $updated_at = $row['updated_at'];


                        $created_by = $row['created_by'];
                        $created_by = getUsername($created_by, false);

                        $updatedBy = $row['updatedBy'];
                        $updatedBy = getUsername($updatedBy, false);

                        $router_ip = $row["router_ip"];
                        $network_ip = $row["network_ip"];
                        $atm_ip = $row["atm_ip"];
                        $subnet_ip = $row["subnet_ip"];
                        $status = $row['status'];


                        if ($status == 1) {
                            $activityStatus = 'Active';
                            $activityClass = 'show';

                        } else {
                            $activityStatus = 'In-Active';
                            $activityClass = 'hide';

                        }

                        echo "<tr>
                                            <td>{$i}</td>
                                            <td class='strong'>{$serialNumber}</td>
                                            <td>{$network_ip}</td>
                                            <td>{$router_ip}</td>
                                            <td>{$atm_ip}</td>
                                            <td>{$subnet_ip}</td>
                                            <td>{$created_at}</td>
                                            <td>{$created_by}</td>
                                            <td>{$activityStatus}</td>
                                            <td>{$updatedBy}</td>
                                            <td>{$updated_at}</td>

                                            <td><a href='#' data-toggle='modal' data-target='#unbindModal' class='{$activityClass}' data-id='{$id}'>Unbind</a></td>

                                        </tr>";

                        $i++;
                    }

                    echo "    </tbody>
                            </table>";



                    $serial_no = $_REQUEST['serial_no'];

                    echo '
                    <div class="dataTables_wrapper form-inline dt-bootstrap no-footer" style="margin: auto;"> 
                    <div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><ul class="pagination">';
           
                    
                    if ($start_window > 1) {

                        echo "<li class='paginate_button'><a href='?page=1&&serial_no=$serial_no'>First</a></li>";
                        echo '<li class="paginate_button"><a href="?page=' . ($start_window - 1) . '&&serial_no=' . $serial_no . '">Prev</a></li>';
                    }

                    for ($i = $start_window; $i <= $end_window; $i++) {
                        ?>
                        <li class="paginate_button" <? if ($i == $current_page) {
                            echo 'active';
                        } ?>">
                            <a href="?page=<?= $i; ?>&&serial_no=<?= $serial_no; ?>">
                                <?= $i; ?>
                            </a>
                        </li>

                    <? }

                    if ($end_window < $total_pages) {

                        echo '<li class="paginate_button"><a href="?page=' . ($end_window + 1) . '&&serial_no=' . $serial_no . '">Next</a></li>';
                        echo '<li class="paginate_button"><a href="?page=' . $total_pages . '&&serial_no=' . $serial_no . '">Last</a></li>';
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
    </div>
















































    <script>
        $(document).ready(function () {

            $("#serial_no").on('input', function () {
                var input = $(this).val();

                $.ajax({
                    type: "POST",
                    url: 'get_serialno_suggestions.php',
                    data: {
                        input: input
                    },
                    success: function (response) {
                        console.log(response)
                        var datalist = $("#serial_noOptions");
                        datalist.empty();

                        var suggestions = JSON.parse(response);

                        suggestions.forEach(function (suggestion) {
                            datalist.append($("<option>").attr('value', suggestion).text(suggestion));
                        });
                    }
                });
            });


            $("#serial_no").on('change', function () {
                var serial_no = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'get_unAssignedIP.php',
                    data: 'serial_no=' + serial_no,
                    success: function (response) {
                        if (response == 0) {
                            alert("No IP addresses available.");
                            $("#IPinfoBox").css('display', 'none');
                        } else if (response == 2) {
                            alert('Entered Serial Number is not Available !');
                            $("#serial_no").val('');
                        } else {
                            var ipAddresses = JSON.parse(response);
                            $("#router_ip").val(ipAddresses.router_ip);
                            $("#network_ip").val(ipAddresses.network_ip);
                            $("#atm_ip").val(ipAddresses.atm_ip);
                            $("#subnet_mask").val(ipAddresses.subnet_ip);
                            $("#ipID").val(ipAddresses.id);
                            if (ipAddresses.msg) {
                                $("#msgDiv").css('display', 'block')
                                $("#msg").html(ipAddresses.msg);
                                $("#submit").css('display', 'none');
                            } else {
                                $("#msgDiv").css('display', 'none');
                                $("#submit").css('display', 'block');
                            }
                            $("#serial_noOptions option[value='" + serial_no + "']").remove();
                            $("#IPinfoBox").css('display', 'flex');
                            $("#router_ip").focus();
                            setTimeout(checkIfIPisUnassigned, 5000);
                        }
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            var form = document.getElementById("routerConfigForm");

            form.addEventListener("keydown", function (event) {
                if (event.key === "Enter") {
                    event.preventDefault(); // Prevent the form from submitting
                }
            });
        });
    </script>

    <style>
        .custom-alert {
            position: fixed;
            top: 10%;
            right: 2%;
            z-index: 1100;
            background: #404e67;
            color: white;
            width: 20%;
            animation: shake 0.5s;
            /* Apply the shake animation */
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            50% {
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-5px);
            }

            100% {
                transform: translateX(5px);
            }
        }
    </style>

    <script>
        function checkIfIPisUnassigned() {
            var ipID = $("#ipID").val();
            $.ajax({
                type: 'GET',
                url: 'checkIfIPisunAssign.php',
                data: 'ipID=' + ipID,
                success: function (response) {
                    console.log(response)
                    if (response == 1) {
                        showTickMark();
                    } else {
                        showCross();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function showTickMark() {
            // Create a Bootstrap alert with a tick mark icon
            var alert = '<div class="alert alert-success custom-alert" role="alert">' +
                '  <i class="fas fa-check-circle"></i> IP is available' +
                '</div>';
            // Append the alert to the page body
            $('body').append(alert);

            // Auto-hide the alert after 5 seconds
            setTimeout(function () {
                $('.custom-alert').fadeOut(1000, function () {
                    $(this).remove();
                });
            }, 5000); // 5000 milliseconds = 5 seconds
            $("#submit").css('display', 'block');
        }

        function showCross() {
            // Create a Bootstrap alert with a cross icon
            var alert = '<div class="alert alert-danger custom-alert" role="alert">' +
                '  <i class="fas fa-times-circle"></i> IP is not available' +
                '</div>';
            // Append the alert to the page body
            $('body').append(alert);

            // Auto-hide the alert after 5 seconds
            setTimeout(function () {
                $('.custom-alert').fadeOut(1000, function () {
                    $(this).remove();
                });
            }, 5000); // 5000 milliseconds = 5 seconds
            $("#submit").css('display', 'none');
        }
    </script>
</div>


<? include('../footer.php'); ?>