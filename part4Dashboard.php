
<?
if ($assignedLho) {
    $query = "SELECT  COUNT(s.delegatedToVendorId) AS siteAllocated,  COALESCE(SUM(s.delegatedByVendor = 1), 0) AS assignEngineer, COALESCE(SUM(s.isFeasibiltyDone = 1), 0) AS feasibiltyDone FROM 
           sites s  where s.LHO like '" . $assignedLho . "'";
} else {
    $query = "SELECT COUNT(s.delegatedToVendorId) AS siteAllocated,  COALESCE(SUM(s.delegatedByVendor = 1), 0) AS assignEngineer, COALESCE(SUM(s.isFeasibiltyDone = 1), 0) AS feasibiltyDone FROM 
        sites s ";
}

$result = mysqli_query($con, $query);
$data = array();
if ($row = mysqli_fetch_assoc($result)) {
    $vendorId = $row['id'];
    $query4 = mysqli_query($con, "SELECT COUNT(DISTINCT siteid) AS count FROM material_requests WHERE status='pending' AND isProject=1");
    $query4_result = mysqli_fetch_assoc($query4);
    $materialRequest = $query4_result['count'];

    if ($assignedLho) {
        $query5 = mysqli_query($con, "SELECT COUNT(1) AS count FROM material_send a INNER JOIN sites s ON a.atmid=s.atmid where  s.LHO like '" . $assignedLho . "'");

        $query6 = mysqli_query($con, "SELECT COUNT(distinct a.atmid) AS count FROM projectInstallation a INNER JOIN sites s ON a.atmid=s.atmid where isDone=1 and s.LHO like '" . $assignedLho . "' and a.status=1");

    } else {
        $query5 = mysqli_query($con, "SELECT COUNT(1) AS count FROM material_send");
        $query6 = mysqli_query($con, "SELECT COUNT(distinct atmid) AS count FROM projectInstallation where isDone=1 and status=1");

    }


    $query5_result = mysqli_fetch_assoc($query5);
    $materialSend = $query5_result['count'];


    $query6_result = mysqli_fetch_assoc($query6);
    $installationDone = $query6_result['count'];


    $vendorName = $row['vendorName'];
    $siteAllocated = $row['siteAllocated'];
    $assignEngineer = $row['assignEngineer'];
    $feasibiltyDone = $row['feasibiltyDone'];

    $data[] = array(
        "Vendor" => $vendorName,
        "siteAllocated" => $siteAllocated,
        "assignEngineer" => $assignEngineer,
        "feasibiltyDone" => $feasibiltyDone,
        "materialRequest" => $materialRequest,
        "materialSend" => $materialSend,
        "project" => $installationDone
    );
}
?>

<div class="col-sm-12" >
    <div class="card">
        <div class="card-block">
            <div id="chartdivpart4" style="height: 300px; overflow: hidden; text-align: left;"></div>
        </div>
    </div>
</div>

<script>
    var data = <?php echo json_encode($data); ?>;
    data.forEach(function (item) {
        item.siteAllocated = parseInt(item.siteAllocated);
        item.assignEngineer = parseInt(item.assignEngineer);
        item.feasibiltyDone = parseInt(item.feasibiltyDone);
        item.materialRequest = parseInt(item.materialRequest);
        item.materialSend = parseInt(item.materialSend);
        item.project = parseInt(item.project);
    });

    Highcharts.chart('chartdivpart4', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Overall Summary'
        },
        series: [{
            name: 'Count',
            data: [
                { name: 'Site Allocated', y: data[0].siteAllocated },
                { name: 'Engineer Assign', y: data[0].assignEngineer },
                { name: 'Feasibility Done', y: data[0].feasibiltyDone },
                { name: 'Material Request', y: data[0].materialRequest },
                { name: 'Material Dispatch', y: data[0].materialSend },
                { name: 'Live Sites', y: data[0].project }
            ]
        }],
        credits: {
            enabled: false
        }
    });

    // Add your full screen functionality here if needed
</script>
