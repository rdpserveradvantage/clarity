<? include('../config.php');


if(isset($_REQUEST['sub_menu'])){

$sub_menu = $_REQUEST['sub_menu']; 
$sub_menu_str  = implode(',',$sub_menu) ; 

}else{
    $sub_menu_str = '';
}


if(isset($_REQUEST['sub_menu_clarify'])){

    $sub_menu_clarify = $_REQUEST['sub_menu_clarify']; 
    $sub_menu_clarify  = implode(',',$sub_menu_clarify) ; 
    
}else{
    $sub_menu_clarify = '';
}


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
permission = '".$sub_menu_str."',
servicePermission = '".$sub_menu_clarify."',
level='".$role."',
vendorid = '".$vendorid."'
where id='".$id."'
" ;
  
if (mysqli_query($con, $sql)) { 
    echo 1 ; 

} else { 
    echo 0 ; 
} ?>


