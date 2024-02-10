<? include('../config.php');

$sub_menu = $_REQUEST['sub_menu']; 
$sub_menu_str  = implode(',',$sub_menu) ; 

$id = $_POST['id'];
$name = $_POST['name'];
$uname = $_POST['uname'];
$pwd = $_POST['pwd'];
$contact = $_POST['contact'];
$role = $_POST['role'];
$vendorid = $_POST['vendorid'];

$sql = "
UPDATE user set 
name='".$name."',
uname = '".$uname."',
pwd = '".$pwd."',
contact = '".$contact."',
level = '".$level."',
permission = '".$sub_menu_str."',
level='".$role."',
vendorid = '".$vendorid."'
where id='".$id."'
" ;
  
if (mysqli_query($con, $sql)) { 
    echo 1 ; 

} else { 
    echo 0 ; 
} ?>


