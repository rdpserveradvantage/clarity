<?php include('../config.php');




$sub_menu = $_REQUEST['sub_menu']; 
$sub_menu_str  = implode(',',$sub_menu) ; 

if(isset($_REQUEST['sub_menu_clarify'])){
    $sub_menu_clarify = $_REQUEST['sub_menu_clarify']; 
    $sub_menu_clarify_str  = implode(',',$sub_menu_clarify) ; 
    
}else{
    $sub_menu_clarify_str = '5,6';
}



$name = $_POST['name'];
$uname = $_POST['uname'];
$pwd = $_POST['pwd'];
$contact = $_POST['contact'];
$role = $_POST['role'];
$vendorid = $_POST['vendorid'];
$isVendor = $_POST['isVendor'];
$islho = $_POST['islho'];




    $sql = "insert into user(name,uname,pwd,contact,level,user_status,permission,vendorid,islho,isVendor,servicePermission) 
    values('" . $name . "','" . $uname . "','" . $pwd . "','" . $contact . "','" . $role . "',1,'".$sub_menu_str."','".$vendorid."','".$islho."','".$isVendor."','".$sub_menu_clarify_str."')";

if (mysqli_query($con, $sql)) { 
    echo 1 ; 

    $insertid = $con->insert_id ; 
    $userid = 110000 + $insertid ; 
    mysqli_query($con,"update user set userid ='".$userid."' where id='".$insertid."'");

} else { 
    echo 0 ; 
} 
?>