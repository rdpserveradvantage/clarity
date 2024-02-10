<? include('../config.php');

$serial_no = $_REQUEST['serial_no'];

if($serial_no){
        $sql = mysqli_query($con,"select * from ipconfuration where serial_no like '".trim($serial_no)."' and status=1");
        
        if($sql_result = mysqli_fetch_assoc($sql)){

            $networkIP = $sql_result['network_ip'];
            $routerIP = $sql_result['router_ip'];
            $atmIP = $sql_result['atm_ip'];
            
            $data = ['networkIP'=>$networkIP,'routerIP'=>$routerIP,'atmIP'=>$atmIP] ; 
        
        if($data){
            echo json_encode($data);    
        }else{
            echo 0;
        }
    }
}else{
    echo 0; 
}

?>