<?php session_start();
include('../config.php') ; ?>
<html>
    <head>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>        
    </head>
    <body>
        

<?

$bank = $_REQUEST['bank'];

if($bank){
    
    $sql = "insert into bank(bank,status) values('".$bank."',1)";
    
    if(mysqli_query($con,$sql)){
        ?>
        
        
            <script>
               swal("Good job!", "Bank Added Successfully !", "success");
        
                   setTimeout(function(){ 
                      window.location.href="bank.php";
                   }, 3000);
        
               </script> 
               
               
               <?
        
        
        
        
    }else{ ?>
    
    
    <script>
                   swal("Error", "Error While Adding Bank !", "error");
                      
                       setTimeout(function(){ 
                          window.history.back();
                       }, 3000);
            
                   </script>
        
    <? }
}



?>