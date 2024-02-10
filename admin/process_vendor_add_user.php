<? include('../config.php');




$sub_menu = $_REQUEST['sub_menu']; 
$sub_menu_str  = implode(',',$sub_menu) ; 


$name = $_POST['name'];
$uname = $_POST['uname'];
$pwd = $_POST['pwd'];
$contact = $_POST['contact'];
$role = $_POST['role'];
$vendorid = $_POST['vendorid'];
$isVendor = $_POST['isVendor'];
$islho = $_POST['islho'];

    $sql = "insert into user(name,uname,pwd,contact,level,user_status,permission,vendorid,islho,isVendor) 
    values('" . $name . "','" . $uname . "','" . $pwd . "','" . $contact . "','" . $role . "',1,'".$sub_menu_str."','".$vendorid."','".$islho."','".$isVendor."')";

if (mysqli_query($con, $sql)) { 
    echo 1 ; 

    $insertid = $con->insert_id ; 
    $userid = 110000 + $insertid ; 
    mysqli_query($con,"update user set userid ='".$userid."' where id='".$insertid."'");


} else { 
    echo 0 ; 
} ?>


