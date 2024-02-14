<? include('../header.php');


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



$isVendor = $_SESSION['isVendor'];
$islho = $_SESSION['islho'];


if($isVendor==1){
    $vendorid = $_SESSION['vendor_id'];
    $vendor_id = " and vendorid='".$vendorid."'" ; 
    ?>
<script>
    // window.location.href="/admin/vendor_add_user.php";
</script>
    <?
    // header('Location: /');
        // exit;
        
}else{
    $vendor_id = '  ' ; 
}




?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function disable(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Think twice to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Proceed it!'
        }).then((result) => {
            if (result.isConfirmed) {

                jQuery.ajax({
                    type: "POST",
                    url: 'disable_user.php',
                    data: 'id=' + id,
                    success: function (msg) {

                        if (msg == 1) {
                            Swal.fire(
                                'Updated!',
                                'Status has been changed.',
                                'success'
                            );

                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);

                        } else if (msg == 0 || msg == 2) {

                            Swal.fire(
                                'Cancelled',
                                'Your imaginary file is safe :)',
                                'error'
                            );



                        }

                    }
                });


            }
        })

    }
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<button type="button" class="btn btn-outline-secondary btn-md" data-bs-toggle="modal" data-bs-target="#adduser"
    data-act="add">
    <i class="mdi mdi-account-plus"></i> &nbsp; Add
</button>



<div class="row">
    <div class="col-12  grid-margin">
        <div class="card">
            <div class="card-header">
                <h5>Users</h5>
            </div>
            <div class="card-body" style="overflow:auto;">


                <?php
                $i = 1;

    $sql = mysqli_query($con, "select * from user where 1 $vendor_id");
                $numRows = mysqli_num_rows($sql);
                ?>

                <?php if ($numRows > 0): ?>
                    <table id="example" class="table dataTable js-exportable no-footer" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th>SR no</th>
                                <th>Name</th>
                                <th>Desgination</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Contact No.</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Active / Inactive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($sql_result = mysqli_fetch_assoc($sql)) {
                                $id = $sql_result['id'];
                                $user_status = ($sql_result['user_status'] == 0) ? 'Inactive' : 'Active';
                                $makeuser_status = ($sql_result['user_status'] == 0) ? 'Make Active' : 'Make Inactive';
                                $status_class = ($sql_result['user_status'] == 0) ? 'text-danger' : 'text-success';

                                $level = $sql_result['level'];
                                $designation = '';

                                if ($level == 1) {
                                    $designation = 'Admin';
                                } elseif ($level == 2) {
                                    $designation = 'Project Executive';
                                } elseif ($level == 3) {
                                    $designation = 'Engineer';
                                }
                                ?>

                                <tr>
                                    <td>
                                        <?= $i; ?>
                                    </td>
                                    <td class="strong">
                                        <?= $sql_result['name']; ?>
                                    </td>
                                    <td>
                                        <?= $designation; ?>
                                    </td>
                                    <td style="text-transform: initial;">
                                        <?= $sql_result['uname']; ?>
                                    </td>
                                     <td class="strong">
                                        <?= $sql_result['pwd']; ?>
                                    </td>
                                    <td style="text-transform: initial;">
                                        <?= $sql_result['contact']; ?>
                                    </td>
                                    <td class="<?= $status_class; ?>">
                                        <?= $user_status; ?>
                                    </td>
                                    <td>

                                        <button type="button" class="btn btn-outline-secondary btn-md" data-bs-toggle="modal"
                                            data-bs-target="#edituser" id="edituserbutton" data-act="add"
                                            data-value="<?= $id; ?>"
                                            style="color: #000;background-color: #e4eaec;border-color: #e4eaec;">
                                            <i class="mdi mdi-account-plus"></i> &nbsp; Edit
                                        </button>

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-danger" onclick="disable(<?= $sql_result['id']; ?>)">
                                            <?= $makeuser_status; ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No data available</p>
                <?php endif; ?>


            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="adduser" tabindex="-1" aria-labelledby="ModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">New message</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="POST">

                    <div class="row">
                        <div class="col-sm-6">


                            <div class="row">

                            <div class="col-sm-12 form-group">
                                    <label>Is Contractor : *</label><br />
                                    <input type="radio" name="isVendor" value="1" checked> : Yes
                                </div>
                                
                            <div class="col-sm-12 form-group">
                                    <label>Is LHO : *</label>
                                    <br />
                                    <input type="radio" name="islho" value="0" checked> : No
                                </div>
                                


                                <div class="col-sm-12 form-group">
                                    <label>Name : *</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label>Email : *</label> <span id="emailvalidationmsg"></span>
                                    <input type="email" id="emailid" name="uname" class="form-control" required>
                                </div>

                                <div class="col-sm-6 form-group">
                                    <label>Password : *</label>
                                    <input type="password" name="pwd" id="pwd" class="form-control" required>
                                </div>


                                <div class="col-sm-6 form-group">
                                    <label>Confirm Password : *</label>
                                    <input type="password" name="cpwd" id="cpwd" class="form-control" required>
                                </div>

                                <div class="col-sm-6 form-group">
                                    <label>Contact : *</label>
                                    <input type="number" id="contact" name="contact" class="form-control"
                                        onkeypress="return validInput(event);" required>
                                </div>

                                <div class="col-sm-6 form-group">
                                    <label>Role : *</label>
                                    <select class="form-control" name="role" required>
                                        <option value="">Select</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Project Executive</option>
                                        <option value="3">Engineer</option>
                                        
                                    </select>
                                </div>


                                <div class="col-sm-6 form-group">
                                    <label for="">Vendor : *</label>
                                    <select class="form-control" name="vendorid" id="vendorSelect" required>

                                        <?php
                                        $vendorsql = mysqli_query($con, "select * from vendor where status=1 and id='".$vendorid."'");
                                        while ($vendorsql_result = mysqli_fetch_assoc($vendorsql)) {
                                            $vendorid = $vendorsql_result['id'];
                                            $vendorName = $vendorsql_result['vendorName'];
                                            ?>
                                            <option value="<?= $vendorid ?>">
                                                <?= $vendorName; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-sm-6 form-group" id="lhoDiv" style="display: none;">
                                    <label for="">LHO : *</label>
                                    <select class="form-control" name="lhoid">
                                        <option value="">Select</option>
                                        <?php
                                        $vendorsql = mysqli_query($con, "select * from lho where status=1");
                                        while ($vendorsql_result = mysqli_fetch_assoc($vendorsql)) {
                                            $lhoid = $vendorsql_result['id'];
                                            $lhoName = $vendorsql_result['lho'];
                                            ?>
                                            <option value="<?= $lhoid ?>">
                                                <?= $lhoName; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
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
                                                        name="sub_menu[]" value="<?php echo $sub_id; ?>">
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

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edituser" tabindex="-1" aria-labelledby="ModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">New message</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="edituserform">
                please wait ...
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>


    $(document).ready(function () {
        $('#vendorSelect').on('change', function () {
            var selectedValue = $(this).val();
            if (selectedValue == 4) {
                $('#lhoDiv').show().find('select').prop('required', true);
            } else {
                $('#lhoDiv').hide().find('select').prop('required', false);
            }
        });

        $('#emailid').on('change', function () {
            var emailInput = $(this);

            $.post('validate_email.php', { emailid: emailInput.val() }, function (response) {
                if (response == 0) {
                    emailInput.removeClass('green-border').addClass('red-border');
                    $("#emailvalidationmsg").html('Email already exists!');
                } else if (response == 1) {
                    emailInput.addClass('green-border').removeClass('red-border');
                    $("#emailvalidationmsg").html('');
                }
            });
        });


    });

    $(document).on('click', '#edituserbutton', function () {
        var userid = $(this).data('value'); // Use .data() method to access data-value
        $.ajax({
            type: 'POST',
            url: 'vendor_edituser.php',
            data: 'userid=' + userid,
            success: function (response) {
                $("#edituserform").html(response)
            }
        });

    });


    $(document).on('change', '.main_menu', function () {
        var isChecked = $(this).prop("checked");
        $(this).siblings(".showsubmenu").find(".submenu").prop("checked", isChecked);
    });


    $(document).ready(function () {



        var passwordField = $('#pwd');
        var confirmPasswordField = $('#cpwd');

        // Function to check if passwords match
        function checkPasswordMatch() {
            var password = passwordField.val();
            var confirmPassword = confirmPasswordField.val();

            if (password !== confirmPassword) {
                alert('Passwords do not match. Please re-enter.');
                passwordField.val('');
                confirmPasswordField.val('');
            }
        }
        confirmPasswordField.blur(checkPasswordMatch);


        $('#addUserForm').submit(function (event) {
            event.preventDefault();

            if ($('.main_menu:checked').length === 0) {
                alert('Please select at least one permission.');
                return;
            }

            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'process_vendor_add_user.php',
                data: formData,
                success: function (response) {
                    console.log(response)
                    if (response == 1) {
                        alert('User added successfully!');
                    } else {
                        alert('Failed to add user. Please try again.');
                    }
                },
                error: function () {
                    alert('Error submitting the form. Please try again.');
                }
            });
        });
    });
</script>

<? include('../footer.php'); ?>
<script>
    function validInput(e) {
        e = (e) ? e : window.event;
        a = document.getElementById('contact');
        cPress = (e.which) ? e.which : e.keyCode;

        if (cPress > 31 && (cPress < 48 || cPress > 57)) {
            return false;
        } else if (a.value.length >= 10) {
            return false;
        }

        return true;
    }

    $(document).ready(function () {
        // Attach the event handler to the checkbox
        $('.serviceExecutive').change(function () {
            if ($(this).is(':checked')) {
                // Checkbox is checked
                console.log('Checkbox checked');
            } else {
                // Checkbox is unchecked
                console.log('Checkbox unchecked');
            }
        });
    });



    $('.serviceExecutive').change(function () {

        let id = $(this).val();

        if ($(this).is(':checked')) {

            $.ajax({
                url: 'serviceExecutive.php',
                type: 'POST',
                data: "userid=" + id + "&type=1",
                success: function (data) {
                    console.log(data);
                }
            });


        } else {
            $.ajax({
                url: 'serviceExecutive.php',
                type: 'POST',
                data: "userid=" + id + "&type=0",
                success: function (data) {
                    console.log(data);
                }
            });
        }
    });
</script>


<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>



<script src="../datatable/jquery.dataTables.js">
</script>
<script src="../datatable/dataTables.bootstrap.js">
</script>
<script src="../datatable/dataTables.buttons.min.js">
</script>
<script src="../datatable/buttons.flash.min.js">
</script>
<script src="../datatable/jszip.min.js">
</script>

<script src="../datatable/pdfmake.min.js">
</script>
<script src="../datatable/vfs_fonts.js">
</script>
<script src="../datatable/buttons.html5.min.js">
</script>
<script src="../datatable/buttons.print.min.js">
</script>
<script src="../datatable/jquery-datatable.js">
</script>