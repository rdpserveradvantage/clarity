<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <?php include('part4dashboard.php'); ?>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between">
                    <h4 class="card-title mb-1">Installation Calls with Most Pending time</h4>
                    <p class="text-muted mb-1">Your data status</p>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="preview-list">

                            <?

                            $i = 1;

                            if ($assignedLho) {
                                $pendingSql = "select 
    p.vendor,p.atmid,p.created_at,p.sbiTicketId,v.status
    from projectInstallation p
    INNER JOIN sites s ON p.atmid = s.atmid
    LEFT JOIN vendor v ON p.vendor = v.id
    where p.isDone=0 and v.status=1 and s.LHO like '" . $assignedLho . "' order by p.created_at asc limit 7";
                                $pendingInstallationSql = mysqli_query($con, $pendingSql);
                            } else {
                                $pendingSql = "select 
    p.vendor,p.atmid,p.created_at,p.sbiTicketId,v.status
    from projectInstallation p 
    LEFT JOIN vendor v ON p.vendor = v.id
    where isDone=0 and v.status=1 order by created_at asc limit 7";
                                $pendingInstallationSql = mysqli_query($con, $pendingSql);
                            }
                            // echo $pendingSql ; 
                            while ($pendingInstallationSqlResult = mysqli_fetch_assoc($pendingInstallationSql)) {
                                $vendorStatus = (int) $pendingInstallationSqlResult['status'];

                                if ($vendorStatus === 1) {
                                    $vendorId = $pendingInstallationSqlResult['vendor'];
                                    $vendorName = getVendorName($vendorId);
                                    $atmid = $pendingInstallationSqlResult['atmid'];
                                    $created_at = $pendingInstallationSqlResult['created_at'];
                                    $sbiTicketId = $pendingInstallationSqlResult['sbiTicketId'];

                                    // Calculate the duration using PHP's DateTime class
                                    $createdAtDateTime = new DateTime($created_at);
                                    $currentDateTime = new DateTime();
                                    $durationInterval = $createdAtDateTime->diff($currentDateTime);
                                    $duration = $durationInterval->format('%d days, %h hours, %i minutes');

                                    ?>
                                    <div class="preview-item border-bottom">
                                        <div class="preview-thumbnail">
                                            <div class="preview-icon bg-primary">
                                                <i class="mdi mdi-file-document"></i>
                                            </div>
                                        </div>
                                        <div class="preview-item-content d-sm-flex flex-grow">
                                            <div class="flex-grow">
                                                <h6 class="preview-subject">
                                                    <?= $atmid; ?>
                                                </h6>
                                                <p class="text-muted mb-0">
                                                    <?= $vendorName; ?>
                                                </p>
                                            </div>
                                            <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                                <p class="text-muted">
                                                    <?= $duration; ?>
                                                </p>
                                                <p class="text-muted mb-0">
                                                    <?= $sbiTicketId; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <? $i++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>