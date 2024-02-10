<? include('../header.php'); ?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     

                                <div class="card">
                                    <div class="card-block">
                                        
                                        <form action="process_customer.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Customer Name</label>
                                                    <input type="text" name="customerName" class="form-control">
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
                                                    <th>Customer Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i= 1; 
                                                $sql = mysqli_query($con,"select * from customer where status=1");
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 

                                                ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td><? echo $sql_result['customerName']; ?></td>


                                                    </tr>    
                                                <? $i++; }?>
                                                
                                            </tbody>
                                    </div>
                                </div>
                                
              
                    
                    
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