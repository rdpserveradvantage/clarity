<?php session_start();
include('../config.php') ; ?>
<html>
    <head>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>        
    </head>
    <body>
        

<?

$contactPersonName= $_REQUEST['contactPersonName'];
$contactPersonNo= $_REQUEST['contactPersonNo'];
$contactPersonEmail = $_REQUEST['contactPersonEmail'];

$lhoid = $_REQUEST['lhoid'];
$designation = $_REQUEST['designation'];
$esc_matrix = $_REQUEST['esc_matrix'];

if($contactPersonName){
    
    $sql = "insert into lhoADVContactDetails(contactPersonName,contactPersonNo,contactPersonEmail,status,lhoid,esc_matrix,designation) 
    values('".$contactPersonName."','".$contactPersonNo."','".$contactPersonEmail."',1,'".$lhoid."','".$esc_matrix."','".$designation."')";
    
    if(mysqli_query($con,$sql)){
        ?>
        
        
            <script>
               swal("Good job!", "Details Added Successfully !", "success");
        
                   setTimeout(function(){ 
                      window.location.href="lhoAdvContactDetails.php";
                   }, 3000);
        
               </script> 
               
               
               <?
        
        
        
        
    }else{ ?>
    
    
    <script>
                   swal("Error", "Error While Adding LHO Details !", "error");
                      
                       setTimeout(function(){ 
                          window.history.back();
                       }, 3000);
            
                   </script>
        
    <? }
}



?>