<?                                
if($assignedLho){
$query = "SELECT v.id,v.vendorName, COUNT(s.delegatedToVendorId) AS siteAllocated,  COALESCE(SUM(s.delegatedByVendor = 1), 0) AS assignEngineer, COALESCE(SUM(s.isFeasibiltyDone = 1), 0) AS feasibiltyDone FROM vendor v
          INNER JOIN sites s ON v.id = s.delegatedToVendorId where v.status=1  and s.LHO like '".$assignedLho."' GROUP BY v.id";
}
else if ($_SESSION['isVendor'] == 1 && $_SESSION['PROJECT_level'] != 3) {


    
$query = "SELECT v.id,v.vendorName, COUNT(s.delegatedToVendorId) AS siteAllocated, 
COALESCE(SUM(s.delegatedByVendor = 1), 0) AS assignEngineer,
COALESCE(SUM(s.isFeasibiltyDone = 1), 0) AS feasibiltyDone
FROM vendor v
LEFT JOIN sites s ON v.id = s.delegatedToVendorId
where v.id = '".$RailTailVendorID."'
GROUP BY v.id";


}
else{
$query = "SELECT v.id,v.vendorName, COUNT(s.delegatedToVendorId) AS siteAllocated,  COALESCE(SUM(s.delegatedByVendor = 1), 0) AS assignEngineer, COALESCE(SUM(s.isFeasibiltyDone = 1), 0) AS feasibiltyDone FROM vendor v
      INNER JOIN sites s ON v.id = s.delegatedToVendorId where v.status=1 GROUP BY v.id";
}
          
$result = mysqli_query($con, $query);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {

$vendorId = $row['id'];
$query4 = mysqli_query($con,"SELECT COUNT(DISTINCT siteid) AS count FROM material_requests WHERE status='pending' AND isProject=1 and vendorId='".$vendorId."'");
$query4_result = mysqli_fetch_assoc($query4);
$materialRequest = $query4_result['count'];

if($assignedLho){
    $query5 = mysqli_query($con,"SELECT COUNT(1) AS count FROM material_send a INNER JOIN sites s ON a.atmid=s.atmid where a.vendorId='".$vendorId."' and s.LHO like '".$assignedLho."'");    
    $query6 = mysqli_query($con,"SELECT COUNT(distinct a.atmid) AS count FROM projectInstallation a INNER JOIN sites s ON a.atmid=s.atmid where a.vendor='".$vendorId."' and isDone=1 and s.LHO like '".$assignedLho."' and a.status=1");
}else{
    $query5 = mysqli_query($con,"SELECT COUNT(1) AS count FROM material_send where vendorId='".$vendorId."'");    
    $query6 = mysqli_query($con,"SELECT COUNT(distinct atmid) AS count FROM projectInstallation where vendor='".$vendorId."' and isDone=1 and status=1");
    
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

<div class="row ">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
            <div id="chartdiv" style="height: 300px; overflow: hidden; text-align: left;"></div>

            </div>
        </div>
    </div>
</div>


<script>
    var data = <?php echo json_encode($data); ?>;
    data.forEach(function(item) {
        item.siteAllocated = parseInt(item.siteAllocated);
        item.assignEngineer = parseInt(item.assignEngineer);
        item.feasibiltyDone = parseInt(item.feasibiltyDone);
        item.materialRequest = parseInt(item.materialRequest);
        item.materialSend = parseInt(item.materialSend);
        item.project = parseInt(item.project);
    });

    Highcharts.chart('chartdiv', {
        chart: {
            type: 'column'
            
        },
        title: {
            text: 'Contractors Wise Summary'
        },
        xAxis: {
            categories: data.map(item => item.Vendor),
            title: {
                text: 'Contractors'
            }
        },
        yAxis: {
            title: {
                text: 'Counts'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.point.category + ': ' + this.point.y;
            }
        },
        legend: {
            align: 'center',
            verticalAlign: 'top',
            layout: 'horizontal',
            itemStyle: {
                fontWeight: 'normal'
            }
        },
        series: [{
            name: 'Site Allocated',
            data: data.map(item => item.siteAllocated)
        }, {
            name: 'Engineer Assign',
            data: data.map(item => item.assignEngineer)
        }, {
            name: 'Feasibility Done',
            data: data.map(item => item.feasibiltyDone)
        }, {
            name: 'Material Request',
            data: data.map(item => item.materialRequest)
        }, {
            name: 'Material Dispatch',
            data: data.map(item => item.materialSend)
        }, {
            name: 'Live Sites',
            data: data.map(item => item.project)
        }],
        plotOptions: {
            column: {
                pointWidth: 15 // Set the desired width (in pixels) for the columns
            },
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        credits: {
            enabled: false
        }
    });
    
 function enterFullScreen() {
        var chartContainer = document.getElementById('chartdiv');
        chartContainer.requestFullscreen = chartContainer.requestFullscreen || chartContainer.mozRequestFullScreen || chartContainer.webkitRequestFullscreen || chartContainer.msRequestFullscreen;
        chartContainer.requestFullscreen();
    }

    // Function to exit full screen mode
    function exitFullScreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }

    // Add event listener to the Full Screen button
    var fullScreenButton = document.getElementById('fullScreenButton');
    fullScreenButton.addEventListener('click', function () {
        if (document.fullscreenElement) {
            exitFullScreen();
            fullScreenButton.textContent = 'Full Screen';
        } else {
            enterFullScreen();
            fullScreenButton.textContent = 'Full Screen';
        }
    });

    // Event listener to exit full screen mode when 'Esc' key is pressed
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            exitFullScreen();
            fullScreenButton.textContent = 'Full Screen';
        }
    });

</script>

