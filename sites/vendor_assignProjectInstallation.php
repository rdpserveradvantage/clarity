<? include('../header.php'); 



 $isVendor = $_SESSION['isVendor'];
 $islho = $_SESSION['islho'];
$ADVANTAGE_level = $_SESSION['ADVANTAGE_level'];



if($islho==0){
    
}else if($isVendor==0){
    ?>
    <script>
    // window.location.href="/corona/sites/vendorSendToInstallation.php";
</script>
    <? 
}



?>


<div class="row">


<div class="card">
                                    <div class="card-body">
                                        <?
                                        $atmid = $_REQUEST['atmid'];
                                        $id = $_REQUEST['id'];
                                        $siteid = $_REQUEST['siteid'];
                                        
                                        $sql = mysqli_query($con,"select * from  projectInstallation where siteid='".$siteid."' order by id desc");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                        $scheduleAtmEngineerName = $sql_result['scheduleAtmEngineerName'];
                                        $scheduleAtmEngineerNumber = $sql_result['scheduleAtmEngineerNumber'];
                                        $bankPersonName = $sql_result['bankPersonName'];
                                        $bankPersonNumber = $sql_result['bankPersonNumber'];
                                        $backRoomKeyPersonName = $sql_result['backRoomKeyPersonName'];
                                        $backRoomKeyPersonNumber = $sql_result['backRoomKeyPersonNumber'];
                                        $sbiTicketId = $sql_result['sbiTicketId'];
                                        $scheduleDate = $sql_result['scheduleDate'];
                                        $scheduleTime = $sql_result['scheduleTime'];



                                        ?>
                                        <h5 style="font-weight: 600;">Proceed Installation : <span style="color:red; "><?php echo $atmid . ' '; ?></span>To Engineer</h5>
                                        <!--<h4>Assign ATMID: <? echo $atmid ; ?> For Installation</h4>-->
                                        <hr>
                                        <form id="myForm" enctype="multipart/form-data">
                                        <!--<form action="process_delegate.php" method="POST">-->
                                            <input type="hidden" name="atmid" value="<? echo $atmid ; ?>" />
                                            <input type="hidden" name="id" value="<? echo $id ; ?>" />
                                            <input type="hidden" name="siteid" value="<? echo $siteid ; ?>" />
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Select Engineer For Installation </label>

                                                    <select name="engineer" class="form-control" required>
                                                        <option value="">Select</option>
                                                        <?
                                                        $sql = mysqli_query($con,"select * from user where user_status=1 and vendorId='".$RailTailVendorID."' and level=3");
                                                        while($sql_result = mysqli_fetch_assoc($sql)){
                                                        $engineerid = $sql_result['userid'];
                                                        $name = $sql_result['name'];
                                                        ?>
                                                        <option value="<? echo $engineerid; ?>">
                                                            <? echo $name; ?>
                                                        </option>
                                                            
                                                            
                                                        <? } ?>
                                                    </select>
                                                </div>
                                              
                                            </div>
                                            <hr>
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <br>
                                                    <button type="submit" class="btn btn-success" onclick="saveForm()">Update</button>
                                                </div>
                                            </div>
                                        
                                        </form>
                                        
                                    </div>
                                </div>




                                      
<script>
    function saveForm() {

    event.preventDefault();
    var formData = new FormData($('#myForm')[0]);
    var requiredFields = $('#myForm :required');
    var emptyFields = [];

    // Check for empty required fields
    requiredFields.each(function() {
        if ($(this).val() === '') {
            emptyFields.push($(this).attr('name'));
        }
    });

    console.log(emptyFields.length)
    if (emptyFields.length > 0) {
        Swal.fire("Error", "Please fill in all the required fields!", "error");
        $('input, select').removeClass('highlight');
        $.each(emptyFields, function(index, fieldName) {
            $('[name="' + fieldName + '"]').addClass('highlight');
        });
        return; // Exit the function if empty fields exist
    }

        $.ajax({
            url: 'process_vendor_assignProjectInstallation.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response == 200) {
                    Swal.fire("Success", "Assigned Successfully!", "success");
                    setTimeout(function() {
                        window.location.href = "sitestest.php";
                    }, 3000); // Redirect after 3 seconds
                } else {
                    alert('Assigned Error!');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Assigned Error!');
            }
        });

}

              </script>      
                    


</div>


<? include('../footer.php'); ?>
