<? include('../config.php');

$imagetype = $_REQUEST["imagetype"];
$siteid = $_REQUEST["siteId"];
$id = $_REQUEST["id"];

if (isset($id) && isset($imagetype)) {

    $sql = mysqli_query($con, "select $imagetype from feasibilitycheck where id='" . $id . "'");
    if ($sqlResult = mysqli_fetch_assoc($sql)) {

        $imagestr = $sqlResult[$imagetype];
        $imageAr = explode(',', $imagestr);
        ?>
        <h2><?php echo $imagetype ; ?></h2>

        <div class="row">
            <?
            foreach ($imageAr as $imageArKey => $imageArVal) {
                ?>
                <div class="col-sm-4">
                    <a href="<?php echo $imageArVal ; ?>" target="_blank">
                        <img src="<?php echo $imageArVal; ?>" alt="" style="width:300px;">
                    </a>
                </div>


            <?
            }
            ?>
        </div>
    <? }
}



?>