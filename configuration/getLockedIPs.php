

<?php include('../config.php');

$sql = mysqli_query($con, "SELECT * FROM ips WHERE isAssign=0 AND status=1 AND isLocked=1");
if (mysqli_num_rows($sql) > 0) {
    echo "
    <table id='example' class='table table-bordered table-striped table-hover dataTable js-exportable no-footer' style='width:100%'>
        <thead>
            <tr class='table-primary'>
                <th>Sr NO</th>
                <th>Network IP</th>
                <th>Router IP</th>
                <th>ATM IP</th>
                <th>Subnet IP</th>
                <th>Lock Since</th>
                <th>Automatic Unlock In</th>
                <th>Unlock Now</th>
            </tr>
        </thead>
        <tbody>
    ";
    $srno = 1;
    while ($sql_result = mysqli_fetch_assoc($sql)) {

        $id = $sql_result['id'];
        $network_ip = $sql_result['network_ip'];
        $router_ip = $sql_result['router_ip'];
        $atm_ip = $sql_result['atm_ip'];
        $subnet_ip = $sql_result['subnet_ip'];
        $lockedTime = strtotime($sql_result['lockedTime']);
        $currentTime = time();
        $timeDifference = $lockedTime + 1800 - $currentTime; // 1800 seconds = 30 minutes

        // Convert seconds to minutes and seconds
        $minutes = floor($timeDifference / 60);
        $seconds = $timeDifference % 60;

        echo "
        <tr>
            <td>{$srno}</td>
            <td>{$network_ip}</td>
            <td>{$router_ip}</td>
            <td>{$atm_ip}</td>
            <td>{$subnet_ip}</td>
            <td>{$sql_result['lockedTime']}</td>
            <td><span class='countdown'>{$minutes} minute {$seconds} second</span></td>
            <td><a href='#' data-toggle='modal' data-target='#unbindModal' data-id='{$id}'>Un-lock</a></td>
        </tr>
        ";
        $srno++;
    }
    echo "</tbody>
        </table>";
} else {
    echo '
    <div class="noRecordsContainer">
                                                   
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
    <dotlottie-player src="../json/nofound.json" background="transparent" speed="1" loop autoplay style="
    height: 400px;
    width: 100%;
"></dotlottie-player>
    
    </div>';
}
?>

<div class="modal fade" id="unbindModal" tabindex="-1" role="dialog" aria-labelledby="unbindModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unbindModalLabel">Unlock Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to unlock this IP?</p>
                <input type="hidden" id="unbindItemId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmUnbind()">Unlock</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    // Event listener to set the ID in the modal when the "Unbind" link is clicked
    $(document).on("click", "a[data-target='#unbindModal']", function () {
        var id = $(this).data('id');
        document.getElementById("unbindItemId").value = id;
    });
</script>

