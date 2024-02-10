<? include('../header.php'); ?>



                    <div class="card">
                        <div class="card-block">
                            <div class="two_end">
                                <h5>Bulk IP UPLOAD <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                <a class="btn btn-primary" href="../excelformats/bulkIPupload.xlsx" download>BULK IP UPLOAD FORMAT</a>
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

if(isset($_POST['submit'])){
    
    
    echo '<div class="card">
            <div class="card-block">';
    


    $date = date('Y-m-d h:i:s a', time());
    $only_date = date('Y-m-d');
    $target_dir = 'PHPExcel/';
    $file_name=$_FILES["images"]["name"];
    $file_tmp=$_FILES["images"]["tmp_name"];
    $file =  $target_dir.'/'.$file_name;
    $created_at = date('Y-m-d H:i:s');




    move_uploaded_file($file_tmp=$_FILES["images"]["tmp_name"],$target_dir.'/'.$file_name);
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
    $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                    null, true, false);                            
  }

    $row = $row-2;
    $error = '0';
    $contents='';

    for($i = 1; $i<=$row; $i++){
    
        $router_ip = $rowData[$i][0][0] ;
        $network_ip	= $rowData[$i][0][1] ;
        $atm_ip		= $rowData[$i][0][2] ;
        $subnet_ip	= $rowData[$i][0][3] ;



                $getSitesSql = mysqli_query($con,"select * from ips where router_ip='".$router_ip."' or 
                network_ip='".$network_ip."' or atm_ip='".$atm_ip."' ");
                if($getSitesSqlResult = mysqli_fetch_assoc($getSitesSql)){
                    echo 'Duplicate Combination with this record : <b>Router IP : </b>  ' . $router_ip .'  <b>Network IP: <b/>' . $network_ip . ' <b>ATM IP : </b>' .  $atm_ip . '<br>' ; 
                    }else{

                        if(mysqli_query($con,"insert into ips(router_ip, network_ip, atm_ip, subnet_ip, isAssign, status, created_at, created_by)
                        values('".$router_ip."','".$network_ip."','".$atm_ip."','".$subnet_ip."','0','1','".$datetime."','".$userid."')")){
                            echo 'Added this record : <b>Router IP : </b>  ' . $router_ip .'  <b>Network IP: </b>' . $network_ip . ' <b>ATM IP : </b>' .  $atm_ip . '<br>' ; 
                        }
                            
                    }
                
            }

        }
    echo '</div>
            </div>';
?>           

       


<? include('../footer.php'); ?>