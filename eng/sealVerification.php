<?  include('../config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$atmid = $_REQUEST['atmid'];
$siteid = $_REQUEST['siteid'];
if(isset($_POST['userid'])){
    $userid = $_POST['userid'] ; 
}

$baseDirectory = 'sealVerificationImages';
$year = date('Y');
$month = date('m');
$targetDirectory = $baseDirectory . '/' . $year . '/' . $month . '/'. $atmid . '/';
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true); // Set appropriate permissions (modify as needed)
}
$error = 0 ;


$sql = "insert into sealVerification(atmid,siteid,status, isVerify, created_by, created_at) 
values('".$atmid."','".$siteid."',1,0,'".$userid."','".$datetime."')" ;
if(mysqli_query($con,$sql)){
$sealVerificationID = $con->insert_id ; 
        
            
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['sealImage']) && $_FILES['sealImage']['error'][0] === UPLOAD_ERR_OK) {
            $files = $_FILES['sealImage'];
    
                foreach ($files['tmp_name'] as $key => $tempFilePath) {
                    $originalFileName = $files['name'][$key];
                    $targetFilePath = $targetDirectory . $originalFileName;
                    if (move_uploaded_file($tempFilePath, $targetFilePath)) {
                        
        
                        $sqlImages = "insert into sealVerificationImages(sealVerificationID,siteid, atmid, imageUrl, status, isVerify, created_by, created_at) 
                                values('".$sealVerificationID."','".$siteid."','".$atmid."','".$targetFilePath."',1,0,'".$userid."','".$datetime."')";
                                mysqli_query($con,$sqlImages);
        
                    } else {
                        $error++ ;
                    }
                }
                
                if($error==0){
                    echo json_encode(200);
                }else{
                    echo json_encode(500);
                }
                
            
            
        }
    }

}
?>