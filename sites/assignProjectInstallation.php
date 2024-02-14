<? include('../header.php'); 


$atmid = $_REQUEST['atmid'];
$id = $_REQUEST['id'];
$siteid = $_REQUEST['siteid'];



 $isVendor = $_SESSION['isVendor'];
 $islho = $_SESSION['islho'];
$ADVANTAGE_level = $_SESSION['ADVANTAGE_level'];


if($islho==1){
    
}else if($isVendor==1){
    ?>
    <script>
    window.location.href="/sites/vendor_assignProjectInstallation.php?id=<?= $id; ?>&siteid=<?= $siteid ; ?>&atmid=<?= $atmid; ?>";
</script>
    <? 
}



?>


<div class="row">


<div class="card">
                                    <div class="card-body">
                                        <?
                                      
                                        
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
                                                    <label>SBIN Ticket ID</label>
                                                    <input type="text" name="sbiTicketId" class="form-control"  value="<?php echo $sbiTicketId; ?>"   />
                                                </div>
                                            </div>
                                            <hr>
                                            
                                                                            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Schedule ATM engineer</label>
                                                    <input type="text" name="scheduleAtmEngineerName" class="form-control"  value="<?php echo $scheduleAtmEngineerName; ?>"  readonly />
                                                </div>
                                                                                
                                                <div class="col-sm-6">
                                                    <label>Schedule ATM engineer Number</label>
                                                    <input type="text" name="scheduleAtmEngineerNumber" class="form-control"  value="<?php echo $scheduleAtmEngineerNumber; ?>" readonly />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Bank Person</label>
                                                    <input type="text" name="bankPersonName" class="form-control"  value="<?php echo $bankPersonName; ?>" />
                                                </div>
                                                                                
                                                <div class="col-sm-6">
                                                    <label>Bank Person Number</label>
                                                    <input type="text" name="bankPersonNumber" class="form-control"  value="<?php echo $bankPersonNumber; ?>"  />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Back-room key Person</label>
                                                    <input type="text" name="backRoomKeyPersonName" class="form-control"  value="<?php echo $backRoomKeyPersonName; ?>"  />
                                                </div>
                                                                                
                                                <div class="col-sm-6">
                                                    <label>Back-room key Person Number</label>
                                                    <input type="text" name="backRoomKeyPersonNumber" class="form-control"  value="<?php echo $backRoomKeyPersonNumber; ?>"  />
                                                </div>
                                            </div>
                                            <hr>
                                            
                                            <div class="row">    
                                                <div class="col-sm-6">
                                                    <label for="dateInput">scheduled Date :</label>
                                                    <input type="date" id="dateInput" name="date" class="form-control" value="<? echo $scheduleDate; ?>"  >    
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="timeInput">scheduled time:</label>
                                                    <input type="time" id="timeInput" name="time" class="form-control" value="<? echo $scheduleTime; ?>"  >
                                                </div>
                                            </div>
                                            
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
            url: 'process_assignProjectInstallation.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response == 200) {
                    Swal.fire("Success", "Updated Successfully!", "success");
                    setTimeout(function() {
                        window.location.href = "sitestest.php";
                    }, 3000); // Redirect after 3 seconds
                } else {
                    alert('Update Error!');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Update Error!');
            }
        });

}

              </script>      
                    


</div>


<? include('../footer.php'); ?>
