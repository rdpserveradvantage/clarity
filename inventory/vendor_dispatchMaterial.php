<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="row">
    <div class="col-sm-12 grid-margin">
        <div class="card">
            <div class="card-block">

                <?php
                $atmid = $_REQUEST['atmid'];
                $siteid = $_REQUEST['siteid'];

                $materialSendId = $_REQUEST['materialSendId'];

                $materialSql = mysqli_query($con, "select * from material_send_details where materialSendId='" . $materialSendId . "'");
                while ($materialSqlResult = mysqli_fetch_assoc($materialSql)) {
                    $attributes[] = $materialSqlResult['attribute'];
                    $values[] = $materialSqlResult['value'];
                    $serialNumbers[] = $materialSqlResult['serialNumber'];
                }

                $sitessql = mysqli_query($con, "select * from sites where id='" . $siteid . "' and atmid='" . $atmid . "' and status=1");
                $sitessql_result = mysqli_fetch_assoc($sitessql);

                $vendorId = $delegatedToVendorId = $sitessql_result['delegatedToVendorId'];
                $vendorName = $sitessql_result['delegatedToVendorName'];

                ?>

                <h5>Receiver's Details</h5>

                <hr />
                <form id="vendorForm">
                    <input type="hidden" name="atmid" value="<?php echo $atmid; ?>">
                    <input type="hidden" name="siteid" value="<?php echo $siteid; ?>">
                    <input type="hidden" name="materialSendID" value="<?= $materialSendId; ?>">


                    <input type="hidden" name="attribute" value="<?php echo htmlentities(serialize($attributes)); ?>">
                    <input type="hidden" name="values" value="<?php echo htmlentities(serialize($values)); ?>">
                    <input type="hidden" name="serialNumbers"
                        value="<?php echo htmlentities(serialize($serialNumbers)); ?>">

                    <div class="row">


                        <div class="col-sm-12">
                            <label for="Vendor">Contractor</label>
                            <select name="vendorId" id="contractor" class="form-control" required>
                                <option>--Select Contractor</option>

                                <?
                                $vendorSql = mysqli_query($con, "select * from vendor where status=1");
                                while ($vendorSqlResult = mysqli_fetch_assoc($vendorSql)) {
                                    ?>
                                    <option value="<?= $vendorSqlResult['id']; ?>">
                                        <?= $vendorSqlResult['vendorName']; ?>
                                    </option>

                                <?
                                }
                                ?>
                            </select>


                        </div>


                        <div class="col-sm-6">
                            <label>Contact Person Name</label>
                            <select class="form-control" name="contactPersonName" id="contactPersonName" required>

                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label>Contact Person Number</label>
                            <input type="text" name="contactPersonNumber" id="contactPersonNumber" class="form-control"
                                required>
                        </div>
                        <div class="col-sm-12">
                            <label>Address</label>
                            <textarea name="address" class="form-control" id="address" required></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label>POD</label>
                            <input type="text" name="POD" class="form-control" required />
                        </div>
                        <div class="col-sm-6">
                            <label>Courier</label>
                            <input type="text" name="courier" class="form-control" required />
                        </div>
                        <div class="col-sm-12">
                            <label>Any Other Remark</label>
                            <input type="text" name="remark" class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                            <input type="submit" name="submit" class="btn btn-primary" onclick="submitForm(event);"
                                id="submitButton" value="Submit">
                        </div>
                    </div>
                </form>

                <script>

                    $(document).on('change', '#contractor', function () {

                        var contractor = $(this).val();

                        $("#contactPersonName").html('');
                        $.ajax({
                            type: "POST",
                            url: 'getVendorsEngineer.php',
                            data: 'vendor=' + contractor,
                            async: false,
                            success: function (msg) {
                                $('#contactPersonName').html(msg);
                            }
                        });


                    })




                    $(document).on('change', '#contactPersonName', function () {

                        var contactPerson = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: 'getVendorUserInfo.php',
                            data: 'contactPerson=' + contactPerson,
                            async: false,
                            success: function (msg) {
                                var data = JSON.parse(msg);
                                $('#contactPersonNumber').val(data.contact);
                                $('#address').val(data.address);
                            }
                        });

                    });


                    function submitForm(event) {
                        event.preventDefault();
                        var requiredFields = document.querySelectorAll('input[required], textarea[required]');
                        for (var i = 0; i < requiredFields.length; i++) {
                            requiredFields[i].classList.remove('highlight-field');
                        }

                        var isValid = true;
                        for (var i = 0; i < requiredFields.length; i++) {
                            if (requiredFields[i].value.trim() === '') {
                                requiredFields[i].classList.add('highlight-field');
                                isValid = false;
                            }
                        }

                        if (isValid) {
                            var formData = new FormData(document.getElementById('vendorForm'));

                            var submitButton = document.getElementById('submitButton');
                            submitButton.disabled = true;

                            var serializedData = new URLSearchParams(formData).toString();
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'vendor_processConfirmSendMaterialRequest.php');
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onload = function () {


                                console.log(xhr.responseText)

                                submitButton.disabled = false;

                                var data = JSON.parse(xhr.responseText);
                                console.log(data);
                                if (data.status == '200') {
                                    alert('Material Send Successfully !')
                                    window.location.href = "materialRecived.php";
                                } else {
                                    alert('Material Send Error !')
                                    console.error(xhr.responseText);
                                    console.log('error');
                                }
                            };
                            xhr.send(serializedData);
                        } else {
                            alert('Please fill in all required fields.');
                        }
                    }
                </script>

                <style>
                    .highlight-field {
                        border-color: red;
                    }
                </style>



            </div>
        </div>

    </div>
</div>


<? include('../footer.php'); ?>