<? include('../header.php'); ?>

<div class="row">


<div class="card">
                        <div class="card-body overflow_auto">
                            <table class="table table-hover table-styling table-xs">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>Atmid</th>
                                        <th>Address</th>
                                        <th>Assign</th>
                                        <th>Assigned Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $sql = "SELECT a.atmid, a.siteid, MAX(a.created_at) as latest_created_at, MAX(a.isSentToEngineer) as isSentToEngineer,
                                    MAX(a.isDone) as isDone, MAX(b.assignedToId) as assignedToId, MAX(b.assignedToName) as assignedToName FROM projectInstallation a
                                    LEFT JOIN assignedInstallation b ON a.siteid = b.siteid AND a.atmid = b.atmid WHERE a.vendor = '" . $RailTailVendorID . "' AND a.status = 1 
                                    GROUP BY a.atmid, a.siteid";
                                    $result = mysqli_query($con, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $siteid = $row['siteid'];
                                        $atmid =  $row['atmid'];
                                        $created_at = $row['created_at'];
                                        $isSentToEngineer = $row['isSentToEngineer'];
                                        $assignedToName = $row['assignedToName'];
                                        $isDone = $row['isDone'];
                                        $address = mysqli_fetch_assoc(mysqli_query($con, "SELECT address FROM sites WHERE id='$siteid'"))['address'];
                                    ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td class="strong"><?= $atmid; ?></td>
                                            <td><?= $address; ?></td>
                                            <td>
                                                <?
                                                if ($isDone == 1) {
                                                    echo 'Installation Done !';
                                                } else {
                                                    if ($isSentToEngineer == 1) {
                                                        echo 'Assigned to <strong>' . $assignedToName . '</strong>';
                                                    } else {
                                                        echo '<a href="assignProjectInstallation.php?id=' . $id . '&siteid=' . $siteid . '&atmid=' . $atmid . '">Assigned to Engineer</a>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><?= $created_at; ?></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
</div>


<? include('../footer.php'); ?>

