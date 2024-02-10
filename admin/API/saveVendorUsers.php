<?php
include($_SERVER["DOCUMENT_ROOT"]. '/corona/config.php');

$name = $_REQUEST['name'];
$uname = $_REQUEST['uname'];
$pwd = $_REQUEST['pwd'];
$contact = $_REQUEST['contact'];
$role = $_REQUEST['role'];
$vendorId = $_REQUEST['vendorId'];

if($role==1){
    $permission = '15,76,78';
}else if($role==2){
    
}else if($role==3){
    $permission = '76';
}


// Check if the required fields are empty
if (empty($name) || empty($uname) || empty($pwd) || empty($contact) || empty($role) || empty($vendorId)) {
  $data = ['statusCode' => 400, 'response' => 'Please fill in all required fields.'];
} else {
  // Check if the uname field is unique
  $checkQuery = "SELECT * FROM vendorUsers WHERE uname = '".$uname."'";
  $checkResult = mysqli_query($con, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    // The uname field is not unique, return an error response
    $data = ['statusCode' => 400, 'response' => 'Username is already taken. Please choose a different username.'];
  } else {
    // Insert the user data into the table
    $insertQuery = "INSERT INTO vendorUsers (name, uname, password, contact, level, vendorId, user_status,permission) 
                    VALUES ('".$name."', '".$uname."', '".$pwd."', '".$contact."', '".$role."', '".$vendorId."', 1,'$permission')";

    if (mysqli_query($con, $insertQuery)) {
      $data = ['statusCode' => 200, 'response' => 'User Created Successfully!'];
    } else {
      $data = ['statusCode' => 500, 'response' => 'User Error!'];
    }
  }
}

echo json_encode($data);
?>
