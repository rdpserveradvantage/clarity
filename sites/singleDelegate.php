<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="row">
    <div class="col-sm-12 grid-margin">


        <style>
            .swal2-popup {
                background: white !important;
            }
        </style>



        <div class="card">
            <div class="card-block">
                <?php
                $atmid = $_REQUEST['atmid'];
                $id = $_REQUEST['id'];
                $action = $_REQUEST['action'];
                ?>
                <h5>Delegate : <span style="color:red; ">
                        <?php echo $atmid . ' '; ?>
                    </span>To Contractor</h5>
                <hr>
                <form id="myForm2" enctype="multipart/form-data">
                    <input type="hidden" name="atmid" value="<?php echo $atmid; ?>" />
                    <input type="hidden" name="siteid" value="<?php echo $id; ?>" />
                    <input type="hidden" name="action" value="<?php echo $action; ?>" />
                    <input type="hidden" name="delegateTo" value="vendor" />

                    <div class="row">
                        <div class="col-sm-12">
                            <label>Contractor</label>
                            <select name="vendor" class="form-control" required>
                                <option value="">SELECT</option>
                                <?php
                                $sql2 = mysqli_query($con, "select * from vendor where status=1");
                                while ($sql_result2 = mysqli_fetch_assoc($sql2)) {
                                    $vendorid = $sql_result2['id'];
                                    $vendorname = $sql_result2['vendorName'];
                                    ?>
                                    <option value="<?php echo $vendorid; ?>">
                                        <?php echo strtoupper($vendorname); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <br>
                            <button type="submit" class="btn btn-success" onclick="saveForm2()">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>


        <script>
            function saveForm2() {
                event.preventDefault();
                var formData = new FormData($('#myForm2')[0]);
                var requiredFields = $('#myForm2 :required');
                var emptyFields = [];
                requiredFields.each(function () {
                    if ($(this).val() === '') {
                        emptyFields.push($(this).attr('name'));
                    }
                });
                if (emptyFields.length > 0) {
                    Swal.fire("Error", "Please fill in all the required fields!", "error");
                    $('input, select').removeClass('highlight');
                    $.each(emptyFields, function (index, fieldName) {
                        $('[name="' + fieldName + '"]').addClass('highlight');
                    });
                    return;
                }
                $.ajax({
                    url: 'process_singleDelegate.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        var obj = JSON.parse(response);
                        if (obj.success==true) {
                            Swal.fire("Success", "Delegated To Vendor Successfully!", "success")
                                .then(function () {
                                    window.location.href = "sitestest.php";
                                });
                        } else {
                            console.error('Added Error!');
                            alert('Added Error!');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert('Added Error!');
                    }
                });
            }

        </script>

    </div>
</div>


<? include('../footer.php'); ?>