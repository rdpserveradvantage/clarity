<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="row">

    <div class="col-sm-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="two_end">
                    <h5>Bulk ROUTER-ATM BIND <span style="font-size:12px; color:red;">(Bulk Upload)</span>
                    </h5>
                    <a class="btn btn-primary" href="excelformat/ROUTER-ATM_bulk.xlsx" download>
                        BULK ROUTER-ATM BIND FORMAT</a>
                </div>
                <hr>

                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">

                        <div class="col-sm-12">
                            <input type="file" name="images" required>
                            <!--<input type="file" name="images" required>-->
                        </div>
                        <div class="col-sm-4">
                            <br />
                            <input type="submit" name="submit" value="upload" class="btn btn-primary">
                        </div>

                    </div>
                </form>



            </div>
        </div>

    </div>




    <?
    ini_set('memory_limit', '-1');
    if (isset($_POST['submit'])) {
        echo '<div class="col-sm-12 grid-margin">';
        echo '<div class="card">
                                <div class="card-body">';



        $date = date('Y-m-d h:i:s a', time());
        $only_date = date('Y-m-d');
        $target_dir = 'PHPExcel/';
        $file_name = $_FILES["images"]["name"];
        $file_tmp = $_FILES["images"]["tmp_name"];
        $file = $target_dir . '/' . $file_name;
        $created_at = date('Y-m-d H:i:s');




        move_uploaded_file($file_tmp = $_FILES["images"]["tmp_name"], $target_dir . '/' . $file_name);
        include('PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
        $inputFileName = $file;

        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 1; $row <= $highestRow; $row++) {
            $rowData[] = $sheet->rangeToArray(
                'A' . $row . ':' . $highestColumn . $row,
                null,
                true,
                false
            );
        }

        $row = $row - 2;
        $error = '0';
        $contents = '';

        for ($i = 1; $i <= $row; $i++) {

            $atmid = $rowData[$i][0][0];
            $serial_no = $rowData[$i][0][1];
            $seal_no = $rowData[$i][0][2];

            $sql = "SELECT * FROM sites WHERE atmid = '" . $atmid . "'";
            $checkQuery = mysqli_query($con, $sql);
            if ($checkQueryResult = mysqli_fetch_assoc($checkQuery)) {
                $insertQuery = "INSERT INTO routerConfiguration (atmid, serialNumber, sealNumber, status, created_at, created_by)
                                                VALUES ('" . $atmid . "', '" . $serial_no . "', '" . $seal_no . "', '1', '" . $datetime . "', '" . $userid . "')";

                try {
                    mysqli_query($con, $insertQuery);
                    echo '
                                    <button class="btn btn-success btn-icon">✔</button>
                                    &nbsp;&nbsp;&nbsp; Serial Number : ' . $serial_no . ' Successfully bind with ATMID : ' . $atmid . '</br>';

                } catch (PDOException $e) {
                    echo '
                                    <i class="feather icon-check bg-simple-c-yellow  update-icon"></i>
                                    &nbsp;&nbsp;&nbsp;Error Serial Number : ' . $serial_no . ' not bind with ATMID : ' . $atmid . '</br>';

                }
            } else {
                echo '
                                    <button class="btn btn-danger btn-icon">✖</button>
                                    &nbsp;&nbsp;&nbsp;Error Serial Number : ' . $serial_no . ' not bind with ATMID : ' . $atmid . '</br>';
            }
        }


        echo '</div>
        </div></div>';
    }
    ?>


    <div class="col-sm-12 grid-margin">
        <div class="card">
            <div class="card-body">

                <?
                $i = 1;
                $sql = mysqli_query($con, "select * from routerConfiguration where status=1 order by id desc limit 40");
                if (mysqli_num_rows($sql) > 0) {

                    echo '<table class="table table-hover table-styling table-xs" style="width:100%;">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>Atm id</th>
                                        <th>Serial Number</th>
                                        <th>Seal Number</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    while ($sql_result = mysqli_fetch_assoc($sql)) {

                        $atmid = $sql_result['atmid'];
                        $serialNumber = $sql_result['serialNumber'];
                        $sealNumber = $sql_result['sealNumber'];
                        $created_at = $sql_result['created_at'];

                        $created_by = $sql_result['created_by'];
                        $created_by = getUsername($created_by, false);


                        echo "<tr>
                                            <td>{$i}</td>
                                            <td>{$atmid}</td>
                                            <td>{$serialNumber}</td>
                                            <td>{$sealNumber}</td>
                                            <td>{$created_at}</td>
                                            <td>{$created_by}</td>
                                            
                                        </tr>";

                        $i++;
                    }

                    echo "    </tbody>
                            </table>";

                } else {
                    echo '
                                    <div class="noRecordsContainer">
                                        <img src="../assets/images/noRecords.png">
                                    </div>';
                }

                ?>
            </div>
        </div>
    </div>


</div>


<? include('../footer.php'); ?>