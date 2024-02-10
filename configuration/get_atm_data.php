<? include('../config.php');

$atmid = $_REQUEST['atmid'];

if ($atmid) {
    $sql = mysqli_query($con, "select * from sites where atmid='" . trim($atmid) . "'");

    if ($sql_result = mysqli_fetch_assoc($sql)) {


        $checksql = mysqli_query($con, "select * from routerConfiguration where atmid='" . trim($atmid) . "' and status=1");
        if($checksqlResult = mysqli_fetch_assoc($checksql)){
            $isConfigurationFound = 1 ; 
        }else{
            $isConfigurationFound = 0 ;
        }





        $customer = strtoupper($sql_result['customer']);
        $bank = $sql_result['bank'];
        $location = $sql_result['address'];
        $state = $sql_result['state'];
        $region = $sql_result['zone'];
        $bm = $sql_result['bm_name'];
        $branch = $sql_result['branch'];
        $city = $sql_result['city'];
        $eng_user_id = $sql_result['engineer_user_id'];
        $lho = $sql_result['LHO'];
        $engname = mysqli_query($con, "select name from mis_loginusers where id = '" . $eng_user_id . "' ");
        $engname_result = mysqli_fetch_assoc($engname);
        $_engname = $engname_result['name'];
        $networkIP = $sql_result['networkIP'];
        $routerIP = $sql_result['routerIP'];
        $atmIP = $sql_result['atmIP'];
        $data = [
            'customer' => $customer,
            'bank' => $bank,
            'location' => $location,
            'city' => $city,
            'state' => $state,
            'region' => $region,
            'branch' => $branch,
            'bm' => $bm,
            'engineer' => $_engname,
            'lho' => $lho
            ,
            'networkIP' => $networkIP,
            'routerIP' => $routerIP,
            'atmIP' => $atmIP,
            'isConfigurationFound'=>$isConfigurationFound
        ];

        if ($data) {
            echo json_encode($data);
        } else {
            echo 0;
        }
    }
} else {
    echo 0;
}

?>