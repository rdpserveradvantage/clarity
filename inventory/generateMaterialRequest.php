<? include('../header.php'); ?>


<div class="card">
    <div class="card-block">
        <form action="process_generateMaterialRequest.php" method="POST">
            <h2>Generate New Material Request</h2>
            <hr>
            <div class="row">
                <div class="col-sm-12 grid-margin">
                    <label>Enter Space Seprated ATMID <span style="color:red;">( if multiple )</span></label>
                    <input type="text" name="atmid" class="form-control" required placeholder="like ABCD EFGH IJKL"/>
                </div>
            </div>

            <input type="submit" name="submit" class="btn btn-primary" />
        </form>
    </div>
</div>



<? include('../footer.php'); ?>