<? include('../header.php'); ?>

<div class="row">


    <div class="page-body">

        <?
         $atmid = $_REQUEST['atmid'];
         $id = $_REQUEST['id'];
         $action = $_REQUEST['action'];


        if ($userLevel == 1) {


            ?>

            <div class="card">
                <div class="card-body">
                    <h5 style="font-weight: 600;">Proceed Feasibility Check : <span style="color:red; ">
                            <?php echo $atmid . ' '; ?>
                        </span>To Project Executive</h5>
                    <hr>
                    <form id="delegateToProjectExecutive" enctype="multipart/form-data">
                        <!--<form action="process_delegate.php" method="POST">-->
                        <input type="hidden" name="atmid" value="<? echo $atmid; ?>" />
                        <input type="hidden" name="siteid" value="<? echo $id; ?>" />
                        <input type="hidden" name="action" value="<? echo $action; ?>" />

                        <div class="row">
                            <div class="col-sm-12">
                                <label>Project Executive</label>

                                <select name="projectExecutive" class="form-control" required>
                                    <option value="">Select</option>
                                    <?
                                    $sql = mysqli_query($con, "select * from user where user_status=1 and vendorId='" . $RailTailVendorID . "' and level=2");
                                    while ($sql_result = mysqli_fetch_assoc($sql)) {
                                        $projectExecutiveId = $sql_result['userid'];
                                        $projectExecutiveName = $sql_result['name'];
                                        ?>
                                        <option value="<? echo $projectExecutiveId; ?>">
                                            <? echo $projectExecutiveName; ?>
                                        </option>


                                    <? } ?>
                                </select>
                                <input type="hidden" name="projectExecutiveName" value="<? echo $projectExecutiveName; ?>">
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <button type="submit" class="btn btn-primary"
                                    onclick="saveToProjectExecutive()">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


        <? } ?>


        <div class="card">
        <div class="page-body">
                                
                                <?
                               
                               
                               if($userLevel==1){
                                   
                               
                                ?>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <h5 style="font-weight: 600;">Proceed Feasibility Check : <span style="color:red; "><?php echo $atmid . ' '; ?></span>To Project Executive</h5>
                                        <hr>
                                        <form id="delegateToProjectExecutive" enctype="multipart/form-data">
                                        <!--<form action="process_delegate.php" method="POST">-->
                                            <input type="hidden" name="atmid" value="<? echo $atmid ; ?>" />
                                            <input type="hidden" name="siteid" value="<? echo $id ; ?>" />
                                            <input type="hidden" name="action" value="<? echo $action ; ?>" />
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Project Executive</label>

                                                    <select name="projectExecutive" class="form-control" required>
                                                        <option value="">Select</option>
                                                        <?
                                                        $sql = mysqli_query($con,"select * from user where user_status=1 and vendorId='".$RailTailVendorID."' and level=2");
                                                        while($sql_result = mysqli_fetch_assoc($sql)){
                                                        $projectExecutiveId = $sql_result['userid'];
                                                        $projectExecutiveName = $sql_result['name'];
                                                        ?>
                                                        <option value="<? echo $projectExecutiveId; ?>">
                                                            <? echo $projectExecutiveName; ?>
                                                        </option>
                                                            
                                                            
                                                        <? } ?>
                                                    </select>
                                                    <input type="hidden" name="projectExecutiveName" value="<? echo $projectExecutiveName; ?>">
                                                </div>
                                                
                                                <div class="col-sm-12">
                                                    <br>
                                                    <button type="submit" class="btn btn-primary" onclick="saveToProjectExecutive()">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                                
                                
                               <? } ?> 
                                
                                
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h5 style="font-weight: 600;">Proceed Feasibility Check : <span style="color:red; "><?php echo $atmid . ' '; ?></span>To Engineer</h5>
                                        <hr>
                                        <form id="myForm" enctype="multipart/form-data">
                                            <input type="hidden" name="atmid" value="<? echo $atmid ; ?>" />
                                            <input type="hidden" name="siteid" value="<? echo $id ; ?>" />
                                            <input type="hidden" name="action" value="<? echo $action ; ?>" />
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Engineer</label>

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
                                                <div class="col-sm-12">
                                                    <br>
                                                    <button type="submit" class="btn btn-primary" onclick="saveForm()">Save</button>
                                                    <!--<input type="submit" name="submit" class="btn btn-primary"  /> -->
                                                </div>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                                
                                
                                
                                
                            </div>
        </div>




    </div>
</div>



<script>
  function saveToProjectExecutive() {
    event.preventDefault();
    var formData = new FormData($('#delegateToProjectExecutive')[0]);
    var requiredFields = $('#delegateToProjectExecutive :required');
    var emptyFields = [];

    // Check for empty required fields
    requiredFields.each(function() {
        if ($(this).val() === '') {
            emptyFields.push($(this).attr('name'));
        }
    });

    if (emptyFields.length > 0) {
        Swal.fire("Error", "Please fill in all the required fields!", "error");
        $('input, select').removeClass('highlight');
        $.each(emptyFields, function(index, fieldName) {
            $('[name="' + fieldName + '"]').addClass('highlight');
        });
        return; 

    }

        $.ajax({
            url: 'process_delegateToProjectExecutive.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response == 200) {
                    Swal.fire("Success", "Delegated Successfully!", "success");
                    setTimeout(function() {
                        window.location.href = "allLeads.php";
                    }, 3000); // Redirect after 3 seconds
                } else {
                    alert('Added Error!');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Added Error!');
            }
        });

}
  
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

    if (emptyFields.length > 0) {
        Swal.fire("Error", "Please fill in all the required fields!", "error");
        $('input, select').removeClass('highlight');
        $.each(emptyFields, function(index, fieldName) {
            $('[name="' + fieldName + '"]').addClass('highlight');
        });
        return; // Exit the function if empty fields exist
    }

        $.ajax({
            url: 'process_vendor_delegate.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response == 200) {
                    Swal.fire("Success", "Delegated Successfully!", "success");
                    setTimeout(function() {
                        // window.location.href = "allLeads.php";
                    }, 3000); // Redirect after 3 seconds
                } else if (response == 202) {
                    Swal.fire("Success", "Delegated Successfully!", "success");
                    setTimeout(function() {
                        window.location.href = "sitestest.php";
                    }, 3000); // Redirect after 3 seconds
                } else {
                    alert('Added Error!');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Added Error!');
            }
        });

}

              </script>      
                    

<? include('../footer.php'); ?>