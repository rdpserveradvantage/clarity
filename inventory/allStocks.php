<? include('../header.php'); 


$isVendor = $_SESSION['isVendor'];
$islho = $_SESSION['islho'];
$ADVANTAGE_level = $_SESSION['ADVANTAGE_level'];

if($ADVANTAGE_level==3){
    ?>
<script>
    window.location.href="/corona/inventory/eng_allStocks.php";
</script>
    <?
}
else if($isVendor==1){
    ?>
<script>
    window.location.href="/corona/inventory/vendor_allStocks.php";
</script>
    <?
}


?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<style>
    .colinfo {
        border: 1px solid;
        padding: 10px;
        text-align: center;
    }

    .qty {
        font-size: 20px;
    }

    .colinfo {
        background-color: #01a9ac;
        color: white;
    }

    .colinfo:hover {
        background-color: white;
        color: black;
    }

    .material,
    .qty {
        font-weight: bolder;
    }
</style>

<div class="row">
    <div class="col-sm-12 grid-margin">
        <div class="card" id="filter">
            <div class="card-block">
                <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                    <div class="row">

                        <div class="col-sm-3">
                            <label>Stock</label>
                            <select name="status" class="form-control">
                                <option value="0" <? if ($_REQUEST['status'] == '0') {
                                    echo 'selected';
                                } ?>>ALL</option>
                                <option value="1" <? if ($_REQUEST['status'] == '1') {
                                    echo 'selected';
                                } ?>>AVAILABLE</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label>Material</label>
                            <select name="material" class="form-control">
                                <option value="">-- Select Material --</option>
                                <?php
                                $i = 0;
                                $materiallist = mysqli_query($con, "SELECT distinct(material) as material from Inventory where status=1 ");
                                while ($fetch_data = mysqli_fetch_assoc($materiallist)) {
                                    ?>

                                    <option value="<?php echo $fetch_data['material'] ?>" <?php if ($fetch_data['material'] == $_REQUEST['material']) {
                                           echo 'selected';
                                       } ?>>
                                        <?php echo $fetch_data['material']; ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="col-sm-3">
                            <label>Serial Number</label>
                            <input type="text" name="serialNumber" class="form-control"
                                value="<?= $_REQUEST['serialNumber']; ?>" placeholder="Enter Serial Number ..." />
                        </div>
                        <div class="col-sm-3">
                            <label>Type</label>
                            <select name="thisInventoryType" class="form-control">
                                <option value="">--Select--</option>
                                <option value="Actual">Actual</option>
                                <option value="Internal">Internal</option>
                            </select>
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
    $sqlappCount = "select count(1) as total from Inventory where 1 ";
    $atm_sql = "select id,material,material_make,model_no,serial_no,challan_no,amount,gst,amount_with_gst,courier_detail,tracking_details,
                            date_of_receiving,receiver_name,vendor_name,vendor_contact,po_date,po_number,created_at,created_by,updated_at,inventoryType,status
                                from Inventory where 1 ";

    if (isset($_REQUEST['material']) && $_REQUEST['material'] != '') {
        $material = $_REQUEST['material'];
        $atm_sql .= "and material like '" . $material . "'";
        $sqlappCount .= "and material like '" . $material . "'";
    }

    if (isset($_REQUEST['status']) && $_REQUEST['status'] != '') {
        $status = $_REQUEST['status'];
        if ($status == '0') {
            $atm_sql .= " and status in (0,1) ";
            $sqlappCount .= " and status in(0,1) ";
        } else if ($status == '1') {
            $atm_sql .= " and status in (1) ";
            $sqlappCount .= " and status in(1) ";
        }
    }

    if (isset($_REQUEST['serialNumber']) && $_REQUEST['serialNumber'] != '') {
        $serialNumber = $_REQUEST['serialNumber'];
        $atm_sql .= "and serial_no like '%" . $serialNumber . "%'";
        $sqlappCount .= "and serial_no like '%" . $serialNumber . "%'";
    }

    if (isset($_REQUEST['thisInventoryType']) && $_REQUEST['thisInventoryType'] != '') {
        $thisInventoryType = $_REQUEST['thisInventoryType'];
        $atm_sql .= "and inventoryType like '%" . $thisInventoryType . "%'";
        $sqlappCount .= "and inventoryType like '%" . $thisInventoryType . "%'";
    }

    $sqlappCount .= " and status=1 " ; 
    $atm_sql .= "  and status=1 order by id desc";
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
            <div class="card-block" style="overflow:auto;">

                <div class="row">

                    <?

                    $groupsql = mysqli_query($con, "select material,count(1) as total from Inventory where status=1 group by material ");
                    while ($groupsqlResult = mysqli_fetch_assoc($groupsql)) {
                        $material = $groupsqlResult['material'];
                        $total = $groupsqlResult['total'];
                        ?>

                        <div class="col-sm-2" style="margin: 5px auto;">
                            <div class="colinfo">
                                <div class="qty">
                                    <?= $total ?>
                                </div>
                                <div class="material">
                                    <?= $material; ?>
                                </div>
                            </div>
                        </div>
                    <?
                    }
                    ?>

                </div>

                <hr />
                <div class="card-header">
                    <h5>Total Records: <strong class="record-count">
                            <? echo $total_records; ?>
                        </strong></h5>
                    <hr>
                    <form action="exportInventoryRecords.php" method="POST">
                        <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                        <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                    </form>

                </div>


                <!-- <div style="display:flex;justify-content:space-around;">
                                <h5 style="text-align:center;">All Stocks - <p>Total Records- <?= $total_records; ?></p>
                                </h5>

                                <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                            </div> -->



                <table class="table table-hover table-styling table-xs">
                    <thead>
                        <tr class="table-primary">
                            <th>Sr no</th>
                            <th>Actions</th>
                            <th>material</th>
                            <th>material_make</th>
                            <th>model_no</th>
                            <th>serial_no</th>
                            <th>challan_no</th>
                            <th>amount</th>
                            <th>gst</th>
                            <th>amount_with_gst</th>
                            <th>courier_detail</th>
                            <th>tracking_details</th>
                            <th>date_of_receiving</th>
                            <th>receiver_name</th>
                            <th>vendor_name</th>
                            <th>vendor_contact</th>
                            <th>po_date</th>
                            <th>po_number</th>
                            <th>Type</th>

                            <!-- Add other column headers here -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $counter = ($current_page - 1) * $page_size + 1;
                        $sql_app = mysqli_query($con, $sql_query);
                        while ($row = mysqli_fetch_assoc($sql_app)) {
                            $materialId = $row['id'];
                            $material = $row['material'];
                            $material_make = $row['material_make'];
                            $model_no = $row['model_no'];
                            $serial_no = $row['serial_no'];
                            $challan_no = $row['challan_no'];
                            $amount = $row['amount'];
                            $gst = $row['gst'];
                            $amount_witd_gst = $row['amount_witd_gst'];
                            $courier_detail = $row['courier_detail'];
                            $tracking_details = $row['tracking_details'];
                            $date_of_receiving = $row['date_of_receiving'];
                            $receiver_name = $row['receiver_name'];
                            $vendor_name = $row['vendor_name'];
                            $vendor_contact = $row['vendor_contact'];
                            $po_date = $row['po_date'];
                            $po_number = $row['po_number'];
                            $inventoryType = $row['inventoryType'];
                            $invstatus = $row['status'];
                            echo '<tr>';
                            ?>
                            <td>
                                <?= $counter; ?>
                            </td>
                            <td>
                                <?
                                if ($invstatus == 0) {
                                } else if ($invstatus == 1) {
                                    echo '<a href="sendIndividualMaterial.php?materialId=' . $materialId . '" >Send Material</a>';
                                }
                                ?>
                            </td>
                            <td>
                                <?= $material; ?>
                            </td>
                            <td>
                                <?= $material_make; ?>
                            </td>
                            <td>
                                <?= $model_no; ?>
                            </td>
                            <td>
                                <?= $serial_no; ?>
                            </td>
                            <td>
                                <?= $challan_no; ?>
                            </td>
                            <td>
                                <?= $amount; ?>
                            </td>
                            <td>
                                <?= $gst; ?>
                            </td>
                            <td>
                                <?= $amount_witd_gst; ?>
                            </td>
                            <td>
                                <?= $courier_detail; ?>
                            </td>
                            <td>
                                <?= $tracking_details; ?>
                            </td>
                            <td>
                                <?= $date_of_receiving; ?>
                            </td>
                            <td>
                                <?= $receiver_name; ?>
                            </td>
                            <td>
                                <?= $vendor_name; ?>
                            </td>
                            <td>
                                <?= $vendor_contact; ?>
                            </td>
                            <td>
                                <?= $po_date; ?>
                            </td>
                            <td>
                                <?= $po_number; ?>
                            </td>
                            <td>
                                <?= $inventoryType; ?>
                            </td>


                            <?

                            // Display other record fields as table cells
                            echo '</tr>';
                            $counter++;
                        }
                        ?>
                    </tbody>
                </table>


                <?

                $material_name = $_REQUEST['material'];

                echo '
                <div class="dataTables_wrapper form-inline dt-bootstrap no-footer" style="margin: auto;"> 
                <div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><ul class="pagination">';



                if ($start_window > 1) {

                    echo "<li class='paginate_button'><a href='?page=1&&material=$material_name'>First</a></li>";
                    echo '<li class="paginate_button"><a href="?page=' . ($start_window - 1) . '&&material=' . $material_name . '">Prev</a></li>';
                }

                for ($i = $start_window; $i <= $end_window; $i++) {
                    ?>
                    <li class="paginate_button <? if ($i == $current_page) {
                        echo 'active';
                    } ?>">
                        <a href="?page=<?= $i; ?>&&material=<?= $material_name; ?>">
                            <?= $i; ?>
                        </a>
                    </li>

                <? }

                if ($end_window < $total_pages) {

                    echo '<li class="paginate_button"><a href="?page=' . ($end_window + 1) . '&&material=' . $material_name . '">Next</a></li>';
                    echo '<li class="paginate_button"><a href="?page=' . $total_pages . '&&material=' . $material_name . '">Last</a></li>';
                }
                echo '</ul></div></div>';


                ?>





            </div>
        </div>
    </div>
</div>
<? include('../footer.php'); ?>