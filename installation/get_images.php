<?php include('../config.php');
if (isset($_GET['id'])) {
    $sealVerificationID = $_GET['id'];

    $query = "SELECT imageUrl FROM sealVerificationImages WHERE sealVerificationID = '$sealVerificationID'";

    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error executing the query: " . mysqli_error($con));
    }
    $response = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = 'http://clarity.advantagesb.com/corona/eng/'.$row['imageUrl'];
        }
        echo json_encode(array("success" => true, "images" => $response));
    } else {
        echo json_encode(array("success" => false, "message" => "No images found for this ATM ID."));
    }

    mysqli_close($con);
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request."));
}
?>
