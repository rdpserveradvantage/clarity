<? include('../header.php'); 

$siteid = $_REQUEST['id'];
$atmid = $_REQUEST['atmid'];

?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

                    <div class="card">
                        <div class="card-block">
                            <h5 style="font-weight: 600;">
                                Edit ATMID : <span style="color: red;"><? echo $atmid; ?> </span>
                            </h5>
                            <hr />

                                <?
                                
                                $sql = mysqli_query($con,"select * from sites where id='".$siteid."'");
                                $sql_result = mysqli_fetch_assoc($sql);
                                
                                $activity = $sql_result['activity'];
                                $customer = $sql_result['customer'];
                                $bank = $sql_result['bank'];
                                $atmid = $sql_result['atmid'];
                                $address = $sql_result['address'];
                                $city = $sql_result['city'];
                                $state = $sql_result['state'];
                                $zone = $sql_result['zone'];
                                $LHO = $sql_result['LHO'];
                                $LHO_Contact_Person = $sql_result['LHO_Contact_Person'];
                                $LHO_Contact_Person_No = $sql_result['LHO_Contact_Person_No'];
                                $LHO_Contact_Person_email = $sql_result['LHO_Contact_Person_email'];
                                $LHO_Adv_Person = $sql_result['LHO_Adv_Person'];
                                $LHO_Adv_Contact = $sql_result['LHO_Adv_Contact'];
                                $LHO_Adv_email = $sql_result['LHO_Adv_email'];
                                $Project_Coordinator_Name = $sql_result['Project_Coordinator_Name'];
                                $Project_Coordinator_No = $sql_result['Project_Coordinator_No'];
                                $Project_Coordinator_email = $sql_result['Project_Coordinator_email'];
                                $Customer_SLA = $sql_result['Customer_SLA'];
                                $Our_SLA = $sql_result['Our_SLA'];
                                $Vendor = $sql_result['Vendor'];
                                $Cash_Management = $sql_result['Cash_Management'];
                                $CRA_VENDOR = $sql_result['CRA_VENDOR'];
                                $ID_on_Make = $sql_result['ID_on_Make'];
                                $Model = $sql_result['Model'];
                                $SiteType = $sql_result['SiteType'];
                                $PopulationGroup = $sql_result['PopulationGroup'];
                                $XPNET_RemoteAddress = $sql_result['XPNET_RemoteAddress'];
                                $CONNECTIVITY = $sql_result['CONNECTIVITY'];
                                $Connectivity_Type = $sql_result['Connectivity_Type'];
                                $po = $sql_result['po'];
                                $po_date = $sql_result['po_date'];
                                $latitude = $sql_result['latitude'];
                                $longitude = $sql_result['longitude'];
                                $verificationStatus = $sql_result['verificationStatus'];
                                $networkIP = $sql_result['networkIP'];
                                $routerIP = $sql_result['routerIP'];
                                $atmIP = $sql_result['atmIP'];
                                $subnetIP = $sql_result['subnetIP'];
                                
                                ?>
                                
                                <form action="process_atmidEdit.php" method="POST">
                                    <input type="hidden" name="siteid" value="<? echo $siteid; ?>" />
                                    <div class="row">
                                        <div class="grid-margin col-sm-3">
                                            <label for="">activity</label>
                                            <input type="text" name="activity" value="<?= $activity; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">customer</label>
                                            <input type="text" name="customer" value="<?= $customer; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">bank</label>
                                            <input type="text" name="bank" value="<?= $bank; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">atmid</label>
                                            <input type="text" name="atmid" value="<?= $atmid; ?>" class="form-control"  />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">address</label>
                                            <input type="text" name="address" value="<?= $address; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">city</label>
                                            <input type="text" name="city" value="<?= $city; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">state</label>
                                            <input type="text" name="state" value="<?= $state; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">zone</label>
                                            <input type="text" name="zone" value="<?= $zone; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">LHO</label>
                                            <input type="text" name="LHO" value="<?= $LHO; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">LHO_Contact_Person</label>
                                            <input type="text" name="LHO_Contact_Person" value="<?= $LHO_Contact_Person; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">LHO_Contact_Person_No</label>
                                            <input type="text" name="LHO_Contact_Person_No" value="<?= $LHO_Contact_Person_No; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">LHO_Contact_Person_email</label>
                                            <input type="text" name="LHO_Contact_Person_email" value="<?= $LHO_Contact_Person_email; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">LHO_Adv_Person</label>
                                            <input type="text" name="LHO_Adv_Person" value="<?= $LHO_Adv_Person; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">LHO_Adv_Contact</label>
                                            <input type="text" name="LHO_Adv_Contact" value="<?= $LHO_Adv_Contact; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">LHO_Adv_email</label>
                                            <input type="text" name="LHO_Adv_email" value="<?= $LHO_Adv_email; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">Project_Coordinator_Name</label>
                                            <input type="text" name="Project_Coordinator_Name" value="<?= $Project_Coordinator_Name; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">Project_Coordinator_No</label>
                                            <input type="text" name="Project_Coordinator_No" value="<?= $Project_Coordinator_No; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">Project_Coordinator_email</label>
                                            <input type="text" name="Project_Coordinator_email" value="<?= $Project_Coordinator_email; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">Customer_SLA</label>
                                            <input type="text" name="Customer_SLA" value="<?= $Customer_SLA; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">Our_SLA</label>
                                            <input type="text" name="Our_SLA" value="<?= $Our_SLA; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">Vendor</label>
                                            <input type="text" name="Vendor" value="<?= $Vendor; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">Cash_Management</label>
                                            <input type="text" name="Cash_Management" value="<?= $Cash_Management; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">CRA_VENDOR</label>
                                            <input type="text" name="CRA_VENDOR" value="<?= $CRA_VENDOR; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">ID_on_Make</label>
                                            <input type="text" name="ID_on_Make" value="<?= $ID_on_Make; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">Model</label>
                                            <input type="text" name="Model" value="<?= $Model; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">SiteType</label>
                                            <input type="text" name="SiteType" value="<?= $SiteType; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">PopulationGroup</label>
                                            <input type="text" name="PopulationGroup" value="<?= $PopulationGroup; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">XPNET_RemoteAddress</label>
                                            <input type="text" name="XPNET_RemoteAddress" value="<?= $XPNET_RemoteAddress; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">CONNECTIVITY</label>
                                            <input type="text" name="CONNECTIVITY" value="<?= $CONNECTIVITY; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">Connectivity_Type</label>
                                            <input type="text" name="Connectivity_Type" value="<?= $Connectivity_Type; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">po</label>
                                            <input type="text" name="po" value="<?= $po; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">po_date</label>
                                            <input type="text" name="po_date" value="<?= $po_date; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">latitude</label>
                                            <input type="text" name="latitude" value="<?= $latitude; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">longitude</label>
                                            <input type="text" name="longitude" value="<?= $longitude; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">verificationStatus</label>
                                            <input type="text" name="verificationStatus" value="<?= $verificationStatus; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">networkIP</label>
                                            <input type="text" name="networkIP" value="<?= $networkIP; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">routerIP</label>
                                            <input type="text" name="routerIP" value="<?= $routerIP; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">atmIP</label>
                                            <input type="text" name="atmIP" value="<?= $atmIP; ?>" class="form-control" />
                                        </div>
                                        <div class="grid-margin col-sm-3">
                                            <label for="">subnetIP</label>
                                            <input type="text" name="subnetIP" value="<?= $subnetIP; ?>" class="form-control" />
                                        </div>
                                    </div>
                                    <br />
                                    <input type="submit" class="btn btn-primary" value="Update" />
                                </form>
                        </div>
                    </div>
                    
                    
                    
<div class="card">
    <div class="card-body" style="display: flex; justify-content: space-between;">
        <span class="strong">Inactive site</span>
        <a id="deleteSite" data-id="<?= $siteid; ?>"><i class="mdi mdi-delete" id="delete"></i></a>
    </div>
</div>

       


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this site?</p>
                <p>Please provide a reason for deleting:</p>
                <textarea id="deleteReason" class="form-control" rows="4"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmDelete" type="button" class="btn btn-danger">Confirm Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).on('click', '#deleteSite', function () {
    let siteid = $(this).data('id');
    $('#deleteModal').modal('show');
    $('#confirmDelete').data('siteid', siteid);
});

$(document).on('click', '#confirmDelete', function () {
    let siteid = $(this).data('siteid');
    let deleteReason = $('#deleteReason').val();

    $.ajax({
        url: 'inactiveSites.php',
        type: 'POST',
        data: {
            siteid: siteid,
            reason: deleteReason
        },
        success: function (data) {
            console.log(data);
            if(data==200){
                swal('Success','Site Inactive Successfully !','success') ; 
                $('#deleteModal').modal('hide');
                  setTimeout(function(){ 
                    window.location.href="sitestest.php";
                }, 2000);
            }else{
                swal('Error','Site Not Inactive !','error') ; 
                $('#deleteModal').modal('hide');
                //   setTimeout(function(){ 
                    window.location.reload();
                // }, 2000);
            }
            
        }
    });
});


</script>


<? include('../footer.php'); ?>
