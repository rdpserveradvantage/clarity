<? include('../config.php');


$serial_no = $_REQUEST['serial_no'];

$checkInvSql = mysqli_query($con, "select * from inventory where serial_no='" . $serial_no . "'");
if ($checkInvSql_result = mysqli_fetch_assoc($checkInvSql)) {
    $checkSql = mysqli_query($con, "select * from ipconfuration where serial_no like '" . $serial_no . "' and status=1");
    if ($checkSql_result = mysqli_fetch_assoc($checkSql)) {

        $id = $checkSql_result['ipID'];
        $router_ip = $checkSql_result['router_ip'];
        $network_ip = $checkSql_result['network_ip'];
        $atm_ip = $checkSql_result['atm_ip'];
        $subnet_ip = $checkSql_result['subnet_ip'];

        $data = ['id' => $id, 'router_ip' => $router_ip, 'network_ip' => $network_ip, 'atm_ip' => $atm_ip, 'subnet_ip' => $subnet_ip, 'msg' => 'IP Already Assigned to this Serial Number'];
        echo json_encode($data);
    } else {
        $sql = mysqli_query($con, "select * from ips where isAssign=0 and status=1 and isLocked=0 order by id asc");
        if ($sql_result = mysqli_fetch_assoc($sql)) {
            $id = $sql_result['id'];
            $router_ip = $sql_result['router_ip'];
            $network_ip = $sql_result['network_ip'];
            $atm_ip = $sql_result['atm_ip'];
            $subnet_ip = $sql_result['subnet_ip'];

            $data = ['id' => $id, 'router_ip' => $router_ip, 'network_ip' => $network_ip, 'atm_ip' => $atm_ip, 'subnet_ip' => $subnet_ip, 'msg' => ''];

            mysqli_query($con, "update ips set isLocked=1 , lockedTime='" . $datetime . "' where id='" . $id . "'");

            echo json_encode($data);
        } else {
            echo 0;
        }
    }
} else {
    echo 2;
}
