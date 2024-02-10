<? include('../config.php');

$vendor = $_REQUEST['vendor'];

?>





<option value="">Select</option>
<?
$vendorUsersSql = mysqli_query($con, "select * from user where vendorId='" . $vendor . "' and user_status=1 order by name asc");
while ($vendorUsersSqlResult = mysqli_fetch_assoc($vendorUsersSql)) {
    $vendorUserName = $vendorUsersSqlResult['name'];
    $vendorUserId = $vendorUsersSqlResult['userid'];
    ?>
    <option value="<?= $vendorUserId; ?>">
        <?= $vendorUserName; ?>
    </option>
<? } ?>