<? 
include($_SERVER["DOCUMENT_ROOT"]. '/config.php');

$atmid = $_REQUEST['ATMID1'];

if(isset($atmid) && !empty($atmid)){
    $sql = mysqli_query($con,"select id,address,city,state,lho from sites where atmid='".$atmid."' and status=1");
    if($sql_result = mysqli_fetch_assoc($sql)){
        
        $id = $sql_result['id'];
        $address= $sql_result['address'];
        $city= $sql_result['city'];
        $state= $sql_result['state'];
        $location= $sql_result['address'];
        $lho= $sql_result['lho'];
        
        $data = ['code'=>200,'id'=>$id,'address'=>$address,'city'=>$city,'state'=>$state,'location'=>$location,'lho'=>$lho];
        echo json_encode($data);           
    }else{
        $data = ['code'=>300,'response'=>'ATMID Not Found !'];
        echo json_encode($data);
    }
}else{
    $data = ['code'=>301,'response'=>'ATMID Cannot Be Blank !'];
        echo json_encode($data);
}
