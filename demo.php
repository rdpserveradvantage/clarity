<? include('config.php');








$sql = mysqli_query($con,"select * from mis_loginusers");
while($sql_result = mysqli_fetch_assoc($sql)){


    $id = $sql_result['id'];
    $vendorId = $sql_result['vendorId'];
    $name = $sql_result['name'];
    $uname = $sql_result['uname'];
    $pwd = $sql_result['pwd'];
    $permission = $sql_result['permission'];
    $designation = $sql_result['designation'];
    $level = $sql_result['level'];
    $cust_id = $sql_result['cust_id'];
    $currentstatus = $sql_result['currentstatus'];
    $alerts = $sql_result['alerts'];
    $branch = $sql_result['branch'];
    $zone = $sql_result['zone'];
    $email = $sql_result['email'];
    $contact = $sql_result['contact'];
    $mac_id = $sql_result['mac_id'];
    $user_status = $sql_result['user_status'];
    $status_access = $sql_result['status_access'];
    $serviceExecutive = $sql_result['serviceExecutive'];
    $token = $sql_result['token'];
    $updated_at = $sql_result['updated_at'];
    $personalcontactno = $sql_result['personalcontactno'];
    $dob = $sql_result['dob'];
    $address = $sql_result['address'];
    $profilePic = $sql_result['profilePic'];
    $coverPic = $sql_result['coverPic'];
    $servicePermission = $sql_result['servicePermission'];

    $a = 
"INSERT INTO user(userid, name, uname, pwd, permission, designation, level, cust_id, currentstatus, alerts, branch, zone, email, contact, mac_id, user_status, status_access, serviceExecutive, token, updated_at, personalcontactno, dob, address, profilePic, coverPic, servicePermission
,isVendor
,vendorid)
values
('".$id."',
'".$name."',
'".$uname."',
'".$pwd."',
'".$permission."',
'".$designation."',
'".$level."',
'".$cust_id."',
'".$currentstatus."',
'".$alerts."',
'".$branch."',
'".$zone."',
'".$email."',
'".$contact."',
'".$mac_id."',
'".$user_status."',
'".$status_access."',
'".$serviceExecutive."',
'".$token."',
'".$updated_at."',
'".$personalcontactno."',
'".$dob."',
'".$address."',
'".$profilePic."',
'".$coverPic."',
'".$servicePermission."'
,1
,'".$vendorId."'

)";

mysqli_query($con,$a);

}


return ; 

$sql = mysqli_query($con,"SELECT * from material_send");
while($sql_result = mysqli_fetch_assoc($sql)){

    $siteid = $sql_result['siteid'];

    $lho = mysqli_fetch_assoc(mysqli_query($con,"select LHO from sites where id='".$siteid."'"))['LHO'];
    mysqli_query($con,"update material_send set lho='".$lho."' where siteid='".$siteid."'");
}

?>