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
                $attributes = $_POST['attribute'];
                $values = $_POST['value'];
                $serialNumbers = $_POST['serialNumber'];
                $vendorId = $_REQUEST['vendorId'];

                if ($vendorId > 0) {
                    $sql = mysqli_query($con, "select * from vendor where id='" . $vendorId . "'");
                    $sql_result = mysqli_fetch_assoc($sql);
                    $vendorName = $sql_result['vendorName'];

                    ?>

                    <h5>Vendor Details</h5>
                    <hr>
                    <p><strong>Vendor Name:</strong>
                        <?php echo $vendorName; ?>
                    </p>
                    <!-- Add other vendor info here -->
                    <hr>
                    <form id="vendorForm">
                        <input type="hidden" name="atmid" value="<?php echo $atmid; ?>">
                        <input type="hidden" name="siteid" value="<?php echo $siteid; ?>">
                        <input type="hidden" name="vendorId" value="<?php echo $vendorId; ?>">
                        <input type="hidden" name="attribute" value="<?php echo htmlentities(serialize($attributes)); ?>">
                        <input type="hidden" name="values" value="<?php echo htmlentities(serialize($values)); ?>">
                        <input type="hidden" name="serialNumbers"
                            value="<?php echo htmlentities(serialize($serialNumbers)); ?>">

                        <div class="row">
                            <div class="col-sm-6">
                                <label>Contact Person Name</label>
                                <input type="text" name="contactPersonName" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <label>Contact Person Number</label>
                                <input type="text" name="contactPersonNumber" class="form-control" required>
                            </div>
                            <div class="col-sm-12">
                                <label>Address</label>
                                <textarea name="address" class="form-control" required></textarea>
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
                        function submitForm(event) {
                            event.preventDefault();

                            // Reset previous field highlighting
                            var requiredFields = document.querySelectorAll('input[required], textarea[required]');
                            for (var i = 0; i < requiredFields.length; i++) {
                                requiredFields[i].classList.remove('highlight-field');
                            }

                            // Validate required fields
                            var isValid = true;
                            for (var i = 0; i < requiredFields.length; i++) {
                                if (requiredFields[i].value.trim() === '') {
                                    requiredFields[i].classList.add('highlight-field');
                                    isValid = false;
                                }
                            }

                            if (isValid) {
                                var formData = new FormData(document.getElementById('vendorForm'));

                                // Disable the submit button
                                var submitButton = document.getElementById('submitButton');
                                submitButton.disabled = true;

                                // Serialize the form data
                                var serializedData = new URLSearchParams(formData).toString();
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', 'processConfirmSendMaterialRequest.php');
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                xhr.onload = function () {
                                    submitButton.disabled = false;
                                    console.log(xhr.responseText);
                                    var response = JSON.parse(xhr.responseText);

                                    if (response.status === "200") {
                                        alert('Material Dispatched successfully!');
                                        window.location.href = "materialSent.php"
                                    } else {
                                        alert('Error: ' + response.message);
                                        console.error(xhr.responseText);
                                        console.log('error');
                                    }
                                };
                                xhr.send(serializedData);
                            } else {
                                // Show alert for empty required fields
                                alert('Please fill in all required fields.');
                            }
                        }
                    </script>

                    <style>
                        .highlight-field {
                            border-color: red;
                        }
                    </style>

                <?php } else {
                    // Add code for when vendorId is not selected
                } ?>

            </div>
        </div>

    </div>
</div>


<? include('../footer.php'); ?>