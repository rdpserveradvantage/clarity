<? include('../header.php'); 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);




if(isset($_POST["checkedIds"])){
    
    $checkedIds = $_POST["checkedIds"];
    foreach ($checkedIds as $id) {

        $sql = mysqli_query($con, "select atmid from sites where id='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        $atmid = $sql_result['atmid'];

        $allsiteid[] = $id;
        $all_atmid[] = $atmid;
    }


}else{
        $atmid = $_REQUEST['atmid'];
     
     
                
        

        $sql = mysqli_query($con, "select id from sites where atmid='" . $atmid . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        $id = $sql_result['id'];

        $allsiteid[] = $id;
        $all_atmid[] = $atmid;
     
}

?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php
                $atmid = $_REQUEST['atmid'];
                $id = $_REQUEST['id'];
                $action = $_REQUEST['action'];
                ?>
                <h5> Delegate : To Contractor</h5>
                
                <span>
                    <?php echo implode(' , ', $all_atmid) . ' '; ?>
                </span>

                <hr>
                <form id="myForm2" action="process_delegate.php" enctype="multipart/form-data">
                    <input type="hidden" name="atmid" value='<?php echo implode(' , ', $all_atmid); ?>' />
                    <input type="hidden" name="siteid" value='<?php echo implode(' , ', $allsiteid); ?>' />
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
    </div>
</div>



<? include('../footer.php'); ?>