<? include('../config.php');

$id = $_REQUEST['id'];

if (isset($id) && $id > 0) {

    if (mysqli_query($con, "update goodreturn  set isAccept=1 where id='" . $id . "'")) {

        $detailsQuery = "SELECT * FROM goodreturndetails WHERE goodReturnID = $id";
        $detailsResult = mysqli_query($con, $detailsQuery);
        while ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
            $attribute = $detailsRow['material'];
            $serialNumber = $detailsRow['serialNumber'];

            if ($serialNumber) {
                mysqli_query($con, "update inventory set status=1 where serial_no LIKE '" . $serialNumber . "'");
            } else {

                $getMatSql = mysqli_query($con, "select * from inventory where material like '" . $attribute . "' and status=0 order by id asc");
                if ($getMatSqlResult = mysqli_fetch_assoc($getMatSql)) {
                    $matId = $getMatSqlResult['id'];
                    mysqli_query($con, "update inventory set status=1 where id = '" . $matId . "'");
                }
            }
            mysqli_query($con, "insert into inventorytracker(material,serial_no,type,created_at,created_by) 
            values('" . $attribute . "','" . $serialNumber . "','Accept Goods Return to Inventory','" . $datetime . "','" . $userid . "')");
        }

        echo 1;


    } else {
        echo 0;
    }
} else {
    echo 0;
}


?>