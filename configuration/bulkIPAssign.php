<? include('../header.php'); ?>

     
          
                                <div class="card">
                                    <div class="card-block">
                                                  <div class="two_end">
                                            <h5>Bulk IP Assign <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                            <a class="btn btn-primary" href="../excelformats/bulkIPAssign.xlsx" download>BULK IP ASSIGN FORMAT</a>
                                        </div>
                                        <hr>
                                        
                                    <form action="<? echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
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
    $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                    null, true, false);                            
  }

    $row = $row-2;
    $error = '0';
    $contents='';

    for($i = 1; $i<=$row; $i++){
        
        
        $atmid = $rowData[$i][0][0] ;
            
            if($atmid){


                $getSitesSql = mysqli_query($con,"select * from sites where atmid='".$atmid."' order by id desc");
                if($getSitesSqlResult = mysqli_fetch_assoc($getSitesSql)){
                    $siteId = $getSitesSqlResult['id'];
                    $routerIP = $rowData[$i][0][1] ;
                    $networkIP = $rowData[$i][0][2] ;
                    $atmIP = $rowData[$i][0][3] ;
                    $subnetIP = $rowData[$i][0][4] ;
                    
                    $sql = "update sites set networkIP='".$networkIP."', routerIP='".$routerIP."',atmIP='".$atmIP."',subnetIP='".$subnetIP."' where atmid='".$atmid."'" ;   
                    if(mysqli_query($con,$sql)){
                        echo $i . ') Assign records for ATMID : <b>'. $atmid . '</b><br>';                 
                    } 
                        confurationDone($siteId,$atmid,'sites');
                        echo '<br>';
                    }

                }
                
            }

        }
    echo '</div>
            </div>';
?>           
                      
                    
                    
    <? include('../footer.php'); ?>