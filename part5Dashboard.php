<div class="row">
    <div class="">


        <?

        $data = array();


        if ($assignedLho) {
            $sql = mysqli_query($con, "
                            SELECT
                            DATE(ESD) AS ESD_Date,
                            COUNT(1) AS ESD_Count,
                            DATE(ASD) AS ASD_Date,
                            COUNT(1) AS ASD_Count
                            FROM
                            sites
                            WHERE
                            (ESD BETWEEN NOW() - INTERVAL 60 DAY AND NOW() + INTERVAL 60 DAY)
                            OR (ASD BETWEEN NOW() - INTERVAL 60 DAY AND NOW() + INTERVAL 60 DAY)
                            and LHO like '" . $assignedLho . "'
                            GROUP BY
                            ESD_Date, ASD_Date
                            ORDER BY
                            ESD_Date, ASD_Date");

        } else if ($_SESSION['PROJECT_level'] == 3) {


            $sql = mysqli_query(
                $con,
                "SELECT
    DATE(a.ESD) AS ESD_Date,
    COUNT(1) AS ESD_Count,
    DATE(a.ASD) AS ASD_Date,
    COUNT(1) AS ASD_Count
    FROM
    sites a INNER JOIN delegation b 
    ON a.id = b.siteid
    WHERE
    ((a.ESD BETWEEN NOW() - INTERVAL 60 DAY AND NOW() + INTERVAL 60 DAY)
    OR (a.ASD BETWEEN NOW() - INTERVAL 60 DAY AND NOW() + INTERVAL 60 DAY))
    and b.engineerId='" . $userid . "'
    GROUP BY
    ESD_Date, ASD_Date
    ORDER BY
    ESD_Date, ASD_Date
    "
            );
        } else if ($_SESSION['isVendor'] == 1 && $_SESSION['PROJECT_level'] != 3) {


            $sql = mysqli_query(
                $con,
                "SELECT
            DATE(a.ESD) AS ESD_Date,
            COUNT(1) AS ESD_Count,
            DATE(a.ASD) AS ASD_Date,
            COUNT(1) AS ASD_Count
            FROM
            sites a 
            WHERE
            ((a.ESD BETWEEN NOW() - INTERVAL 60 DAY AND NOW() + INTERVAL 60 DAY)
            OR (a.ASD BETWEEN NOW() - INTERVAL 60 DAY AND NOW() + INTERVAL 60 DAY))
            and a.delegatedToVendorId='" . $_GLOBAL_VENDOR_ID . "'
            GROUP BY
            ESD_Date, ASD_Date
            ORDER BY
            ESD_Date, ASD_Date
            "
            );


        } else {
            $sql = mysqli_query($con, "
                            SELECT
                            DATE(ESD) AS ESD_Date,
                            COUNT(1) AS ESD_Count,
                            DATE(ASD) AS ASD_Date,
                            COUNT(1) AS ASD_Count
                            FROM
                            sites
                            WHERE
                            (ESD BETWEEN NOW() - INTERVAL 60 DAY AND NOW() + INTERVAL 60 DAY)
                            OR (ASD BETWEEN NOW() - INTERVAL 60 DAY AND NOW() + INTERVAL 60 DAY)
                            GROUP BY
                            ESD_Date, ASD_Date
                            ORDER BY
                            ESD_Date, ASD_Date");

        }

        while ($sql_result = mysqli_fetch_assoc($sql)) {
            $data[] = array(
                "ESD_Date" => $sql_result['ESD_Date'],
                "ESD_Count" => intval($sql_result['ESD_Count']),
                "ASD_Date" => $sql_result['ASD_Date'],
                "ASD_Count" => intval($sql_result['ASD_Count'])
            );
        }
        ?>

        <div id="container" style="height: 400px;"></div>


        <script>
            // Extract data from PHP and format it for Highcharts
            var chartData = <?php echo json_encode($data); ?>;

            // Create Highchart with a series chart type
            Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'ESD and ASD Counts'
                },
                xAxis: {
                    categories: chartData.map(function (item) {
                        return item.ESD_Date;
                    }),
                    title: {
                        text: 'Date'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Count'
                    }
                },
                series: [{
                    name: 'ESD',
                    data: chartData.map(function (item) {
                        return item.ESD_Count;
                    })
                }, {
                    name: 'ASD',
                    data: chartData.map(function (item) {
                        return item.ASD_Count;
                    })
                }]
            });
        </script>
        <?
        $data = array();

        ?>
<br />
        <div class="col-md-12 grid-margin stretch-card" id="highchart-container" style="height: 500px;"></div>

        <div class="col-md-12 grid-margin stretch-card">

            <div class="table-responsive" style="width: 100%;">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>LHO</th>
                            <th>Allocated Sites</th>
                            <th>Material Dispatch</th>
                            <th>Delivered</th>
                            <th>In-transit</th>
                            <th colspan="2" style="text-align:center;">Todays</th>
                        </tr>
                        <tr>
                            <th></th> <!-- Empty cell for Sr No -->
                            <th></th> <!-- Empty cell for LHO -->
                            <th></th> <!-- Empty cell for Allocated Sites -->
                            <th></th> <!-- Empty cell for Send Material -->
                            <th></th> <!-- Empty cell for Delivered -->
                            <th></th> <!-- Empty cell for In-transit -->
                            <th>Feasibility</th>
                            <th>Installation</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?
                        $i = 1;
                        if ($assignedLho) {
                            $sql = mysqli_query($con, "select * from lho where status=1 and lho like '" . $assignedLho . "'");
                        } else {
                            $sql = mysqli_query($con, "select * from lho where status=1");
                        }

                        while ($sql_result = mysqli_fetch_assoc($sql)) {

                            $lho = $sql_result['lho'];

                            $allocatedCount = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(1) AS allocatedCount FROM sites WHERE LOWER(LHO) LIKE LOWER('%" . $lho . "%') AND status = 1"))['allocatedCount'];

                            // echo "SELECT COUNT(1) AS count FROM material_send a where  a.lho like '" . $lho . "' and portal='clarity'" ;
                            $sendMaterialCount = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(1) AS count FROM material_send a where  a.lho like '" . $lho . "' and portal='clarity'"))['count'];
                            $deliveredsendMaterialCount = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(1) AS count FROM material_send a where  a.lho like '" . $lho . "' and portal='clarity' and isDelivered=1"))['count'];
                            $intrasitsendMaterialCount = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(1) AS count FROM material_send a where  a.lho like '" . $lho . "' and portal='clarity' and isDelivered=0"))['count'];


                            $asdesdCount = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(CASE WHEN ESD = CURDATE() THEN 1 END) AS ESD_Count,
                COUNT(CASE WHEN ASD = CURDATE() THEN 1 END) AS ASD_Count FROM
                sites WHERE (ESD = CURDATE() OR ASD = CURDATE()) AND status=1 and LHO like '" . $lho . "'"));


                            $ESD_Count = $asdesdCount['ESD_Count'];
                            $ASD_Count = $asdesdCount['ASD_Count'];
                            ?>
                            <tr>
                                <td>
                                    <?= $i; ?>
                                </td>
                                <td>
                                    <?= $lho; ?>
                                </td>
                                <td class="text-right">
                                    <?= $allocatedCount; ?>
                                </td>
                                <td class="text-right font-weight-medium">
                                    <?= $sendMaterialCount; ?>
                                </td>

                                <td class="text-right font-weight-medium">
                                    <?= $deliveredsendMaterialCount; ?>
                                </td>

                                <td class="text-right font-weight-medium">
                                    <?= $intrasitsendMaterialCount; ?>
                                </td>
                                <td>
                                    <?= $ESD_Count; ?>
                                </td>
                                <td>
                                    <?= $ASD_Count; ?>
                                </td>

                            </tr>
                            <?

                            $data[] = array(
                                "LHO" => $lho,
                                "TotalAllocatedSites" => intval($allocatedCount),
                                "SendMaterial" => intval($sendMaterialCount),
                                "Delivered" => intval($deliveredsendMaterialCount),
                                "InTransit" => intval($intrasitsendMaterialCount),
                            );

                            $i++;
                        }
                        ?>


                    </tbody>
                </table>
            </div>

        </div>


        <script>
            // Extract data from PHP and format it for Highcharts
            var chartData = <?php echo json_encode($data); ?>;

            // Extract LHO names and counts for chart series
            var lhoNames = chartData.map(function (item) {
                return item.LHO;
            });

            var allocatedSites = chartData.map(function (item) {
                return item.TotalAllocatedSites;
            });

            var sendMaterial = chartData.map(function (item) {
                return item.SendMaterial;
            });

            var delivered = chartData.map(function (item) {
                return item.Delivered;
            });

            var inTransit = chartData.map(function (item) {
                return item.InTransit;
            });

            // Create Highchart with a column chart type
            Highcharts.chart('highchart-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Site Status LHO Wise'
                },
                xAxis: {
                    categories: lhoNames,
                    title: {
                        text: 'LHO'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Counts'
                    }
                },
                series: [{
                    name: 'Allocated Sites',
                    data: allocatedSites
                }, {
                    name: 'Material Dispatch',
                    data: sendMaterial
                }, {
                    name: 'Delivered',
                    data: delivered
                }, {
                    name: 'In Transit',
                    data: inTransit
                }]
            });
        </script>
    </div>
</div>