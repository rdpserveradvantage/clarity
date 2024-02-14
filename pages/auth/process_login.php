<?php include('../../config.php') ; 
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



$uname = $_REQUEST['username'];
$password = $_REQUEST['password'];



if($uname && $password){

    $sql = mysqli_query($con, "SELECT * FROM user WHERE (uname = '$uname' OR contact = '$uname') AND pwd = '$password' AND user_status = 1");
    $result = mysqli_num_rows($sql);
    if($result>0){
        $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
                $_SESSION['ADVANTAGE_auth']=1;
                $_SESSION['ADVANTAGE_username']=$sql_result['name'];
                $_SESSION['ADVANTAGE_designation']=$sql_result['designation'];
                $_SESSION['ADVANTAGE_userid'] = $sql_result['userid'];
                $_SESSION['ADVANTAGE_level'] = $sql_result['level'];
                $_SESSION['ADVANTAGE_uname'] = $sql_result['uname'];
                
                $_SESSION['ADVANTAGE_branch'] = $sql_result['branch'];
                $_SESSION['ADVANTAGE_zone'] = $sql_result['zone'];
                $_SESSION['ADVANTAGE_cust_id'] = $sql_result['cust_id'];
                $_SESSION['vendor_id'] = $sql_result['vendorid'];

                $_SESSION['isVendor'] = $sql_result['isVendor'];
                $_SESSION['islho'] = $sql_result['islho'];
                
                $_SESSION['contact'] = $sql_result['contact'];

                
                $userid = $sql_result['id'];
                
                if($uname == 'admin@gmail.com'){
                    $_SESSION['ADVANTAGE_access']=1 ;
                }
                
                
                
                
                
                $secret_key = "Advantage";
        		$issuedat_claim = time(); // issued at
        		$notbefore_claim = $issuedat_claim + 10; //not before in seconds
        		$expire_claim = $issuedat_claim + 60; // expire time in seconds
        		
                $token = array(
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $userid,
                        "fullname" => $fname,
                        "email" => $email,
                ));
                $jwt = JWT::encode($token, $secret_key,"HS256");
                $token_sql = "update user set token='".$jwt."' , updated_at = '".$datetime."' where id='".$userid."'";
                    mysqli_query($con,$token_sql) ;                
                    
                
                $_SESSION['ADVANTAGE_advantagetoken'] = $jwt ;
                $response['success'] = true;
                $response['redirect'] = 'index.php'; // Change this to your actual redirect URL

                

    header('Content-Type: application/json');
    echo json_encode($response);               
               
               }else{
                    $response['success'] = false;
                    $response['message'] = 'Invalid username or password';
                    $response['redirect'] = 'login.php'; // Change this to your actual redirect URL
                    header('Content-Type: application/json');
                    echo json_encode($response);
               } 
             }else{ 
                 $response['success'] = false;
                    $response['message'] = 'Invalid username or password';
                    $response['redirect'] = 'login.php'; // Change this to your actual redirect URL
                    header('Content-Type: application/json');
                    echo json_encode($response);
                 
             }
}
else{ 
    $response['success'] = false;
                    $response['message'] = 'Please provide both username and password';
                    $response['redirect'] = 'login.php'; // Change this to your actual redirect URL
                    header('Content-Type: application/json');
                    echo json_encode($response);
    }
