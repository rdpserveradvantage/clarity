<? include('../header.php'); ?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
    

.swal2-popup {
    background: white !important;
}
</style>

                                <div class="card">
                                    <div class="card-block">
                                        
                                        <h4>Project Co-ordinator</h4>
                                        <hr>
                                        
                                        <form action="process_projectCoordinator.php" method="POST">
                                            <div class="row">
                                                    <div class="col-sm-4">
                                                    <label>Contact Person</label>
                                                    <input type="text" name="contactPersonName" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Contact Person No</label>
                                                    <input type="text" name="contactPersonNo" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Contact Person Email</label>
                                                    <input type="text" name="contactPersonEmail" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Designation</label>
                                                    <input type="text" name="designation" class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Exclamation Matrix</label>
                                                    <input type="text" name="esc_matrix" class="form-control" placeholder="Level 1 or Level 2 ..." />
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
                                        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>#</th>
                                                    <th>Contact Person</th>
                                                    <th>Contact Person No</th>
                                                    <th>Contact Person Email</th>
                                                    <th>Designation</th>
                                                    <th>Escalation Matrix</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i= 1; 
                                                $sql = mysqli_query($con,"select * from projectCoordinator where status=1");
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                    $id = $sql_result['id'];
                                                ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td><? echo $sql_result['contactPersonName']; ?></td>
                                                        <td><? echo $sql_result['contactPersonNo']; ?></td>
                                                        <td><? echo $sql_result['contactPersonEmail']; ?></td>
                                                        <td><? echo $sql_result['designation']; ?></td>
                                                        <td><? echo $sql_result['esc_matrix']; ?></td>
                                                        <td>
                                                            <a href="#" class="delete-link" data-projectCordinatorId="<?= $id; ?>">Delete</a>
                                                        </td>
                                                    </tr>    
                                                <? $i++; }?>
                                                
                                            </tbody>
                                    </div>
                                </div>
                                
                              
<script>
    $(document).ready(function () {
        $(".delete-link").on("click", function (e) {
            e.preventDefault(); // Prevent the default behavior of the anchor tag
            
            var projectCordinatorId = $(this).data('projectcordinatorid');

            alert(projectCordinatorId) ; 

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var deleteUrl = "deleteProjectCordinator.php"; // Replace with your actual delete endpoint

                    $.ajax({
                        url: deleteUrl,
                        method: 'POST', // Change the method as needed
                        data: { projectCordinatorId: projectCordinatorId },
                        success: function (response) {
                            if(response==1){
                                Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Your record has been deleted.',
                            });
                            }else{
                                Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while deleting the record.',
                            });    
                            }
                           
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while deleting the record.',
                            });
                        }
                    });
                }
            });
        });
    });
</script>

                    
    <? include('../footer.php'); ?>

    

    
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="../datatable/jquery.dataTables.js"></script>
<script src="../datatable/dataTables.bootstrap.js"></script>
<script src="../datatable/dataTables.buttons.min.js"></script>
<script src="../datatable/buttons.flash.min.js"></script>
<script src="../datatable/jszip.min.js"></script>

<script src="../datatable/pdfmake.min.js"></script>
<script src="../datatable/vfs_fonts.js"></script>
<script src="../datatable/buttons.html5.min.js"></script>
<script src="../datatable/buttons.print.min.js"></script>
<script src="../datatable/jquery-datatable.js"></script>