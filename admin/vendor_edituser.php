<? include('../config.php');
$id = $_REQUEST['userid'];

$sql = mysqli_query($con,"select * from user where id='".$id."'");
$sql_result = mysqli_fetch_assoc($sql) ; 

$name = $sql_result['name'];
$uname = $sql_result['uname'];
$pwd = $sql_result['pwd'];
$user_permission = $sql_result['permission'];
$level = $sql_result['level'];
$contact = $sql_result['contact'];
$vendorid = $sql_result['vendorid'];


$user_permission = explode (",", $user_permission);


?>

<form id="editUserForm" method="POST">
<input type="hidden" name="id" value="<?= $id; ?>" />
    <div class="row">
        <div class="col-sm-6">


            <div class="row">
                <div class="col-sm-12 form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="<?= $name; ?>">
                </div>

                <div class="col-sm-12 form-group">
                    <label>Email / userid</label>
                    <input type="email" name="uname" class="form-control" value="<?= $uname?>" readonly>
                </div>

                <div class="col-sm-12 form-group">
                    <label>Password</label>
                    <input type="password" name="pwd" class="form-control" value="<?= $pwd; ?>">
                </div>

                <div class="col-sm-12 form-group">
                    <label>Contact</label>
                    <input type="number" id="contact" name="contact" class="form-control"
                        onkeypress="return validInput(event);" value="<?= $contact; ?>">
                </div>

                <div class="col-sm-12 form-group">
                    <label>Role</label>
                    <select class="form-control" name="role" required>
                        <option value="">Select</option>
                        <option value="1" <? if($level==1){ echo 'selected';} ?>>Admin</option>
                        <option value="2" <? if($level==2){ echo 'selected';} ?>>Project Executive</option>
                        <option value="3" <? if($level==3){ echo 'selected';} ?>>Engineer</option>
                    </select>
                </div>
               
                <div class="col-sm-12 form-group">
                                    <label for="">Vendor</label>
                                    <select class="form-control" name="vendorid" required>
                                        <option value="">Select</option>
                                        <?php 
                                        $vendorsql = mysqli_query($con,"select * from vendor where status=1");
                                        while($vendorsql_result = mysqli_fetch_assoc($vendorsql)){
                                            $thisvendorid = $vendorsql_result['id'];
                                            $vendorName = $vendorsql_result['vendorName'];
                                            ?>
                                            <option value="<?= $thisvendorid?>" <? if($thisvendorid==$vendorid){ echo 'selected' ; }?>><?= $vendorName ; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 grid-margin">
                    <br>
                    <input type="submit" name="submit" class="btn btn-primary">
                </div>
            </div>

        </div>

        <div class="col-sm-6">
            <h4>Permissions</h4>
            <hr />
            <ul style="overflow: scroll; max-height: 500px;">
                <?php
                $statusColumn = 'status';
                
                    $mainsql = mysqli_query($con, "select * from main_menu where $statusColumn=1");
                while ($mainsql_result = mysqli_fetch_assoc($mainsql)) {
                    $main_id = $mainsql_result['id'];
                    ?>
                    <li class="card-block">
                        <input type="checkbox" class="main_menu" value="<?php echo $main_id; ?>">
                        <span class="strong">
                            <?php echo $mainsql_result['name']; ?>
                        </span>
                        <ul class="showsubmenu">
                            <?php
                            $sub_sql = mysqli_query($con, "select * from sub_menu where main_menu='" . $main_id . "' and $statusColumn=1");
                            while ($sub_sql_result = mysqli_fetch_assoc($sub_sql)) {
                                $sub_id = $sub_sql_result['id'];
                                ?>
                                <li>
                                    <input class="submenu" type="checkbox" data-main_id="<?php echo $main_id ?>"
                                        name="sub_menu[]" value="<?php echo $sub_id; ?>"  <? if(in_array($sub_id,$user_permission)){ echo 'checked' ; } ?>>
                                    <?php echo $sub_sql_result['sub_menu']; ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <hr />
                    </li>
                <?php } ?>
            </ul>

        </div>
    </div>

</form>



<script>
     $(document).ready(function () {
        
        $('#editUserForm').submit(function (event) {
        alert('update event');
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'process_vendor_edit_user.php',
                data: formData,
                success: function (response) {
                    console.log(response)
                    if (response == 1) {
                        alert('User updated successfully!');
                    } else {
                        alert('Failed to Update user. Please try again.');
                    }
                },
                error: function () {
                    alert('Error submitting the form. Please try again.');
                }
            });
        });
    });
    </script>
