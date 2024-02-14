<? include('../header.php'); ?>


<div class="card">
    <div class="card-block overflow_auto">

        <?
        $counter = 1;
        $sql = mysqli_query($con, "select siteid, atmid, vendorId, vendorName, engineerId, engineerName, customerDependency, electricalDependency, hardwareDependency, powerIssue, softwareDependency, upsIssue, created_at, created_by, status, 
                                        portal from holdInstallation where status=1");

        if (mysqli_num_rows($sql) > 0) { ?>


            <table class="table table-hover table-styling table-xs">
                <thead>
                    <tr class="table-primary">
                        <th>Sr No</th>
                        <th>Action</th>
                        <th>ATMID</th>
                        <th>Vendor</th>
                        <th>Engineer</th>
                        <th>Customer Dependency</th>
                        <th>Electrical Dependency</th>
                        <th>Hardware Dependency</th>
                        <th>Power Issue</th>
                        <th>software Dependency</th>
                        <th>Ups Issue</th>
                        <th>Created At</th>
                        <th>Created By</th>
                    </tr>
                </thead>
                <tbody>


                    <?

                    while ($sql_result = mysqli_fetch_assoc($sql)) {


                        $siteid = $sql_result['siteid'];
                        $atmid = $sql_result['atmid'];
                        $vendorId = $sql_result['vendorId'];
                        $vendorName = $sql_result['vendorName'];
                        $engineerId = $sql_result['engineerId'];
                        $engineerName = $sql_result['engineerName'];
                        $customerDependency = $sql_result['customerDependency'];
                        $electricalDependency = $sql_result['electricalDependency'];
                        $hardwareDependency = $sql_result['hardwareDependency'];
                        $powerIssue = $sql_result['powerIssue'];
                        $softwareDependency = $sql_result['softwareDependency'];
                        $upsIssue = $sql_result['upsIssue'];
                        $created_at = $sql_result['created_at'];
                        $created_by = $sql_result['created_by'];
                        $status = $sql_result['status'];
                        $portal = $sql_result['portal'];


                        ?>

                        <tr>
                            <td>
                                <?= $counter; ?>
                            </td>
                            <td><a href="unholdInstallation.php?siteid=<? echo $siteid ?>&atmid=<? echo $atmid; ?>">Unhold</a>
                            </td>
                            <td class="strong">
                                <?= $atmid; ?>
                            </td>
                            <td>
                                <?= $vendorName; ?>
                            </td>
                            <td>
                                <?= $engineerName; ?>
                            </td>
                            <td>
                                <?= $customerDependency; ?>
                            </td>
                            <td>
                                <?= $electricalDependency ?>
                            </td>
                            <td>
                                <?= $hardwareDependency; ?>
                            </td>
                            <td>
                                <?= $powerIssue; ?>
                            </td>
                            <td>
                                <?= $softwareDependency; ?>
                            </td>
                            <td>
                                <?= $upsIssue; ?>
                            </td>
                            <td>
                                <?= $created_at; ?>
                            </td>
                            <td>
                                <?= $engineerName; ?>
                            </td>
                        </tr>

                        <?
                        $counter++;
                    }

                    ?>

                </tbody>
            </table>




        <? } else {

            echo '
                                                                                            
                                                <div class="noRecordsContainer">
                                                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
                                                <dotlottie-player src="../json/nofound.json" background="transparent" speed="1" loop autoplay style="
                                                height: 400px;
                                                width: 100%;
                                            "></dotlottie-player>
                                                
                                                </div>';

        } ?>







    </div>
</div>



<? include('../footer.php'); ?>