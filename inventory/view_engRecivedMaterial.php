<?php include('../config.php');

$id = $_REQUEST['id'];


?>

<table class="table">
    <thead>
        <tr>
            <th>Sr No</th>
            <th>Material</th>
            <th>Serial Number</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $sql = mysqli_query($con, "select * from material_send_details where materialSendId='" . $id . "'");
        while ($sql_result = mysqli_fetch_assoc($sql)) {

            $attribute = $sql_result['attribute'];
            $value = $sql_result['value'];
            ?>
            <tr>
                <td>
                    <?php echo $i; ?>
                </td>
                <td>
                    <?php echo $attribute; ?>
                </td>
                <td>
                    <?php echo $value; ?>
                </td>


            </tr>

            <?php
            $i++;
        }

        ?>

    </tbody>
</table>