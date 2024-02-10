<? include('../config.php');

$pendingInstallationSql = $_REQUEST['exportSql'];
    // Implement the export to Excel here
    $filename = "installation_calls_export_" . date('Y-m-d') . ".xls";
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Content-Type: application/vnd.ms-excel');

$pendingInstallationSql = mysqli_query($con,$pendingInstallationSql);
    // Output the Excel data here
    echo "Vendor \t Atmid \t Pending From \t Duration \t SBIN Ticket ID \n";
    while ($pendingInstallationSqlResult = mysqli_fetch_assoc($pendingInstallationSql)) {
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

        echo "$vendorName \t $atmid \t $created_at \t $duration \t $sbiTicketId \n";
    }

    exit;
?>