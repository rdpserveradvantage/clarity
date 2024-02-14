<? include('../header.php'); ?>


                    <div class="card">
                                <div class="card-body" style="overflow:auto;">
                                    <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>#</th>
                                                <th>User ID</th>
                                                <th>Name</th>
                                                <th>Desgination</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Contact No.</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $RailTailVendorID = $_REQUEST['vendor'];
                                            $i = 1;
                                            // echo "select * from user where vendorId='" . $RailTailVendorID . "'";
                                            $sql = mysqli_query($con, "select * from user where vendorId='" . $RailTailVendorID . "'");
                                            while ($sql_result = mysqli_fetch_assoc($sql)) {
                                                $serviceExecutiveStatus = 0;
                                                if ($sql_result['user_status'] == 0) {
                                                    $user_status = 'Inactive';
                                                    $makeuser_status = 'Make Active';
                                                } else {
                                                    $user_status = 'Active';
                                                    $makeuser_status = 'Make Inactive';
                                                    $status_class = 'text-success';
                                                }
                                                $level = $sql_result['level'];

                                                if ($level == 1) {
                                                    $designation = 'Admin';
                                                } else if ($level == 2) {
                                                    $designation = 'Project Executive';
                                                } else if ($level == 3) {
                                                    $designation = 'Engineer';
                                                } else if ($level == 4) {
                                                    $designation = 'Branch';
                                                }

                                                $desgination = $sql_result['designation'];
                                            ?>
                                                <tr>
                                                    <td><? echo $i; ?></td>
                                                    <td><? echo $sql_result['id']; ?></td>
                                                    <td><? echo $sql_result['name']; ?></td>
                                                    <td><? echo $designation; ?></td>
                                                    <td style="text-transform: initial;"><? echo $sql_result['uname']; ?></td>
                                                    <td style="text-transform: initial;"><? echo $sql_result['password']; ?></td>
                                                    <td style="text-transform: initial;"><? echo $sql_result['contact']; ?></td>
                                                    <td class="<? echo $status_class; ?>"><? echo $user_status; ?></td>
                                                    
                                                </tr>
                                            <? $i++;
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
            

<? include('../footer.php'); ?>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="../datatable/jquery.dataTables.js"></script>
<script src="../datatable/dataTables.bootstrap.js"></script>
<script src="../datatable/dataTables.buttons.min.js"></script>
<script src="../datatable/buttons.flash.min.js"></script>
<script src="../datatable/jszip.min.js"></script>

<script src="../datatable/pdfmake.min.js"></script>
<script src="../datatable/vfs_fonts.js"></script>
<script src="../datatable/buttons.html5.min.js"></script>
<script src="../datatable/buttons.print.min.js"></script>
<script src="../datatable/jquery-datatable.js"></script>