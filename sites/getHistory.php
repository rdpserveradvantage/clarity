<? include('../config.php');
$siteId = $_REQUEST['siteId'];

$i = 1;

$sql = mysqli_query($con, "select * from event_log where site_id='" . $siteId . "'");
if (mysqli_num_rows($sql) > 0) {

    ?>

    <table class="table">
        <thead>
            <tr class="table-primary">
                <th>Sr No</th>
                <th>ATMID</th>
                <th>Portal</th>
                <th>Event</th>
                <th>Description</th>
                <th>Datetime</th>
            </tr>
        </thead>
        <tbody>
            <?
            while ($sql_result = mysqli_fetch_assoc($sql)) {

                $atmid = $sql_result['atmid'];
                $portal = $sql_result['portal'];
                $event = $sql_result['event_name'];
                $description = $sql_result['event_description'];
                $created_at = $sql_result['event_timestamp'];
                ?>
                <tr>
                    <td>
                        <?= $i; ?>
                    </td>
                    <td class="strong">
                        <?= $atmid; ?>
                    </td>
                    <td>
                        <?= $portal; ?>
                    </td>
                    <td>
                        <?= $event; ?>
                    </td>
                    <td>
                        <?= $description; ?>
                    </td>
                    <td>
                        <?= $created_at; ?>
                    </td>
                </tr>

                <? $i++;
            } ?>
        </tbody>
    </table>
<? } else {

    echo '
                                            
<div class="noRecordsContainer">
    <img src="assets/no_records.jpg">
</div>';

} ?>