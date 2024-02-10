<?php  include('../config.php') ; ?>
<html>
    <head>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>        
    </head>
    <body>
        

<?

$operator = $_REQUEST['operator'];

if($operator){
    
    $sql = "insert into operator(operator,status) values('".$operator."',1)";
    
    if(mysqli_query($con,$sql)){
        ?>
        
        
            <script>
               swal("Good job!", "Operator Added Successfully !", "success");
        
                   setTimeout(function(){ 
                      window.location.href="operator.php";
                   }, 3000);
        
               </script> 
               
               
               <?
        
        
        
        
    }else{ ?>
    
    
    <script>
                   swal("Error", "Error While Adding operator !", "error");
                      
                       setTimeout(function(){ 
                          window.history.back();
                       }, 3000);
            
                   </script>
        
    <? }
}



?>