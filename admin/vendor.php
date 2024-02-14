<? include('../header.php'); ?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
        function disable(id){

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
                            url: 'disable_vendor.php',
                           data: 'id='+id,
                                success:function(msg) {
                                    
                                    console.log(msg);
                                    
                                    if(msg==1){
                                            Swal.fire(
                                              'Updated!',
                                              'Status has been changed.',
                                              'success'
                                            );
                                            
                                            setTimeout(function(){ 
                                        window.location.reload();
                                    }, 2000);
                                    
                                    }else if(msg==0 || msg==2){
                                        
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
           
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <form action="process_vendor.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Contractor Name</label>
                                                    <input type="text" name="vendorName" class="form-control" required>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <br>
                                                    <input type="submit" name="submit" class="btn btn-primary">
                                                </div>                                                
                                            </div>

                                        </form>
                                        
                                        
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                <div class="card">
                                    <div class="card-body" style="overflow:auto;">

                                        <table id="example" class="table table-hover table-styling" style="width:100%">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>#</th>
                                                    <th>Contractor Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $sql = mysqli_query($con, "select * from vendor where status=1 order by id asc");
                                                while ($sql_result = mysqli_fetch_assoc($sql)) {
                                                    $id = $sql_result['id'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td class="strong"><?php echo $sql_result['vendorName']; ?></td>
                                                        <td>
                                                            <a href="#" class="btn btn-success createVendorUserLink" data-vendorid="<?php echo $id; ?>">Create Contractor User</a>
                                                            | 
                                                            <a class="btn btn-primary" href="viewVendorUser.php?vendor=<? echo $id; ?>">View Users</a>
                                                            |
                                                            <a href="editVendor.php?id=<? echo $id; ?>" class="btn btn-success editVendor" data-vendorid="<?php echo $id; ?>">Edit</a>
                                                            |
                                                            <a href="viewVendor.php?id=<? echo $id; ?>" class="btn btn-success viewVendor" data-vendorid="<?php echo $id; ?>">View</a>
                                                            |
                                                            <a href="#" class="btn btn-danger" onclick="disable(<? echo $id; ?>)">Delete</a>
                                                            </td>
                                                        
                                                    </tr>
                                                <?php $i++;
                                                } ?>
                                            </tbody>
                                        </table>



                                    </div>
                                </div>
                                
                          

<!-- Modal for Create Vendor User -->
<div class="modal fade" id="createVendorUserModal" tabindex="-1" role="dialog" aria-labelledby="createVendorUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createVendorUserModalLabel">Create Contractor User</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="createVendorUserForm">
          <div class="row">
            <div class="col-sm-3">
              <label>Name</label>
              <input type="text" name="name" class="form-control">
            </div>
            <div class="col-sm-3">
              <label>Email / Username</label>
              <input type="email" name="uname" class="form-control">
            </div>
            <div class="col-sm-3">
              <label>Password</label>
              <input type="password" name="pwd" class="form-control">
            </div>
            <div class="col-sm-3">
              <label>Contact</label>
              <input type="number" id="contact" name="contact" class="form-control" onkeypress="return validInput(event);">
            </div>
            <div class="col-sm-12">
              <label>Role</label>
              <select class="form-control" name="role" required="">
                <option value="">Select</option>
                <option value="1">Admin</option>
                <option value="2">Project Executive</option>
                <option value="3">Engineer</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveVendorUser" data-vendorid="">Save</button>
      </div>
    </div>
  </div>
</div>

                
                    
<script>

function validInput(event) {
  // Add your validation logic here
  // For example, if you want to allow only numeric input:
  var charCode = (event.which) ? event.which : event.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
  return true;
}

    
$(document).ready(function() {


  // Create Vendor User link click event
  $('.createVendorUserLink').click(function(e) {
    e.preventDefault();
    var vendorId = $(this).data('vendorid');
    $('#createVendorUserModal').modal('show');
    $('#saveVendorUser').data('vendorid', vendorId);
    $('#createVendorUserModal').modal('hide');

  });

  // Save Vendor User click event
// Save Vendor User click event
$('#saveVendorUser').click(function() {
  var vendorId = $(this).data('vendorid');
  var formData = $('#createVendorUserForm').serialize();

  // Make AJAX call to save vendor user data
  $.ajax({
    url: '<? $_SERVER["DOCUMENT_ROOT"]; ?>/admin/API/saveVendorUsers.php',
    type: 'POST',
    data: formData + '&vendorId=' + vendorId,
    success: function(response) {
      console.log(response);

      if (response.statusCode === 200) {
        Swal.fire({
          title: 'Success',
          text: response.response,
          icon: 'success',
        });
        $('#createVendorUserModal').modal('hide');
      } else {
        Swal.fire({
          title: 'Error',
          text: response.response,
          icon: 'error',
        });
        $('#createVendorUserModal').modal('hide');
      }
    },
    error: function(xhr, status, error) {
      // Handle the error case
      console.error(error);
      Swal.fire({
        title: 'Error',
        text: 'An error occurred. Please try again.',
        icon: 'error',
      });
      // TODO: Handle the error case
    }
  });
});

});



</script>
                    
<? include('../footer.php'); ?>