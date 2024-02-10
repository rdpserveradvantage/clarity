<? include('../header.php'); 


if ($assignedLho) {

    echo 'No permission to access this page !' ; 

}else{





?>



                    <div class="card">
                        <div class="card-block">
                            <div class="two_end">
                                <h5>Bulk IP Configuration <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                <a class="btn btn-primary" href="../excelformats/Bulk_Already_IP_Configured.xlsx" download>BULK IP CONFIGURATION FORMAT</a>
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




                    <?
                    ini_set('memory_limit', '-1');

                    if (isset($_POST['submit'])) {


                        echo '<div class="card">
            <div class="card-block">';



                        $date = date('Y-m-d h:i:s a', time());
                        $only_date = date('Y-m-d');
                        $target_dir = 'PHPExcel/';
                        $file_name = $_FILES["images"]["name"];
                        $file_tmp = $_FILES["images"]["tmp_name"];
                        $file =  $target_dir . '/' . $file_name;
                        $created_at = date('Y-m-d H:i:s');




                        move_uploaded_file($file_tmp = $_FILES["images"]["tmp_name"], $target_dir . '/' . $file_name);
                        include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
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

                            $router_ip = $rowData[$i][0][0];
                            $network_ip    = $rowData[$i][0][1];
                            $atm_ip        = $rowData[$i][0][2];
                            $subnet_ip    = $rowData[$i][0][3];
                            $serial_number = $rowData[$i][0][4];

                            if ($router_ip) {
                                $checksql = mysqli_query($con, "select * from ips where router_ip = '" . $router_ip . "'");
                                $checksqlResult = mysqli_fetch_assoc($checksql);

                                $ipID = $checksqlResult['id'];

                                if (mysqli_query($con, "update inventory set isIPAssign=1 where serial_no='" . $serial_number . "'")) {
                                    echo 'IP Assigned To Serial Number : ' . $serial_number;
                                    mysqli_query($con, "update ips set isAssign=1 where id='" . $ipID . "'");
                                    mysqli_query($con, "insert into ipconfuration(ipID, serial_no, router_ip, network_ip, atm_ip, subnet_ip, created_at, created_by, status)
                            values('" . $ipID . "','" . $serial_number . "','" . $router_ip . "','" . $network_ip . "','" . $atm_ip . "','" . $subnet_mask . "','" . $datetime . "','" . $userid . "',1)");
                                } else {
                                    echo 'Error In IP Assigned To Serial Number : ' . $serial_number;
                                }
                            }
                        }
                    }
                    echo '</div>
            </div>';
        }
                    ?>



<? include('../footer.php'); ?>