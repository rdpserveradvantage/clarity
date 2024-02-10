<? include('../header.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="row">
    <? $materialId = $_REQUEST['materialId']; ?>

    <div class="col-sm-12 grid-margin">
        <div class="card">
            <div class="card-block">
                <h5>Vendor Details</h5>
                <hr>
                <form id="vendorForm">
                    <input type="hidden" name="materialId" value="<?= $materialId; ?>" />
                    <input type="hidden" name="atmid" value="<?= $atmid; ?>">
                    <input type="hidden" name="siteid" value="<?= $siteid; ?>">
                    <input type="hidden" name="attribute" value="<?= htmlentities(serialize($attributes)); ?>">
                    <input type="hidden" name="values" value="<?= htmlentities(serialize($values)); ?>">
                    <input type="hidden" name="serialNumbers" value="<?= htmlentities(serialize($serialNumbers)); ?>">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="">Contractor</label>
                            <select class="form-control" name="vendorId" required>
                                <option value="">Select</option>
                                <?
                                $vendorSql = mysqli_query($con, "select * from vendor where status=1");
                                while ($vendorSqlResult = mysqli_fetch_assoc($vendorSql)) {
                                    $vendorId = $vendorSqlResult['id'];
                                    $vendorName = $vendorSqlResult['vendorName'];

                                    echo '<option value="' . $vendorId . '">' . $vendorName . '</option>';
                                }
                                ?>
                            </select>
                            <br>
                        </div>
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
                        var requiredFields = document.querySelectorAll('select[required],input[required], textarea[required]');
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
                            xhr.open('POST', 'processInvidualMaterialSend.php');
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onload = function () {
                                submitButton.disabled = false;
                                console.log(xhr.responseText);
                                var response = JSON.parse(xhr.responseText);
                                console.log(xhr.responseText);
                                if (response.status === "200") {
                                    alert('Form data saved successfully!');
                                    window.location.href = "materialSent.php"
                                } else {
                                    alert('Error: ' + response.message);
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