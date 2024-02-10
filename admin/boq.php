<? include('../header.php'); ?>

<link rel="stylesheet" type="text/css" href="datatable/dataTables.bootstrap.css">

<style>
     .btn-circle {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn i {
    margin-right: 1px;
}
</style>

                    <div class="card">
                        <div class="card-header">

                                <h3>BOQ Management </h3>
                                <button type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#addModal" style="float:right;" title="Add BOQ">
                                    <i class="fa fa-plus"></i>
                                </button>                                

                        </div>
                        <div class="card-block">
                            <table class="table table-styling">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>BOQ</th>
                                        <th>Count</th>
                                        <th>Actions</th>
                                        <th>Need Serial Number ? </th>
                                    </tr>
                                </thead>
                                <tbody id="boq-data"></tbody>
                            </table>

                            <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Update BOQ Record</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="recordId" />
                                            <div class="form-group">
                                                <label for="value">Value</label>
                                                <input type="text" class="form-control" id="value" />
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Count</label>
                                                <input type="text" class="form-control" id="count" />
                                            </div>
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="activityStatus">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">Required Serial Number</label>
                                                <select class="form-control" id="needSerialNumber">
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="updateRecord()">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modal for adding a new BOQ -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add BOQ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="boqName">BOQ Name</label>
                    <input type="text" class="form-control" id="boqName" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="text" class="form-control" id="quantity" required>
                </div>
                <label for="status">Required Serial Number</label>
                    <select class="form-control" id="needSerialNumber">
                        <option value="1" selected>Yes</option>
                        <option value="0">No</option>
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Call the addBOQ() function to handle form submission -->
                <button type="button" class="btn btn-primary" onclick="addBOQ()">Add BOQ</button>
            </div>
        </div>
    </div>
</div>

                        </div>
                    </div>
               

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    // Function to open the add modal
    function openAddModal() {
        $("#addModal").modal("show");
    }

function addBOQ() {
    var boqName = $("#boqName").val();
    var quantity = $("#quantity").val();

    // Data to be sent in the request body as JSON
    var requestData = {
        boq_name: boqName,
        quantity: quantity,
    };

    $.ajax({
        url: "add_boq.php", // Replace with your REST API endpoint
        type: "POST",
        data: JSON.stringify(requestData), // Convert the data to JSON format
        contentType: "application/json", // Specify the content type as JSON
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.status === 200) {
                // Show success message using SweetAlert
                $("#addModal").modal("hide");
                    
                swal("Success", "BOQ added successfully!", "success").then(() => {
                    // Close the modal and refresh the BOQ data
                    loadBOQData();
                });
                window.location.reload();
            } else {
                // Show error message using SweetAlert
                swal("Error", "Failed to add BOQ", "error");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            // Show error message using SweetAlert for AJAX error
            swal("Error", "An error occurred. Please try again later.", "error");
        },
    });
}



    $(document).ready(function () {
        // Load BOQ data on page load
        loadBOQData();
    });

    // Function to load BOQ data
    function loadBOQData() {
        $.ajax({
            url: "get_boq.php",
            type: "GET",
            dataType: "json",
            success: function (data) {
                var boqData = "";
                $.each(data, function (key, value) {
                    var counter = key+1 ; 
                    
                    if(value.needSerialNumber==1){
                        needSerialNumber = 'Yes' ; 
                    }else{
                        needSerialNumber = 'No' ;
                    }
                    
                    boqData += "<tr>";
                    boqData += '<td>' + counter + '</td>';
                    boqData += "<td class='strong'>" + value.value + "</td>";
                    boqData += "<td>" + value.count + "</td>";
                    boqData += "<td>";
                    boqData += '<button type="button" class="btn btn-primary" onclick="openUpdateModal(' + value.id + ')">Edit | Delete </button>';
                    boqData += "</td>";
                    boqData += "<td>" + needSerialNumber + "</td>";
                    boqData += "</tr>";
                });
                $("#boq-data").html(boqData);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
        });
    }

    // Function to open the update modal and pre-fill the record data
    function openUpdateModal(id) {
        $.ajax({
            url: "get_single_boq.php?id=" + id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#recordId").val(data.id);
                $("#value").val(data.value);
                $("#count").val(data.count);
                $("#activityStatus").val(data.status);
                $("#needSerialNumber").val(data.needSerialNumber);
                $("#updateModal").modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
        });
    }

    // Function to update the BOQ record
    function updateRecord() {
        var id = $("#recordId").val();
        var count = $("#count").val();
        var status = $("#activityStatus").val();
        var needSerialNumber = $("#needSerialNumber").val();
        var value = $("#value").val();

        $.ajax({
            url: "update_boq.php",
            type: "POST",
            data: {
                id: id,
                count: count,
                status: status,
                value: value,
                needSerialNumber: needSerialNumber,
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                // Close the modal and refresh the BOQ data
                $("#updateModal").modal("hide");
                loadBOQData();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
        });
    }
</script>

<? include('../footer.php'); ?>
