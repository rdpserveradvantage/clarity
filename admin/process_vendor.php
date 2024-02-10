<?php include('../config.php') ; ?>
<html>
    <head>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>        
    </head>
    <body>
        

<?

$vendorName = $_REQUEST['vendorName'];

if($vendorName){
    
    $sql = "insert into vendor(vendorName,status) values('".$vendorName."',1)";
    
    if(mysqli_query($con,$sql)){
        ?>
        
        
            <script>
               swal("Good job!", "Contractor Added Successfully !", "success");
        
                   setTimeout(function(){ 
                      window.location.href="vendor.php";
                   }, 3000);
        
               </script> 
               
               
               <?
        
        
        
        
    }else{ ?>
    
    
    <script>
                   swal("Error", "Error While Adding vendor !", "error");
                      
                       setTimeout(function(){ 
                          window.history.back();
                       }, 3000);
            
                   </script>
        
    <? }
}



?>